<?php
/**
 * POWERHOUSE_ENV_VERSION
 *
 * The version of this file. Changes in the version code indicate
 * a breaking difference. In most cases, Powerhouse should
 * automatically fix the old env.php file to conform to the newer
 * version.
 */
define("POWERHOUSE_ENV_VERSION", 1);

/**
 * POWERHOUSE_CONFIGURED
 *
 * If you want to use this file and get straight to using
 * Powerhouse without installation, change the following
 * into a `true`.
 *
 * Default: false
 * Suggested: true
 */
define("POWERHOUSE_CONFIGURED", false);

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
define("POWERHOUSE_HTTP_ROOT", "/");

/**
 * POWERHOUSE_DIR_FILES
 *
 * The location of where the files for Powerhouse would be stored.
 * This must be an absolute path.
 *
 * You may want to change this to something like "/var/files" or
 * something similar. It's best to keep the given directory outside
 * of the document roots.
 *
 * Default: /var/ph_files
 * Suggested: [anywhere]
 **/
define("POWERHOUSE_DIR_FILES", "/var/ph_files");

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

// POWERHOUSE UPLOAD MANAGEMENT

/**
 * POWERHOUSE_UPLOADS_ENABLED
 *
 * Enabling this option will enable uploads for this
 * Powerhouse option. Disabling it will prevent anyone
 * from uploading. If you wish to restrict who gets to
 * upload, use security options instead.
 *
 * Default: false
 * Suggested: false
 */
define("POWERHOUSE_UPLOADS_ENABLED", true);

/**
 * POWERHOUSE_UPLOADS_PROGRESSTOKEN
 *
 * The name of the parameter where the upload progress
 * token is stored. If you wish to change this option
 * manually, change its value in the .htaccess file for
 * the top-level Powerhouse directory (the same
 * directory this file is in.)
 *
 * Default: PH_UPLOAD_PROGRESS_TOKEN
 */
define("POWERHOUSE_UPLOADS_PROGRESSTOKEN", ini_get("session.upload_progress.name"));

/**
 * POWERHOUSE_UPLOADS_MAXSIZE
 *
 * The maximum file size allowed for one file.
 * If you wish to change this option manually,
 * change its value in the .htaccess file for the
 * top-level Powerhouse directory (the same directory
 * this file is in.)
 *
 * Default: 1000000000 (1 GB)
 */
define("POWERHOUSE_UPLOADS_MAXSIZE", intval(ini_get("upload_max_filesize")));

/**
 * POWERHOUSE_UPLOADS_SIMULTANEOUS
 *
 * The maximum amount of simultaneous uploads
 * per request allowed. This is 1 by default, but
 * can be increased, as long as the interface
 * supports multiple-file uploads.
 *
 * Default: 1
 */
define("POWERHOUSE_UPLOADS_SIMULTANEOUS", intval(ini_get("max_file_uploads")));