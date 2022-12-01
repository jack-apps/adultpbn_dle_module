<?php

// Путь к скаченному файлу links.php (относительно корня, там где index.php)
const __LINKS_FILE = 'adultpbn/links.php';

// API ключ выданный биржей adultpbn, по умолчанию он помещается внутрь файла
// links.php при скачивание из биржи, но на всякий случай можно указать и вручную
const __API_KEY = '';

// Если true то автообновление файла (__LINKS_FILE) будет отключено
const __DISABLE_AUTOUPDATE = false;

// Если true то вместо CURL будет использоваться file_get_contents при обращение к бирже
const __DISABLE_CURL = false;


// По умолчанию домен сайта берется из конфига DLE, но можно указать и тут
const __DOMAIN = '';

// По умолчанию кодировка сайта берется из конфига DLE, но можно указать и тут
const __ENCODING = '';

// Если true то все ссылки по умолчанию будут открываться в новой вкладке
const __BLANK = false;

// Указанное значение будет помещено перед ссылками при выводе на странице сайта
const __WSTART = '';

// Указанное значение будет помещено после ссылок при выводе на странице сайта
const __WEND = '';

// Разделитель между ссылками, например <br>. Для неразрывного пробела можно использовать &nbsp;
const __DELIMITER = '';

// Если true то все ошибки по умолчанию будут записываться в файл возле links.php
const __LOG = false;

// Лимит в секундах на соединение с биржей adultpbn, выше трех лучше
// не указывать, иначе появится вероятность того, что сайт начнет сильно
// провисать при падение или нестабильной работы биржи, в идеале вообще 1 поставить
const __TIMEOUT = 2;





$__params = [
    'place'      =>  $place      ??  'any',
    'wstart'     =>  $wstart     ??  __WSTART,
    'wend'       =>  $wend       ??  __WEND,
    'delimiter'  =>  $delimiter  ??  __DELIMITER,
    'domain'     =>  $domain     ??  __DOMAIN,
    'encoding'   =>  $encoding   ??  __ENCODING,
    'blank'      =>  $blank      ??  __BLANK,
    'log'        =>  $log        ??  __LOG,
    'debug'      =>  $debug      ??  false,
    'test'       =>  $test       ??  false,
];


/**
 * =============================================
 *            Подготовка к выводу
 *
 *  @var array $config Глобальный конфиг DLE
 * =============================================
 */

if ($__params['debug']) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}

$__linksFile = ROOT_DIR . '/' . trim(__LINKS_FILE, '/');

if (file_exists($__linksFile)) {
    require_once $__linksFile;
} else {
    if ($__params['debug']) {
        echo 'Указан неверный путь к файлу links.php ('.__LINKS_FILE.')';
    }

    return;
}

$__init = new LBHelperInit();

if (empty(__API_KEY) && isset(LBHelper::init()->params['api_key'])) {
    $__init->api_key(LBHelper::init()->params['api_key']);
} elseif (! empty(__API_KEY)) {
    $__init->api_key(__API_KEY);
} else {
    if ($__params['debug']) {
        echo 'Необходимо указать __API_KEY';
    }

    return;
}

if (empty($__params['domain'])) {
    $__params['domain'] = parse_url($config['http_home_url'], PHP_URL_HOST);
}

if (empty($__params['encoding'])) {
    $__params['encoding'] = empty($config['charset']) ? 'utf-8' : $config['charset'];
}

$__init->domain($__params['domain']);
$__init->encoding($__params['encoding']);

if ($__params['blank']) {
    $__init->targetBlank();
}

if ($__params['log']) {
    $__init->log();
}

if ($__params['test']) {
    $__init->test();
}

if (__TIMEOUT > 1) {
    $__init->timeout(__TIMEOUT < 10 ? __TIMEOUT : 3);
}

if (__DISABLE_AUTOUPDATE) {
    $__init->disableAutoupdate();
}

if (__DISABLE_CURL) {
    $__init->disableCurl();
}


/**
 * =================================
 *           Вывод ссылок
 * =================================
 */

$__urls = new LBHelperUrls($__init->params);

switch ($__params['place']) {
    case 'header':
        $__links = $__urls
            ->header()
            ->delimiter($__params['delimiter'])
            ->wrap($__params['wstart'], $__params['wend'])
            ->get();
        break;
    case 'footer':
        $__links = $__urls
            ->footer()
            ->delimiter($__params['delimiter'])
            ->wrap($__params['wstart'], $__params['wend'])
            ->get();
        break;
    case 'sidebar':
        $__links = $__urls
            ->sidebar()
            ->delimiter($__params['delimiter'])
            ->wrap($__params['wstart'], $__params['wend'])
            ->get();
        break;
    case 'content':
        $__links = $__urls
            ->content()
            ->delimiter($__params['delimiter'])
            ->wrap($__params['wstart'], $__params['wend'])
            ->get();
        break;
    default:
        $__links = $__urls
            ->delimiter($__params['delimiter'])
            ->wrap($__params['wstart'], $__params['wend'])
            ->get();
}

echo $__links;