<?php

// Load the non-configurable constants.
require_once "const.php";

// The following are configurable constants. You may change them.
// Please refer to the documentation before changing most of these.

// POWERHOUSE DIRECTORY AND HTTP CONSTANTS

/**
 * POWERHOUSE_HTTP_ROOT
 *
 * The root of the Powerhouse directory, relative to the root of
 * the web server, with / being $_SERVER["DOCUMENT_ROOT"].
 *
 * The leading / is required (the path must be absolute).
 *
 * Default: /
 * Suggested: /
 **/
define("POWERHOUSE_HTTP_ROOT", "/PROJECTS/powerhouse");

/**
 * POWERHOUSE_DIR_FILES
 *
 * The location of where the files for Powerhouse would be stored,
 * relative to the Powerhouse root directory.
 *
 * You may want to change this to something like "/var/files" or
 * something similar. It's best to keep the given directory outside
 * of the document roots.
 *
 * Default: /var/ph_files
 * Suggested: [anywhere]
 **/
define("POWERHOUSE_DIR_FILES", POWERHOUSE_DIR_ROOT . "/old/files");

// POWERHOUSE APPEARANCE AND THEME

/**
 * POWERHOUSE_APPEARANCE_THEME
 *
 * The theme that Powerhouse uses. Themes must be valid collections
 * of CSS files that shape the look of the Powerhouse browse.
 *
 * Default: material
 * Suggested: material
 **/
define("POWERHOUSE_APPEARANCE_THEME", "material");

// POWERHOUSE FILE STORAGE AND MANAGEMENT

/**
 * POWERHOUSE_FILES_SHORTHAND
 *
 * The shorthand directory used to refer to directories inside
 * of your installation. You may want to block access to this
 * folder using a robots.txt file.
 *
 * You can understand more about the shorthand directory by
 * visiting the README file inside of the `i` directory.
 *
 * Default: i
 * Suggested: i
 **/
define("POWERHOUSE_FILES_SHORTHAND", "i");

/**
 * POWERHOUSE_FILES_NOHIDDEN
 *
 * Prevent the upload, download, preview, and access of files that
 * start with a period (UNIX hidden files). NTFS hidden files
 * (Windows) are unsupported.
 *
 * Default: false
 * Suggested: true
 **/
define("POWERHOUSE_FILES_NOHIDDEN", false);

/**
 * POWERHOUSE_FILES_NODOWNLOADS
 *
 * This prevents files from being downloaded.
 *
 * Default: false
 * Suggested: false
 */
define("POWERHOUSE_FILES_NODOWNLOADS", false);

/**
 * POWERHOUSE_FILES_NOUPLOADS
 *
 * This prevents files from being uploaded.
 *
 * Default: false
 * Suggested: false
 */
define("POWERHOUSE_FILES_NOUPLOADS", false);

/**
 * POWERHOUSE_FILES_PRIVILEGED
 *
 * Enable user privileges. This option will enable
 * accounts, permissions, and the administration
 * panel. If you're running an exclusive version of
 * Powerhouse, and want to restrict downloads or uploads
 * of files, go ahead and set this to on.
 *
 * WARNING: It is advised that you use the graphical
 * setup to manage the options for privileged
 * installations, to make life easier.
 *
 * Default: false
 * Suggested: false
 */
define("POWERHOUSE_FILES_PRIVILEGED", false);

// Verify the configuration values.
require __DIR__ . "/system/verify_file_directory.php";
FileDirectoryVerifier::verify();