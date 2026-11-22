<?php

namespace Database\Seeders;

/**
 * Answer keys for the animal questions. Each answer maps to [Wikipedia article or null to use the label, aliases].
 * Explicit articles avoid ambiguous titles, e.g. "Turkey" (the country) or "Seal" (a disambiguation page).
 */
final class AnimalData
{
    /**
     * Animals kept on farms, including the young and sexes people often name instead.
     *
     * @var array<string, array{0: string|null, 1: list<string>}>
     */
    public const array FARM_ANIMALS = [
        'Cow' => ['Cattle', ['cattle', 'bull', 'calf', 'ox', 'oxen', 'heifer', 'steer', 'dairy cow']],
        'Pig' => ['Domestic pig', ['hog', 'boar', 'sow', 'piglet', 'swine']],
        'Sheep' => [null, ['lamb', 'ram', 'ewe']], 'Goat' => [null, ['billy goat', 'nanny goat']],
        'Horse' => [null, ['pony', 'foal', 'mare', 'stallion', 'colt']], 'Donkey' => [null, ['ass', 'burro']], 'Mule' => [null, []],
        'Chicken' => [null, ['hen', 'rooster', 'chick', 'cockerel', 'chickens']], 'Duck' => [null, ['duckling']],
        'Goose' => [null, ['geese', 'gosling']], 'Turkey' => ['Domestic turkey', []], 'Rabbit' => [null, ['bunny']],
        'Llama' => [null, []], 'Alpaca' => [null, []], 'Water buffalo' => [null, ['buffalo']], 'Yak' => ['Domestic yak', []],
        'Camel' => [null, []], 'Guinea fowl' => ['Guineafowl', ['guineafowl']], 'Quail' => [null, []], 'Pheasant' => [null, []],
        'Ostrich' => [null, []], 'Emu' => [null, []], 'Peacock' => ['Peafowl', ['peafowl', 'peahen']],
        'Pigeon' => ['Rock dove', ['dove']], 'Dog' => [null, ['sheepdog', 'farm dog', 'collie']], 'Cat' => [null, ['barn cat']],
        'Honey bee' => [null, ['bee', 'bees', 'honeybee']], 'Barn owl' => [null, ['owl']], 'Reindeer' => [null, []],
        'Bison' => [null, []], 'Deer' => [null, []], 'Guinea pig' => [null, []], 'Mouse' => [null, ['mice']], 'Rat' => [null, []],
        'Zebu' => [null, []], 'Silkworm' => ['Bombyx mori', []],
    ];

