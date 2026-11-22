<?php

namespace Database\Seeders;

/**
 * Answer keys for the non-geography questions. Each answer maps to [Wikipedia article or null
 * to use the label, aliases], or just to its aliases where the label is always the article.
 */
final class TriviaData
{
    /**
     * Answer => [Wikipedia article (null to use the label), aliases].
     *
     * @var array<string, array{0: string|null, 1: list<string>}>
     */
    public const array ELEMENTS = [
        'Hydrogen' => [null, []], 'Helium' => [null, []], 'Lithium' => [null, []], 'Beryllium' => [null, []],
        'Boron' => [null, []], 'Carbon' => [null, []], 'Nitrogen' => [null, []], 'Oxygen' => [null, []],
        'Fluorine' => [null, []], 'Neon' => [null, []], 'Sodium' => [null, []], 'Magnesium' => [null, []],
        'Aluminium' => [null, ['aluminum']], 'Silicon' => [null, []], 'Phosphorus' => [null, []],
        'Sulfur' => [null, ['sulphur']], 'Chlorine' => [null, []], 'Argon' => [null, []], 'Potassium' => [null, []],
        'Calcium' => [null, []], 'Scandium' => [null, []], 'Titanium' => [null, []], 'Vanadium' => [null, []],
        'Chromium' => [null, []], 'Manganese' => [null, []], 'Iron' => [null, []], 'Cobalt' => [null, []],
        'Nickel' => [null, []], 'Copper' => [null, []], 'Zinc' => [null, []], 'Gallium' => [null, []],
        'Germanium' => [null, []], 'Arsenic' => [null, []], 'Selenium' => [null, []], 'Bromine' => [null, []],
        'Krypton' => [null, []], 'Rubidium' => [null, []], 'Strontium' => [null, []], 'Yttrium' => [null, []],
        'Zirconium' => [null, []], 'Niobium' => [null, []], 'Molybdenum' => [null, []], 'Technetium' => [null, []],
        'Ruthenium' => [null, []], 'Rhodium' => [null, []], 'Palladium' => [null, []], 'Silver' => [null, []],
        'Cadmium' => [null, []], 'Indium' => [null, []], 'Tin' => [null, []], 'Antimony' => [null, []],
        'Tellurium' => [null, []], 'Iodine' => [null, []], 'Xenon' => [null, []], 'Caesium' => [null, ['cesium']],
        'Barium' => [null, []], 'Lanthanum' => [null, []], 'Cerium' => [null, []], 'Praseodymium' => [null, []],
        'Neodymium' => [null, []], 'Promethium' => [null, []], 'Samarium' => [null, []], 'Europium' => [null, []],
        'Gadolinium' => [null, []], 'Terbium' => [null, []], 'Dysprosium' => [null, []], 'Holmium' => [null, []],
        'Erbium' => [null, []], 'Thulium' => [null, []], 'Ytterbium' => [null, []], 'Lutetium' => [null, []],
        'Hafnium' => [null, []], 'Tantalum' => [null, []], 'Tungsten' => [null, ['wolfram']], 'Rhenium' => [null, []],
        'Osmium' => [null, []], 'Iridium' => [null, []], 'Platinum' => [null, []], 'Gold' => [null, []],
        'Mercury' => ['Mercury (element)', []], 'Thallium' => [null, []], 'Lead' => [null, []], 'Bismuth' => [null, []],
        'Polonium' => [null, []], 'Astatine' => [null, []], 'Radon' => [null, []], 'Francium' => [null, []],
        'Radium' => [null, []], 'Actinium' => [null, []], 'Thorium' => [null, []], 'Protactinium' => [null, []],
        'Uranium' => [null, []], 'Neptunium' => [null, []], 'Plutonium' => [null, []], 'Americium' => [null, []],
        'Curium' => [null, []], 'Berkelium' => [null, []], 'Californium' => [null, []], 'Einsteinium' => [null, []],
        'Fermium' => [null, []], 'Mendelevium' => [null, []], 'Nobelium' => [null, []], 'Lawrencium' => [null, []],
        'Rutherfordium' => [null, []], 'Dubnium' => [null, []], 'Seaborgium' => [null, []], 'Bohrium' => [null, []],
        'Hassium' => [null, []], 'Meitnerium' => [null, []], 'Darmstadtium' => [null, []], 'Roentgenium' => [null, []],
        'Copernicium' => [null, []], 'Nihonium' => [null, []], 'Flerovium' => [null, []], 'Moscovium' => [null, []],
        'Livermorium' => [null, []], 'Tennessine' => [null, []], 'Oganesson' => [null, []],
    ];

