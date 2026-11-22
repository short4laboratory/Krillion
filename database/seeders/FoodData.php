<?php

namespace Database\Seeders;

/**
 * Answer keys for the food questions. Each answer maps to [Wikipedia article or null to use the label, aliases].
 * The open-ended categories are deliberately generous so that real answers are rarely turned away.
 */
final class FoodData
{
    /**
     * Dishes from across Asia: East, South, Southeast, Central and West.
     *
     * @var array<string, array{0: string|null, 1: list<string>}>
     */
    public const array ASIAN_DISHES = [
        // Japan
        'Sushi' => [null, ['maki', 'nigiri']], 'Sashimi' => [null, []], 'Ramen' => [null, []], 'Udon' => [null, []],
        'Soba' => [null, []], 'Tempura' => [null, []], 'Tonkatsu' => [null, []], 'Teriyaki' => [null, ['teriyaki chicken']],
        'Yakitori' => [null, []], 'Okonomiyaki' => [null, []], 'Takoyaki' => [null, []], 'Onigiri' => [null, ['rice ball']],
        'Miso soup' => [null, ['miso']], 'Gyoza' => [null, []], 'Japanese curry' => [null, ['katsu curry', 'kare raisu']],
        'Katsudon' => [null, []], 'Gyudon' => [null, ['beef bowl']], 'Oyakodon' => [null, []], 'Sukiyaki' => [null, []],
        'Shabu-shabu' => [null, []], 'Mochi' => [null, []], 'Edamame' => [null, []], 'Karaage' => [null, []],
        'Yakisoba' => [null, []], 'Natto' => [null, []], 'Unagi' => [null, ['unadon']], 'Chawanmushi' => [null, []],
        // China
        'Fried rice' => [null, ['egg fried rice']], 'Chow mein' => [null, []], 'Lo mein' => [null, []],
        'Kung Pao chicken' => [null, ['kung pao']], 'Sweet and sour pork' => [null, ['sweet and sour chicken', 'sweet and sour']],
        'Peking duck' => [null, ['beijing duck', 'crispy duck']], 'Mapo tofu' => [null, []], 'Hot pot' => [null, ['hotpot']],
        'Dim sum' => [null, []], 'Dumplings' => ['Jiaozi', ['jiaozi', 'dumpling']], 'Xiaolongbao' => [null, ['soup dumplings']],
        'Char siu' => [null, ['bbq pork']], 'Wonton' => [null, ['wonton soup', 'wontons']], 'Spring rolls' => ['Spring roll', ['spring roll']],
        'Egg rolls' => ['Egg roll', ['egg roll']], 'Congee' => [null, ['jook', 'rice porridge']], 'Baozi' => [null, ['bao', 'steamed bun', 'bao bun']],
        'Dan dan noodles' => [null, []], 'General Tso\'s chicken' => [null, ['general tso']], 'Orange chicken' => [null, []],
        'Chop suey' => [null, []], 'Mooncake' => [null, []], 'Zongzi' => [null, []], 'Twice-cooked pork' => [null, []],
        'Hot and sour soup' => [null, []], 'Scallion pancake' => [null, ['scallion pancakes']], 'Shumai' => [null, ['siu mai']],
        'Har gow' => [null, []], 'Cheung fun' => ['Rice noodle roll', ['rice noodle roll']],
        // Korea
        'Kimchi' => [null, []], 'Bibimbap' => [null, []], 'Bulgogi' => [null, []], 'Korean fried chicken' => [null, []],
        'Tteokbokki' => [null, ['topokki', 'rice cakes']], 'Japchae' => [null, []], 'Gimbap' => [null, ['kimbap']],
        'Samgyeopsal' => [null, ['korean bbq', 'korean barbecue']], 'Galbi' => [null, ['kalbi']], 'Sundubu-jjigae' => [null, ['sundubu']],
        'Kimchi-jjigae' => [null, ['kimchi stew']], 'Naengmyeon' => [null, []], 'Pajeon' => [null, []], 'Jajangmyeon' => [null, []],
        'Budae-jjigae' => [null, ['army stew']], 'Mandu' => ['Mandu (food)', []],
        // Vietnam, Thailand, Cambodia, Myanmar
        'Pho' => [null, []], 'Banh mi' => [null, []], 'Bun cha' => [null, []], 'Goi cuon' => [null, ['summer rolls', 'fresh spring rolls']],
        'Bun bo Hue' => [null, []], 'Com tam' => [null, ['broken rice']], 'Banh xeo' => [null, []],
        'Pad thai' => [null, []], 'Green curry' => [null, ['thai green curry']], 'Red curry' => [null, ['thai red curry']],
        'Massaman curry' => [null, ['massaman']], 'Tom yum' => [null, ['tom yum goong']], 'Tom kha gai' => [null, ['tom kha']],
        'Som tam' => [null, ['papaya salad', 'green papaya salad']], 'Pad see ew' => [null, []], 'Pad kra pao' => [null, ['pad krapow', 'basil chicken']],
        'Mango sticky rice' => [null, []], 'Larb' => [null, ['laab']], 'Khao soi' => [null, []], 'Satay' => [null, ['sate']],
        'Fish amok' => [null, ['amok']], 'Mohinga' => [null, []],
        // South Asia
        'Biryani' => [null, []], 'Butter chicken' => [null, ['murgh makhani']], 'Chicken tikka masala' => [null, ['tikka masala']],
        'Tandoori chicken' => [null, ['tandoori']], 'Samosa' => [null, []], 'Dal' => [null, ['daal', 'dhal', 'lentil curry']],
        'Naan' => [null, []], 'Paneer tikka' => [null, []], 'Palak paneer' => [null, ['saag paneer']], 'Chana masala' => [null, ['chole']],
        'Dosa' => ['Dosa (food)', ['masala dosa']], 'Idli' => [null, []], 'Vada' => ['Vada (food)', []], 'Rogan josh' => [null, []],
        'Vindaloo' => [null, []], 'Korma' => [null, []], 'Aloo gobi' => [null, []], 'Pani puri' => [null, ['golgappa', 'puchka']],
        'Pav bhaji' => [null, []], 'Chole bhature' => [null, []], 'Gulab jamun' => [null, []], 'Rasgulla' => [null, []],
        'Pakora' => [null, ['bhaji', 'onion bhaji']], 'Momo' => ['Momo (food)', ['momos']], 'Kheer' => [null, []], 'Jalebi' => [null, []],
        'Raita' => [null, []], 'Sambar' => ['Sambar (dish)', []], 'Dhokla' => [null, []], 'Vada pav' => [null, []],
        'Malai kofta' => [null, []], 'Curry' => [null, []], 'Roti' => [null, ['chapati']], 'Paratha' => [null, []], 'Kofta' => [null, []],
        // Southeast Asia (maritime)
        'Nasi goreng' => [null, []], 'Mie goreng' => [null, []], 'Rendang' => [null, ['beef rendang']], 'Gado-gado' => [null, []],
        'Laksa' => [null, []], 'Nasi lemak' => [null, []], 'Char kway teow' => [null, []], 'Roti canai' => [null, ['roti prata']],
        'Adobo' => ['Philippine adobo', ['chicken adobo']], 'Sinigang' => [null, []], 'Lechon' => [null, []], 'Pancit' => [null, []],
        'Lumpia' => [null, []], 'Halo-halo' => [null, []], 'Sisig' => [null, []], 'Kare-kare' => [null, []],
        'Hainanese chicken rice' => [null, ['chicken rice']], 'Bak kut teh' => [null, []],
        // Central and West Asia
        'Hummus' => [null, []], 'Falafel' => [null, []], 'Shawarma' => [null, []], 'Kebab' => [null, ['kabab', 'doner kebab', 'shish kebab', 'doner']],
        'Tabbouleh' => [null, []], 'Baba ghanoush' => [null, []], 'Plov' => ['Pilaf', ['pilaf', 'pilau']], 'Manti' => ['Manti (food)', []],
        'Dolma' => [null, []], 'Baklava' => [null, []], 'Lahmacun' => [null, []], 'Shakshuka' => [null, []], 'Fattoush' => [null, []],
        'Mansaf' => [null, []], 'Kibbeh' => [null, []],
    ];

