<?php

namespace Database\Seeders;

/**
 * Reference lists for the geography questions: every sovereign country (UN members plus
 * Kosovo, Palestine, Taiwan and Vatican City) with the aliases people commonly type, and
 * the facts each question filters them by.
 */
final class WorldData
{
    /**
     * Country => aliases.
     *
     * @var array<string, list<string>>
     */
    public const array COUNTRIES = [
        'Afghanistan' => [], 'Albania' => [], 'Algeria' => [], 'Andorra' => [], 'Angola' => [],
        'Antigua and Barbuda' => ['antigua'], 'Argentina' => [], 'Armenia' => [], 'Australia' => [], 'Austria' => [],
        'Azerbaijan' => [], 'Bahamas' => [], 'Bahrain' => [], 'Bangladesh' => [], 'Barbados' => [],
        'Belarus' => [], 'Belgium' => [], 'Belize' => [], 'Benin' => [], 'Bhutan' => [], 'Bolivia' => [],
        'Bosnia and Herzegovina' => ['bosnia', 'bosnia herzegovina'], 'Botswana' => [], 'Brazil' => [],
        'Brunei' => [], 'Bulgaria' => [], 'Burkina Faso' => [], 'Burundi' => [], 'Cambodia' => [],
        'Cameroon' => [], 'Canada' => [], 'Cape Verde' => ['cabo verde'], 'Central African Republic' => ['car'],
        'Chad' => [], 'Chile' => [], 'China' => ['prc', 'peoples republic of china'], 'Colombia' => [],
        'Comoros' => [], 'Costa Rica' => [], 'Croatia' => [], 'Cuba' => [], 'Cyprus' => [],
        'Czech Republic' => ['czechia'], 'Democratic Republic of the Congo' => ['drc', 'dr congo', 'congo kinshasa', 'democratic republic of congo'],
        'Denmark' => [], 'Djibouti' => [], 'Dominica' => [], 'Dominican Republic' => [], 'Ecuador' => [],
        'Egypt' => [], 'El Salvador' => [], 'Equatorial Guinea' => [], 'Eritrea' => [], 'Estonia' => [],
        'Eswatini' => ['swaziland'], 'Ethiopia' => [], 'Fiji' => [], 'Finland' => [], 'France' => [],
        'Gabon' => [], 'Gambia' => [], 'Georgia' => [], 'Germany' => [], 'Ghana' => [], 'Greece' => [],
        'Grenada' => [], 'Guatemala' => [], 'Guinea' => [], 'Guinea-Bissau' => [], 'Guyana' => [],
        'Haiti' => [], 'Honduras' => [], 'Hungary' => [], 'Iceland' => [], 'India' => [], 'Indonesia' => [],
        'Iran' => ['persia'], 'Iraq' => [], 'Ireland' => ['republic of ireland', 'eire'], 'Israel' => [],
        'Italy' => [], 'Ivory Coast' => ['cote divoire', 'cote d ivoire'], 'Jamaica' => [], 'Japan' => [],
        'Jordan' => [], 'Kazakhstan' => [], 'Kenya' => [], 'Kiribati' => [], 'Kosovo' => [], 'Kuwait' => [],
        'Kyrgyzstan' => ['kyrgyz republic'], 'Laos' => ['lao'], 'Latvia' => [], 'Lebanon' => [], 'Lesotho' => [],
        'Liberia' => [], 'Libya' => [], 'Liechtenstein' => [], 'Lithuania' => [], 'Luxembourg' => [],
        'Madagascar' => [], 'Malawi' => [], 'Malaysia' => [], 'Maldives' => [], 'Mali' => [], 'Malta' => [],
        'Marshall Islands' => [], 'Mauritania' => [], 'Mauritius' => [], 'Mexico' => [],
        'Micronesia' => ['federated states of micronesia'], 'Moldova' => [], 'Monaco' => [], 'Mongolia' => [],
        'Montenegro' => [], 'Morocco' => [], 'Mozambique' => [], 'Myanmar' => ['burma'], 'Namibia' => [],
        'Nauru' => [], 'Nepal' => [], 'Netherlands' => ['holland'], 'New Zealand' => ['aotearoa'],
        'Nicaragua' => [], 'Niger' => [], 'Nigeria' => [], 'North Korea' => ['dprk'],
        'North Macedonia' => ['macedonia'], 'Norway' => [], 'Oman' => [], 'Pakistan' => [], 'Palau' => [],
        'Palestine' => ['state of palestine'], 'Panama' => [], 'Papua New Guinea' => ['png'], 'Paraguay' => [],
        'Peru' => [], 'Philippines' => [], 'Poland' => [], 'Portugal' => [], 'Qatar' => [],
        'Republic of the Congo' => ['congo', 'congo brazzaville', 'congo republic'], 'Romania' => [],
        'Russia' => ['russian federation'], 'Rwanda' => [],
        'Saint Kitts and Nevis' => ['st kitts and nevis', 'st kitts', 'saint kitts'], 'Saint Lucia' => ['st lucia'],
        'Saint Vincent and the Grenadines' => ['st vincent and the grenadines', 'st vincent', 'saint vincent'],
        'Samoa' => [], 'San Marino' => [], 'São Tomé and Príncipe' => ['sao tome'], 'Saudi Arabia' => [],
        'Senegal' => [], 'Serbia' => [], 'Seychelles' => [], 'Sierra Leone' => [], 'Singapore' => [],
        'Slovakia' => [], 'Slovenia' => [], 'Solomon Islands' => [], 'Somalia' => [], 'South Africa' => [],
        'South Korea' => ['korea', 'republic of korea'], 'South Sudan' => [], 'Spain' => [], 'Sri Lanka' => [],
        'Sudan' => [], 'Suriname' => [], 'Sweden' => [], 'Switzerland' => [], 'Syria' => [], 'Taiwan' => [],
        'Tajikistan' => [], 'Tanzania' => [], 'Thailand' => [], 'Timor-Leste' => ['east timor'], 'Togo' => [],
        'Tonga' => [], 'Trinidad and Tobago' => ['trinidad'], 'Tunisia' => [], 'Turkey' => ['turkiye'],
        'Turkmenistan' => [], 'Tuvalu' => [], 'Uganda' => [], 'Ukraine' => [],
        'United Arab Emirates' => ['uae', 'emirates'],
        'United Kingdom' => ['uk', 'britain', 'great britain', 'england'],
        'United States' => ['usa', 'us', 'america', 'united states of america'],
        'Uruguay' => [], 'Uzbekistan' => [], 'Vanuatu' => [], 'Vatican City' => ['vatican', 'holy see'],
        'Venezuela' => [], 'Vietnam' => ['viet nam'], 'Yemen' => [], 'Zambia' => [], 'Zimbabwe' => [],
    ];

