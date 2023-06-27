<?php

use App\Models\Configure;
use \Illuminate\Support\Str;

function template($asset = false)
{
    $activeTheme = config('basic.theme');
    if ($asset) return 'assets/themes/' . $activeTheme . '/';
    return 'themes.' . $activeTheme . '.';
}


function recursive_array_replace($find, $replace, $array)
{
    if (!is_array($array)) {
        return str_replace($find, $replace, $array);
    }
    $newArray = [];
    foreach ($array as $key => $value) {
        $newArray[$key] = recursive_array_replace($find, $replace, $value);
    }
    return $newArray;
}

function menuActive($routeName, $type = null)
{
    $class = 'active';
    if ($type == 3) {
        $class = 'selected';
    } elseif ($type == 2) {
        $class = 'has-arrow active';
    } elseif ($type == 1) {
        $class = 'in';
    }
    if (is_array($routeName)) {
        foreach ($routeName as $key => $value) {
            if (request()->routeIs($value)) {
                return $class;
            }
        }
    } elseif (request()->routeIs($routeName)) {
        return $class;
    }
}


function getFile($image, $clean = '')
{
    return file_exists($image) && is_file($image) ? asset($image) . $clean : asset(config('location.default'));
}

function removeFile($path)
{
    return file_exists($path) && is_file($path) ? @unlink($path) : false;
}

function loopIndex($object)
{
    return ($object->currentPage() - 1) * $object->perPage() + 1;
}

function getAmount($amount, $length = 0)
{
    if (0 < $length) {
        return number_format($amount + 0, $length);
    }
    return $amount + 0;
}


if (!function_exists('getRoute')) {
    function getRoute($route, $params = null)
    {
        return isset($params) ? route($route, $params) : route($route);
    }
}


if (!function_exists('isMenuActive')) {
    function isMenuActive($routes, $type = 0)
    {
        $class = [
            '0' => 'active',
            '1' => 'style=display:block',
            '2' => true
        ];

        if (is_array($routes)) {
            foreach ($routes as $key => $route) {
                if (request()->routeIs($route)) {
                    return $class[$type];
                }
            }
        } elseif (request()->routeIs($routes)) {
            return $class[$type];
        }

        if ($type == 1) {
            return 'style=display:none';
        } else {
            return false;
        }
    }
}


if (!function_exists('getTitle')) {
    function getTitle($title)
    {
        return ucwords(preg_replace('/[^A-Za-z0-9]/', ' ', $title));
    }
}


function basicControl()
{
    return Configure::firstOrCreate(['id' => 1]);
}


function strRandom($length = 12)
{
    $characters = 'ABCDEFGHJKMNOPQRSTUVWXYZ123456789';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function diffForHumans($date)
{
    $lang = session()->get('lang');
    \Carbon\Carbon::setlocale($lang);
    return \Carbon\Carbon::parse($date)->diffForHumans();
}

function dateTime($date, $format = 'd M, Y h:i A')
{
    return date($format, strtotime($date));
}

if (!function_exists('putPermanentEnv')) {
    function putPermanentEnv($key, $value)
    {
        $path = app()->environmentFilePath();
        $escaped = preg_quote('=' . env($key), '/');
        file_put_contents($path, preg_replace(
            "/^{$key}{$escaped}/m",
            "{$key}={$value}",
            file_get_contents($path)
        ));
    }
}

function checkTo($currencies, $selectedCurrency = 'USD')
{
    foreach ($currencies as $key => $currency) {
        if (property_exists($currency, strtoupper($selectedCurrency))) {
            return $key;
        }
    }
}

function code($length = 6)
{
    if ($length == 0) return 0;
    $min = pow(10, $length - 1);
    $max = 0;
    while ($length > 0 && $length--) {
        $max = ($max * 10) + 9;
    }
    return random_int($min, $max);
}

function invoice()
{

    return time() . code(4);
}

function wordTruncate($string, $offset = 0, $length = null): string
{
    $words = explode(" ", $string);
    isset($length) ? array_splice($words, $offset, $length) : array_splice($words, $offset);
    return implode(" ", $words);
}

function linkToEmbed($string)
{
    if (strpos($string, 'youtube') !== false) {
        $words = explode("/", $string);
        if (strpos($string, 'embed') == false) {
            array_splice($words, -1, 0, 'embed');
        }
        $words = str_ireplace('watch?v=', '', implode("/", $words));
        return $words;
    }
    return $string;
}


function slug($title)
{
    return \Illuminate\Support\Str::slug($title);
}

function title2snake($string)
{
    return Str::title(str_replace(' ', '_', $string));
}

function snake2Title($string)
{
    return Str::title(str_replace('_', ' ', $string));
}

function kebab2Title($string)
{
    return Str::title(str_replace('-', ' ', $string));
}

function getLevelUser($id)
{
    $ussss = new \App\Models\User();
    return $ussss->referralUsers([$id]);
}

function getPercent($total, $current)
{
    if ($current > 0 && $total > 0) {
        $percent = (($current * 100) / $total) ?: 0;
    } else {
        $percent = 0;
    }
    return round($percent, 0);
}

function flagLanguage($data)
{
    return '{' . rtrim($data, ',') . '}';
}

function getIpInfo()
{
    $ip = null;
    $deep_detect = TRUE;

    if (filter_var($ip, FILTER_VALIDATE_IP) === FALSE) {
        $ip = $_SERVER["REMOTE_ADDR"];
        if ($deep_detect) {
            if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP))
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP))
                $ip = $_SERVER['HTTP_CLIENT_IP'];
        }
    }
    $xml = @simplexml_load_file("http://www.geoplugin.net/xml.gp?ip=" . $ip);

    $country = @$xml->geoplugin_countryName;
    $city = @$xml->geoplugin_city;
    $area = @$xml->geoplugin_areaCode;
    $code = @$xml->geoplugin_countryCode;
    $long = @$xml->geoplugin_longitude;
    $lat = @$xml->geoplugin_latitude;


    $user_agent = $_SERVER['HTTP_USER_AGENT'];
    $os_platform = "Unknown OS Platform";
    $os_array = array(
        '/windows nt 10/i' => 'Windows 10',
        '/windows nt 6.3/i' => 'Windows 8.1',
        '/windows nt 6.2/i' => 'Windows 8',
        '/windows nt 6.1/i' => 'Windows 7',
        '/windows nt 6.0/i' => 'Windows Vista',
        '/windows nt 5.2/i' => 'Windows Server 2003/XP x64',
        '/windows nt 5.1/i' => 'Windows XP',
        '/windows xp/i' => 'Windows XP',
        '/windows nt 5.0/i' => 'Windows 2000',
        '/windows me/i' => 'Windows ME',
        '/win98/i' => 'Windows 98',
        '/win95/i' => 'Windows 95',
        '/win16/i' => 'Windows 3.11',
        '/macintosh|mac os x/i' => 'Mac OS X',
        '/mac_powerpc/i' => 'Mac OS 9',
        '/linux/i' => 'Linux',
        '/ubuntu/i' => 'Ubuntu',
        '/iphone/i' => 'iPhone',
        '/ipod/i' => 'iPod',
        '/ipad/i' => 'iPad',
        '/android/i' => 'Android',
        '/blackberry/i' => 'BlackBerry',
        '/webos/i' => 'Mobile'
    );
    foreach ($os_array as $regex => $value) {
        if (preg_match($regex, $user_agent)) {
            $os_platform = $value;
        }
    }
    $browser = "Unknown Browser";
    $browser_array = array(
        '/msie/i' => 'Internet Explorer',
        '/firefox/i' => 'Firefox',
        '/safari/i' => 'Safari',
        '/chrome/i' => 'Chrome',
        '/edge/i' => 'Edge',
        '/opera/i' => 'Opera',
        '/netscape/i' => 'Netscape',
        '/maxthon/i' => 'Maxthon',
        '/konqueror/i' => 'Konqueror',
        '/mobile/i' => 'Handheld Browser'
    );
    foreach ($browser_array as $regex => $value) {
        if (preg_match($regex, $user_agent)) {
            $browser = $value;
        }
    }

    $data['country'] = $country;
    $data['city'] = $city;
    $data['area'] = $area;
    $data['code'] = $code;
    $data['long'] = $long;
    $data['lat'] = $lat;
    $data['os_platform'] = $os_platform;
    $data['browser'] = $browser;
    $data['ip'] = request()->ip();
    $data['time'] = date('d-m-Y h:i:s A');

    return $data;
}


function resourcePaginate($data, $callback)
{
    return $data->setCollection($data->getCollection()->map($callback));
}


function clean($string)
{
    $string = str_replace(' ', '_', $string); // Replaces all spaces with hyphens.
    return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
}

function camelToWord($str)
{
    $arr = preg_split('/(?=[A-Z])/', $str);
    return trim(join(' ', $arr));
}