    /**
     * @var array<string, array{0: string|null, 1: list<string>}>
     */
    public const array BONES = [
        'Femur' => [null, ['thigh bone', 'thighbone']], 'Tibia' => [null, ['shin bone', 'shinbone']],
        'Fibula' => [null, ['calf bone']], 'Patella' => [null, ['kneecap', 'knee cap']], 'Humerus' => [null, []],
        'Radius' => ['Radius (bone)', []], 'Ulna' => [null, []], 'Clavicle' => [null, ['collarbone', 'collar bone']],
        'Scapula' => [null, ['shoulder blade']], 'Sternum' => [null, ['breastbone', 'breast bone']],
        'Rib' => [null, ['ribs', 'rib cage']], 'Skull' => [null, ['cranium']],
        'Mandible' => [null, ['jawbone', 'jaw bone', 'jaw', 'lower jaw']], 'Maxilla' => [null, ['upper jaw']],
        'Pelvis' => [null, ['pelvic bone']], 'Hip bone' => [null, ['innominate bone', 'coxal bone', 'os coxae']],
        'Sacrum' => [null, []], 'Coccyx' => [null, ['tailbone', 'tail bone']],
        'Vertebra' => [null, ['vertebrae', 'backbone', 'spine', 'cervical vertebra', 'thoracic vertebra', 'lumbar vertebra']],
        'Atlas' => ['Atlas (anatomy)', []], 'Axis' => ['Axis (anatomy)', []], 'Hyoid' => ['Hyoid bone', ['hyoid bone']],
        'Stapes' => [null, ['stirrup']], 'Incus' => [null, ['anvil']], 'Malleus' => [null, ['hammer']],
        'Talus' => ['Talus bone', ['talus bone', 'ankle bone', 'astragalus']],
        'Calcaneus' => [null, ['heel bone', 'heel', 'calcaneum']], 'Navicular' => ['Navicular bone', ['navicular bone']],
        'Cuboid' => ['Cuboid bone', ['cuboid bone']], 'Cuneiform' => ['Cuneiform bones', ['cuneiforms', 'cuneiform bone']],
        'Scaphoid' => ['Scaphoid bone', ['scaphoid bone']], 'Lunate' => ['Lunate bone', ['lunate bone']],
        'Triquetrum' => ['Triquetral bone', ['triquetral', 'triquetral bone']], 'Pisiform' => ['Pisiform bone', ['pisiform bone']],
        'Trapezium' => ['Trapezium (bone)', []], 'Trapezoid' => ['Trapezoid bone', ['trapezoid bone']],
        'Capitate' => ['Capitate bone', ['capitate bone']], 'Hamate' => ['Hamate bone', ['hamate bone']],
        'Carpal' => ['Carpal bones', ['carpals', 'carpal bone', 'wrist bone']],
        'Tarsal' => ['Tarsus (skeleton)', ['tarsals', 'tarsal bone']],
        'Metacarpal' => ['Metacarpal bones', ['metacarpals']], 'Metatarsal' => ['Metatarsal bones', ['metatarsals']],
        'Phalanx' => ['Phalanx bone', ['phalanges', 'finger bone', 'toe bone']],
        'Frontal bone' => [null, ['frontal']], 'Parietal bone' => [null, ['parietal']],
        'Temporal bone' => [null, ['temporal']], 'Occipital bone' => [null, ['occipital']],
        'Sphenoid' => ['Sphenoid bone', ['sphenoid bone']], 'Ethmoid' => ['Ethmoid bone', ['ethmoid bone']],
        'Nasal bone' => [null, ['nasal']], 'Lacrimal bone' => [null, ['lacrimal']],
        'Zygomatic bone' => [null, ['cheekbone', 'cheek bone', 'zygomatic']], 'Palatine bone' => [null, ['palatine']],
        'Vomer' => [null, []], 'Inferior nasal concha' => [null, ['nasal concha', 'turbinate']],
        'Ilium' => ['Ilium (bone)', []], 'Ischium' => [null, []], 'Pubis' => ['Pubis (bone)', ['pubic bone']],
        'Sesamoid' => ['Sesamoid bone', ['sesamoid bone']],
    ];