    /**
     * Countries whose Wikipedia article title isn't simply the country's name.
     *
     * @var array<string, string>
     */
    public const array COUNTRY_ARTICLES = [
        'Bahamas' => 'The Bahamas',
        'Gambia' => 'The Gambia',
        'Georgia' => 'Georgia (country)',
        'Ireland' => 'Republic of Ireland',
        'Micronesia' => 'Federated States of Micronesia',
        'Palestine' => 'State of Palestine',
        'Timor-Leste' => 'East Timor',
    ];

    /**
     * Countries with no red anywhere on their flag. Flags with even a little red
     * (a stripe, a star, part of an emblem) count as having red.
     *
     * @var list<string>
     */
    public const array FLAGS_WITHOUT_RED = [
        'Argentina', 'Bahamas', 'Barbados', 'Bhutan', 'Bosnia and Herzegovina', 'Botswana', 'Brazil', 'Cyprus',
        'Estonia', 'Finland', 'Gabon', 'Greece', 'Honduras', 'India', 'Ireland', 'Israel', 'Ivory Coast',
        'Jamaica', 'Kazakhstan', 'Kosovo', 'Lesotho', 'Marshall Islands', 'Micronesia', 'Nauru', 'Niger',
        'Nigeria', 'Pakistan', 'Palau', 'Rwanda', 'Saint Lucia', 'Saint Vincent and the Grenadines',
        'Saudi Arabia', 'Sierra Leone', 'Solomon Islands', 'Somalia', 'Sweden', 'Tanzania', 'Ukraine', 'Uruguay',
    ];

    /**
     * Countries with land borders with exactly two other countries.
     *
     * @var list<string>
     */
    public const array BORDERS_EXACTLY_TWO = [
        'Andorra', 'Bangladesh', 'Belize', 'Bhutan', 'Costa Rica', 'Ecuador', 'El Salvador', 'Equatorial Guinea',
        'Estonia', 'Eswatini', 'Guinea-Bissau', 'Kuwait', 'Lebanon', 'Liechtenstein', 'Moldova', 'Mongolia', 'Nepal',
        'Netherlands', 'Nicaragua', 'Panama', 'Sierra Leone', 'Sweden', 'Tunisia', 'United Arab Emirates',
        'United States', 'Uruguay', 'Yemen',
    ];

