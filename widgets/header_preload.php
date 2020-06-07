<?php

require_once __DIR__ . "/../const.php";
require_once __DIR__ . "/utilities/TagGenerator.php";

echo '<!-- Auto-generated code. Expect mess. -->' . PHP_EOL;

// Viewport adjustments are disabled by default.
//
// Why? Because Powerhouse was built for computer devices.
//
// Powerhouse does have a usable API, which means developers may choose to make
// their own mobile app that connects to their Powerhouse server.
//
// echo '<meta name="viewport" content="width=device-width, initial-scale=1.0">';

// SEO Metadata Tags

// Page and installation constants.

echo '<script type="text/javascript" src="' . POWERHOUSE_HTTP_ROOT . '/scripts/powerhouse.djs"></script>';

// Other scripts
echo '<script type="text/javascript" src="' . POWERHOUSE_HTTP_ROOT . '/scripts/utils.js"></script>';

// Theme CSS
echo TagGenerator::getThemeCSS("global") . PHP_EOL;
echo TagGenerator::getThemeCSS("icons") . PHP_EOL;
echo PHP_EOL;
// Theme Scripts
echo TagGenerator::getThemeScript("global") . PHP_EOL;
echo TagGenerator::getThemeScript("header.pre-load") . PHP_EOL;

// Required styles from theme
if (isset($requiredStyles) && is_array($requiredStyles)) {
    foreach ($requiredStyles as $style)
        echo TagGenerator::getThemeCSS($style);
}
if (isset($requiredScripts) && is_array($requiredScripts)) {
    foreach ($requiredStyles as $style)
        echo TagGenerator::getThemeCSS($style);
}

// Metadata tags
echo '<link rel="icon" type="image/ico" href="' . POWERHOUSE_HTTP_ROOT . '/favicon.ico">';

// Libraries and third-party scripts.
echo '<script src="' . POWERHOUSE_HTTP_ROOT . '/scripts/third-party/jquery-3.5.0.min.js"></script>';
echo '<script src="' . POWERHOUSE_HTTP_ROOT . '/scripts/third-party/axios.min.js"></script>';

/** @noinspection PhpStatementHasEmptyBodyInspection */
if (DEBUG_MODE) {
    // code
} else {
    // more code
}

echo PHP_EOL . '<!-- End of auto-generated code. -->' . PHP_EOL;