    /**
     * The 88 constellations recognised by the International Astronomical Union.
     *
     * @var array<string, list<string>>
     */
    public const array CONSTELLATIONS = [
        'Andromeda' => [], 'Antlia' => [], 'Apus' => [], 'Aquarius' => [], 'Aquila' => [], 'Ara' => [], 'Aries' => [],
        'Auriga' => [], 'Boötes' => [], 'Caelum' => [], 'Camelopardalis' => [], 'Cancer' => [], 'Canes Venatici' => [],
        'Canis Major' => ['great dog'], 'Canis Minor' => ['little dog'], 'Capricornus' => ['capricorn'], 'Carina' => [],
        'Cassiopeia' => [], 'Centaurus' => [], 'Cepheus' => [], 'Cetus' => [], 'Chamaeleon' => ['chameleon'],
        'Circinus' => [], 'Columba' => [], 'Coma Berenices' => [], 'Corona Australis' => [], 'Corona Borealis' => [],
        'Corvus' => [], 'Crater' => [], 'Crux' => ['southern cross'], 'Cygnus' => [], 'Delphinus' => [], 'Dorado' => [],
        'Draco' => [], 'Equuleus' => [], 'Eridanus' => [], 'Fornax' => [], 'Gemini' => [], 'Grus' => [],
        'Hercules' => [], 'Horologium' => [], 'Hydra' => [], 'Hydrus' => [], 'Indus' => [], 'Lacerta' => [],
        'Leo' => [], 'Leo Minor' => [], 'Lepus' => [], 'Libra' => [], 'Lupus' => [], 'Lynx' => [], 'Lyra' => [],
        'Mensa' => [], 'Microscopium' => [], 'Monoceros' => [], 'Musca' => [], 'Norma' => [], 'Octans' => [],
        'Ophiuchus' => [], 'Orion' => [], 'Pavo' => [], 'Pegasus' => [], 'Perseus' => [], 'Phoenix' => [],
        'Pictor' => [], 'Pisces' => [], 'Piscis Austrinus' => [], 'Puppis' => [], 'Pyxis' => [], 'Reticulum' => [],
        'Sagitta' => [], 'Sagittarius' => [], 'Scorpius' => ['scorpio'], 'Sculptor' => [], 'Scutum' => [],
        'Serpens' => [], 'Sextans' => [], 'Taurus' => [], 'Telescopium' => [], 'Triangulum' => [],
        'Triangulum Australe' => [], 'Tucana' => [], 'Ursa Major' => ['great bear', 'big dipper'],
        'Ursa Minor' => ['little bear', 'little dipper'], 'Vela' => [], 'Virgo' => [], 'Volans' => [], 'Vulpecula' => [],
    ];

    /**
     * Plays in the Shakespeare canon (including collaborations).
     *
     * @var array<string, list<string>>
     */
    public const array SHAKESPEARE_PLAYS = [
        'Hamlet' => [], 'Macbeth' => [], 'Othello' => [], 'King Lear' => ['lear'], 'Romeo and Juliet' => [],
        'A Midsummer Night\'s Dream' => ['midsummer nights dream'], 'The Tempest' => [], 'Julius Caesar' => [],
        'Twelfth Night' => [], 'Much Ado About Nothing' => [], 'The Merchant of Venice' => [],
        'The Taming of the Shrew' => [], 'As You Like It' => [], 'Richard III' => ['richard the third'],
        'Henry V' => ['henry the fifth'], 'Antony and Cleopatra' => [], 'The Comedy of Errors' => [],
        'Titus Andronicus' => [], 'The Winter\'s Tale' => [], 'Coriolanus' => [], 'Cymbeline' => [],
        'Pericles, Prince of Tyre' => ['pericles'], 'Timon of Athens' => [], 'Troilus and Cressida' => [],
        'Measure for Measure' => [], 'All\'s Well That Ends Well' => [], 'The Two Gentlemen of Verona' => [],
        'Love\'s Labour\'s Lost' => ['loves labors lost'], 'The Merry Wives of Windsor' => [], 'Richard II' => ['richard the second'],
        'King John' => [], 'Henry IV, Part 1' => ['henry iv', 'henry iv part one', 'henry the fourth'],
        'Henry IV, Part 2' => ['henry iv part two'], 'Henry VI, Part 1' => ['henry vi', 'henry vi part one'],
        'Henry VI, Part 2' => ['henry vi part two'], 'Henry VI, Part 3' => ['henry vi part three'],
        'Henry VIII' => ['henry the eighth'], 'The Two Noble Kinsmen' => [], 'Edward III' => [],
    ];