    /**
     * Animals commonly kept at zoos (and the aquariums many zoos include), by common name.
     *
     * @var array<string, array{0: string|null, 1: list<string>}>
     */
    public const array ZOO_ANIMALS = [
        // Big cats and other carnivores
        'Lion' => [null, ['lioness']], 'Tiger' => [null, []], 'Leopard' => [null, []], 'Snow leopard' => [null, []],
        'Cheetah' => [null, []], 'Jaguar' => [null, []], 'Cougar' => [null, ['puma', 'mountain lion']], 'Lynx' => [null, []],
        'Serval' => [null, []], 'Caracal' => [null, []], 'Ocelot' => [null, []], 'Wolf' => [null, ['grey wolf', 'gray wolf']],
        'Fox' => [null, ['red fox']], 'Arctic fox' => [null, []], 'Fennec fox' => [null, ['fennec']], 'Hyena' => [null, []],
        'Meerkat' => [null, []], 'Otter' => [null, []], 'Badger' => [null, []], 'Skunk' => [null, []], 'Raccoon' => [null, []],
        'Red panda' => [null, []], 'Giant panda' => [null, ['panda']], 'Bear' => [null, []], 'Polar bear' => [null, []],
        'Brown bear' => [null, ['grizzly', 'grizzly bear']], 'Sun bear' => [null, []], 'Binturong' => [null, ['bearcat']],
        'Coati' => [null, []], 'Kinkajou' => [null, []], 'Fossa' => ['Fossa (animal)', []], 'Wolverine' => [null, []],
        // Primates
        'Monkey' => [null, []], 'Gorilla' => [null, []], 'Chimpanzee' => [null, ['chimp']], 'Bonobo' => [null, []],
        'Orangutan' => [null, []], 'Gibbon' => [null, []], 'Baboon' => [null, []], 'Mandrill' => [null, []],
        'Capuchin' => ['Capuchin monkey', ['capuchin monkey']], 'Tamarin' => [null, []], 'Marmoset' => [null, []],
        'Lemur' => [null, ['ring-tailed lemur']], 'Aye-aye' => [null, []], 'Spider monkey' => [null, []], 'Howler monkey' => [null, []],
        'Macaque' => [null, ['snow monkey']],
        // Large herbivores
        'Elephant' => [null, []], 'Giraffe' => [null, []], 'Zebra' => [null, []], 'Hippopotamus' => [null, ['hippo']],
        'Rhinoceros' => [null, ['rhino']], 'Tapir' => [null, []], 'Okapi' => [null, []], 'Camel' => [null, []],
        'Llama' => [null, []], 'Alpaca' => [null, []], 'Bison' => [null, ['american buffalo']], 'Buffalo' => ['African buffalo', ['african buffalo', 'cape buffalo']],
        'Yak' => [null, []], 'Antelope' => [null, []], 'Gazelle' => [null, []], 'Impala' => [null, []],
        'Wildebeest' => [null, ['gnu']], 'Oryx' => [null, []], 'Kudu' => [null, []], 'Bongo' => ['Bongo (antelope)', []],
        'Nyala' => [null, []], 'Dik-dik' => [null, []], 'Moose' => [null, []], 'Elk' => [null, ['wapiti']], 'Reindeer' => [null, ['caribou']],
        'Deer' => [null, []], 'Warthog' => ['Common warthog', []], 'Muskox' => [null, ['musk ox']], 'Ibex' => [null, []],
        'Mountain goat' => [null, []], 'Takin' => [null, []], 'Capybara' => [null, []],
        // Small mammals and oddities
        'Sloth' => [null, []], 'Armadillo' => [null, []], 'Anteater' => [null, ['giant anteater']], 'Aardvark' => [null, []],
        'Pangolin' => [null, []], 'Hedgehog' => [null, []], 'Porcupine' => [null, []], 'Beaver' => [null, []],
        'Hyrax' => [null, []], 'Bat' => [null, ['fruit bat']], 'Prairie dog' => [null, []],
        // Australian animals
        'Kangaroo' => [null, []], 'Wallaby' => [null, []], 'Koala' => [null, []], 'Wombat' => [null, []],
        'Tasmanian devil' => [null, []], 'Quokka' => [null, []], 'Platypus' => [null, []], 'Echidna' => [null, []],
        // Marine mammals and fish
        'Sea lion' => [null, []], 'Seal' => ['Pinniped', []], 'Walrus' => [null, []], 'Dolphin' => [null, []],
        'Manatee' => [null, []], 'Shark' => [null, []], 'Stingray' => [null, []], 'Penguin' => [null, []],
        // Birds
        'Flamingo' => [null, []], 'Ostrich' => [null, []], 'Emu' => [null, []], 'Cassowary' => [null, []],
        'Parrot' => [null, []], 'Macaw' => [null, []], 'Cockatoo' => [null, []], 'Toucan' => [null, []],
        'Peacock' => ['Peafowl', ['peafowl']], 'Owl' => [null, []], 'Eagle' => [null, ['bald eagle']], 'Vulture' => [null, []],
        'Hawk' => [null, []], 'Falcon' => [null, []], 'Condor' => [null, []], 'Pelican' => [null, []], 'Stork' => [null, []],
        'Crane' => ['Crane (bird)', []], 'Ibis' => [null, []], 'Hornbill' => [null, []], 'Kiwi' => ['Kiwi (bird)', []],
        'Secretary bird' => ['Secretarybird', ['secretarybird']], 'Shoebill' => [null, []], 'Kookaburra' => [null, []],
        // Reptiles, amphibians and invertebrates
        'Crocodile' => [null, []], 'Alligator' => [null, []], 'Gharial' => [null, []], 'Snake' => [null, []],
        'Python' => ['Pythonidae', []], 'Cobra' => [null, ['king cobra']], 'Boa constrictor' => [null, ['boa']], 'Anaconda' => ['Green anaconda', []],
        'Tortoise' => [null, ['giant tortoise', 'galapagos tortoise']], 'Turtle' => [null, []], 'Lizard' => [null, []],
        'Komodo dragon' => [null, []], 'Iguana' => [null, []], 'Chameleon' => [null, []], 'Gecko' => [null, []],
        'Tuatara' => [null, []], 'Frog' => [null, ['poison dart frog']], 'Toad' => [null, []], 'Salamander' => [null, []],
        'Axolotl' => [null, []], 'Tarantula' => [null, []], 'Scorpion' => [null, []], 'Butterfly' => [null, []],
    ];

