<?php

require_once "env.php";

echo '<!-- Auto-generated code. Expect mess. -->' . PHP_EOL;

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

echo "<script>";
echo "const POWERHOUSE_HTTP_ROOT = \"" . POWERHOUSE_HTTP_ROOT . "\";";
echo "const POWERHOUSE_DEV_PAGE = \"" . POWERHOUSE_DEV_PAGE . "\";";

// TODO DIRECTORY THING
echo "const phDirectory = \"" . "/" . "\";";

echo "</script>";

// Other scripts
echo '<script src="' . POWERHOUSE_HTTP_ROOT . '/scripts/utils.js"></script>';

echo PHP_EOL . '<!-- End of auto-generated code. -->';