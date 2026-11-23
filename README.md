# Krillion

A trivia game where the obvious answer is the wrong move. Seven questions, 25 seconds each: give a **correct** answer that hardly anyone else would think of. The rarer your answer, the deeper you sink into the Mariana Trench, from the sunlit surface all the way down to Challenger Deep, 10,935 m below.

Built with Laravel 13, Blade and Tailwind CSS v4. No JavaScript framework; just a few small scripts for the animations.

## How to play

1. **Cast off.** Start on a fishing boat at dusk and cast your first answer off the side.
2. **Dive.** Questions 2–7 happen underwater. Each answer sinks you deeper and reels out your line, and the sea life changes as you pass through each zone.
3. **Beat the clock.** You get 25 seconds per question. When time runs out, whatever you've typed is submitted. If nothing usable is there, the fish gets away and you score 0.
4. **Haul in the results.** After the final catch you see your depth, your overall fish, and how every answer scored. Finished dives can be shared by link, and the deepest divers appear on the leaderboard.

Answers are checked as you type them in: a typo gets *Did you mean "Skull"?* (press Enter again to accept it), and wrong answers are turned away without leaving the page.

## Scoring

Every question has a complete answer key. An answer only scores if it's on the key; nicknames and spellings count ("soccer" → Football, "UPenn" → Penn, "Bosnia" → Bosnia and Herzegovina).

A correct answer scores **10 to 100 points, in steps of 10**, by how rarely people would think of it compared with that question's most popular answer:

| Points | Rarity | Fish class | Could be a… |
|---|---|---|---|
| 10 | Common (silver) | Schooler | sardine, anchovy or mackerel |
| 20–30 | Uncommon (green) | Reef Dweller | clownfish, blue tang or butterflyfish |
| 40–50 | Rare (red) | Drifter | ocean sunfish, pufferfish or seahorse |
| 60–70 | Epic (purple) | Lanternfish | lanternfish or hatchetfish |
| 80–90 | Legendary (gold) | Anglerfish | anglerfish, viperfish or gulper eel |
| 100 | Mythic (shimmer) | Snailfish | snailfish or barreleye |

The most popular answer is worth 10; an answer at least 100× rarer is worth 100. In between the curve is generous, so moderately rare answers score well.

### Where "how common" comes from

There's no official API for how often an answer is searched, so popularity comes from three places:

- **Wikipedia page views:** how often each answer's article was read in the last 60 days, the closest public measure of how often people look something up.
- **Datamuse word frequency:** a small boost for everyday words, applied only when the answer's own name is its article (so "Quark" the cheese isn't inflated by physics).
- **Other players:** every answer given is counted. Popularity starts from Wikipedia and the crowd gradually takes over, so the first person to say something rare scores more than the tenth.

Popularity is measured ahead of time by an artisan command (see below), so nothing is looked up while you play.

### The dive

Your total score sets your depth. Each zone gets a fair share of the score, so a typical dive passes through a new zone every answer or two:

| Zone | From |
|---|---|
| Sunlight Zone | 0 m |
| Twilight Zone | 200 m |
| Deep Scattering Layer | 500 m |
| Midnight Zone | 1,000 m |
| Hydrothermal Vents | 2,500 m |
| Abyssal Zone | 4,000 m |
| Hadal Zone | 6,000 m |
| Challenger Deep | 10,000 m |

## The questions

28 questions, 7 drawn at random per dive:

- **Science and nature:** chemical elements, bones of the human body, constellations, planets and dwarf planets, types of cloud, SI units, flightless birds
- **Animals:** farm animals, zoo animals, the cat family, marsupials
- **Food:** Asian dishes, pasta, cheeses, spices
- **Culture:** Shakespeare plays, Greek letters, Olympian Greek gods, Norse gods, Chinese zodiac animals, tarot major arcana, EU languages, Paris 2024 Olympic sports
- **Geography:** flags with red, countries bordering exactly two others, landlocked countries, island countries, European capitals

