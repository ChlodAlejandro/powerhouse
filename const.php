<?php
// The following are constants, which shouldn't be changed.

/**
 * DEBUG_MODE
 *
 * If Powerhouse should be using development files instead.
 **/
define("DEBUG_MODE", true);

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
list($scriptPath) = get_included_files();
define("POWERHOUSE_DIR_ROOT", dirname($scriptPath));