function getSmsActivateServices()
{
    $smsActivateServices =
        [
            0 => [
                'Service Code' => 'full',
                'Name' => ' Full Rent',
            ],
            1 => [
                'Service Code' => 'fg',
                'Name' => ' IndianOil',
            ],
            2 => [
                'Service Code' => 'fr',
                'Name' => ' Dana',
            ],
            3 => [
                'Service Code' => 'wv',
                'Name' => ' AIS',
            ],
            4 => [
                'Service Code' => 'dk',
                'Name' => ' Pairs',
            ],
            5 => [
                'Service Code' => 'vm',
                'Name' => ' OkCupid',
            ],
            6 => [
                'Service Code' => 'mb',
                'Name' => ' Yahoo',
            ],
            7 => [
                'Service Code' => 'qg',
                'Name' => ' MoneyPay',
            ],
            8 => [
                'Service Code' => 'jt',
                'Name' => ' TurkiyePetrolleri',
            ],
            9 => [
                'Service Code' => 'bi',
                'Name' => ' 勇仕网络Ys4fun',
            ],
            10 => [
                'Service Code' => 'pm',
                'Name' => ' AOL',
            ],
            11 => [
                'Service Code' => 'sv',
                'Name' => ' Dostavista',
            ],
            12 => [
                'Service Code' => 'pg',
                'Name' => ' NRJ Music Awards',
            ],
            13 => [
                'Service Code' => 'yz',
                'Name' => ' Около',
            ],
            14 => [
                'Service Code' => 'vo',
                'Name' => ' Brand20ua',
            ],
            15 => [
                'Service Code' => 'he',
                'Name' => ' Mewt',
            ],
            16 => [
                'Service Code' => 'vk',
                'Name' => ' vk.com',
            ],
            17 => [
                'Service Code' => 'gk',
                'Name' => ' AptekaRU',
            ],
            18 => [
                'Service Code' => 'sy',
                'Name' => ' Brahma',
            ],
            19 => [
                'Service Code' => 'ch',
                'Name' => ' Pocket52',
            ],
            20 => [
                'Service Code' => 'ia',
                'Name' => ' Socios',
            ],
            21 => [
                'Service Code' => 'bx',
                'Name' => ' Dosi',
            ],
            22 => [
                'Service Code' => 'ua',
                'Name' => ' BlaBlaCar',
            ],
            23 => [
                'Service Code' => 'xl',
                'Name' => ' Wmaraci',
            ],
            24 => [
                'Service Code' => 'qc',
                'Name' => ' Праймериз 2020',
            ],
            25 => [
                'Service Code' => 'kt',
                'Name' => ' KakaoTalk',
            ],
            26 => [
                'Service Code' => 'bs',
                'Name' => ' TradeUP',
            ],
            27 => [
                'Service Code' => 'jr',
                'Name' => ' Самокат',
            ],
            28 => [
                'Service Code' => 'ii',
                'Name' => ' CashKaro',
            ],
            29 => [
                'Service Code' => 'rl',
                'Name' => ' inDriver',
            ],
            30 => [
                'Service Code' => 'nk',
                'Name' => ' Gittigidiyor',
            ],
            31 => [
                'Service Code' => 'hc',
                'Name' => ' MOMO',
            ],
            32 => [
                'Service Code' => 'ik',
                'Name' => ' GuruBets',
            ],
            33 => [
                'Service Code' => 'lj',
                'Name' => ' Santander',
            ],
            34 => [
                'Service Code' => 'rj',
                'Name' => ' Детский мир',
            ],
            35 => [
                'Service Code' => 'bn',
                'Name' => ' Alfagift',
            ],
            36 => [
                'Service Code' => 'dd',
                'Name' => ' CloudChat',
            ],
            37 => [
                'Service Code' => 'hy',
                'Name' => ' Ininal',
            ],
            38 => [
                'Service Code' => 'wf',
                'Name' => ' YandexGo',
            ],
            39 => [
                'Service Code' => 'jv',
                'Name' => ' Consultant',
            ],
            40 => [
                'Service Code' => 'ke',
                'Name' => ' Эльдорадо',
            ],
            41 => [
                'Service Code' => 'nn',
                'Name' => ' Giftcloud',
            ],
            42 => [
                'Service Code' => 'av',
                'Name' => ' avito',
            ],
            43 => [
                'Service Code' => 'zf',
                'Name' => ' OnTaxi',
            ],
            44 => [
                'Service Code' => 'zr',
                'Name' => ' Papara',
            ],
            45 => [
                'Service Code' => 'mu',
                'Name' => ' MyMusicTaste',
            ],
            46 => [
                'Service Code' => 'no',
                'Name' => ' Virgo',
            ],
            47 => [
                'Service Code' => 'cc',
                'Name' => ' Quipp',
            ],
            48 => [
                'Service Code' => 'zm',
                'Name' => ' OfferUp',
            ],
            49 => [
                'Service Code' => 'mo',
                'Name' => ' Bumble',
            ],
            50 => [
                'Service Code' => 'vv',
                'Name' => ' Seosprint',
            ],
            51 => [
                'Service Code' => 'wg',
                'Name' => ' Skout',
            ],
            52 => [
                'Service Code' => 'tr',
                'Name' => ' Paysend',
            ],
            53 => [
                'Service Code' => 'zj',
                'Name' => ' ROBINHOOD',
            ],
            54 => [
                'Service Code' => 'ee',
                'Name' => ' Twilio',
            ],
            55 => [
                'Service Code' => 'fk',
                'Name' => ' BLIBLI',
            ],
            56 => [
                'Service Code' => 'ad',
                'Name' => ' Iti',
            ],
            57 => [
                'Service Code' => 'sl',
                'Name' => ' СберАптека',
            ],
            58 => [
                'Service Code' => 'fl',
                'Name' => ' RummyLoot',
            ],
            59 => [
                'Service Code' => 'hs',
                'Name' => ' Asda',
            ],
            60 => [
                'Service Code' => 'bl',
                'Name' => ' BIGO LIVE',
            ],
            61 => [
                'Service Code' => 'zx',
                'Name' => ' CommunityGaming',
            ],
            62 => [
                'Service Code' => 'gy',
                'Name' => ' MIYACHAT',
            ],
            63 => [
                'Service Code' => 'jq',
                'Name' => ' Paysafecard',
            ],
            64 => [
                'Service Code' => 'kp',
                'Name' => ' HQ Trivia',
            ],
            65 => [
                'Service Code' => 'ge',
                'Name' => ' Paytm',
            ],
            66 => [
                'Service Code' => 'gz',
                'Name' => ' LYKA',
            ],
            67 => [
                'Service Code' => 'mj',
                'Name' => ' Zalo',
            ],
            68 => [
                'Service Code' => 'ir',
                'Name' => ' Chispa',
            ],
            69 => [
                'Service Code' => 'fa',
                'Name' => ' XadrezFeliz',
            ],
            70 => [
                'Service Code' => 'at',
                'Name' => ' Perfluence',
            ],
            71 => [
                'Service Code' => 'qh',
                'Name' => ' Oriflame',
            ],
            72 => [
                'Service Code' => 'dr',
                'Name' => ' OpenAI',
            ],
            73 => [
                'Service Code' => 'rg',
                'Name' => ' Porbet',
            ],
            74 => [
                'Service Code' => 'ih',
                'Name' => ' TeenPattiStarpro',
            ],
            75 => [
                'Service Code' => 'hk',
                'Name' => ' 4Fun',
            ],
            76 => [
                'Service Code' => 'bm',
                'Name' => ' MarketGuru',
            ],
            77 => [
                'Service Code' => 'gs',
                'Name' => ' SamsungShop',
            ],
            78 => [
                'Service Code' => 'sr',
                'Name' => ' Starbucks',
            ],
            79 => [
                'Service Code' => 'ci',
                'Name' => ' redBus',
            ],
            80 => [
                'Service Code' => 'ac',
                'Name' => ' DoorDash',
            ],
            81 => [
                'Service Code' => 'sf',
                'Name' => ' SneakersnStuff',
            ],
            82 => [
                'Service Code' => 'ne',
                'Name' => ' Coindcx',
            ],
            83 => [
                'Service Code' => 'sm',
                'Name' => ' YoWin',
            ],
            84 => [
                'Service Code' => 'zv',
                'Name' => ' Digikala',
            ],
            85 => [
                'Service Code' => 'bj',
                'Name' => ' Вита экспресс',
            ],
            86 => [
                'Service Code' => 'dv',
                'Name' => ' NoBroker',
            ],
            87 => [
                'Service Code' => 'zw',
                'Name' => ' Quack',
            ],
            88 => [
                'Service Code' => 'gh',
                'Name' => ' GyFTR',
            ],
            89 => [
                'Service Code' => 'cp',
                'Name' => ' Uklon',
            ],
            90 => [
                'Service Code' => 'ai',
                'Name' => ' CELEBe',
            ],
            91 => [
                'Service Code' => 'xf',
                'Name' => ' LightChat',
            ],
            92 => [
                'Service Code' => 'ru',
                'Name' => ' HOP',
            ],
            93 => [
                'Service Code' => 'ym',
                'Name' => ' youla.ru',
            ],
            94 => [
                'Service Code' => 'sj',
                'Name' => ' HandyPick',
            ],
            95 => [
                'Service Code' => 'fc',
                'Name' => ' PharmEasy',
            ],
            96 => [
                'Service Code' => 'hx',
                'Name' => ' AliExpress',
            ],
            97 => [
                'Service Code' => 'aw',
                'Name' => ' Taikang',
            ],
            98 => [
                'Service Code' => 'tx',
                'Name' => ' Bolt',
            ],
            99 => [
                'Service Code' => 'oh',
                'Name' => ' MapleSEA ',
            ],
            100 => [
                'Service Code' => 'ki',
                'Name' => ' 99app',
            ],
            101 => [
                'Service Code' => 'tg',
                'Name' => ' Telegram',
            ],
            102 => [
                'Service Code' => 'ug',
                'Name' => ' Fiqsy',
            ],
            103 => [
                'Service Code' => 'pq',
                'Name' => ' CDkeys',
            ],
            104 => [
                'Service Code' => 'gd',
                'Name' => ' Surveytime',
            ],
            105 => [
                'Service Code' => 'tc',
                'Name' => ' Rambler',
            ],
            106 => [
                'Service Code' => 'xw',
                'Name' => ' Taki',
            ],
            107 => [
                'Service Code' => 'me',
                'Name' => ' Line messenger',
            ],
            108 => [
                'Service Code' => 'of',
                'Name' => ' Urent',
            ],
            109 => [
                'Service Code' => 'hd',
                'Name' => ' MarketPapa',
            ],
            110 => [
                'Service Code' => 'rm',
                'Name' => ' Faberlic',
            ],
            111 => [
                'Service Code' => 'ud',
                'Name' => ' Disney Hotstar',
            ],
            112 => [
                'Service Code' => 'eb',
                'Name' => ' Voltz',
            ],
            113 => [
                'Service Code' => 'ur',
                'Name' => ' MyDailyCash',
            ],
            114 => [
                'Service Code' => 'wz',
                'Name' => ' FoxFord',
            ],
            115 => [
                'Service Code' => 'jl',
                'Name' => ' Hopi',
            ],
            116 => [
                'Service Code' => 'gm',
                'Name' => ' Mocospace',
            ],
            117 => [
                'Service Code' => 'es',
                'Name' => ' iQIYI',
            ],
            118 => [
                'Service Code' => 'zy',
                'Name' => ' Nttgame',
            ],
            119 => [
                'Service Code' => 'ef',
                'Name' => ' Nextdoor',
            ],
            120 => [
                'Service Code' => 'sk',
                'Name' => ' Skroutz',
            ],
            121 => [
                'Service Code' => 'fj',
                'Name' => ' Potato Chat',
            ],
            122 => [
                'Service Code' => 'mm',
                'Name' => ' Microsoft',
            ],
            123 => [
                'Service Code' => 'dy',
                'Name' => ' Zomato',
            ],
            124 => [
                'Service Code' => 'io',
                'Name' => ' ЗдравСити',
            ],
            125 => [
                'Service Code' => 'yi',
                'Name' => ' Yemeksepeti',
            ],
            126 => [
                'Service Code' => 'jh',
                'Name' => ' PingPong',
            ],
            127 => [
                'Service Code' => 'gt',
                'Name' => ' Gett',
            ],
            128 => [
                'Service Code' => 'rp',
                'Name' => ' hamrahaval',
            ],
            129 => [
                'Service Code' => 'ei',
                'Name' => ' Taksheel',
            ],
            130 => [
                'Service Code' => 'co',
                'Name' => ' Rediffmail',
            ],
            131 => [
                'Service Code' => 'fy',
                'Name' => ' Mylove',
            ],
            132 => [
                'Service Code' => 'un',
                'Name' => ' humblebundle',
            ],
            133 => [
                'Service Code' => 'qj',
                'Name' => ' Whoosh',
            ],
            134 => [
                'Service Code' => 'nb',
                'Name' => ' Верный',
            ],
            135 => [
                'Service Code' => 'dx',
                'Name' => ' Powerkredite',
            ],
            136 => [
                'Service Code' => 'bz',
                'Name' => ' Blizzard',
            ],
            137 => [
                'Service Code' => 'wq',
                'Name' => ' Leboncoin1',
            ],
            138 => [
                'Service Code' => 'np',
                'Name' => ' Siply',
            ],
            139 => [
                'Service Code' => 're',
                'Name' => ' Coinbase',
            ],
            140 => [
                'Service Code' => 'pr',
                'Name' => ' Trendyol',
            ],
            141 => [
                'Service Code' => 'wa',
                'Name' => ' Whatsapp',
            ],
            142 => [
                'Service Code' => 'fb',
                'Name' => ' facebook',
            ],
            143 => [
                'Service Code' => 'kd',
                'Name' => ' Author24',
            ],
            144 => [
                'Service Code' => 'gp',
                'Name' => ' Ticketmaster',
            ],
            145 => [
                'Service Code' => 'up',
                'Name' => ' Magnolia',
            ],
            146 => [
                'Service Code' => 'wo',
                'Name' => ' Parkplus',
            ],
            147 => [
                'Service Code' => 'eq',
                'Name' => ' Qoo10',
            ],
            148 => [
                'Service Code' => 'ub',
                'Name' => ' Uber',
            ],
            149 => [
                'Service Code' => 'kb',
                'Name' => ' kufarby',
            ],
            150 => [
                'Service Code' => 'ig',
                'Name' => ' Instagram',
            ],
            151 => [
                'Service Code' => 'rh',
                'Name' => ' Ace2Three',
            ],
            152 => [
                'Service Code' => 'bc',
                'Name' => ' GCash',
            ],
            153 => [
                'Service Code' => 'hu',
                'Name' => ' Ukrnet',
            ],
            154 => [
                'Service Code' => 'pa',
                'Name' => ' Gamekit',
            ],
            155 => [
                'Service Code' => 'su',
                'Name' => ' LOCO',
            ],
            156 => [
                'Service Code' => 'full',
                'Name' => ' Full rent',
            ],
            157 => [
                'Service Code' => 'av',
                'Name' => ' avito call forwarding',
            ],
            158 => [
                'Service Code' => 'ew',
                'Name' => ' Nike',
            ],
            159 => [
                'Service Code' => 'tw',
                'Name' => ' Twitter',
            ],
            160 => [
                'Service Code' => 'ry',
                'Name' => ' McDonalds',
            ],
            161 => [
                'Service Code' => 'cb',
                'Name' => ' Bazos',
            ],
            162 => [
                'Service Code' => 'lx',
                'Name' => ' DewuPoison',
            ],
            163 => [
                'Service Code' => 'ex',
                'Name' => ' Linode',
            ],
            164 => [
                'Service Code' => 'im',
                'Name' => ' Imo',
            ],
            165 => [
                'Service Code' => 'kk',
                'Name' => ' Idealista',
            ],
            166 => [
                'Service Code' => 'ju',
                'Name' => ' Indomaret',
            ],
            167 => [
                'Service Code' => 'fv',
                'Name' => ' Vidio',
            ],
            168 => [
                'Service Code' => 'ue',
                'Name' => ' Onet',
            ],
            169 => [
                'Service Code' => 'jm',
                'Name' => ' mzadqatar',
            ],
            170 => [
                'Service Code' => 'rb',
                'Name' => ' Tick',
            ],
            171 => [
                'Service Code' => 'wj',
                'Name' => ' 1хbet',
            ],
            172 => [
                'Service Code' => 'it',
                'Name' => ' CashApp',
            ],
            173 => [
                'Service Code' => 'gu',
                'Name' => ' Fora',
            ],
            174 => [
                'Service Code' => 'eu',
                'Name' => ' LiveScore',
            ],
            175 => [
                'Service Code' => 'ff',
                'Name' => ' AVON',
            ],
            176 => [
                'Service Code' => 'qq',
                'Name' => ' Tencent QQ',
            ],
            177 => [
                'Service Code' => 'dq',
                'Name' => ' IceCasino',
            ],
            178 => [
                'Service Code' => 'xq',
                'Name' => ' MPL',
            ],
            179 => [
                'Service Code' => 'jc',
                'Name' => ' IVI',
            ],
            180 => [
                'Service Code' => 'ha',
                'Name' => ' My11Circle',
            ],
            181 => [
                'Service Code' => 'sh',
                'Name' => ' Vkusvill',
            ],
            182 => [
                'Service Code' => 'tf',
                'Name' => ' Noon',
            ],
            183 => [
                'Service Code' => 'th',
                'Name' => ' WestStein',
            ],
            184 => [
                'Service Code' => 'eo',
                'Name' => ' Sizeer',
            ],
            185 => [
                'Service Code' => 'ra',
                'Name' => ' KeyPay',
            ],
            186 => [
                'Service Code' => 'ny',
                'Name' => ' Pyro Music',
            ],
            187 => [
                'Service Code' => 'dn',
                'Name' => ' Paxful',
            ],
            188 => [
                'Service Code' => 'ao',
                'Name' => ' UU163',
            ],
            189 => [
                'Service Code' => 'pl',
                'Name' => ' Перекресток',
            ],
            190 => [
                'Service Code' => 'nw',
                'Name' => ' Ximalaya',
            ],
            191 => [
                'Service Code' => 'qe',
                'Name' => ' GG',
            ],
            192 => [
                'Service Code' => 'sg',
                'Name' => ' OZON',
            ],
            193 => [
                'Service Code' => 'bu',
                'Name' => ' MonobankIndia',
            ],
            194 => [
                'Service Code' => 'af',
                'Name' => ' GalaxyWin',
            ],
            195 => [
                'Service Code' => 'vw',
                'Name' => ' CoinField',
            ],
            196 => [
                'Service Code' => 'zl',
                'Name' => ' Airtel',
            ],
            197 => [
                'Service Code' => 'lf',
                'Name' => ' TikTok/Douyin',
            ],
            198 => [
                'Service Code' => 'cn',
                'Name' => ' Fiverr',
            ],
            199 => [
                'Service Code' => 'lv',
                'Name' => ' Megogo',
            ],
            200 => [
                'Service Code' => 'tp',
                'Name' => ' IndiaGold',
            ],
            201 => [
                'Service Code' => 'fx',
                'Name' => ' PGbonus',
            ],
            202 => [
                'Service Code' => 'pz',
                'Name' => ' Lidl',
            ],
            203 => [
                'Service Code' => 'pp',
                'Name' => ' Huya',
            ],
            204 => [
                'Service Code' => 'qk',
                'Name' => ' Bit',
            ],
            205 => [
                'Service Code' => 'jy',
                'Name' => ' Sorare',
            ],
            206 => [
                'Service Code' => 'rv',
                'Name' => ' Kotak811',
            ],
            207 => [
                'Service Code' => 'lg',
                'Name' => ' MediBuddy',
            ],
            208 => [
                'Service Code' => 'yl',
                'Name' => ' Yalla',
            ],
            209 => [
                'Service Code' => 'gq',
                'Name' => ' Freelancer',
            ],
            210 => [
                'Service Code' => 'ak',
                'Name' => ' Douyu',
            ],
            211 => [
                'Service Code' => 'sp',
                'Name' => ' HappyFresh',
            ],
            212 => [
                'Service Code' => 'vx',
                'Name' => ' HeyBox',
            ],
            213 => [
                'Service Code' => 'dc',
                'Name' => ' YikYak',
            ],
            214 => [
                'Service Code' => 'di',
                'Name' => ' Loanflix',
            ],
            215 => [
                'Service Code' => 'bt',
                'Name' => ' Alfa',
            ],
            216 => [
                'Service Code' => 'wk',
                'Name' => ' Mobile01',
            ],
            217 => [
                'Service Code' => 'cx',
                'Name' => ' Icrypex',
            ],
            218 => [
                'Service Code' => 'yn',
                'Name' => ' Allegro',
            ],
            219 => [
                'Service Code' => 'fo',
                'Name' => ' MobiKwik',
            ],
            220 => [
                'Service Code' => 'ly',
                'Name' => ' Olacabs',
            ],
            221 => [
                'Service Code' => 'oi',
                'Name' => ' Tinder',
            ],
            222 => [
                'Service Code' => 'iz',
                'Name' => ' Global24',
            ],
            223 => [
                'Service Code' => 'nu',
                'Name' => ' Stripe',
            ],
            224 => [
                'Service Code' => 'fz',
                'Name' => ' KFC',
            ],
            225 => [
                'Service Code' => 'qi',
                'Name' => ' 32red',
            ],
            226 => [
                'Service Code' => 'nv',
                'Name' => ' Naver',
            ],
            227 => [
                'Service Code' => 'op',
                'Name' => ' MIRATORG',
            ],
            228 => [
                'Service Code' => 'wn',
                'Name' => ' GameArena',
            ],
            229 => [
                'Service Code' => 'dz',
                'Name' => ' Dominos Pizza',
            ],
            230 => [
                'Service Code' => 'vs',
                'Name' => ' WinzoGame',
            ],
            231 => [
                'Service Code' => 'fi',
                'Name' => ' Dundle',
            ],
            232 => [
                'Service Code' => 'bb',
                'Name' => ' LazyPay',
            ],
            233 => [
                'Service Code' => 'wc',
                'Name' => ' Craigslist',
            ],
            234 => [
                'Service Code' => 'hn',
                'Name' => 1688,
            ],
            235 => [
                'Service Code' => 'da',
                'Name' => ' MTS CashBack',
            ],
            236 => [
                'Service Code' => 'ja',
                'Name' => ' Weverse',
            ],
            237 => [
                'Service Code' => 'qu',
                'Name' => ' Agroinform',
            ],
            238 => [
                'Service Code' => 'jd',
                'Name' => ' GiraBank',
            ],
            239 => [
                'Service Code' => 'ay',
                'Name' => ' Ruten',
            ],
            240 => [
                'Service Code' => 'ym',
                'Name' => ' youla.ru call forwarding',
            ],
            241 => [
                'Service Code' => 'cr',
                'Name' => ' TenChat',
            ],
            242 => [
                'Service Code' => 'zo',
                'Name' => ' Kaggle',
            ],
            243 => [
                'Service Code' => 'dw',
                'Name' => ' Divar',
            ],
            244 => [
                'Service Code' => 'zk',
                'Name' => ' Deliveroo',
            ],
            245 => [
                'Service Code' => 'fh',
                'Name' => ' Lalamove',
            ],
            246 => [
                'Service Code' => 'nz',
                'Name' => ' Foodpanda',
            ],
            247 => [
                'Service Code' => 'yy',
                'Name' => ' Venmo',
            ],
            248 => [
                'Service Code' => 'hi',
                'Name' => ' JungleeRummy',
            ],
            249 => [
                'Service Code' => 'oq',
                'Name' => ' Vlife',
            ],
            250 => [
                'Service Code' => 'tn',
                'Name' => ' LinkedIN',
            ],
            251 => [
                'Service Code' => 'kf',
                'Name' => ' Weibo',
            ],
            252 => [
                'Service Code' => 'hg',
                'Name' => ' Switips',
            ],
            253 => [
                'Service Code' => 'aq',
                'Name' => ' Glovo',
            ],
            254 => [
                'Service Code' => 'en',
                'Name' => ' Hermes',
            ],
            255 => [
                'Service Code' => 'iw',
                'Name' => ' MyLavash',
            ],
            256 => [
                'Service Code' => 'ol',
                'Name' => ' KazanExpress',
            ],
            257 => [
                'Service Code' => 'dh',
                'Name' => ' eBay',
            ],
            258 => [
                'Service Code' => 'ta',
                'Name' => ' Wink',
            ],
            259 => [
                'Service Code' => 'nf',
                'Name' => ' Netflix',
            ],
            260 => [
                'Service Code' => 'mg',
                'Name' => ' Magnit',
            ],
            261 => [
                'Service Code' => 'gb',
                'Name' => ' YouStar',
            ],
            262 => [
                'Service Code' => 'pd',
                'Name' => ' IFood',
            ],
            263 => [
                'Service Code' => 'ni',
                'Name' => ' Gojek',
            ],
            264 => [
                'Service Code' => 'dt',
                'Name' => ' Delivery Club',
            ],
            265 => [
                'Service Code' => 'qm',
                'Name' => ' RosaKhutor',
            ],
            266 => [
                'Service Code' => 'qt',
                'Name' => ' MoneyСontrol',
            ],
            267 => [
                'Service Code' => 'ss',
                'Name' => ' hezzl',
            ],
            268 => [
                'Service Code' => 'rs',
                'Name' => ' Lotus',
            ],
            269 => [
                'Service Code' => 'uu',
                'Name' => ' Wildberries',
            ],
            270 => [
                'Service Code' => 'jp',
                'Name' => ' Rbt',
            ],
            271 => [
                'Service Code' => 'ce',
                'Name' => ' mosru',
            ],
            272 => [
                'Service Code' => 'ea',
                'Name' => ' JamesDelivery',
            ],
            273 => [
                'Service Code' => 'ti',
                'Name' => ' cryptocom',
            ],
            274 => [
                'Service Code' => 'td',
                'Name' => ' ChaingeFinance',
            ],
            275 => [
                'Service Code' => 'yg',
                'Name' => ' CourseHero',
            ],
            276 => [
                'Service Code' => 'hr',
                'Name' => ' JKF',
            ],
            277 => [
                'Service Code' => 'kl',
                'Name' => ' kolesa.kz',
            ],
            278 => [
                'Service Code' => 'dj',
                'Name' => ' LUKOIL-AZS',
            ],
            279 => [
                'Service Code' => 'ql',
                'Name' => ' CMTcuzdan',
            ],
            280 => [
                'Service Code' => 'km',
                'Name' => ' Rozetka',
            ],
            281 => [
                'Service Code' => 'jj',
                'Name' => ' Aitu',
            ],
            282 => [
                'Service Code' => 'vi',
                'Name' => ' Viber',
            ],
            283 => [
                'Service Code' => 'dl',
                'Name' => ' Lazada',
            ],
            284 => [
                'Service Code' => 'll',
                'Name' => ' 888casino',
            ],
            285 => [
                'Service Code' => 'nl',
                'Name' => ' Myntra',
            ],
            286 => [
                'Service Code' => 'sz',
                'Name' => ' Pivko24',
            ],
            287 => [
                'Service Code' => 'jx',
                'Name' => ' Swiggy',
            ],
            288 => [
                'Service Code' => 'ph',
                'Name' => ' SnappFood',
            ],
            289 => [
                'Service Code' => 'jn',
                'Name' => ' CloudBet',
            ],
            290 => [
                'Service Code' => 'le',
                'Name' => ' E bike Gewinnspiel',
            ],
            291 => [
                'Service Code' => 'cz',
                'Name' => ' Getmega',
            ],
            292 => [
                'Service Code' => 'xm',
                'Name' => ' Лэтуаль',
            ],
            293 => [
                'Service Code' => 'nq',
                'Name' => ' Trip',
            ],
            294 => [
                'Service Code' => 'ie',
                'Name' => ' bet365',
            ],
            295 => [
                'Service Code' => 'kq',
                'Name' => ' FotoCasa',
            ],
            296 => [
                'Service Code' => 'zz',
                'Name' => ' DENT',
            ],
            297 => [
                'Service Code' => 'et',
                'Name' => ' Clubhouse',
            ],
            298 => [
                'Service Code' => 'hh',
                'Name' => ' Uplay',
            ],
            299 => [
                'Service Code' => 'cm',
                'Name' => ' Prom',
            ],
            300 => [
                'Service Code' => 'uy',
                'Name' => ' Meliuz',
            ],
            301 => [
                'Service Code' => 'qr',
                'Name' => ' MEGA',
            ],
            302 => [
                'Service Code' => 'hq',
                'Name' => ' Magicbricks',
            ],
            303 => [
                'Service Code' => 'eg',
                'Name' => ' ContactSys',
            ],
            304 => [
                'Service Code' => 'rz',
                'Name' => ' EasyPay',
            ],
            305 => [
                'Service Code' => 'yp',
                'Name' => ' Payzapp',
            ],
            306 => [
                'Service Code' => 'cl',
                'Name' => ' UWIN',
            ],
            307 => [
                'Service Code' => 'sa',
                'Name' => ' AGIBANK',
            ],
            308 => [
                'Service Code' => 'yk',
                'Name' => ' СпортМастер',
            ],
            309 => [
                'Service Code' => 'cd',
                'Name' => ' SpotHit',
            ],
            310 => [
                'Service Code' => 'ko',
                'Name' => ' AdaKami',
            ],
            311 => [
                'Service Code' => 'wh',
                'Name' => ' TanTan',
            ],
            312 => [
                'Service Code' => 'pf',
                'Name' => ' pof.com',
            ],
            313 => [
                'Service Code' => 'yj',
                'Name' => ' eWallet',
            ],
            314 => [
                'Service Code' => 'gv',
                'Name' => ' Humta',
            ],
            315 => [
                'Service Code' => 'px',
                'Name' => ' Nifty',
            ],
            316 => [
                'Service Code' => 'rc',
                'Name' => ' Skype',
            ],
            317 => [
                'Service Code' => 'so',
                'Name' => ' RummyWealth',
            ],
            318 => [
                'Service Code' => 'bq',
                'Name' => ' Adani',
            ],
            319 => [
                'Service Code' => 'ob',
                'Name' => ' Onlinerby',
            ],
            320 => [
                'Service Code' => 'mq',
                'Name' => ' GMNG',
            ],
            321 => [
                'Service Code' => 'dm',
                'Name' => ' Iwplay',
            ],
            322 => [
                'Service Code' => 'kv',
                'Name' => ' Rush',
            ],
            323 => [
                'Service Code' => 'yw',
                'Name' => ' Grindr',
            ],
            324 => [
                'Service Code' => 'ib',
                'Name' => ' Immowelt',
            ],
            325 => [
                'Service Code' => 'od',
                'Name' => ' FWDMAX',
            ],
            326 => [
                'Service Code' => 'ip',
                'Name' => ' Burger King',
            ],
            327 => [
                'Service Code' => 'bh',
                'Name' => ' Uteka',
            ],
            328 => [
                'Service Code' => 'cw',
                'Name' => ' PaddyPower',
            ],
            329 => [
                'Service Code' => 'kz',
                'Name' => ' NimoTV',
            ],
            330 => [
                'Service Code' => 'uh',
                'Name' => ' Yubo',
            ],
            331 => [
                'Service Code' => 'fd',
                'Name' => ' Mamba',
            ],
            332 => [
                'Service Code' => 'qf',
                'Name' => ' RedBook',
            ],
            333 => [
                'Service Code' => 'qn',
                'Name' => ' Blued ',
            ],
            334 => [
                'Service Code' => 'ix',
                'Name' => ' Celcoin',
            ],
            335 => [
                'Service Code' => 'my',
                'Name' => ' CAIXA',
            ],
            336 => [
                'Service Code' => 'fe',
                'Name' => ' CliQQ',
            ],
            337 => [
                'Service Code' => 'xe',
                'Name' => ' GalaxyChat',
            ],
            338 => [
                'Service Code' => 'ax',
                'Name' => ' CrefisaMais',
            ],
            339 => [
                'Service Code' => 'kx',
                'Name' => ' Vivo',
            ],
            340 => [
                'Service Code' => 'ou',
                'Name' => ' Gabi',
            ],
            341 => [
                'Service Code' => 'tm',
                'Name' => ' Akulaku',
            ],
            342 => [
                'Service Code' => 'ct',
                'Name' => ' КухняНаРайоне',
            ],
            343 => [
                'Service Code' => 'kg',
                'Name' => ' FreeChargeApp',
            ],
            344 => [
                'Service Code' => 'ok',
                'Name' => ' ok.ru',
            ],
            345 => [
                'Service Code' => 'fq',
                'Name' => ' Контур',
            ],
            346 => [
                'Service Code' => 'ul',
                'Name' => ' Getir',
            ],
            347 => [
                'Service Code' => 'hf',
                'Name' => ' Cleartrip',
            ],
            348 => [
                'Service Code' => 'cf',
                'Name' => ' irancell',
            ],
            349 => [
                'Service Code' => 'rt',
                'Name' => ' hily',
            ],
            350 => [
                'Service Code' => 'gr',
                'Name' => ' Astropay',
            ],
            351 => [
                'Service Code' => 'tq',
                'Name' => ' Swvl',
            ],
            352 => [
                'Service Code' => 'oy',
                'Name' => ' CashFly',
            ],
            353 => [
                'Service Code' => 'ds',
                'Name' => ' Discord',
            ],
            354 => [
                'Service Code' => 'rf',
                'Name' => ' Akudo',
            ],
            355 => [
                'Service Code' => 'ui',
                'Name' => ' RuTube',
            ],
            356 => [
                'Service Code' => 'wt',
                'Name' => ' IZI',
            ],
            357 => [
                'Service Code' => 'df',
                'Name' => ' Happn',
            ],
            358 => [
                'Service Code' => 'xx',
                'Name' => ' Joyride',
            ],
            359 => [
                'Service Code' => 'kn',
                'Name' => ' Verse',
            ],
            360 => [
                'Service Code' => 'oz',
                'Name' => ' Poshmark',
            ],
            361 => [
                'Service Code' => 'hb',
                'Name' => ' Twitch',
            ],
            362 => [
                'Service Code' => 'vj',
                'Name' => ' Stormgain',
            ],
            363 => [
                'Service Code' => 'ys',
                'Name' => ' ZCity',
            ],
            364 => [
                'Service Code' => 'dg',
                'Name' => ' Mercari',
            ],
            365 => [
                'Service Code' => 'uj',
                'Name' => ' СhampionСasino',
            ],
            366 => [
                'Service Code' => 'wx',
                'Name' => ' Apple',
            ],
            367 => [
                'Service Code' => 'jb',
                'Name' => ' Wing Money',
            ],
            368 => [
                'Service Code' => 'yx',
                'Name' => ' JTExpress',
            ],
            369 => [
                'Service Code' => 'gl',
                'Name' => ' GlobalTel',
            ],
            370 => [
                'Service Code' => 'po',
                'Name' => ' premium.one',
            ],
            371 => [
                'Service Code' => 'ks',
                'Name' => ' Hirect',
            ],
            372 => [
                'Service Code' => 'iv',
                'Name' => ' Inboxlv',
            ],
            373 => [
                'Service Code' => 'gn',
                'Name' => ' A9A',
            ],
            374 => [
                'Service Code' => 'ft',
                'Name' => ' Букмекерские',
            ],
            375 => [
                'Service Code' => 'qy',
                'Name' => ' Zhihu',
            ],
            376 => [
                'Service Code' => 'st',
                'Name' => ' Auchan',
            ],
            377 => [
                'Service Code' => 'bp',
                'Name' => ' GoFundMe',
            ],
            378 => [
                'Service Code' => 'az',
                'Name' => ' CityBase',
            ],
            379 => [
                'Service Code' => 'py',
                'Name' => ' Monese',
            ],
            380 => [
                'Service Code' => 'xi',
                'Name' => ' InFund',
            ],
            381 => [
                'Service Code' => 'lq',
                'Name' => ' Potato',
            ],
            382 => [
                'Service Code' => 'js',
                'Name' => ' GolosZa',
            ],
            383 => [
                'Service Code' => 'gx',
                'Name' => ' Hepsiburadacom',
            ],
            384 => [
                'Service Code' => 'vy',
                'Name' => ' Meta',
            ],
            385 => [
                'Service Code' => 'va',
                'Name' => ' SportGully',
            ],
            386 => [
                'Service Code' => 'el',
                'Name' => ' Bisu',
            ],
            387 => [
                'Service Code' => 'wp',
                'Name' => ' 163СOM',
            ],
            388 => [
                'Service Code' => 'lw',
                'Name' => ' MrGreen',
            ],
            389 => [
                'Service Code' => 'zs',
                'Name' => ' Bilibili',
            ],
            390 => [
                'Service Code' => 'dp',
                'Name' => ' ProtonMail',
            ],
            391 => [
                'Service Code' => 'yd',
                'Name' => ' 米画师Mihuashi',
            ],
            392 => [
                'Service Code' => 'og',
                'Name' => ' Okko',
            ],
            393 => [
                'Service Code' => 'vp',
                'Name' => ' Kwai',
            ],
            394 => [
                'Service Code' => 'ls',
                'Name' => ' Careem',
            ],
            395 => [
                'Service Code' => 'hm',
                'Name' => ' Globus',
            ],
            396 => [
                'Service Code' => 'eh',
                'Name' => ' Telegram 2.0',
            ],
            397 => [
                'Service Code' => 'xd',
                'Name' => ' Tokopedia',
            ],
            398 => [
                'Service Code' => 'kc',
                'Name' => ' Vinted',
            ],
            399 => [
                'Service Code' => 'zt',
                'Name' => ' Budweiser',
            ],
            400 => [
                'Service Code' => 'fp',
                'Name' => ' Phound',
            ],
            401 => [
                'Service Code' => 'ca',
                'Name' => ' SuperS',
            ],
            402 => [
                'Service Code' => 'ot',
                'Name' => ' Any other call forwarding',
            ],
            403 => [
                'Service Code' => 'zu',
                'Name' => ' BigC',
            ],
            404 => [
                'Service Code' => 'sn',
                'Name' => ' OLX',
            ],
            405 => [
                'Service Code' => 'lu',
                'Name' => ' Crickpe',
            ],
            406 => [
                'Service Code' => 'mi',
                'Name' => ' Zupee',
            ],
            407 => [
                'Service Code' => 'sb',
                'Name' => ' Lamoda',
            ],
            408 => [
                'Service Code' => 'pt',
                'Name' => ' Bitaqaty',
            ],
            409 => [
                'Service Code' => 'tk',
                'Name' => ' МВидео',
            ],
            410 => [
                'Service Code' => 'yv',
                'Name' => ' IPLwin',
            ],
            411 => [
                'Service Code' => 'ck',
                'Name' => ' BeReal',
            ],
            412 => [
                'Service Code' => 'lp',
                'Name' => ' Algida',
            ],
            413 => [
                'Service Code' => 'tu',
                'Name' => ' Lyft',
            ],
            414 => [
                'Service Code' => 'jo',
                'Name' => ' SticPay',
            ],
            415 => [
                'Service Code' => 'au',
                'Name' => ' Haraj',
            ],
            416 => [
                'Service Code' => 'za',
                'Name' => ' JDcom',
            ],
            417 => [
                'Service Code' => 'hw',
                'Name' => ' Alipay/Alibaba/1688',
            ],
            418 => [
                'Service Code' => 'ma',
                'Name' => ' Mail.ru',
            ],
            419 => [
                'Service Code' => 'cs',
                'Name' => ' AgriDevelop',
            ],
            420 => [
                'Service Code' => 'ot',
                'Name' => ' Any other',
            ],
            421 => [
                'Service Code' => 'vc',
                'Name' => ' Banqi',
            ],
            422 => [
                'Service Code' => 'uf',
                'Name' => ' Eneba',
            ],
            423 => [
                'Service Code' => 'lb',
                'Name' => ' Mailru Group',
            ],
            424 => [
                'Service Code' => 'iq',
                'Name' => ' icq',
            ],
            425 => [
                'Service Code' => 'nr',
                'Name' => ' Tosla',
            ],
            426 => [
                'Service Code' => 'os',
                'Name' => ' Dhani',
            ],
            427 => [
                'Service Code' => 'xy',
                'Name' => ' Depop',
            ],
            428 => [
                'Service Code' => 'hp',
                'Name' => ' Meesho',
            ],
            429 => [
                'Service Code' => 'ml',
                'Name' => ' ApostaGanha',
            ],
            430 => [
                'Service Code' => 'hj',
                'Name' => ' Stoloto',
            ],
            431 => [
                'Service Code' => 'rk',
                'Name' => ' Fotka',
            ],
            432 => [
                'Service Code' => 'lo',
                'Name' => ' OPPO',
            ],
            433 => [
                'Service Code' => 'ez',
                'Name' => ' GoerliFaucet',
            ],
            434 => [
                'Service Code' => 'bf',
                'Name' => ' Keybase ',
            ],
            435 => [
                'Service Code' => 'xb',
                'Name' => ' RummyOla',
            ],
            436 => [
                'Service Code' => 'sd',
                'Name' => ' dodopizza',
            ],
            437 => [
                'Service Code' => 'uk',
                'Name' => ' Airbnb',
            ],
            438 => [
                'Service Code' => 'ht',
                'Name' => ' Bitso',
            ],
            439 => [
                'Service Code' => 'ey',
                'Name' => ' miloan',
            ],
            440 => [
                'Service Code' => 'be',
                'Name' => ' СберМегаМаркет',
            ],
            441 => [
                'Service Code' => 'ab',
                'Name' => ' Alibaba',
            ],
            442 => [
                'Service Code' => 'do',
                'Name' => ' Leboncoin',
            ],
            443 => [
                'Service Code' => 'zq',
                'Name' => ' IndiaPlays',
            ],
            444 => [
                'Service Code' => 'du',
                'Name' => ' AUBANK',
            ],
            445 => [
                'Service Code' => 'ya',
                'Name' => ' Yandex',
            ],
            446 => [
                'Service Code' => 'gf',
                'Name' => ' GoogleVoice',
            ],
            447 => [
                'Service Code' => 'mn',
                'Name' => ' RRSA',
            ],
            448 => [
                'Service Code' => 'nm',
                'Name' => ' Thisshop',
            ],
            449 => [
                'Service Code' => 'tt',
                'Name' => ' Ziglu',
            ],
            450 => [
                'Service Code' => 'rx',
                'Name' => ' Sheerid',
            ],
            451 => [
                'Service Code' => 'tl',
                'Name' => ' Truecaller',
            ],
            452 => [
                'Service Code' => 'ga',
                'Name' => ' Roposo',
            ],
            453 => [
                'Service Code' => 'jg',
                'Name' => ' Grab',
            ],
            454 => [
                'Service Code' => 'us',
                'Name' => ' IRCTC',
            ],
            455 => [
                'Service Code' => 'xz',
                'Name' => ' paycell',
            ],
            456 => [
                'Service Code' => 'vz',
                'Name' => ' Hinge',
            ],
            457 => [
                'Service Code' => 'xk',
                'Name' => ' DiDi',
            ],
            458 => [
                'Service Code' => 'iy',
                'Name' => ' FoodHub',
            ],
            459 => [
                'Service Code' => 'yb',
                'Name' => ' Система Город',
            ],
            460 => [
                'Service Code' => 'gi',
                'Name' => ' Hotline',
            ],
            461 => [
                'Service Code' => 'an',
                'Name' => ' Adidas',
            ],
            462 => [
                'Service Code' => 'db',
                'Name' => ' ezbuy',
            ],
            463 => [
                'Service Code' => 'mx',
                'Name' => ' SoulApp',
            ],
            464 => [
                'Service Code' => 'er',
                'Name' => ' Kwork',
            ],
            465 => [
                'Service Code' => 'aj',
                'Name' => ' OneAset',
            ],
            466 => [
                'Service Code' => 'gj',
                'Name' => ' Carousell',
            ],
            467 => [
                'Service Code' => 'gc',
                'Name' => ' TradingView',
            ],
            468 => [
                'Service Code' => 'ar',
                'Name' => ' Wondermart',
            ],
            469 => [
                'Service Code' => 'yf',
                'Name' => ' Citymobil',
            ],
            470 => [
                'Service Code' => 'uo',
                'Name' => ' CafeBazaar',
            ],
            471 => [
                'Service Code' => 'fx',
                'Name' => ' PGbonus call forwarding',
            ],
            472 => [
                'Service Code' => 'em',
                'Name' => ' ZéDelivery',
            ],
            473 => [
                'Service Code' => 'qo',
                'Name' => ' Moneylion',
            ],
            474 => [
                'Service Code' => 'bo',
                'Name' => ' Wise',
            ],
            475 => [
                'Service Code' => 'mc',
                'Name' => ' Michat',
            ],
            476 => [
                'Service Code' => 'uv',
                'Name' => ' BinBin',
            ],
            477 => [
                'Service Code' => 'gw',
                'Name' => ' CallApp',
            ],
            478 => [
                'Service Code' => 'qz',
                'Name' => ' Faceit',
            ],
            479 => [
                'Service Code' => 'rr',
                'Name' => ' Wolt',
            ],
            480 => [
                'Service Code' => 'hz',
                'Name' => ' Drom',
            ],
            481 => [
                'Service Code' => 'ka',
                'Name' => ' Shopee',
            ],
            482 => [
                'Service Code' => 'yu',
                'Name' => ' Xiaomi',
            ],
            483 => [
                'Service Code' => 'ae',
                'Name' => ' myGLO',
            ],
            484 => [
                'Service Code' => 'ed',
                'Name' => ' Gamer',
            ],
            485 => [
                'Service Code' => 'uw',
                'Name' => ' Kirana',
            ],
            486 => [
                'Service Code' => 'bd',
                'Name' => ' X5ID',
            ],
            487 => [
                'Service Code' => 'kj',
                'Name' => ' YAPPY',
            ],
            488 => [
                'Service Code' => 'bk',
                'Name' => ' G2G',
            ],
            489 => [
                'Service Code' => 'xu',
                'Name' => ' RecargaPay',
            ],
            490 => [
                'Service Code' => 'mr',
                'Name' => ' Fastmail',
            ],
            491 => [
                'Service Code' => 'vd',
                'Name' => ' Betfair',
            ],
            492 => [
                'Service Code' => 've',
                'Name' => ' Dream11',
            ],
            493 => [
                'Service Code' => 'lt',
                'Name' => ' BitClout',
            ],
            494 => [
                'Service Code' => 'cq',
                'Name' => ' Mercado',
            ],
            495 => [
                'Service Code' => 'fs',
                'Name' => '  Şikayet var',
            ],
            496 => [
                'Service Code' => 'jw',
                'Name' => ' Br777',
            ],
            497 => [
                'Service Code' => 'br',
                'Name' => ' Вкусно и Точка',
            ],
            498 => [
                'Service Code' => 'xr',
                'Name' => ' Tango',
            ],
            499 => [
                'Service Code' => 'xn',
                'Name' => ' Familia',
            ],
            500 => [
                'Service Code' => 'gg',
                'Name' => ' PagSmile',
            ],
            501 => [
                'Service Code' => 'ej',
                'Name' => ' MrQ',
            ],
            502 => [
                'Service Code' => 'ec',
                'Name' => ' RummyCulture',
            ],
            503 => [
                'Service Code' => 'ep',
                'Name' => ' Temu',
            ],
            504 => [
                'Service Code' => 'yq',
                'Name' => ' Фокстрот',
            ],
            505 => [
                'Service Code' => 'cu',
                'Name' => ' 炙热星河',
            ],
            506 => [
                'Service Code' => 'ri',
                'Name' => ' BillMill',
            ],
            507 => [
                'Service Code' => 'lk',
                'Name' => ' PurePlatfrom',
            ],
            508 => [
                'Service Code' => 'ij',
                'Name' => ' Revolut',
            ],
            509 => [
                'Service Code' => 'am',
                'Name' => ' Amazon',
            ],
            510 => [
                'Service Code' => 'zg',
                'Name' => ' Setel',
            ],
            511 => [
                'Service Code' => 'bg',
                'Name' => ' MIXMART',
            ],
            512 => [
                'Service Code' => 'wb',
                'Name' => ' WeChat',
            ],
            513 => [
                'Service Code' => 'uz',
                'Name' => ' OffGamers',
            ],
            514 => [
                'Service Code' => 'qb',
                'Name' => ' Payberry',
            ],
            515 => [
                'Service Code' => 'il',
                'Name' => ' IQOS',
            ],
            516 => [
                'Service Code' => 'ic',
                'Name' => ' JoGo',
            ],
            517 => [
                'Service Code' => 'tj',
                'Name' => ' dbrUA',
            ],
            518 => [
                'Service Code' => 'om',
                'Name' => ' Corona',
            ],
            519 => [
                'Service Code' => 'oc',
                'Name' => ' DealShare',
            ],
            520 => [
                'Service Code' => 'iu',
                'Name' => ' Bykea',
            ],
            521 => [
                'Service Code' => 'la',
                'Name' => ' ssoidnet',
            ],
            522 => [
                'Service Code' => 'oe',
                'Name' => ' Codashop',
            ],
            523 => [
                'Service Code' => 'vg',
                'Name' => ' ShellBox',
            ],
            524 => [
                'Service Code' => 'uc',
                'Name' => ' Tatneft',
            ],
            525 => [
                'Service Code' => 'bv',
                'Name' => ' Metro',
            ],
            526 => [
                'Service Code' => 'de',
                'Name' => ' Karusel',
            ],
            527 => [
                'Service Code' => 'je',
                'Name' => ' Nanovest',
            ],
            528 => [
                'Service Code' => 'ah',
                'Name' => ' EscapeFromTarkov',
            ],
            529 => [
                'Service Code' => 'wl',
                'Name' => ' YouGotaGift',
            ],
            530 => [
                'Service Code' => 'xh',
                'Name' => ' OVO',
            ],
            531 => [
                'Service Code' => 'mt',
                'Name' => ' Steam',
            ],
            532 => [
                'Service Code' => 'fw',
                'Name' => ' 99acres',
            ],
            533 => [
                'Service Code' => 'ev',
                'Name' => ' Picpay ',
            ],
            534 => [
                'Service Code' => 'sq',
                'Name' => ' KuCoinPlay',
            ],
            535 => [
                'Service Code' => 'vn',
                'Name' => ' Yaay',
            ],
            536 => [
                'Service Code' => 'ba',
                'Name' => ' Expressmoney',
            ],
            537 => [
                'Service Code' => 'ww',
                'Name' => ' BIP',
            ],
            538 => [
                'Service Code' => 'cg',
                'Name' => ' Gemgala',
            ],
            539 => [
                'Service Code' => 'jz',
                'Name' => ' Kaya',
            ],
            540 => [
                'Service Code' => 'cv',
                'Name' => ' WashXpress',
            ],
            541 => [
                'Service Code' => 'ji',
                'Name' => ' Monobank',
            ],
            542 => [
                'Service Code' => 'si',
                'Name' => ' Cita Previa',
            ],
            543 => [
                'Service Code' => 'aa',
                'Name' => ' Probo',
            ],
            544 => [
                'Service Code' => 'qa',
                'Name' => ' MyFishka',
            ],
            545 => [
                'Service Code' => 'vf',
                'Name' => ' Q12 Trivia',
            ],
            546 => [
                'Service Code' => 'lh',
                'Name' => ' 24betting',
            ],
            547 => [
                'Service Code' => 'mh',
                'Name' => ' Ашан',
            ],
            548 => [
                'Service Code' => 'pw',
                'Name' => ' SellMonitor',
            ],
            549 => [
                'Service Code' => 'rd',
                'Name' => ' Lenta',
            ],
            550 => [
                'Service Code' => 'xv',
                'Name' => ' Wish',
            ],
            551 => [
                'Service Code' => 'li',
                'Name' => ' Baidu',
            ],
            552 => [
                'Service Code' => 'yo',
                'Name' => ' Amasia',
            ],
            553 => [
                'Service Code' => 'lc',
                'Name' => ' Subito',
            ],
            554 => [
                'Service Code' => 'zd',
                'Name' => ' Zilch',
            ],
            555 => [
                'Service Code' => 'cj',
                'Name' => ' Dotz',
            ],
            556 => [
                'Service Code' => 'zi',
                'Name' => ' LoveLocal',
            ],
            557 => [
                'Service Code' => 'xt',
                'Name' => ' Flipkart',
            ],
            558 => [
                'Service Code' => 'mf',
                'Name' => ' Weidian',
            ],
            559 => [
                'Service Code' => 'mk',
                'Name' => ' LongHu',
            ],
            560 => [
                'Service Code' => 'fm',
                'Name' => ' Touchance',
            ],
            561 => [
                'Service Code' => 'jf',
                'Name' => ' Likee',
            ],
            562 => [
                'Service Code' => 'kh',
                'Name' => ' Bukalapak',
            ],
            563 => [
                'Service Code' => 'we',
                'Name' => ' DrugVokrug',
            ],
            564 => [
                'Service Code' => 'ho',
                'Name' => ' Cathay',
            ],
            565 => [
                'Service Code' => 'kw',
                'Name' => ' Foody',
            ],
            566 => [
                'Service Code' => 'ld',
                'Name' => ' Cashmine',
            ],
            567 => [
                'Service Code' => 'ts',
                'Name' => ' PayPal',
            ],
            568 => [
                'Service Code' => 'hl',
                'Name' => ' Band',
            ],
            569 => [
                'Service Code' => 'cy',
                'Name' => ' РСА',
            ],
            570 => [
                'Service Code' => 'xj',
                'Name' => ' СберМаркет',
            ],
            571 => [
                'Service Code' => 'ku',
                'Name' => ' RoyalWin',
            ],
            572 => [
                'Service Code' => 'zn',
                'Name' => ' Biedronka',
            ],
            573 => [
                'Service Code' => 'xs',
                'Name' => ' GroupMe',
            ],
            574 => [
                'Service Code' => 'kr',
                'Name' => ' Eyecon',
            ],
            575 => [
                'Service Code' => 'ln',
                'Name' => ' Grofers',
            ],
            576 => [
                'Service Code' => 'lr',
                'Name' => ' Okta',
            ],
            577 => [
                'Service Code' => 'bw',
                'Name' => ' Signal',
            ],
            578 => [
                'Service Code' => 'ya',
                'Name' => ' Yandex call forwarding',
            ],
            579 => [
                'Service Code' => 'zh',
                'Name' => ' Zoho',
            ],
            580 => [
                'Service Code' => 'fu',
                'Name' => ' Snapchat',
            ],
            581 => [
                'Service Code' => 'pu',
                'Name' => ' Justdating',
            ],
            582 => [
                'Service Code' => 'ky',
                'Name' => ' SpatenOktoberfest',
            ],
            583 => [
                'Service Code' => 'lm',
                'Name' => ' FarPost',
            ],
            584 => [
                'Service Code' => 'sw',
                'Name' => ' NCsoft',
            ],
            585 => [
                'Service Code' => 'go',
                'Name' => ' Google,youtube,Gmail',
            ],
            586 => [
                'Service Code' => 'qd',
                'Name' => ' Taobao',
            ],
        ];
    return $smsActivateServices;
}