    /**
     * The 24 letters of the Greek alphabet => [Wikipedia article or null, aliases].
     *
     * @var array<string, array{0: string|null, 1: list<string>}>
     */
    public const array GREEK_LETTERS = [
        'Alpha' => [null, []], 'Beta' => [null, []], 'Gamma' => [null, []], 'Delta' => [null, []],
        'Epsilon' => [null, []], 'Zeta' => [null, []], 'Eta' => [null, []], 'Theta' => [null, []],
        'Iota' => [null, []], 'Kappa' => [null, []], 'Lambda' => [null, []], 'Mu' => [null, []],
        'Nu' => ['Nu (Greek)', []], 'Xi' => [null, []], 'Omicron' => [null, []], 'Pi' => [null, []],
        'Rho' => [null, []], 'Sigma' => [null, []], 'Tau' => [null, []], 'Upsilon' => [null, []],
        'Phi' => [null, []], 'Chi' => [null, []], 'Psi' => [null, []], 'Omega' => [null, []],
    ];

    /**
     * Birds that can't fly, living or extinct.
     *
     * @var array<string, array{0: string|null, 1: list<string>}>
     */
    public const array FLIGHTLESS_BIRDS = [
        'Ostrich' => [null, []], 'Emu' => [null, []], 'Cassowary' => [null, []], 'Rhea' => ['Rhea (bird)', []],
        'Kiwi' => ['Kiwi (bird)', []],
        'Penguin' => [null, ['emperor penguin', 'king penguin', 'adelie penguin', 'gentoo penguin', 'chinstrap penguin', 'rockhopper penguin', 'macaroni penguin', 'little penguin', 'african penguin', 'galapagos penguin', 'magellanic penguin', 'humboldt penguin']],
        'Kākāpō' => [null, ['kakapo']], 'Takahē' => [null, ['takahe']], 'Weka' => [null, []],
        'Flightless cormorant' => [null, ['galapagos cormorant']], 'Steamer duck' => [null, []],
        'Inaccessible Island rail' => [null, ['inaccessible rail']], 'Dodo' => [null, []], 'Moa' => [null, []],
        'Great auk' => [null, []], 'Elephant bird' => [null, []],
    ];

    /**
     * The planets and the five recognised dwarf planets of our solar system.
     *
     * @var array<string, array{0: string|null, 1: list<string>}>
     */
    public const array PLANETS = [
        'Mercury' => ['Mercury (planet)', []], 'Venus' => [null, []], 'Earth' => [null, []], 'Mars' => [null, []],
        'Jupiter' => [null, []], 'Saturn' => [null, []], 'Uranus' => [null, []], 'Neptune' => [null, []],
        'Pluto' => [null, []], 'Ceres' => ['Ceres (dwarf planet)', []], 'Eris' => ['Eris (dwarf planet)', []],
        'Haumea' => [null, []], 'Makemake' => [null, []],
    ];

    /**
     * The Olympian gods of Greek mythology (Hestia and Dionysus both count), plus Hades.
     *
     * @var array<string, list<string>>
     */
    public const array GREEK_GODS = [
        'Zeus' => [], 'Hera' => [], 'Poseidon' => [], 'Demeter' => [], 'Athena' => ['athene'], 'Apollo' => [],
        'Artemis' => [], 'Ares' => [], 'Aphrodite' => [], 'Hephaestus' => ['hephaistos'], 'Hermes' => [],
        'Hestia' => [], 'Dionysus' => ['dionysos'], 'Hades' => [],
    ];