    /**
     * Shapes and kinds of Italian pasta.
     *
     * @var array<string, array{0: string|null, 1: list<string>}>
     */
    public const array PASTA = [
        'Spaghetti' => [null, []], 'Penne' => [null, ['mostaccioli']], 'Fusilli' => [null, ['spirals']], 'Farfalle' => [null, ['bow tie', 'bow ties', 'bowtie']],
        'Rigatoni' => [null, []], 'Linguine' => [null, []], 'Fettuccine' => [null, ['fettucine']], 'Tagliatelle' => [null, []],
        'Lasagne' => [null, ['lasagna']], 'Macaroni' => [null, ['elbow macaroni', 'elbows']], 'Ravioli' => [null, []],
        'Tortellini' => [null, []], 'Gnocchi' => [null, []], 'Orzo' => [null, ['risoni']], 'Conchiglie' => [null, ['shells', 'pasta shells']],
        'Orecchiette' => [null, []], 'Pappardelle' => [null, []], 'Bucatini' => [null, []], 'Cannelloni' => [null, []],
        'Capellini' => [null, ['angel hair']], 'Ziti' => [null, []], 'Rotini' => [null, []], 'Vermicelli' => [null, []],
        'Tortelloni' => [null, []], 'Cavatappi' => [null, []], 'Ditalini' => [null, ['ditali']], 'Gemelli' => [null, []],
        'Paccheri' => [null, []], 'Manicotti' => [null, []], 'Agnolotti' => [null, []], 'Cappelletti' => [null, []],
        'Fregola' => [null, ['fregula']], 'Strozzapreti' => [null, []], 'Trofie' => [null, []], 'Cavatelli' => [null, []],
        'Mafaldine' => [null, ['reginette']], 'Radiatori' => [null, []], 'Campanelle' => [null, []], 'Casarecce' => [null, []],
        'Garganelli' => [null, []], 'Pici' => [null, []], 'Tagliolini' => [null, []], 'Spaghettini' => [null, []],
        'Stelline' => [null, []], 'Anelli' => [null, []], 'Lumache' => [null, []], 'Mezzelune' => [null, []],
        'Busiate' => [null, []], 'Malloreddus' => [null, []], 'Bigoli' => [null, []], 'Rotelle' => [null, ['ruote', 'wagon wheels']],
        'Tortiglioni' => [null, []], 'Calamarata' => [null, []], 'Corzetti' => [null, []], 'Culurgiones' => [null, []],
        'Scialatielli' => [null, []], 'Sedanini' => ['Sedani', ['sedani']], 'Pastina' => [null, []], 'Acini di pepe' => [null, []],
        'Lasagnette' => [null, []],
    ];

