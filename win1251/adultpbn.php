<?php

// ���� � ���������� ����� links.php (������������ �����, ��� ��� index.php)
// ������ ���� ���������� ������� � ��������� �����, �������� adultpbn
// ����� ���������� ��������� 766 ����� �� �����, ����� ����� �����
// ����������� ���������� ��� ����� � ������ ����������
// ���� ����� ����� ���������� ��������, �� ��� ��������� ������ debug
// �� ����� ������ ������ ����� ��������� � ������������� ��������� �����
const __LINKS_FILE = 'adultpbn/links.php';

// API ���� �������� ������ adultpbn, �� ��������� �� ���������� ������ �����
// links.php ��� ���������� �� �����, �� �� ������ ������ ����� ������� � �������
const __API_KEY = '';

// ���� true �� �������������� ����� (__LINKS_FILE) ����� ���������
const __DISABLE_AUTOUPDATE = false;

// ���� true �� ������ CURL ����� �������������� file_get_contents ��� ��������� � �����
const __DISABLE_CURL = false;


// �� ��������� ����� ����� ������� �� ������� DLE, �� ����� ������� � ���
const __DOMAIN = '';

// �� ��������� ��������� ����� ������� �� ������� DLE, �� ����� ������� � ���
const __ENCODING = '';

// ���� true �� ��� ������ �� ��������� ����� ����������� � ����� �������
const __BLANK = false;

// ��������� �������� ����� �������� ����� �������� ��� ������ �� �������� �����
const __WSTART = '';

// ��������� �������� ����� �������� ����� ������ ��� ������ �� �������� �����
const __WEND = '';

// ����������� ����� ��������, �������� <br>. ��� ������������ ������� ����� ������������ &nbsp;
const __DELIMITER = '';

// ���� true �� ��� ������ �� ��������� ����� ������������ � ���� ����� links.php
const __LOG = false;

// ����� � �������� �� ���������� � ������ adultpbn, ���� ���� �����
// �� ���������, ����� �������� ����������� ����, ��� ���� ������ ������
// ��������� ��� ������� ��� ������������ ������ �����, � ������ ������ 1 ���������
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
 *            ���������� � ������
 *
 *  @var array $config ���������� ������ DLE
 * =============================================
 */

if ($__params['debug']) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}

$__linksFile = ROOT_DIR . '/' . trim(__LINKS_FILE, '/');
$__linksFileDir = dirname($__linksFile);

if (file_exists($__linksFile)) {
    require_once $__linksFile;

    if (is_writable($__linksFileDir) === false && $__params['debug']) {
        echo "���������� ������� ����� �� ������ (766) ��� $__linksFileDir";
    }
} else {
    if ($__params['debug']) {
        echo '������ �������� ���� � ����� links.php ('.__LINKS_FILE.')';
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
        echo '���������� ������� __API_KEY';
    }

    return;
}


if (empty($__params['domain']) && ! empty(trim($config['http_home_url'], '/'))) {
    $__params['domain'] = parse_url($config['http_home_url'], PHP_URL_HOST);
} elseif (! empty($_SERVER['SERVER_NAME'])) {
    $__params['domain'] = $_SERVER['SERVER_NAME'];
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

if (isset($_GET['debug'])) {
    echo '<pre>'; var_dump($__init); echo '</pre>';
}
/**
 * =================================
 *           ����� ������
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