    /**
     * Every species in the cat family (Felidae), plus the domestic cat.
     *
     * @var array<string, array{0: string|null, 1: list<string>}>
     */
    public const array CAT_FAMILY = [
        'Lion' => [null, []], 'Tiger' => [null, []], 'Leopard' => [null, ['panther', 'black panther']], 'Jaguar' => [null, []],
        'Cheetah' => [null, []], 'Snow leopard' => [null, []], 'Clouded leopard' => [null, []], 'Sunda clouded leopard' => [null, []],
        'Cougar' => [null, ['puma', 'mountain lion', 'panther cat']], 'Eurasian lynx' => [null, ['lynx']], 'Canada lynx' => [null, []],
        'Iberian lynx' => [null, []], 'Bobcat' => [null, []], 'Caracal' => [null, []], 'Serval' => [null, []], 'Ocelot' => [null, []],
        'Margay' => [null, []], 'Oncilla' => [null, []], 'Jaguarundi' => [null, []], 'Geoffroy\'s cat' => [null, []],
        'Kodkod' => [null, ['guina']], 'Andean mountain cat' => [null, ['andean cat']], 'Pampas cat' => [null, []],
        'Sand cat' => [null, []], 'Black-footed cat' => [null, []], 'African wildcat' => [null, []],
        'European wildcat' => [null, ['wildcat', 'scottish wildcat']], 'Jungle cat' => [null, []], 'Fishing cat' => [null, []],
        'Flat-headed cat' => [null, []], 'Rusty-spotted cat' => [null, []], 'Leopard cat' => [null, []], 'Iriomote cat' => [null, []],
        'Pallas\'s cat' => [null, ['manul', 'pallas cat']], 'Marbled cat' => [null, []], 'Asian golden cat' => [null, []],
        'African golden cat' => [null, []], 'Bay cat' => [null, ['bornean bay cat']], 'Chinese mountain cat' => [null, []],
        'Domestic cat' => ['Cat', ['cat', 'house cat', 'housecat', 'kitten']],
    ];

    /**
     * Marsupials of Australasia and the Americas.
     *
     * @var array<string, array{0: string|null, 1: list<string>}>
     */
    public const array MARSUPIALS = [
        'Kangaroo' => [null, ['red kangaroo', 'grey kangaroo', 'gray kangaroo', 'roo']], 'Koala' => [null, ['koala bear']],
        'Wombat' => [null, []], 'Wallaby' => [null, []], 'Wallaroo' => [null, []], 'Tree-kangaroo' => [null, ['tree kangaroo']],
        'Quokka' => [null, []], 'Pademelon' => [null, []], 'Potoroo' => [null, []], 'Bettong' => [null, []],
        'Opossum' => [null, ['virginia opossum']], 'Possum' => ['Phalangeriformes', ['brushtail possum', 'ringtail possum']],
        'Tasmanian devil' => [null, []], 'Thylacine' => [null, ['tasmanian tiger', 'tasmanian wolf']], 'Quoll' => [null, []],
        'Numbat' => [null, []], 'Bilby' => [null, []], 'Bandicoot' => [null, []], 'Sugar glider' => [null, []],
        'Greater glider' => [null, []], 'Feathertail glider' => [null, []], 'Cuscus' => ['Phalanger', []], 'Dunnart' => [null, []],
        'Antechinus' => [null, []], 'Phascogale' => [null, []], 'Marsupial mole' => [null, []], 'Monito del monte' => [null, []],
        'Shrew opossum' => [null, []], 'Honey possum' => [null, []], 'Kowari' => [null, []], 'Planigale' => [null, []],
        'Ningaui' => [null, []], 'Mulgara' => [null, []],
    ];
}
