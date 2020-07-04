<?php
require_once __DIR__ . "/../const.php";

class FileDirectoryVerifier
{
    public static $ok = false;
    public static $issue;

    public static $requiredHtaccessLines = [
        "php_flag engine off",
        "Order deny,allow",
        "Deny from All"
    ];

    public static function verify() {
        if (file_exists(POWERHOUSE_DIR_FILES)) {
            if (!is_readable(POWERHOUSE_DIR_FILES))
                self::$issue = new Exception("The files directory is unreadable. No files may be downloaded (and most likely uploaded either.) Please delete all files that may be named the same as the said folder, or allow Powerhouse to read the files directory (\"" . POWERHOUSE_DIR_FILES . "\").");
            else if (!is_writable(POWERHOUSE_DIR_FILES)) {
                self::$issue = new Exception("The files directory is unwritable. No files may be uploaded. If you wish to enable download-only mode, or restrict uploads to specific users, please do so in the configuration. Please delete all files that may be named the same as the said folder, or allow Powerhouse to write on the files directory (\"" . POWERHOUSE_DIR_FILES . "\").");
            } else {
                self::$ok = true;
            }
        } else {
            $mkdirOK = mkdir(POWERHOUSE_DIR_FILES, 0775, true);
            if ($mkdirOK) {
                $htaccessLoc = POWERHOUSE_DIR_FILES . "/.htaccess";
                if (file_exists($htaccessLoc)) {
                    $htaccessLines = explode("\n",
                        str_replace("\r\n", "\n", file_get_contents($htaccessLoc))
                    );
                    foreach (FileDirectoryVerifier::$requiredHtaccessLines as $requiredLine) {
                        if (!in_array($requiredLine, $htaccessLines)) {
                            self::$ok = true;
                            self::$issue = new Exception("The directory HTACCESS does not contain required HTACCESS lines in order to keep your server secure. This opens up the folder to intruders. Please make sure that the HTACCESS file in your files directory contains the required lines.");
                        }
                    }
                } else {
                    $htaccessOK = file_put_contents($htaccessLoc,
                        join("\r\n", FileDirectoryVerifier::$requiredHtaccessLines));
                    if ($htaccessOK !== false) {
                        self::$ok = true;
                        self::$issue = new Exception("The directory HTACCESS file failed to write. This opens up the folder to intruders. Please allow Powerhouse to write on the files directory (\"" . POWERHOUSE_DIR_FILES . "\"), or read the HTACCESS instructions for the files directory in the documentation.");
                    }
                }
            } else {
                self::$issue = new Exception("The files directory cannot be made. No files may be uploaded or downloaded. Please allow Powerhouse to write on the files directory (\"" . POWERHOUSE_DIR_FILES . "\").");
            }
        }

        return self::$ok;
    }
}