    /**
     * @var list<string>
     */
    public const array LANDLOCKED = [
        'Afghanistan', 'Andorra', 'Armenia', 'Austria', 'Azerbaijan', 'Belarus', 'Bhutan', 'Bolivia', 'Botswana',
        'Burkina Faso', 'Burundi', 'Central African Republic', 'Chad', 'Czech Republic', 'Eswatini', 'Ethiopia',
        'Hungary', 'Kazakhstan', 'Kosovo', 'Kyrgyzstan', 'Laos', 'Lesotho', 'Liechtenstein', 'Luxembourg', 'Malawi',
        'Mali', 'Moldova', 'Mongolia', 'Nepal', 'Niger', 'North Macedonia', 'Paraguay', 'Rwanda', 'San Marino',
        'Serbia', 'Slovakia', 'South Sudan', 'Switzerland', 'Tajikistan', 'Turkmenistan', 'Uganda', 'Uzbekistan',
        'Vatican City', 'Zambia', 'Zimbabwe',
    ];

    /**
     * Countries made up entirely of islands (including ones that share an island, like Haiti or Ireland).
     * Australia is a continent, so it isn't counted.
     *
     * @var list<string>
     */
    public const array ISLAND_COUNTRIES = [
        'Antigua and Barbuda', 'Bahamas', 'Bahrain', 'Barbados', 'Brunei', 'Cape Verde', 'Comoros', 'Cuba', 'Cyprus',
        'Dominica', 'Dominican Republic', 'Fiji', 'Grenada', 'Haiti', 'Iceland', 'Indonesia', 'Ireland', 'Jamaica',
        'Japan', 'Kiribati', 'Madagascar', 'Maldives', 'Malta', 'Marshall Islands', 'Mauritius', 'Micronesia', 'Nauru',
        'New Zealand', 'Palau', 'Papua New Guinea', 'Philippines', 'Saint Kitts and Nevis', 'Saint Lucia',
        'Saint Vincent and the Grenadines', 'Samoa', 'São Tomé and Príncipe', 'Seychelles', 'Singapore',
        'Solomon Islands', 'Sri Lanka', 'Taiwan', 'Timor-Leste', 'Tonga', 'Trinidad and Tobago', 'Tuvalu',
        'United Kingdom', 'Vanuatu',
    ];

    /**
     * European capitals (including transcontinental countries) => [Wikipedia article or null, aliases].
     *
     * @var array<string, array{0: string|null, 1: list<string>}>
     */
    public const array EUROPEAN_CAPITALS = [
        'Amsterdam' => [null, []], 'Andorra la Vella' => [null, []], 'Ankara' => [null, []], 'Astana' => [null, ['nur-sultan']],
        'Athens' => [null, []], 'Baku' => [null, []], 'Belgrade' => [null, []], 'Berlin' => [null, []],
        'Bern' => [null, ['berne']], 'Bratislava' => [null, []], 'Brussels' => [null, []], 'Bucharest' => [null, []],
        'Budapest' => [null, []], 'Chișinău' => ['Chișinău', ['chisinau', 'kishinev']], 'Copenhagen' => [null, []],
        'Dublin' => [null, []], 'Helsinki' => [null, []], 'Kyiv' => [null, ['kiev']], 'Lisbon' => [null, []],
        'Ljubljana' => [null, []], 'London' => [null, []], 'Luxembourg City' => [null, ['luxembourg']],
        'Madrid' => [null, []], 'Minsk' => [null, []], 'Monaco' => [null, ['monte carlo']], 'Moscow' => [null, []],
        'Nicosia' => [null, []], 'Oslo' => [null, []], 'Paris' => [null, []], 'Podgorica' => [null, []],
        'Prague' => [null, []], 'Pristina' => [null, ['prishtina']], 'Reykjavík' => [null, []], 'Riga' => [null, []],
        'Rome' => [null, []], 'San Marino' => ['San Marino (city)', []], 'Sarajevo' => [null, []], 'Skopje' => [null, []],
        'Sofia' => [null, []], 'Stockholm' => [null, []], 'Tallinn' => [null, []], 'Tbilisi' => [null, []],
        'Tirana' => [null, ['tirane']], 'Vaduz' => [null, []], 'Valletta' => [null, []], 'Vatican City' => [null, ['vatican']],
        'Vienna' => [null, ['wien']], 'Vilnius' => [null, []], 'Warsaw' => [null, []], 'Yerevan' => [null, []],
        'Zagreb' => [null, []],
    ];
}
