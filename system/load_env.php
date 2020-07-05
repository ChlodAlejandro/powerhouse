<?php

if ((!file_exists(__DIR__ . "/../env.php")) && (!defined("POWERHOUSE_SKIP_ENV"))) {
    exit("env.php does not exist. Please configure Powerhouse first.<br/>" .
        "<a href=\"/setup\">Click here to begin the setup.</a>");
} else {
    try {
        set_error_handler(function() {
            exit("There is an issue with this Powerhouse installation.<br/>Please double-check your configuration.");
        });
        include_once __DIR__ . "/../env.php";
        restore_error_handler();
    } catch (Exception $e) {
        exit("There is an error with this Powerhouse installation.<br/>Please double-check your configuration.");
    }

    // Verify the configuration values.
    require_once __DIR__ . "/../system/verify_file_directory.php";
    FileDirectoryVerifier::verify();
}