## Getting started

Requirements: PHP 8.3+ with the `pdo_sqlite`, `curl` and `openssl` extensions, Composer, Node.js and npm.

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan db:seed --class=QuestionSeeder
php artisan krillion:fetch-popularity
npm install
npm run build
php artisan serve
```

Then open http://localhost:8000. With [Laravel Herd](https://herd.laravel.com) the site is also served at http://krillion.test without `artisan serve`.

`krillion:fetch-popularity` measures every answer on Wikipedia. It's resumable, so if it's interrupted just run it again; `--fresh` re-measures everything. Without it the game still works, but every answer scores as "typical".

For development with live-reloading assets, run `composer run dev` (or `npm run dev` alongside `php artisan serve`).

### Wikipedia rate limits

Wikimedia allows about 10 requests a minute from clients without contact details, and about 200 a minute when the User-Agent includes an email address or URL. The popularity command batches 50 articles per request and waits out rate limits on its own, but it's much faster if you identify yourself in `.env`:

```dotenv
WIKIPEDIA_USER_AGENT="MyKrillion/1.0 (you@example.com)"
WIKIPEDIA_REQUESTS_PER_MINUTE=150
```

### Windows notes

- If `php` on your PATH isn't the one you expect, check which binary runs with `where php`. A stand-alone PHP install needs `extension=pdo_sqlite` and `extension=sqlite3` enabled in its `php.ini`.
- HTTPS errors such as `cURL error 60` from the popularity command mean PHP has no certificate bundle. Point `curl.cainfo` and `openssl.cafile` in `php.ini` at a `cacert.pem`.

## Adding or changing questions

Questions and their answer keys live in `database/seeders`:

| File | Contains |
|---|---|
| `QuestionSeeder.php` | The question list: prompt, placeholder, and which answer key to use |
| `WorldData.php` | Countries and the geography facts the location questions filter by |
| `TriviaData.php` | Science, culture and language answer keys |
| `FoodData.php` | Dishes, pasta, cheeses and spices |
| `AnimalData.php` | Farm, zoo, cat-family and marsupial answer keys |

Each answer is `'Label' => [wikipedia article or null, [aliases]]`. Give an explicit article when the name alone is ambiguous (`'Turkey' => ['Domestic turkey', []]`). A question's `suffix` is tried before the bare label, so `'(constellation)'` makes "Cancer" measure the constellation rather than the disease.

After editing, re-seed and measure the new answers:

```bash
php artisan db:seed --class=QuestionSeeder
php artisan krillion:fetch-popularity
```

Re-seeding is safe: existing rows are updated in place, answers removed from a key are deleted, and questions removed from the list are retired rather than deleted, so old dives keep their results. The seeder tests check that every question has a key and that no alias collides with another answer.

## How it's built

| Piece | Where |
|---|---|
| Matching typed answers, aliases and "did you mean" suggestions | `app/Services/AnswerMatcher.php`, `AnswerChecker.php` |
| Scoring and crowd counts | `app/Services/AnswerScorer.php` |
| Wikipedia page views and Datamuse frequency | `app/Services/WikipediaPopularity.php`, `app/Console/Commands/FetchPopularity.php` |
| Fish classes, rarity tiers and species | `app/Enums/FishClass.php` |
| Ocean zones and depth | `app/Enums/DepthZone.php`, `app/Models/Dive.php` |
| Pages | `resources/views/dives` (boat, question, final catch, results) |
| Sea creatures, flora and scenery (inline SVG) | `resources/views/components` |
| Cast, descent, timer and spell-check scripts | `resources/js` |

The 25-second clock is enforced on the server as well as on screen: refreshing doesn't reset it, and an answer arriving more than 5 seconds late counts as a miss. Animations respect the operating system's reduced-motion setting.

## Tests

```bash
php artisan test
```

The suite uses Pest with an in-memory SQLite database, and all outbound HTTP is faked. Format PHP with `vendor/bin/pint`.
