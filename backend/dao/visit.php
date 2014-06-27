<?php
/**
 * User: Enthusiasmus
 * Date: 17.02.14
 * Time: 13:05
 */

include "../config.php";
include "../model/common.php";
include "../model/battery.php";
include "../model/connection.php";
include "../model/cookie.php";
include "../model/social.php";
include "../model/plugin.php";
include "../model/mimetype.php";
include "../model/photo.php";
include "../model/position.php";

function insertVisit(Common $common)
{
    global $DSN, $DB_USER, $DB_PASS;
    $adapter = new PDO($DSN, $DB_USER, $DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")) or die(FALSE);

    $insert = $adapter->prepare('INSERT INTO visit
        (
            cAppCodeName, cAppName, cAppVersion,
            cBuildId, cCookiesActive, cCssActive,
            cDoNotTrack, cJavaActive, cJsActive,
            cLanguage, cLastPage, cOSCPU,
            cPlatform, cProductSub, cUrl,
            cUserAgent, cVendor, cVendorSub,
            sBrowser, sCity, sContinent,
            sCountry, sIp, sLastPage,
            sLatitude, sLongitude, sProvince
        )
        VALUES
        (
            :cAppCodeName, :cAppName, :cAppVersion,
            :cBuildId, :cCookiesActive, :cCssActive,
            :cDoNotTrack, :cJavaActive, :cJsActive,
            :cLanguage, :cLastPage, :cOSCPU,
            :cPlatform, :cProductSub, :cUrl,
            :cUserAgent, :cVendor, :cVendorSub,
            :sBrowser, :sCity, :sContinent,
            :sCountry, :sIp, :sLastPage,
            :sLatitude, :sLongitude, :sProvince
        )
    ');

    $result = $insert->execute(array(
        ':cAppCodeName' => $common->getCAppCodeName(),
        ':cAppName' => $common->getCAppName(),
        ':cAppVersion' => $common->getCAppVersion(),

        ':cBuildId' => $common->getCBuildId(),
        ':cCookiesActive' => $common->getCCookiesActive(),
        ':cCssActive' => $common->getCCssActive(),

        ':cDoNotTrack' => $common->getCDoNotTrack(),
        ':cJavaActive' => $common->getCJavaActive(),
        ':cJsActive' => $common->getCJsActive(),

        ':cLanguage' => $common->getCLanguage(),
        ':cLastPage' => $common->getCLastPage(),
        ':cOSCPU' => $common->getCOSCPU(),

        ':cPlatform' => $common->getCPlatform(),
        ':cProductSub' => $common->getCProductSub(),
        ':cUrl' => $common->getCUrl(),

        ':cUserAgent' => $common->getCUserAgent(),
        ':cVendor' => $common->getCVendor(),
        ':cVendorSub' => $common->getCVendorSub(),

        ':sBrowser' => $common->getSBrowser(),
        ':sCity' => $common->getSCity(),
        ':sContinent' => $common->getSContinent(),

        ':sCountry' => $common->getSCountry(),
        ':sIp' => $common->getSIp(),
        ':sLastPage' => $common->getSLastPage(),

        ':sLatitude' => $common->getSLatitude(),
        ':sLongitude' => $common->getSLongitude(),
        ':sProvince' => $common->getSProvince()
    ));

    if (!$result) {
        die('Failure at database request! Visit');
    } else {
        return intval($adapter->lastInsertId());
    }
}

function insertBattery(Battery $battery, $id)
{
    global $DSN, $DB_USER, $DB_PASS;
    $adapter = new PDO($DSN, $DB_USER, $DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")) or die(FALSE);

    $insert = $adapter->prepare('INSERT INTO battery
        (fkVisit, level, isLoading, loadingDuration,  unloadingDuration)
        VALUES
        (:fkVisit, :level, :isLoading, :loadingDuration, :unloadingDuration)
    ');

    $result = $insert->execute(array(
        ':fkVisit' => (int)$id,
        ':level' => (string)$battery->getLevel(),
        ':isLoading' => filter_var($battery->getIsLoading(), FILTER_VALIDATE_BOOLEAN),
        ':loadingDuration' => (string)$battery->getLoadingDuration(),
        ':unloadingDuration' => (string)$battery->getUnloadingDuration()
    ));

    if (!$result) {
        die('Failure at database request! Battery');
    } else {
        return intval($adapter->lastInsertId());
    }
}

function insertConnection(Connection $connection, $id)
{
    global $DSN, $DB_USER, $DB_PASS;
    $adapter = new PDO($DSN, $DB_USER, $DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")) or die(FALSE);

    $insert = $adapter->prepare('INSERT INTO connection (fkVisit, bandwidth, metered) VALUES (:fkVisit, :bandwidth, :metered)');
    $result = $insert->execute(array(
        ':fkVisit' => (int)$id,
        ':bandwidth' => (string)$connection->getBandwidth(),
        ':metered' => (string)$connection->getMetered()
    ));

    if (!$result) {
        die('Failure at database request! Connection');
    } else {
        return intval($adapter->lastInsertId());
    }
}

function insertCookies($cookies, $id)
{
    global $DSN, $DB_USER, $DB_PASS;
    $adapter = new PDO($DSN, $DB_USER, $DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")) or die(FALSE);
    $insert = $adapter->prepare('INSERT INTO cookie (fkVisit, idx, name) VALUES (:fkVisit, :idx, :name)');

    $errors = array();
    foreach ($cookies as $idx => $value) {
        $result = $insert->execute(array(
            ':fkVisit' => (int)$id,
            ':idx' => (string)$cookies[$idx]->getKey(),
            ':name' => (string)$cookies[$idx]->getName()
        ));

        if (!$result) {
            $errors[] = "Fehler " . $cookies[$idx]->getKey();
        }
    }

    if (count($errors) > 1) {
        foreach ($errors as $idx => $value) {
            echo $errors[$idx];
        }
        die('Failure at database request!');
    } else {
        return intval($adapter->lastInsertId());
    }
    //TODO: CHECK AT SERVER
}

function insertLogins($logins, $id)
{
    global $DSN, $DB_USER, $DB_PASS;
    $adapter = new PDO($DSN, $DB_USER, $DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")) or die(FALSE);
    $insert = $adapter->prepare('INSERT INTO login (fkVisit, state, name) VALUES (:fkVisit, :state, :name)');

    $errors = array();
    foreach ($logins as $idx => $value) {
        $result = $insert->execute(array(
            ':fkVisit' => (int)$id,
            ':state' => (string)$logins[$idx]->getState(),
            ':name' => (string)$logins[$idx]->getName()
        ));
        if (!$result) {
            $errors[] = "Fehler " . $logins[$idx]->getName();
        }
    }

    if (count($errors) > 1) {
        foreach ($errors as $idx => $value) {
            echo $errors[$idx];
        }
        die('Failure at database request!');
    } else {
        return intval($adapter->lastInsertId());
    }
}

function insertPlugins($plugins, $id)
{
    global $DSN, $DB_USER, $DB_PASS;
    $adapter = new PDO($DSN, $DB_USER, $DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")) or die(FALSE);
    $insert = $adapter->prepare('INSERT INTO plugin (fkVisit, version, name, description) VALUES (:fkVisit, :version, :name, :description)');

    $errors = array();
    foreach ($plugins as $idx => $value) {
        $result = $insert->execute(array(
            ':fkVisit' => (int)$id,
            ':version' => (string)$plugins[$idx]->getVersion(),
            ':name' => (string)$plugins[$idx]->getName(),
            ':description' => (string)$plugins[$idx]->getDescription()
        ));
        if (!$result) {
            $errors[] = "Fehler " . $plugins[$idx]->getName();
        }
    }

    if (count($errors) > 1) {
        foreach ($errors as $idx => $value) {
            echo $errors[$idx];
        }
        die('Failure at database request!');
    } else {
        return intval($adapter->lastInsertId());
    }
}

function insertMimeTypes($mimeTypes, $id)
{
    global $DSN, $DB_USER, $DB_PASS;
    $adapter = new PDO($DSN, $DB_USER, $DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")) or die(FALSE);
    $insert = $adapter->prepare('INSERT INTO mimeType (fkVisit, type, name, suffix, plugin) VALUES (:fkVisit, :type, :name, :suffix, :plugin)');

    $errors = array();
    foreach ($mimeTypes as $idx => $value) {
        $result = $insert->execute(array(
            ':fkVisit' => (int)$id,
            ':type' => (string)$mimeTypes[$idx]->getType(),
            ':name' => (string)$mimeTypes[$idx]->getName(),
            ':suffix' => (string)$mimeTypes[$idx]->getSuffix(),
            ':plugin' => (string)$mimeTypes[$idx]->getPlugin()
        ));
        if (!$result) {
            $errors[] = "Fehler " . $mimeTypes[$idx]->getName();
        }
    }

    if (count($errors) > 1) {
        foreach ($errors as $idx => $value) {
            echo $errors[$idx];
        }
        die('Failure at database request!');
    } else {
        return intval($adapter->lastInsertId());
    }
}

function insertPhoto(Photo $photo, $id)
{
    global $DSN, $DB_USER, $DB_PASS;
    $adapter = new PDO($DSN, $DB_USER, $DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")) or die(FALSE);

    $insert = $adapter->prepare('INSERT INTO media (fkVisit, photo) VALUES (:fkVisit, :photo)');
    $result = $insert->execute(array(
        ':fkVisit' => (int)$id,
        ':photo' => (string)$photo->getData()
    ));

    if (!$result) {
        die('Failure at database request! Photo');
    } else {
        return intval($adapter->lastInsertId());
    }
}

function insertPosition(Position $position, $id)
{
    global $DSN, $DB_USER, $DB_PASS;
    $adapter = new PDO($DSN, $DB_USER, $DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")) or die(FALSE);
    $insert = $adapter->prepare('INSERT INTO position (
        fkVisit, timestamp, latitude, longitude,
        accuracy, altitude, altitudeAccuracy, speed, heading
    ) VALUES (
        :fkVisit, :timestamp, :latitude, :longitude,
        :accuracy, :altitude, :altitudeAccuracy, :speed, :heading
    )');

    $result = $insert->execute(array(
        ':fkVisit' => (int)$id,
        ':timestamp' => (string)$position->getTimestamp(),
        ':latitude' => (string)$position->getLatitude(),
        ':longitude' => (string)$position->getLongitude(),
        ':accuracy' => (string)$position->getAccuracy(),
        ':altitude' => (string)$position->getAltitude(),
        ':altitudeAccuracy' => (string)$position->getAltitudeAccuracy(),
        ':speed' => (string)$position->getSpeed(),
        ':heading' => (string)$position->getHeading()
    ));
    if (!$result) {
        die('Failure at database request! Position');
    } else {
        return intval($adapter->lastInsertId());
    }
}
/**
 * Error settings
 *
 *  $adapter->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );  //before prepare
 *  print_r($insert->errorInfo());                                      //after execute
 */