    /**
     * Cheeses from around the world.
     *
     * @var array<string, array{0: string|null, 1: list<string>}>
     */
    public const array CHEESES = [
        'Cheddar' => [null, []], 'Mozzarella' => [null, []], 'Parmesan' => ['Parmigiano Reggiano', ['parmigiano reggiano', 'parmigiano']],
        'Brie' => [null, []], 'Camembert' => [null, []], 'Gouda' => ['Gouda cheese', []], 'Edam' => [null, []],
        'Emmental' => [null, ['swiss', 'swiss cheese', 'emmentaler']], 'Gruyère' => ['Gruyère cheese', ['gruyere']], 'Feta' => [null, []],
        'Roquefort' => [null, []], 'Gorgonzola' => [null, []], 'Stilton' => ['Stilton cheese', []], 'Blue cheese' => [null, []],
        'Ricotta' => [null, []], 'Mascarpone' => [null, []], 'Cream cheese' => [null, []], 'Cottage cheese' => [null, []],
        'Halloumi' => [null, []], 'Paneer' => [null, []], 'Manchego' => [null, []], 'Pecorino' => [null, ['pecorino romano', 'romano']],
        'Provolone' => [null, []], 'Burrata' => [null, []], 'Monterey Jack' => [null, ['jack cheese']], 'Colby' => ['Colby cheese', []],
        'Pepper Jack' => [null, []], 'American cheese' => [null, []], 'Havarti' => [null, []], 'Muenster' => ['Muenster cheese', []],
        'Brunost' => [null, ['gjetost', 'brown cheese']], 'Jarlsberg' => ['Jarlsberg cheese', []], 'Raclette' => [null, []],
        'Comté' => ['Comté cheese', ['comte']], 'Reblochon' => [null, []], 'Taleggio' => ['Taleggio cheese', []], 'Fontina' => [null, []],
        'Asiago' => ['Asiago cheese', []], 'Grana Padano' => [null, []], 'Appenzeller' => ['Appenzeller cheese', []],
        'Limburger' => [null, []], 'Wensleydale' => ['Wensleydale cheese', []], 'Red Leicester' => [null, []],
        'Double Gloucester' => ['Gloucester cheese', ['gloucester']], 'Lancashire' => ['Lancashire cheese', []], 'Cheshire' => ['Cheshire cheese', []],
        'Caerphilly' => ['Caerphilly cheese', []], 'Boursin' => ['Boursin cheese', []], 'Port Salut' => [null, []],
        'Saint-Nectaire' => [null, []], 'Munster' => ['Munster cheese', []], 'Époisses' => ['Époisses de Bourgogne', ['epoisses']],
        'Morbier' => ['Morbier cheese', []], 'Tomme' => [null, []], 'Chèvre' => ['Goat cheese', ['goat cheese', 'chevre', 'goats cheese']],
        'Queso fresco' => [null, []], 'Oaxaca' => ['Oaxaca cheese', ['quesillo']], 'Cotija' => ['Cotija cheese', []], 'Labneh' => ['Strained yogurt', []],
        'Akkawi' => [null, []], 'Kashkaval' => [null, []], 'Quark' => ['Quark (dairy product)', []], 'Tilsit' => ['Tilsit cheese', []],
        'Leerdammer' => [null, []], 'Mimolette' => [null, []], 'Kefalotyri' => [null, []], 'Graviera' => [null, []],
        'Mizithra' => [null, []], 'Danish Blue' => [null, ['danablu']], 'Cambozola' => [null, []], 'Scamorza' => [null, []],
        'Stracchino' => [null, []], 'Caciocavallo' => [null, []], 'Bocconcini' => [null, []], 'String cheese' => [null, []],
        'Velveeta' => [null, []], 'Wagasi' => [null, []], 'Cheese curds' => ['Curd cheese', ['curds', 'cheese curd']],
    ];

