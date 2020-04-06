<?php

// Load the non-configurable constants.
require_once "const.php";

// The following are configurable constants. You may change them.
// Please refer to the documentation before changing most of these.

/**
 * POWERHOUSE_HTTP_ROOT
 *
 * The root of the Powerhouse directory, relative to the root of
 * the web server, with / being $_SERVER["DOCUMENT_ROOT"].
 *
 * The leading / is required (the path must be absolute).
 **/
define("POWERHOUSE_HTTP_ROOT", "/PROJECTS/powerhouse");

/**
 * POWERHOUSE_DIR_FILES
 *
 * The location of where the files for Powerhouse would be stored,
 * relative to the Powerhouse root directory.
 **/
define("POWERHOUSE_DIR_FILES", "files");