    /**
     * Gods and goddesses of Norse mythology => [Wikipedia article or null, aliases].
     *
     * @var array<string, array{0: string|null, 1: list<string>}>
     */
    public const array NORSE_GODS = [
        'Odin' => [null, ['woden', 'wotan', 'odinn']], 'Thor' => [null, []], 'Loki' => [null, []],
        'Frigg' => [null, ['frigga']], 'Freyja' => [null, ['freya']], 'Freyr' => [null, ['frey']],
        'Baldr' => [null, ['baldur', 'balder']], 'Týr' => [null, ['tiw']], 'Heimdall' => [null, ['heimdallr']],
        'Hel' => ['Hel (mythological being)', []], 'Njörðr' => [null, ['njord', 'njordr', 'njoror']], 'Bragi' => [null, []],
        'Iðunn' => [null, ['idun', 'idunn', 'iduna']], 'Víðarr' => [null, ['vidar', 'vidarr']], 'Váli' => [null, ['vali']],
        'Höðr' => [null, ['hodr', 'hod', 'hoder']], 'Ullr' => [null, ['ull']], 'Forseti' => [null, []], 'Sif' => [null, []],
        'Skaði' => [null, ['skadi']],
    ];

    /**
     * Sports and disciplines on the programme of the Paris 2024 Summer Olympics.
     *
     * @var array<string, array{0: string|null, 1: list<string>}>
     */
    public const array PARIS_2024_SPORTS = [
        'Archery' => [null, []], 'Artistic gymnastics' => [null, ['gymnastics']], 'Rhythmic gymnastics' => [null, []],
        'Trampoline' => ['Trampolining', ['trampolining']], 'Artistic swimming' => [null, ['synchronised swimming', 'synchronized swimming']],
        'Athletics' => ['Athletics (sport)', ['track and field', 'track', 'running']], 'Badminton' => [null, []],
        'Basketball' => [null, []], '3x3 basketball' => [null, ['3x3']], 'Beach volleyball' => [null, []],
        'Volleyball' => [null, []], 'Boxing' => [null, []], 'Breaking' => ['Breakdancing', ['breakdancing', 'breakdance']],
        'Canoeing' => [null, ['canoe', 'kayaking', 'kayak', 'canoe sprint', 'canoe slalom']],
        'Cycling' => [null, ['road cycling', 'track cycling']], 'BMX' => [null, ['bmx racing', 'bmx freestyle']],
        'Mountain biking' => [null, ['mountain bike']], 'Diving' => ['Diving (sport)', []],
        'Equestrian' => ['Equestrianism', ['horse riding', 'dressage', 'show jumping', 'eventing']], 'Fencing' => [null, []],
        'Football' => ['Association football', ['soccer']], 'Golf' => [null, []], 'Handball' => [null, []],
        'Field hockey' => [null, ['hockey']], 'Judo' => [null, []], 'Marathon swimming' => [null, ['open water swimming']],
        'Modern pentathlon' => [null, ['pentathlon']], 'Rowing' => ['Rowing (sport)', []], 'Rugby sevens' => [null, ['rugby']],
        'Sailing' => [null, []], 'Shooting' => ['Shooting sports', []], 'Skateboarding' => [null, []],
        'Sport climbing' => [null, ['climbing', 'rock climbing']], 'Surfing' => [null, []],
        'Swimming' => ['Swimming (sport)', []], 'Table tennis' => [null, ['ping pong']], 'Taekwondo' => [null, []],
        'Tennis' => [null, []], 'Triathlon' => [null, []], 'Water polo' => [null, []],
        'Weightlifting' => ['Olympic weightlifting', []], 'Wrestling' => [null, []],
    ];

    /**
     * Cloud types: the ten genera plus well-known special clouds.
     *
     * @var array<string, array{0: string|null, 1: list<string>}>
     */
    public const array CLOUDS = [
        'Cirrus' => [null, []], 'Cirrocumulus' => [null, []], 'Cirrostratus' => [null, []], 'Altocumulus' => [null, []],
        'Altostratus' => [null, []], 'Nimbostratus' => [null, []], 'Stratocumulus' => [null, []], 'Stratus' => [null, []],
        'Cumulus' => [null, []], 'Cumulonimbus' => [null, ['thundercloud', 'thunderhead', 'storm cloud']],
        'Lenticular' => [null, []], 'Mammatus' => [null, []], 'Noctilucent' => [null, []],
        'Nacreous' => ['Polar stratospheric cloud', ['polar stratospheric', 'mother of pearl']], 'Arcus' => [null, ['shelf cloud', 'roll cloud']],
        'Wall cloud' => [null, []], 'Funnel cloud' => [null, []], 'Pileus' => ['Pileus (meteorology)', ['cap cloud']],
        'Contrail' => [null, ['vapour trail', 'vapor trail']], 'Fog' => [null, ['mist']], 'Pyrocumulus' => [null, ['flammagenitus', 'fire cloud']],
        'Fluctus' => ['Kelvin–Helmholtz instability', ['kelvin helmholtz']],
    ];

