<?php

include "../dao/visit.php";
include "../helper/lzw.php";

/**
 * Read JSON data
 */
$handle = fopen('php://input', 'r');
$jsonInput = fgets($handle);

$jsonInputDecompressed /* = TODO*/;

$decoded = json_decode($jsonInputDecompressed, true);

if ($_GET['flag'] == 0) {
    /**
     * Client data
     */
    $common = new Common($decoded['common']['cAppCodeName'],
        $decoded['common']['cAppName'],
        $decoded['common']['cAppVersion'],
        $decoded['common']['cBuildId'],
        $decoded['common']['cCookiesActive'],
        $decoded['common']['cCssActive'],
        $decoded['common']['cDoNotTrack'],
        $decoded['common']['cJavaActive'],
        $decoded['common']['cJsActive'],
        $decoded['common']['cLanguage'],
        $decoded['common']['cLastPage'],
        $decoded['common']['cOSCPU'],
        $decoded['common']['cPlatform'],
        $decoded['common']['cProductSub'],
        $decoded['common']['cUrl'],
        $decoded['common']['cUserAgent'],
        $decoded['common']['cVendor'],
        $decoded['common']['cVendorSub']
    );

    /**
     * Server data
     */
    $common->setSBrowser($_SERVER['HTTP_USER_AGENT']);
    $common->setSLastPage($_SERVER['HTTP_REFERER']);
    if (isset($_SERVER['REMOTE_ADDR'])) {
        $common->setSIp($_SERVER['REMOTE_ADDR']);
        $array = unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip=' . $_SERVER['REMOTE_ADDR']));
    }
    if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $common->setSIp($_SERVER['HTTP_X_FORWARDED_FOR']);
        $array = unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip=' . $_SERVER['HTTP_X_FORWARDED_FOR']));
    }
    $common->setSCity($array['geoplugin_city']);
    $common->setSContinent($array['geoplugin_continentCode']);
    $common->setSCountry($array['geoplugin_countryName']);

    $common->setSLatitude($array['geoplugin_latitude']);
    $common->setSLongitude($array['geoplugin_longitude']);
    $common->setSProvince($array['geoplugin_region']);

    $id = insertVisit($common);

    /**
     * Battery data
     */
    $battery = new Battery($decoded['battery']['level'], $decoded['battery']['isLoading'], $decoded['battery']['loadingDuration'], $decoded['battery']['unloadingDuration']);
    insertBattery($battery, $id);

    /**
     * Connection data
     */
    $connection = new Connection($decoded['connection']['bandwidth'], $decoded['connection']['metered']);
    insertConnection($connection, $id);

    /**
     * Cookies data
     */
    $cookies = array();
    foreach ($decoded['cookies'] as $key => $value) {
        $cookie = new Cookie($key, $value);
        $cookies[] = $cookie;
    }
    insertCookies($cookies, $id);

    /**
     * Plugins data
     */
    $plugins = array();
    foreach ($decoded['plugins'] as $name => $value) {
        $plugin = new Plugin($name, $value["version"], $value["description"]);
        $plugins[] = $plugin;
    }
    insertPlugins($plugins, $id);

    /**
     * MimeTypes data
     */
    $mimeTypes = array();
    foreach ($decoded['mimeTypes'] as $name => $value) {
        $mimeType = new MimeType($name, $value['suffix'], $value['type'], $value['plugin']);
        $mimeTypes[] = $mimeType;
    }
    insertMimeTypes($mimeTypes, $id);

    echo $id;
} elseif ($_GET["flag"] == 1) {
    /**
     * Photo data
     */
    $photo = new Photo($decoded['photo']);
    insertPhoto($photo, $decoded['id']);
    echo "OK";
} elseif ($_GET["flag"] == 2) {
    /**
     * Location data
     */
    $position = new Position(
        $decoded['position']['timestamp'],
        $decoded['position']['latitude'],
        $decoded['position']['longitude'],
        $decoded['position']['accuracy'],
        $decoded['position']['altitude'],
        $decoded['position']['altitudeAccuracy'],
        $decoded['position']['speed'],
        $decoded['position']['heading']
    );
    insertPosition($position, $decoded['id']);
    echo "OK";
} elseif ($_GET["flag"] == 3) {
    /**
     * Login data
     */
    $logins = array();
    foreach ($decoded["logins"] as $name => $state) {
        $login = new Login($name, $state);
        $logins[] = $login;
    }
    insertLogins($logins, $decoded["id"]);
    echo "OK";
}

