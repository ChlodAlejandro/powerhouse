<?php
/**
 * Welcome to the GitHub issue request auto-writer!
 *
 * This script will automatically build steps 1a and 1b of your
 * issue request on the GitHub repository.
 *
 * Please do NOT run this on a browser. Instead, run this on your
 * system with the following command (on the main Powerhouse dir):
 *
 *     php system/cli/issue_writer.php
 *
 * This should automatically start the process, and your Step 1a and
 * 1b content should be output to the terminal.
 *
 * This script is available only in English.
 **/

// Starting up...
$step = "starting up";

set_error_handler(function($errno, $errstr, $errfile = null, $errline = null) {
    global $step;
    array_push($exceptions,
        [
            "step" => $step,
            "err" => [
                "n" => $errno,
                "e" => $errstr,
                "f" => $errfile,
                "l" => $errline
            ]
        ]
    );
    return true;
});

$exceptions = [];



// Grabbing the default const.php and env.php files from GitHub
$step = "grabbing default configuration";

// Importing Powerhouse configuration
$step = "importing Powerhouse configuration";

$constOK = true;
$envOK = true;

try {
    include_once (__DIR__ . "../../const.php");
} catch (Exception $e) {
    $constOK = $e;
}

try {
    include_once (__DIR__ . "../../const.php");
} catch (Exception $e) {
    $envOK = $e;
}

// Cleaning up...

restore_error_handler();