function getSmsActivateCountries()
{
    $countries = [
        0 => [
            'id' => 0,
            'rus' => 'Россия',
            'eng' => 'Russia',
            'chn' => '俄罗斯',
            'visible' => 1,
            'retry' => 1,
            'rent' => 1,
            'multiService' => 1,
        ],
        1 => [
            'id' => 1,
            'rus' => 'Украина',
            'eng' => 'Ukraine',
            'chn' => '乌克兰',
            'visible' => 1,
            'retry' => 1,
            'rent' => 1,
            'multiService' => 1,
        ],
        2 => [
            'id' => 2,
            'rus' => 'Казахстан',
            'eng' => 'Kazakhstan',
            'chn' => '哈萨克斯坦',
            'visible' => 1,
            'retry' => 1,
            'rent' => 1,
            'multiService' => 1,
        ],
        3 => [
            'id' => 3,
            'rus' => 'Китай',
            'eng' => 'China',
            'chn' => '中国',
            'visible' => 1,
            'retry' => 0,
            'rent' => 0,
            'multiService' => 0,
        ],
        4 => [
            'id' => 4,
            'rus' => 'Филиппины',
            'eng' => 'Philippines',
            'chn' => '菲律宾',
            'visible' => 1,
            'retry' => 1,
            'rent' => 0,
            'multiService' => 1,
        ],
        5 => [
            'id' => 5,
            'rus' => 'Мьянма',
            'eng' => 'Myanmar',
            'chn' => '缅甸',
            'visible' => 1,
            'retry' => 1,
            'rent' => 0,
            'multiService' => 0,
        ],
        6 => [
            'id' => 6,
            'rus' => 'Индонезия',
            'eng' => 'Indonesia',
            'chn' => '印度尼西亚',
            'visible' => 1,
            'retry' => 1,
            'rent' => 1,
            'multiService' => 1,
        ],
        7 => [
            'id' => 7,
            'rus' => 'Малайзия',
            'eng' => 'Malaysia',
            'chn' => '马来西亚',
            'visible' => 1,
            'retry' => 1,
            'rent' => 1,
            'multiService' => 1,
        ],
        8 => [
            'id' => 8,
            'rus' => 'Кения',
            'eng' => 'Kenya',
            'chn' => '肯尼亚',
            'visible' => 1,
            'retry' => 1,
            'rent' => 0,
            'multiService' => 1,
        ],
        9 => [
            'id' => 9,
            'rus' => 'Танзания',
            'eng' => 'Tanzania',
            'chn' => '坦桑尼亚',
            'visible' => 1,
            'retry' => 1,
            'rent' => 0,
            'multiService' => 0,
        ],
        10 => [
            'id' => 10,
            'rus' => 'Вьетнам',
            'eng' => 'Vietnam',
            'chn' => '越南',
            'visible' => 1,
            'retry' => 1,
            'rent' => 1,
            'multiService' => 1,
        ],
        11 => [
            'id' => 11,
            'rus' => 'Кыргызстан',
            'eng' => 'Kyrgyzstan',
            'chn' => '吉尔吉斯斯坦',
            'visible' => 1,
            'retry' => 1,
            'rent' => 0,
            'multiService' => 1,
        ],
        12 => [
            'id' => 12,
            'rus' => 'США (виртуальные)',
            'eng' => 'USA (virtual)',
            'chn' => '美国（虚拟）',
            'visible' => 1,
            'retry' => 1,
            'rent' => 0,
            'multiService' => 0,
        ],
        13 => [
            'id' => 13,
            'rus' => 'Израиль',
            'eng' => 'Israel',
            'chn' => '以色列',
            'visible' => 1,
            'retry' => 1,
            'rent' => 0,
            'multiService' => 0,
        ],
        14 => [
            'id' => 14,
            'rus' => 'Гонконг',
            'eng' => 'HongKong',
            'chn' => '香港',
            'visible' => 1,
            'retry' => 1,
            'rent' => 0,
            'multiService' => 1,
        ],
        15 => [
            'id' => 15,
            'rus' => 'Польша',
            'eng' => 'Poland',
            'chn' => '波兰',
            'visible' => 1,
            'retry' => 1,
            'rent' => 1,
            'multiService' => 1,
        ],
        16 => [
            'id' => 16,
            'rus' => 'Англия',
            'eng' => 'England',
            'chn' => '英格兰',
            'visible' => 1,
            'retry' => 1,
            'rent' => 1,
            'multiService' => 1,
        ],
        17 => [
            'id' => 17,
            'rus' => 'Мадагаскар',
            'eng' => 'Madagascar',
            'chn' => '马达加斯加',
            'visible' => 1,
            'retry' => 0,
            'rent' => 0,
            'multiService' => 0,
        ],
        18 => [
            'id' => 18,
            'rus' => 'Дем. Конго',
            'eng' => 'DCongo',
            'chn' => '刚果',
            'visible' => 1,
            'retry' => 0,
            'rent' => 0,
            'multiService' => 0,
        ],
        19 => [
            'id' => 19,
            'rus' => 'Нигерия',
            'eng' => 'Nigeria',
            'chn' => '尼日利亚',
            'visible' => 1,
            'retry' => 1,
            'rent' => 0,
            'multiService' => 0,
        ],
        20 => [
            'id' => 20,
            'rus' => 'Макао',
            'eng' => 'Macao',
            'chn' => '澳门',
            'visible' => 1,
            'retry' => 0,
            'rent' => 0,
            'multiService' => 0,
        ],
        21 => [
            'id' => 21,
            'rus' => 'Египет',
            'eng' => 'Egypt',
            'chn' => '埃及',
            'visible' => 1,
            'retry' => 1,
            'rent' => 0,
            'multiService' => 0,
        ],
        22 => [
            'id' => 22,
            'rus' => 'Индия',
            'eng' => 'India',
            'chn' => '印度',
            'visible' => 1,
            'retry' => 1,
            'rent' => 0,
            'multiService' => 1,
        ],
        23 => [
            'id' => 23,
            'rus' => 'Ирландия',
            'eng' => 'Ireland',
            'chn' => '爱尔兰',
            'visible' => 1,
            'retry' => 1,
            'rent' => 1,
            'multiService' => 1,
        ],
        24 => [
            'id' => 24,
            'rus' => 'Камбоджа',
            'eng' => 'Cambodia',
            'chn' => '柬埔寨',
            'visible' => 1,
            'retry' => 0,
            'rent' => 0,
            'multiService' => 0,
        ],
        25 => [
            'id' => 25,
            'rus' => 'Лаос',
            'eng' => 'Laos',
            'chn' => '老挝',
            'visible' => 1,
            'retry' => 1,
            'rent' => 0,
            'multiService' => 1,
        ],
        26 => [
            'id' => 26,
            'rus' => 'Гаити',
            'eng' => 'Haiti',
            'chn' => '海地',
            'visible' => 1,
            'retry' => 1,
            'rent' => 0,
            'multiService' => 1,
        ],
        27 => [
            'id' => 27,
            'rus' => 'Кот д\'Ивуар',
            'eng' => 'Ivory',
            'chn' => '象牙海岸',
            'visible' => 1,
            'retry' => 1,
            'rent' => 0,
            'multiService' => 0,
        ],
        28 => [
            'id' => 28,
            'rus' => 'Гамбия',
            'eng' => 'Gambia',
            'chn' => '冈比亚',
            'visible' => 1,
            'retry' => 0,
            'rent' => 0,
            'multiService' => 0,
        ],
        29 => [
            'id' => 29,
            'rus' => 'Сербия',
            'eng' => 'Serbia',
            'chn' => '塞尔维亚',
            'visible' => 1,
            'retry' => 1,
            'rent' => 0,
            'multiService' => 0,
        ],
        30 => [
            'id' => 30,
            'rus' => 'Йемен',
            'eng' => 'Yemen',
            'chn' => '也门',
            'visible' => 1,
            'retry' => 0,
            'rent' => 0,
            'multiService' => 0,
        ],
        31 => [
            'id' => 31,
            'rus' => 'ЮАР',
            'eng' => 'Southafrica',
            'chn' => '南非',
            'visible' => 1,
            'retry' => 0,
            'rent' => 0,
            'multiService' => 0,
        ],
        32 => [
            'id' => 32,
            'rus' => 'Румыния',
            'eng' => 'Romania',
            'chn' => '罗马尼亚',
            'visible' => 1,
            'retry' => 1,
            'rent' => 1,
            'multiService' => 1,
        ],
        33 => [
            'id' => 33,
            'rus' => 'Колумбия',
            'eng' => 'Colombia',
            'chn' => '哥伦比亚',
            'visible' => 1,
            'retry' => 1,
            'rent' => 0,
            'multiService' => 1,
        ],
        34 => [
            'id' => 34,
            'rus' => 'Эстония',
            'eng' => 'Estonia',
            'chn' => '爱沙尼亚',
            'visible' => 1,
            'retry' => 1,
            'rent' => 1,
            'multiService' => 1,
        ],
        35 => [
            'id' => 35,
            'rus' => 'Азербайджан',
            'eng' => 'Azerbaijan',
            'chn' => '阿塞拜疆',
            'visible' => 0,
            'retry' => 0,
            'rent' => 0,
            'multiService' => 0,
        ],
        36 => [
            'id' => 36,
            'rus' => 'Канада',
            'eng' => 'Canada',
            'chn' => '加拿大',
            'visible' => 1,
            'retry' => 1,
            'rent' => 0,
            'multiService' => 0,
        ],
        37 => [
            'id' => 37,
            'rus' => 'Марокко',
            'eng' => 'Morocco',
            'chn' => '摩洛哥',
            'visible' => 1,
            'retry' => 1,
            'rent' => 0,
            'multiService' => 0,
        ],
        38 => [
            'id' => 38,
            'rus' => 'Гана',
            'eng' => 'Ghana',
            'chn' => '加纳',
            'visible' => 1,
            'retry' => 0,
            'rent' => 0,
            'multiService' => 0,
        ],
        39 => [
            'id' => 39,
            'rus' => 'Аргентина',
            'eng' => 'Argentina',
            'chn' => '阿根廷',
            'visible' => 1,
            'retry' => 0,
            'rent' => 0,
            'multiService' => 0,
        ],
        40 => [
            'id' => 40,
            'rus' => 'Узбекистан',
            'eng' => 'Uzbekistan',
            'chn' => '乌兹别克斯坦',
            'visible' => 1,
            'retry' => 1,
            'rent' => 0,
            'multiService' => 1,
        ],
        41 => [
            'id' => 41,
            'rus' => 'Камерун',
            'eng' => 'Cameroon',
            'chn' => '喀麦隆',
            'visible' => 1,
            'retry' => 0,
            'rent' => 0,
            'multiService' => 0,
        ],
        42 => [
            'id' => 42,
            'rus' => 'Чад',
            'eng' => 'Chad',
            'chn' => '乍得',
            'visible' => 1,
            'retry' => 0,
            'rent' => 0,
            'multiService' => 0,
        ],
        43 => [
            'id' => 43,
            'rus' => 'Германия',
            'eng' => 'Germany',
            'chn' => '德国',
            'visible' => 1,
            'retry' => 1,
            'rent' => 1,
            'multiService' => 1,
        ],
        44 => [
            'id' => 44,
            'rus' => 'Литва',
            'eng' => 'Lithuania',
            'chn' => '立陶宛',
            'visible' => 1,
            'retry' => 1,
            'rent' => 1,
            'multiService' => 1,
        ],
        45 => [
            'id' => 45,
            'rus' => 'Хорватия',
            'eng' => 'Croatia',
            'chn' => '克罗地亚',
            'visible' => 1,
            'retry' => 1,
            'rent' => 1,
            'multiService' => 0,
        ],
        46 => [
            'id' => 46,
            'rus' => 'Швеция',
            'eng' => 'Sweden',
            'chn' => '瑞典',
            'visible' => 1,
            'retry' => 1,
            'rent' => 1,
            'multiService' => 1,
        ],
        47 => [
            'id' => 47,
            'rus' => 'Ирак',
            'eng' => 'Iraq',
            'chn' => '伊拉克',
            'visible' => 1,
            'retry' => 1,
            'rent' => 0,
            'multiService' => 0,
        ],
        48 => [
            'id' => 48,
            'rus' => 'Нидерланды',
            'eng' => 'Netherlands',
            'chn' => '荷兰',
            'visible' => 1,
            'retry' => 1,
            'rent' => 1,
            'multiService' => 1,
        ],
        49 => [
            'id' => 49,
            'rus' => 'Латвия',
            'eng' => 'Latvia',
            'chn' => '拉脱维亚',
            'visible' => 1,
            'retry' => 1,
            'rent' => 1,
            'multiService' => 1,
        ],
        50 => [
            'id' => 50,
            'rus' => 'Австрия',
            'eng' => 'Austria',
            'chn' => '奥地利',
            'visible' => 1,
            'retry' => 0,
            'rent' => 1,
            'multiService' => 0,
        ],
        51 => [
            'id' => 51,
            'rus' => 'Беларусь',
            'eng' => 'Belarus',
            'chn' => '白俄罗斯',
            'visible' => 1,
            'retry' => 1,
            'rent' => 0,
            'multiService' => 1,
        ],
        52 => [
            'id' => 52,
            'rus' => 'Таиланд',
            'eng' => 'Thailand',
            'chn' => '泰国',
            'visible' => 1,
            'retry' => 1,
            'rent' => 1,
            'multiService' => 1,
        ],
        53 => [
            'id' => 53,
            'rus' => 'Сауд. Аравия',
            'eng' => 'Saudiarabia',
            'chn' => '沙特阿拉伯',
            'visible' => 1,
            'retry' => 0,
            'rent' => 0,
            'multiService' => 0,
        ],
        54 => [
            'id' => 54,
            'rus' => 'Мексика',
            'eng' => 'Mexico',
            'chn' => '墨西哥',
            'visible' => 1,
            'retry' => 1,
            'rent' => 0,
            'multiService' => 0,
        ],
        55 => [
            'id' => 55,
            'rus' => 'Тайвань',
            'eng' => 'Taiwan',
            'chn' => '台湾',
            'visible' => 1,
            'retry' => 1,
            'rent' => 0,
            'multiService' => 0,
        ],
        56 => [
            'id' => 56,
            'rus' => 'Испания',
            'eng' => 'Spain',
            'chn' => '西班牙',
            'visible' => 1,
            'retry' => 1,
            'rent' => 1,
            'multiService' => 1,
        ],
        57 => [
            'id' => 57,
            'rus' => 'Иран',
            'eng' => 'Iran',
            'chn' => '伊朗',
            'visible' => 0,
            'retry' => 0,
            'rent' => 0,
            'multiService' => 0,
        ],
        58 => [
            'id' => 58,
            'rus' => 'Алжир',
            'eng' => 'Algeria',
            'chn' => '阿尔及利亚',
            'visible' => 1,
            'retry' => 1,
            'rent' => 0,
            'multiService' => 0,
        ],
        59 => [
            'id' => 59,
            'rus' => 'Словения',
            'eng' => 'Slovenia',
            'chn' => '斯洛文尼亚',
            'visible' => 1,
            'retry' => 0,
            'rent' => 1,
            'multiService' => 0,
        ],
        60 => [
            'id' => 60,
            'rus' => 'Бангладеш',
            'eng' => 'Bangladesh',
            'chn' => '孟加拉国',
            'visible' => 1,
            'retry' => 1,
            'rent' => 0,
            'multiService' => 0,
        ],
        61 => [
            'id' => 61,
            'rus' => 'Сенегал',
            'eng' => 'Senegal',
            'chn' => '塞内加尔',
            'visible' => 1,
            'retry' => 0,
            'rent' => 0,
            'multiService' => 0,
        ],
        62 => [
            'id' => 62,
            'rus' => 'Турция',
            'eng' => 'Turkey',
            'chn' => '土耳其',
            'visible' => 1,
            'retry' => 0,
            'rent' => 0,
            'multiService' => 0,
        ],
        63 => [
            'id' => 63,
            'rus' => 'Чехия',
            'eng' => 'Czech',
            'chn' => '捷克共和国',
            'visible' => 1,
            'retry' => 1,
            'rent' => 1,
            'multiService' => 1,
        ],
        64 => [
            'id' => 64,
            'rus' => 'Шри-Ланка',
            'eng' => 'Srilanka',
            'chn' => '斯里兰卡',
            'visible' => 1,
            'retry' => 0,
            'rent' => 0,
            'multiService' => 0,
        ],
        65 => [
            'id' => 65,
            'rus' => 'Перу',
            'eng' => 'Peru',
            'chn' => '秘鲁',
            'visible' => 1,
            'retry' => 1,
            'rent' => 0,
            'multiService' => 0,
        ],
        66 => [
            'id' => 66,
            'rus' => 'Пакистан',
            'eng' => 'Pakistan',
            'chn' => '巴基斯坦',
            'visible' => 1,
            'retry' => 1,
            'rent' => 0,
            'multiService' => 0,
        ],
        67 => [
            'id' => 67,
            'rus' => 'Новая Зеландия',
            'eng' => 'Newzealand',
            'chn' => '新西兰',
            'visible' => 1,
            'retry' => 1,
            'rent' => 0,
            'multiService' => 0,
        ],
        68 => [
            'id' => 68,
            'rus' => 'Гвинея',
            'eng' => 'Guinea',
            'chn' => '几内亚',
            'visible' => 1,
            'retry' => 1,
            'rent' => 0,
            'multiService' => 0,
        ],
        69 => [
            'id' => 69,
            'rus' => 'Мали',
            'eng' => 'Mali',
            'chn' => '马里',
            'visible' => 1,
            'retry' => 1,
            'rent' => 0,
            'multiService' => 0,
        ],
        70 => [
            'id' => 70,
            'rus' => 'Венесуэла',
            'eng' => 'Venezuela',
            'chn' => '委内瑞拉',
            'visible' => 1,
            'retry' => 1,
            'rent' => 0,
            'multiService' => 0,
        ],
        71 => [
            'id' => 71,
            'rus' => 'Эфиопия',
            'eng' => 'Ethiopia',
            'chn' => '埃塞俄比亚',
            'visible' => 1,
            'retry' => 0,
            'rent' => 0,
            'multiService' => 0,
        ],
        72 => [
            'id' => 72,
            'rus' => 'Монголия',
            'eng' => 'Mongolia',
            'chn' => '蒙古',
            'visible' => 1,
            'retry' => 1,
            'rent' => 0,
            'multiService' => 0,
        ],
        73 => [
            'id' => 73,
            'rus' => 'Бразилия',
            'eng' => 'Brazil',
            'chn' => '巴西',
            'visible' => 1,
            'retry' => 1,
            'rent' => 1,
            'multiService' => 1,
        ],
        74 => [
            'id' => 74,
            'rus' => 'Афганистан',
            'eng' => 'Afghanistan',
            'chn' => '阿富汗',
            'visible' => 1,
            'retry' => 1,
            'rent' => 0,
            'multiService' => 0,
        ],
        75 => [
            'id' => 75,
            'rus' => 'Уганда',
            'eng' => 'Uganda',
            'chn' => '乌干达',
            'visible' => 1,
            'retry' => 0,
            'rent' => 0,
            'multiService' => 0,
        ],
        76 => [
            'id' => 76,
            'rus' => 'Ангола',
            'eng' => 'Angola',
            'chn' => '安哥拉',
            'visible' => 1,
            'retry' => 0,
            'rent' => 0,
            'multiService' => 0,
        ],
        77 => [
            'id' => 77,
            'rus' => 'Кипр',
            'eng' => 'Cyprus',
            'chn' => '塞浦路斯',
            'visible' => 1,
            'retry' => 1,
            'rent' => 1,
            'multiService' => 0,
        ],
        78 => [
            'id' => 78,
            'rus' => 'Франция',
            'eng' => 'France',
            'chn' => '法國',
            'visible' => 1,
            'retry' => 1,
            'rent' => 1,
            'multiService' => 1,
        ],
        79 => [
            'id' => 79,
            'rus' => 'Папуа-Новая Гвинея',
            'eng' => 'Papua',
            'chn' => '巴布亞新幾內亞',
            'visible' => 1,
            'retry' => 1,
            'rent' => 0,
            'multiService' => 0,
        ],
        80 => [
            'id' => 80,
            'rus' => 'Мозамбик',
            'eng' => 'Mozambique',
            'chn' => '莫桑比克',
            'visible' => 1,
            'retry' => 0,
            'rent' => 0,
            'multiService' => 0,
        ],
        81 => [
            'id' => 81,
            'rus' => 'Непал',
            'eng' => 'Nepal',
            'chn' => '尼泊爾',
            'visible' => 1,
            'retry' => 1,
            'rent' => 0,
            'multiService' => 0,
        ],
        82 => [
            'id' => 82,
            'rus' => 'Бельгия',
            'eng' => 'Belgium',
            'chn' => '比利時',
            'visible' => 1,
            'retry' => 0,
            'rent' => 1,
            'multiService' => 0,
        ],
        83 => [
            'id' => 83,
            'rus' => 'Болгария',
            'eng' => 'Bulgaria',
            'chn' => '保加利亞',
            'visible' => 1,
            'retry' => 1,
            'rent' => 0,
            'multiService' => 1,
        ],
        84 => [
            'id' => 84,
            'rus' => 'Венгрия',
            'eng' => 'Hungary',
            'chn' => '匈牙利',
            'visible' => 1,
            'retry' => 0,
            'rent' => 0,
            'multiService' => 0,
        ],
        85 => [
            'id' => 85,
            'rus' => 'Молдова',
            'eng' => 'Moldova',
            'chn' => '摩爾多瓦',
            'visible' => 1,
            'retry' => 1,
            'rent' => 1,
            'multiService' => 1,
        ],
        86 => [
            'id' => 86,
            'rus' => 'Италия',
            'eng' => 'Italy',
            'chn' => '義大利',
            'visible' => 1,
            'retry' => 0,
            'rent' => 1,
            'multiService' => 0,
        ],
        87 => [
            'id' => 87,
            'rus' => 'Парагвай',
            'eng' => 'Paraguay',
            'chn' => '巴拉圭',
            'visible' => 1,
            'retry' => 1,
            'rent' => 0,
            'multiService' => 0,
        ],
        88 => [
            'id' => 88,
            'rus' => 'Гондурас',
            'eng' => 'Honduras',
            'chn' => '洪都拉斯',
            'visible' => 1,
            'retry' => 1,
            'rent' => 0,
            'multiService' => 0,
        ],
        89 => [
            'id' => 89,
            'rus' => 'Тунис',
            'eng' => 'Tunisia',
            'chn' => '突尼斯',
            'visible' => 1,
            'retry' => 1,
            'rent' => 0,
            'multiService' => 0,
        ],
        90 => [
            'id' => 90,
            'rus' => 'Никарагуа',
            'eng' => 'Nicaragua',
            'chn' => '尼加拉瓜',
            'visible' => 1,
            'retry' => 1,
            'rent' => 0,
            'multiService' => 0,
        ],
        91 => [
            'id' => 91,
            'rus' => 'Тимор-Лесте',
            'eng' => 'Timorleste',
            'chn' => '東帝汶',
            'visible' => 1,
            'retry' => 0,
            'rent' => 0,
            'multiService' => 0,
        ],
        92 => [
            'id' => 92,
            'rus' => 'Боливия',
            'eng' => 'Bolivia',
            'chn' => '玻利維亞',
            'visible' => 1,
            'retry' => 1,
            'rent' => 0,
            'multiService' => 0,
        ],
        93 => [
            'id' => 93,
            'rus' => 'Коста Рика',
            'eng' => 'Costarica',
            'chn' => '哥斯達黎加',
            'visible' => 1,
            'retry' => 0,
            'rent' => 0,
            'multiService' => 0,
        ],
        94 => [
            'id' => 94,
            'rus' => 'Гватемала',
            'eng' => 'Guatemala',
            'chn' => '危地馬拉',
            'visible' => 1,
            'retry' => 1,
            'rent' => 0,
            'multiService' => 0,
        ],
        95 => [
            'id' => 95,
            'rus' => 'ОАЭ',
            'eng' => 'Uae',
            'chn' => '阿拉伯聯合酋長國',
            'visible' => 1,
            'retry' => 1,
            'rent' => 0,
            'multiService' => 0,
        ],
        96 => [
            'id' => 96,
            'rus' => 'Зимбабве',
            'eng' => 'Zimbabwe',
            'chn' => '津巴布韋',
            'visible' => 1,
            'retry' => 0,
            'rent' => 0,
            'multiService' => 0,
        ],
        97 => [
            'id' => 97,
            'rus' => 'Пуэрто-Рико',
            'eng' => 'Puertorico',
            'chn' => '波多黎各',
            'visible' => 1,
            'retry' => 0,
            'rent' => 0,
            'multiService' => 0,
        ],
        98 => [
            'id' => 98,
            'rus' => 'Судан',
            'eng' => 'Sudan',
            'chn' => '蘇丹蘇丹',
            'visible' => 0,
            'retry' => 0,
            'rent' => 0,
            'multiService' => 0,
        ],
        99 => [
            'id' => 99,
            'rus' => 'Того',
            'eng' => 'Togo',
            'chn' => '多哥',
            'visible' => 1,
            'retry' => 0,
            'rent' => 0,
            'multiService' => 0,
        ],
        100 => [
            'id' => 100,
            'rus' => 'Кувейт',
            'eng' => 'Kuwait',
            'chn' => '科威特',
            'visible' => 1,
            'retry' => 0,
            'rent' => 0,
            'multiService' => 0,
        ],
        101 => [
            'id' => 101,
            'rus' => 'Сальвадор',
            'eng' => 'Salvador',
            'chn' => '薩爾瓦多',
            'visible' => 1,
            'retry' => 0,
            'rent' => 0,
            'multiService' => 0,
        ],
        102 => [
            'id' => 102,
            'rus' => 'Ливия',
            'eng' => 'Libyan',
            'chn' => '利比亞',
            'visible' => 1,
            'retry' => 1,
            'rent' => 0,
            'multiService' => 0,
        ],
        103 => [
            'id' => 103,
            'rus' => 'Ямайка',
            'eng' => 'Jamaica',
            'chn' => '牙買加',
            'visible' => 1,
            'retry' => 1,
            'rent' => 0,
            'multiService' => 0,
        ],
        104 => [
            'id' => 104,
            'rus' => 'Тринидад и Тобаго',
            'eng' => 'Trinidad',
            'chn' => '特立尼達和多巴哥',
            'visible' => 1,
            'retry' => 0,
            'rent' => 0,
            'multiService' => 0,
        ],
        105 => [
            'id' => 105,
            'rus' => 'Эквадор',
            'eng' => 'Ecuador',
            'chn' => '厄瓜多爾',
            'visible' => 1,
            'retry' => 0,
            'rent' => 0,
            'multiService' => 0,
        ],
        106 => [
            'id' => 106,
            'rus' => 'Свазиленд',
            'eng' => 'Swaziland',
            'chn' => '斯威士蘭',
            'visible' => 1,
            'retry' => 0,
            'rent' => 0,
            'multiService' => 0,
        ],
        107 => [
            'id' => 107,
            'rus' => 'Оман',
            'eng' => 'Oman',
            'chn' => '阿曼',
            'visible' => 1,
            'retry' => 0,
            'rent' => 0,
            'multiService' => 0,
        ],
        108 => [
            'id' => 108,
            'rus' => 'Босния и Герцеговина',
            'eng' => 'Bosnia',
            'chn' => '波斯尼亞和黑塞哥維那',
            'visible' => 1,
            'retry' => 0,
            'rent' => 0,
            'multiService' => 0,
        ],
        109 => [
            'id' => 109,
            'rus' => 'Доминиканская Республика',
            'eng' => 'Dominican',
            'chn' => '多明尼加共和國',
            'visible' => 1,
            'retry' => 1,
            'rent' => 0,
            'multiService' => 1,
        ],
        110 => [
            'id' => 110,
            'rus' => 'Сирия',
            'eng' => 'Syrian',
            'chn' => '敘利亞',
            'visible' => 0,
            'retry' => 0,
            'rent' => 0,
            'multiService' => 0,
        ],
        111 => [
            'id' => 111,
            'rus' => 'Катар',
            'eng' => 'Qatar',
            'chn' => '卡塔爾',
            'visible' => 1,
            'retry' => 0,
            'rent' => 0,
            'multiService' => 0,
        ],
        112 => [
            'id' => 112,
            'rus' => 'Панама',
            'eng' => 'Panama',
            'chn' => '巴拿馬',
            'visible' => 1,
            'retry' => 0,
            'rent' => 0,
            'multiService' => 0,
        ],
        113 => [
            'id' => 113,
            'rus' => 'Куба',
            'eng' => 'Cuba',
            'chn' => '古巴',
            'visible' => 0,
            'retry' => 0,
            'rent' => 0,
            'multiService' => 0,
        ],
        114 => [
            'id' => 114,
            'rus' => 'Мавритания',
            'eng' => 'Mauritania',
            'chn' => '毛里塔尼亞',
            'visible' => 1,
            'retry' => 0,
            'rent' => 0,
            'multiService' => 0,
        ],
        115 => [
            'id' => 115,
            'rus' => 'Сьерра-Леоне',
            'eng' => 'Sierraleone',
            'chn' => '塞拉利昂',
            'visible' => 1,
            'retry' => 0,
            'rent' => 0,
            'multiService' => 0,
        ],
        116 => [
            'id' => 116,
            'rus' => 'Иордания',
            'eng' => 'Jordan',
            'chn' => '約旦',
            'visible' => 1,
            'retry' => 1,
            'rent' => 0,
            'multiService' => 0,
        ],
        117 => [
            'id' => 117,
            'rus' => 'Португалия',
            'eng' => 'Portugal',
            'chn' => '葡萄牙',
            'visible' => 1,
            'retry' => 1,
            'rent' => 1,
            'multiService' => 1,
        ],
        118 => [
            'id' => 118,
            'rus' => 'Барбадос',
            'eng' => 'Barbados',
            'chn' => '巴巴多斯',
            'visible' => 1,
            'retry' => 0,
            'rent' => 0,
            'multiService' => 0,
        ],
        119 => [
            'id' => 119,
            'rus' => 'Бурунди',
            'eng' => 'Burundi',
            'chn' => '布隆迪',
            'visible' => 1,
            'retry' => 0,
            'rent' => 0,
            'multiService' => 0,
        ],
        120 => [
            'id' => 120,
            'rus' => 'Бенин',
            'eng' => 'Benin',
            'chn' => '貝寧',
            'visible' => 1,
            'retry' => 0,
            'rent' => 0,
            'multiService' => 0,
        ],
        121 => [
            'id' => 121,
            'rus' => 'Бруней',
            'eng' => 'Brunei',
            'chn' => '文萊',
            'visible' => 1,
            'retry' => 0,
            'rent' => 0,
            'multiService' => 0,
        ],
        122 => [
            'id' => 122,
            'rus' => 'Багамы',
            'eng' => 'Bahamas',
            'chn' => '巴哈馬',
            'visible' => 1,
            'retry' => 0,
            'rent' => 0,
            'multiService' => 0,
        ],
        123 => [
            'id' => 123,
            'rus' => 'Ботсвана',
            'eng' => 'Botswana',
            'chn' => '博茨瓦納',
            'visible' => 1,
            'retry' => 0,
            'rent' => 0,
            'multiService' => 0,
        ],
        124 => [
            'id' => 124,
            'rus' => 'Белиз',
            'eng' => 'Belize',
            'chn' => '伯利茲',
            'visible' => 1,
            'retry' => 0,
            'rent' => 0,
            'multiService' => 0,
        ],
        125 => [
            'id' => 125,
            'rus' => 'ЦАР',
            'eng' => 'Caf',
            'chn' => '中非共和國',
            'visible' => 1,
            'retry' => 0,
            'rent' => 0,
            'multiService' => 0,
        ],
        126 => [
            'id' => 126,
            'rus' => 'Доминика',
            'eng' => 'Dominica',
            'chn' => '多米尼加',
            'visible' => 1,
            'retry' => 1,
            'rent' => 0,
            'multiService' => 0,
        ],
        127 => [
            'id' => 127,
            'rus' => 'Гренада',
            'eng' => 'Grenada',
            'chn' => '格林納達',
            'visible' => 1,
            'retry' => 0,
            'rent' => 0,
            'multiService' => 0,
        ],
        128 => [
            'id' => 128,
            'rus' => 'Грузия',
            'eng' => 'Georgia',
            'chn' => '佐治亞州',
            'visible' => 1,
            'retry' => 1,
            'rent' => 0,
            'multiService' => 1,
        ],
        129 => [
            'id' => 129,
            'rus' => 'Греция',
            'eng' => 'Greece',
            'chn' => '希臘',
            'visible' => 1,
            'retry' => 1,
            'rent' => 1,
            'multiService' => 1,
        ],
        130 => [
            'id' => 130,
            'rus' => 'Гвинея-Бисау',
            'eng' => 'Guineabissau',
            'chn' => '幾內亞比紹',
            'visible' => 1,
            'retry' => 0,
            'rent' => 0,
            'multiService' => 0,
        ],
        131 => [
            'id' => 131,
            'rus' => 'Гайана',
            'eng' => 'Guyana',
            'chn' => '圭亞那',
            'visible' => 1,
            'retry' => 0,
            'rent' => 0,
            'multiService' => 0,
        ],
        132 => [
            'id' => 132,
            'rus' => 'Исландия',
            'eng' => 'Iceland',
            'chn' => '冰島',
            'visible' => 1,
            'retry' => 0,
            'rent' => 0,
            'multiService' => 0,
        ],
        133 => [
            'id' => 133,
            'rus' => 'Коморы',
            'eng' => 'Comoros',
            'chn' => '科摩羅',
            'visible' => 1,
            'retry' => 0,
            'rent' => 0,
            'multiService' => 0,
        ],
        134 => [
            'id' => 134,
            'rus' => 'Сент-Китс и Невис',
            'eng' => 'Saintkitts',
            'chn' => '聖基茨和尼維斯',
            'visible' => 1,
            'retry' => 0,
            'rent' => 0,
            'multiService' => 0,
        ],
        135 => [
            'id' => 135,
            'rus' => 'Либерия',
            'eng' => 'Liberia',
            'chn' => '利比里亞',
            'visible' => 1,
            'retry' => 0,
            'rent' => 0,
            'multiService' => 0,
        ],
        136 => [
            'id' => 136,
            'rus' => 'Лесото',
            'eng' => 'Lesotho',
            'chn' => '萊索托',
            'visible' => 1,
            'retry' => 0,
            'rent' => 0,
            'multiService' => 0,
        ],
        137 => [
            'id' => 137,
            'rus' => 'Малави',
            'eng' => 'Malawi',
            'chn' => '馬拉維',
            'visible' => 1,
            'retry' => 0,
            'rent' => 0,
            'multiService' => 0,
        ],
        138 => [
            'id' => 138,
            'rus' => 'Намибия',
            'eng' => 'Namibia',
            'chn' => '納米比亞',
            'visible' => 1,
            'retry' => 0,
            'rent' => 0,
            'multiService' => 0,
        ],
        139 => [
            'id' => 139,
            'rus' => 'Нигер',
            'eng' => 'Niger',
            'chn' => '尼日爾',
            'visible' => 1,
            'retry' => 0,
            'rent' => 0,
            'multiService' => 0,
        ],
        140 => [
            'id' => 140,
            'rus' => 'Руанда',
            'eng' => 'Rwanda',
            'chn' => '盧旺達',
            'visible' => 1,
            'retry' => 0,
            'rent' => 0,
            'multiService' => 0,
        ],
        141 => [
            'id' => 141,
            'rus' => 'Словакия',
            'eng' => 'Slovakia',
            'chn' => '斯洛伐克',
            'visible' => 1,
            'retry' => 0,
            'rent' => 0,
            'multiService' => 0,
        ],
        142 => [
            'id' => 142,
            'rus' => 'Суринам',
            'eng' => 'Suriname',
            'chn' => '蘇里南',
            'visible' => 1,
            'retry' => 0,
            'rent' => 0,
            'multiService' => 0,
        ],
        143 => [
            'id' => 143,
            'rus' => 'Таджикистан',
            'eng' => 'Tajikistan',
            'chn' => '塔吉克斯坦',
            'visible' => 1,
            'retry' => 1,
            'rent' => 0,
            'multiService' => 0,
        ],
        144 => [
            'id' => 144,
            'rus' => 'Монако',
            'eng' => 'Monaco',
            'chn' => '摩納哥',
            'visible' => 1,
            'retry' => 0,
            'rent' => 0,
            'multiService' => 0,
        ],
        145 => [
            'id' => 145,
            'rus' => 'Бахрейн',
            'eng' => 'Bahrain',
            'chn' => '巴林',
            'visible' => 1,
            'retry' => 0,
            'rent' => 0,
            'multiService' => 0,
        ],
        146 => [
            'id' => 146,
            'rus' => 'Реюньон',
            'eng' => 'Reunion',
            'chn' => '團圓',
            'visible' => 1,
            'retry' => 0,
            'rent' => 0,
            'multiService' => 0,
        ],
        147 => [
            'id' => 147,
            'rus' => 'Замбия',
            'eng' => 'Zambia',
            'chn' => '贊比亞',
            'visible' => 1,
            'retry' => 0,
            'rent' => 0,
            'multiService' => 0,
        ],
        148 => [
            'id' => 148,
            'rus' => 'Армения',
            'eng' => 'Armenia',
            'chn' => '亞美尼亞',
            'visible' => 1,
            'retry' => 1,
            'rent' => 0,
            'multiService' => 1,
        ],
        149 => [
            'id' => 149,
            'rus' => 'Сомали',
            'eng' => 'Somalia',
            'chn' => '索馬里',
            'visible' => 1,
            'retry' => 0,
            'rent' => 0,
            'multiService' => 0,
        ],
        150 => [
            'id' => 150,
            'rus' => 'Конго',
            'eng' => 'Congo',
            'chn' => '剛果',
            'visible' => 1,
            'retry' => 0,
            'rent' => 0,
            'multiService' => 0,
        ],
        151 => [
            'id' => 151,
            'rus' => 'Чили',
            'eng' => 'Chile',
            'chn' => '智利',
            'visible' => 1,
            'retry' => 0,
            'rent' => 0,
            'multiService' => 0,
        ],
        152 => [
            'id' => 152,
            'rus' => 'Буркина-Фасо',
            'eng' => 'Burkinafaso',
            'chn' => '布基納法索',
            'visible' => 1,
            'retry' => 0,
            'rent' => 0,
            'multiService' => 0,
        ],
        153 => [
            'id' => 153,
            'rus' => 'Ливан',
            'eng' => 'Lebanon',
            'chn' => '黎巴嫩',
            'visible' => 1,
            'retry' => 0,
            'rent' => 0,
            'multiService' => 0,
        ],
        154 => [
            'id' => 154,
            'rus' => 'Габон',
            'eng' => 'Gabon',
            'chn' => '加蓬',
            'visible' => 1,
            'retry' => 0,
            'rent' => 0,
            'multiService' => 0,
        ],
        155 => [
            'id' => 155,
            'rus' => 'Албания',
            'eng' => 'Albania',
            'chn' => '阿爾巴尼亞',
            'visible' => 1,
            'retry' => 0,
            'rent' => 0,
            'multiService' => 0,
        ],
        156 => [
            'id' => 156,
            'rus' => 'Уругвай',
            'eng' => 'Uruguay',
            'chn' => '烏拉圭',
            'visible' => 1,
            'retry' => 0,
            'rent' => 0,
            'multiService' => 0,
        ],
        157 => [
            'id' => 157,
            'rus' => 'Маврикий',
            'eng' => 'Mauritius',
            'chn' => '毛里求斯',
            'visible' => 1,
            'retry' => 1,
            'rent' => 0,
            'multiService' => 0,
        ],
        158 => [
            'id' => 158,
            'rus' => 'Бутан',
            'eng' => 'Bhutan',
            'chn' => '丁烷',
            'visible' => 1,
            'retry' => 0,
            'rent' => 0,
            'multiService' => 0,
        ],
        159 => [
            'id' => 159,
            'rus' => 'Мальдивы',
            'eng' => 'Maldives',
            'chn' => '马尔代夫',
            'visible' => 1,
            'retry' => 0,
            'rent' => 0,
            'multiService' => 0,
        ],
        160 => [
            'id' => 160,
            'rus' => 'Гваделупа',
            'eng' => 'Guadeloupe',
            'chn' => '瓜德罗普岛',
            'visible' => 1,
            'retry' => 0,
            'rent' => 0,
            'multiService' => 0,
        ],
        161 => [
            'id' => 161,
            'rus' => 'Туркменистан',
            'eng' => 'Turkmenistan',
            'chn' => '土库曼斯坦',
            'visible' => 1,
            'retry' => 0,
            'rent' => 0,
            'multiService' => 0,
        ],
        162 => [
            'id' => 162,
            'rus' => 'Французская Гвиана',
            'eng' => 'Frenchguiana',
            'chn' => '法属圭亚那',
            'visible' => 1,
            'retry' => 0,
            'rent' => 0,
            'multiService' => 0,
        ],
        163 => [
            'id' => 163,
            'rus' => 'Финляндия',
            'eng' => 'Finland',
            'chn' => '芬兰',
            'visible' => 1,
            'retry' => 1,
            'rent' => 0,
            'multiService' => 1,
        ],
        164 => [
            'id' => 164,
            'rus' => 'Сент-Люсия',
            'eng' => 'Saintlucia',
            'chn' => '圣卢西亚',
            'visible' => 1,
            'retry' => 0,
            'rent' => 0,
            'multiService' => 0,
        ],
        165 => [
            'id' => 165,
            'rus' => 'Люксембург',
            'eng' => 'Luxembourg',
            'chn' => '卢森堡',
            'visible' => 1,
            'retry' => 0,
            'rent' => 0,
            'multiService' => 0,
        ],
        166 => [
            'id' => 166,
            'rus' => 'Сент-Винсент и Гренадин',
            'eng' => 'Saintvincentgrenadines',
            'chn' => '圣文森特和格林纳丁斯',
            'visible' => 1,
            'retry' => 0,
            'rent' => 0,
            'multiService' => 0,
        ],
        167 => [
            'id' => 167,
            'rus' => 'Экваториальная Гвинея',
            'eng' => 'Equatorialguinea',
            'chn' => '赤道几内亚',
            'visible' => 1,
            'retry' => 0,
            'rent' => 0,
            'multiService' => 0,
        ],
        168 => [
            'id' => 168,
            'rus' => 'Джибути',
            'eng' => 'Djibouti',
            'chn' => '吉布地',
            'visible' => 1,
            'retry' => 0,
            'rent' => 0,
            'multiService' => 0,
        ],
        169 => [
            'id' => 169,
            'rus' => 'Антигуа и Барбуда',
            'eng' => 'Antiguabarbuda',
            'chn' => '安提瓜和巴布达',
            'visible' => 1,
            'retry' => 0,
            'rent' => 0,
            'multiService' => 0,
        ],
        170 => [
            'id' => 170,
            'rus' => 'Острова Кайман',
            'eng' => 'Caymanislands',
            'chn' => '开曼群岛',
            'visible' => 1,
            'retry' => 0,
            'rent' => 0,
            'multiService' => 0,
        ],
        171 => [
            'id' => 171,
            'rus' => 'Черногория',
            'eng' => 'Montenegro',
            'chn' => '黑山共和国',
            'visible' => 1,
            'retry' => 0,
            'rent' => 0,
            'multiService' => 0,
        ],
        172 => [
            'id' => 172,
            'rus' => 'Дания',
            'eng' => 'Denmark',
            'chn' => '丹麥',
            'visible' => 1,
            'retry' => 1,
            'rent' => 1,
            'multiService' => 1,
        ],
        173 => [
            'id' => 173,
            'rus' => 'Швейцария',
            'eng' => 'Switzerland',
            'chn' => '瑞士',
            'visible' => 1,
            'retry' => 0,
            'rent' => 0,
            'multiService' => 0,
        ],
        174 => [
            'id' => 174,
            'rus' => 'Норвегия',
            'eng' => 'Norway',
            'chn' => '挪威',
            'visible' => 1,
            'retry' => 0,
            'rent' => 0,
            'multiService' => 0,
        ],
        175 => [
            'id' => 175,
            'rus' => 'Австралия',
            'eng' => 'Australia',
            'chn' => '澳大利亞',
            'visible' => 1,
            'retry' => 0,
            'rent' => 0,
            'multiService' => 0,
        ],
        176 => [
            'id' => 176,
            'rus' => 'Эритрея',
            'eng' => 'Eritrea',
            'chn' => '厄立特里亞',
            'visible' => 1,
            'retry' => 0,
            'rent' => 0,
            'multiService' => 0,
        ],
        177 => [
            'id' => 177,
            'rus' => 'Южный Судан',
            'eng' => 'Southsudan',
            'chn' => '南蘇丹',
            'visible' => 1,
            'retry' => 0,
            'rent' => 0,
            'multiService' => 0,
        ],
        178 => [
            'id' => 178,
            'rus' => 'Сан-Томе и Принсипи',
            'eng' => 'Saotomeandprincipe',
            'chn' => '聖多美和普林西比',
            'visible' => 1,
            'retry' => 0,
            'rent' => 0,
            'multiService' => 0,
        ],
        179 => [
            'id' => 179,
            'rus' => 'Аруба',
            'eng' => 'Aruba',
            'chn' => '阿魯巴島',
            'visible' => 1,
            'retry' => 0,
            'rent' => 0,
            'multiService' => 0,
        ],
        180 => [
            'id' => 180,
            'rus' => 'Монтсеррат',
            'eng' => 'Montserrat',
            'chn' => '蒙特塞拉特',
            'visible' => 1,
            'retry' => 0,
            'rent' => 0,
            'multiService' => 0,
        ],
        181 => [
            'id' => 181,
            'rus' => 'Ангилья',
            'eng' => 'Anguilla',
            'chn' => '安圭拉島',
            'visible' => 1,
            'retry' => 0,
            'rent' => 0,
            'multiService' => 0,
        ],
        182 => [
            'id' => 182,
            'rus' => 'Япония',
            'eng' => 'Japan',
            'chn' => '日本',
            'visible' => 0,
            'retry' => 0,
            'rent' => 0,
            'multiService' => 0,
        ],
        183 => [
            'id' => 183,
            'rus' => 'Северная Македония',
            'eng' => 'Northmacedonia',
            'chn' => '北馬其頓',
            'visible' => 1,
            'retry' => 0,
            'rent' => 0,
            'multiService' => 0,
        ],
        184 => [
            'id' => 184,
            'rus' => 'Республика Сейшелы',
            'eng' => 'Seychelles',
            'chn' => '塞舌爾共和國',
            'visible' => 1,
            'retry' => 0,
            'rent' => 0,
            'multiService' => 0,
        ],
        185 => [
            'id' => 185,
            'rus' => 'Новая Каледония',
            'eng' => 'Newcaledonia',
            'chn' => '新喀裡多尼亞',
            'visible' => 1,
            'retry' => 0,
            'rent' => 0,
            'multiService' => 0,
        ],
        186 => [
            'id' => 186,
            'rus' => 'Кабо-Верде',
            'eng' => 'Capeverde',
            'chn' => '佛得角',
            'visible' => 1,
            'retry' => 0,
            'rent' => 0,
            'multiService' => 0,
        ],
        187 => [
            'id' => 187,
            'rus' => 'США',
            'eng' => 'USA',
            'chn' => '美国（物理)',
            'visible' => 1,
            'retry' => 0,
            'rent' => 1,
            'multiService' => 0,
        ],
        188 => [
            'id' => 188,
            'rus' => 'Палестина',
            'eng' => 'Palestine',
            'chn' => '巴勒斯坦',
            'visible' => 0,
            'retry' => 0,
            'rent' => 0,
            'multiService' => 0,
        ],
        189 => [
            'id' => 189,
            'rus' => 'Фиджи',
            'eng' => 'Fiji',
            'chn' => '斐濟',
            'visible' => 1,
            'retry' => 1,
            'rent' => 0,
            'multiService' => 0,
        ],
        190 => [
            'id' => 190,
            'rus' => 'Южная Корея',
            'eng' => 'Southkorea',
            'chn' => '大韓民國',
            'visible' => 0,
            'retry' => 1,
            'rent' => 0,
            'multiService' => 0,
        ],
        191 => [
            'id' => 191,
            'rus' => 'Северная Корея',
            'eng' => 'Northkorea',
            'chn' => '朝鲜民主主义人民共和国',
            'visible' => 0,
            'retry' => 0,
            'rent' => 0,
            'multiService' => 0,
        ],
        192 => [
            'id' => 192,
            'rus' => 'Западная Сахара',
            'eng' => 'Westernsahara',
            'chn' => '撒哈拉沙漠西部',
            'visible' => 0,
            'retry' => 0,
            'rent' => 0,
            'multiService' => 0,
        ],
        193 => [
            'id' => 193,
            'rus' => 'Соломоновы острова',
            'eng' => 'Solomonislands',
            'chn' => '所罗门群岛',
            'visible' => 0,
            'retry' => 0,
            'rent' => 0,
            'multiService' => 0,
        ],
        194 => [
            'id' => 194,
            'rus' => 'Джерси',
            'eng' => 'Jersey',
            'chn' => '泽西岛',
            'visible' => 0,
            'retry' => 0,
            'rent' => 0,
            'multiService' => 0,
        ],
        195 => [
            'id' => 195,
            'rus' => 'Бермуды',
            'eng' => 'Bermuda',
            'chn' => '百慕大',
            'visible' => 0,
            'retry' => 0,
            'rent' => 0,
            'multiService' => 0,
        ],
        196 => [
            'id' => 196,
            'rus' => 'Сингапур',
            'eng' => 'Singapore',
            'chn' => '新加坡共和国',
            'visible' => 1,
            'retry' => 0,
            'rent' => 0,
            'multiService' => 0,
        ],
        197 => [
            'id' => 197,
            'rus' => 'Тонга',
            'eng' => 'Tonga',
            'chn' => '汤加王国',
            'visible' => 0,
            'retry' => 0,
            'rent' => 0,
            'multiService' => 0,
        ],
        198 => [
            'id' => 198,
            'rus' => 'Самоа',
            'eng' => 'Samoa',
            'chn' => '萨摩亚',
            'visible' => 0,
            'retry' => 0,
            'rent' => 0,
            'multiService' => 0,
        ],
        199 => [
            'id' => 199,
            'rus' => 'Мальта',
            'eng' => 'Malta',
            'chn' => '马耳他',
            'visible' => 0,
            'retry' => 0,
            'rent' => 0,
            'multiService' => 0,
        ],
        200 => [
            'id' => 200,
            'rus' => 'Лихтенштейн',
            'eng' => 'Liechtenstein',
            'chn' => '列支敦士登',
            'visible' => 0,
            'retry' => 0,
            'rent' => 0,
            'multiService' => 0,
        ],
    ];
    return $countries;
}

function getDataFromCountry($key): array
{
    $data = getSmsActivateCountries();
    $found = array_search($key, array_column($data, 'id'));
    return $data[$found];

}

function mapProvider($provider)
{
    return [
        'url' => $provider['url'],
        'api_key' => $provider['api_key'],
        'email' => $provider['email']
    ];
}
