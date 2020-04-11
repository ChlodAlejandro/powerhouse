<?php

require_once "env.php";

echo '<!-- Auto-generated code. Expect mess. -->' . PHP_EOL;

// Viewport adjustments

echo '<meta name="viewport" content="width=device-width, initial-scale=1.0">';

// Required CSS tags
echo '<link rel="stylesheet" type="text/css" href="' . POWERHOUSE_HTTP_ROOT . '/css/standard.css">';
echo '<link rel="stylesheet" type="text/css" href="' . POWERHOUSE_HTTP_ROOT . '/css/main.css">';

// Metadata tags
echo '<link rel="icon" type="image/ico" href="' . POWERHOUSE_HTTP_ROOT . '/favicon.ico">';

// Libraries and third-party scripts.
echo '<script src="' . POWERHOUSE_HTTP_ROOT . '/scripts/third-party/jquery-3.4.1.min.js"></script>';
echo '<script defer src="' . POWERHOUSE_HTTP_ROOT . '/scripts/third-party/material-1.3.0.min.js"></script>';

echo '<script src="https://unpkg.com/axios/dist/axios.min.js"></script>';

/** @noinspection PhpStatementHasEmptyBodyInspection */
if (DEBUG_MODE) {
    // code
} else {
    // more code
}

// Page and installation constants.

echo '<script type="text/javascript" src="' . POWERHOUSE_HTTP_ROOT . '/scripts/constants.djs"></script>';

// Other scripts
echo '<script src="' . POWERHOUSE_HTTP_ROOT . '/scripts/utils.js"></script>';

echo PHP_EOL . '<!-- End of auto-generated code. -->';