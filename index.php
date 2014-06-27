<!DOCTYPE html>
<html>
<head>
    <title></title>
    <meta content="text/html;charset=UTF-8" http-equiv="content-type">
    <link href="assets/css/main.css" type="text/css" rel="stylesheet"/>
</head>
<body>
<div id="serverInformations">
    <h1>Serverseitige Informationen</h1>

    <div>
        <?php
        if (isset($_SERVER['REMOTE_ADDR'])) {
            echo '<div class="data">IP: ' . $_SERVER['REMOTE_ADDR'];
            $array = unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip=' . $_SERVER['REMOTE_ADDR']));
        }
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            echo '<div class="data">FORWARED IP: ' . $_SERVER['HTTP_X_FORWARDED_FOR'];
            $array = unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip=' . $_SERVER['HTTP_X_FORWARDED_FOR']));
        }

        echo '<br>Browser: ' . $_SERVER['HTTP_USER_AGENT'];

        if (isset($_SERVER['HTTP_REFERER'])) {
            echo '<br>Vorherige Website: ' . $_SERVER['HTTP_REFERER'];
        }

        echo '<br>Kontinent: ' . $array['geoplugin_continentCode'];
        echo '<br>Land: ' . $array['geoplugin_countryName'];
        echo '<br>Bundesland: ' . $array['geoplugin_region'];
        echo '<br>Stadt: ' . $array['geoplugin_city'];

        echo '<br>Latitude: ' . $array['geoplugin_latitude'];
        echo '<br>Longitude: ' . $array['geoplugin_longitude'] . "</div>";

        echo '<div align="center" class="data" id="map"><iframe width="100%" align="middle" height="250" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.de/maps?q=' . $array['geoplugin_latitude'] . ',' . $array['geoplugin_longitude'] . '&amp;num=1&amp;ie=UTF8&amp;t=m&amp;z=11&amp;output=embed"></iframe></div>';
        //TODO: Evt. whois mit IP-Adresse zum Anzeigen des Provider
        ?>
    </div>
</div>

<div id="clientInformations">
    <div class="javascriptOnly">
        <p style="clear:both;"></p>
        <h1>Clientseitige Informationen</h1>
        <div id="common" class="data">
            <h2>Allgemein</h2>
        </div>
        <div id="cookies" class="data">
            <h2 class='subtitle'><a href='javascript:void(0)'>Cookies</a></h2>
            <ul></ul>
        </div>
        <div id="battery" class="data">
            <h2 class='subtitle'><a href='javascript:void(0)'>Batterie</a></h2>
            <ul></ul>
        </div>
        <div id="connection" class="data">
            <h2 class='subtitle'><a href='javascript:void(0)'>Verbindung</a></h2>
            <ul></ul>
        </div>
        <div id="logins" class="data">
            <h2 class='subtitle'><a href='javascript:void(0)'>Sociale Netzwerke Anmeldestatus</a></h2>
            <ul></ul>
        </div>
        <div id="geolocation" class="data">
            <h2 class='subtitle'><a href='javascript:void(0)'>Geolocation</a></h2>
            <span id="associateGeolocation">
                <input type="button" value="Start"/>
            </span>
        </div>
        <div id="media" class="data">
            <h2 class='subtitle'><a href='javascript:void(0)'>UserMedia - Bild/Ton</a></h2>
            <span id="associateMedia">
                <input type="button" value="Start"/>
            </span>
            <div id="video">
                <video></video>
                <canvas></canvas>
                <img id="photo"/>
            </div>
        </div>
        <div class="long">
            <div id="plugins" class="data">
                <h2 class='subtitle'><a href='javascript:void(0)'>Plugins</a></h2>
                <ul></ul>
            </div>
            <div id="mimeTypes" class="data">
                <h2 class='subtitle'><a href='javascript:void(0)'>MimeTypes</a></h2>
                <ul></ul>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="assets/js/settings.js"></script>
    <script type="text/javascript" src="assets/js/helper/lzw.js"></script>
    <script type="text/javascript" src="assets/js/ajax.js"></script>
    <script type="text/javascript" src="assets/js/main.js"></script>
    <noscript>
        <style type="text/css">
            .javascriptOnly {
                display: none;
            }
        </style>
        JavaScript ist nicht aktiviert!
    </noscript>
</div>

</body>
</html>