    /**
     * The twelve animals of the Chinese zodiac.
     *
     * @var array<string, list<string>>
     */
    public const array CHINESE_ZODIAC = [
        'Rat' => ['mouse'], 'Ox' => ['cow', 'bull', 'buffalo'], 'Tiger' => [], 'Rabbit' => ['hare'], 'Dragon' => [],
        'Snake' => [], 'Horse' => [], 'Goat' => ['sheep', 'ram'], 'Monkey' => [], 'Rooster' => ['chicken', 'cock', 'hen'],
        'Dog' => [], 'Pig' => ['boar'],
    ];

    /**
     * The seven SI base units and the 22 named derived units.
     *
     * @var array<string, array{0: string|null, 1: list<string>}>
     */
    public const array SI_UNITS = [
        'Metre' => [null, ['meter']], 'Kilogram' => [null, ['kilo']], 'Second' => [null, []], 'Ampere' => [null, ['amp']],
        'Kelvin' => [null, []], 'Mole' => ['Mole (unit)', []], 'Candela' => [null, []], 'Radian' => [null, []],
        'Steradian' => [null, []], 'Hertz' => [null, []], 'Newton' => ['Newton (unit)', []], 'Pascal' => ['Pascal (unit)', []],
        'Joule' => [null, []], 'Watt' => [null, []], 'Coulomb' => [null, []], 'Volt' => [null, []], 'Farad' => [null, []],
        'Ohm' => [null, []], 'Siemens' => ['Siemens (unit)', []], 'Weber' => ['Weber (unit)', []], 'Tesla' => ['Tesla (unit)', []],
        'Henry' => ['Henry (unit)', []], 'Degree Celsius' => ['Celsius', ['celsius', 'degrees celsius']], 'Lumen' => ['Lumen (unit)', []],
        'Lux' => [null, []], 'Becquerel' => [null, []], 'Gray' => ['Gray (unit)', []], 'Sievert' => [null, []], 'Katal' => [null, []],
    ];

    /**
     * The 24 official languages of the European Union.
     *
     * @var array<string, list<string>>
     */
    public const array EU_LANGUAGES = [
        'Bulgarian' => [], 'Croatian' => [], 'Czech' => [], 'Danish' => [], 'Dutch' => ['flemish'], 'English' => [],
        'Estonian' => [], 'Finnish' => [], 'French' => [], 'German' => [], 'Greek' => [], 'Hungarian' => [],
        'Irish' => ['gaelic', 'irish gaelic'], 'Italian' => [], 'Latvian' => [], 'Lithuanian' => [], 'Maltese' => [],
        'Polish' => [], 'Portuguese' => [], 'Romanian' => [], 'Slovak' => [], 'Slovene' => ['slovenian'], 'Spanish' => [],
        'Swedish' => [],
    ];

    /**
     * The 22 cards of the tarot's major arcana.
     *
     * @var array<string, list<string>>
     */
    public const array TAROT_MAJOR_ARCANA = [
        'The Fool' => [], 'The Magician' => [], 'The High Priestess' => [], 'The Empress' => [], 'The Emperor' => [],
        'The Hierophant' => [], 'The Lovers' => [], 'The Chariot' => [], 'Strength' => [], 'The Hermit' => [],
        'Wheel of Fortune' => [], 'Justice' => [], 'The Hanged Man' => [], 'Death' => [], 'Temperance' => [],
        'The Devil' => [], 'The Tower' => [], 'The Star' => [], 'The Moon' => [], 'The Sun' => [], 'Judgement' => ['judgment'],
        'The World' => [],
    ];
}