    /**
     * Spices and spice blends (not leafy herbs).
     *
     * @var array<string, array{0: string|null, 1: list<string>}>
     */
    public const array SPICES = [
        'Black pepper' => [null, ['pepper', 'peppercorn', 'peppercorns']], 'Cinnamon' => [null, []], 'Nutmeg' => [null, []],
        'Cumin' => [null, []], 'Turmeric' => [null, []], 'Paprika' => [null, ['smoked paprika']], 'Saffron' => [null, []],
        'Cardamom' => [null, ['cardamon']], 'Clove' => [null, ['cloves']], 'Ginger' => [null, []], 'Chili powder' => [null, ['chilli powder', 'chili', 'chilli']],
        'Cayenne pepper' => [null, ['cayenne']], 'Coriander' => [null, ['coriander seed']], 'Fennel seed' => ['Fennel', ['fennel']],
        'Star anise' => [null, []], 'Anise' => [null, ['aniseed']], 'Allspice' => [null, []], 'Mace' => ['Mace (spice)', []],
        'Sumac' => [null, []], 'Fenugreek' => [null, []], 'Mustard seed' => [null, ['mustard']], 'Caraway' => [null, []],
        'Juniper berry' => [null, ['juniper', 'juniper berries']], 'Vanilla' => [null, []], 'Asafoetida' => [null, ['hing']],
        'Garam masala' => [null, []], 'Five-spice powder' => [null, ['chinese five spice', 'five spice']], 'Curry powder' => [null, []],
        'Za\'atar' => [null, []], 'Galangal' => [null, []], 'Annatto' => [null, []], 'Nigella seed' => ['Nigella sativa', ['nigella', 'kalonji', 'black cumin']],
        'Ajwain' => [null, []], 'Celery seed' => [null, []], 'Poppy seed' => [null, []], 'Sesame seed' => ['Sesame', ['sesame']],
        'Sichuan pepper' => [null, ['szechuan pepper']], 'Pink peppercorn' => [null, []], 'Grains of paradise' => [null, []],
        'Long pepper' => [null, []], 'Dill seed' => ['Dill', []], 'Liquorice root' => ['Liquorice', ['licorice', 'licorice root']],
        'Ras el hanout' => [null, []], 'Berbere' => [null, []], 'Baharat' => [null, []], 'Garlic powder' => [null, []],
        'Onion powder' => [null, []], 'Chipotle' => [null, []], 'Wasabi' => [null, []], 'Horseradish' => [null, []],
        'White pepper' => [null, []], 'Amchur' => [null, ['mango powder', 'amchoor']], 'Tamarind' => [null, []], 'Old Bay' => ['Old Bay Seasoning', []],
    ];
}
