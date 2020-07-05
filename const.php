<?php
// The following are constants, which shouldn't be changed.
//
// If you want to change a configuration value, use env.php
// instead. If you're changing the values here, you may
// void your warranty!

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
 * POWERHOUSE_DEV_REPOSITORY
 *
 * The repository of Powerhouse. Scripts that need to download other scripts
 * will usually grab their files from here.
 *
 * This is usually the GitHub repository.
 **/
define("POWERHOUSE_DEV_REPOSITORY", "https://raw.githubusercontent.com/ChlodAlejandro/powerhouse/master");

/**
 * POWERHOUSE_DIR_ROOT
 *
 * The root of the Powerhouse directory, relative to the file
 * system, with / being the root of the file system.
 **/
define("POWERHOUSE_DIR_ROOT", __DIR__);

// POWERHOUSE SECURITY CONFIGURATION.

/**
 * POWERHOUSE_SECURITY_ALLOWROOT
 *
 * WARNING: UNDER NO CIRCUMSTANCES SHOULD YOU ENABLE THIS
 * UNLESS YOUR SYSTEM IS HEAVILY RESTRICTED AND YOU
 * UNDERSTAND THE ISSUES THAT DISABLING THIS OPTION
 * MAY CAUSE.
 *
 * Allows Powerhouse to use the root as a valid directory.
 * For Unix-based systems, this would be /, and for Windows
 * based-systems, this would be the top folder of the drive
 * where Powerhouse is installed.
 *
 * This is an EXTREMELY dangerous option. The Powerhouse
 * contributors are not responsible for damages to your server
 * if this option was turned on.
 */
define("POWERHOUSE_SECURITY_ALLOWROOT", false);

// Disable `env.php` loading if installing or troubleshooting.
if (!defined("POWERHOUSE_TROUBLESHOOTING")
    && !defined("POWERHOUSE_INSTALLING"))
    require(__DIR__ . "/system/load_env.php");