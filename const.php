<?php
// The following are constants, which shouldn't be changed.

/**
 * DEBUG_MODE
 *
 * If Powerhouse should be using development options instead.
 **/
define("DEBUG_MODE", true);

/**
 * POWERHOUSE_VERSION
 *
 * The version of Powerhouse.
 **/
define("POWERHOUSE_VERSION", "1.0.0-beta-0001");

/**
 * POWERHOUSE_DEV_PAGE
 *
 * The development homepage of Powerhouse, where the issue
 * tracker, source code, releases, etc. are managed.
 *
 * This is usually the GitHub repository.
 **/
define("POWERHOUSE_DEV_PAGE", "https://github.com/ChlodAlejandro/powerhouse");

/**
 * POWERHOUSE_DIR_ROOT
 *
 * The root of the Powerhouse directory, relative to the file
 * system, with / being the root of the file system.
 **/
define("POWERHOUSE_DIR_ROOT", __DIR__);

if ((!file_exists(__DIR__ . "/env.php")) && (!defined("POWERHOUSE_SKIP_ENV"))) {
    exit("env.php does not exist. Please configure Powerhouse first.<br/>" .
        "<a href=\"setup\">Click here to begin the setup.</a>");
} else {
    try {
        set_error_handler(function() {
            exit("There is an issue with this Powerhouse installation.<br/>Please double-check your configuration.");
        });
        include_once __DIR__ . "/env.php";
        restore_error_handler();
    } catch (Exception $e) {
        exit("There is an error with this Powerhouse installation.<br/>Please double-check your configuration.");
    }

    // Verify the configuration values.
    require_once __DIR__ . "/system/verify_file_directory.php";
    FileDirectoryVerifier::verify();
}