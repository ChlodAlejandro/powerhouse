<?php
require_once __DIR__ . "/../../../const.php";
class FileCheckpoints
{

    /**
     * Checks if the given string is not a valid
     * filename (either due to system constraints or
     * due to system security).
     *
     * @param string $filename The filename of the file.
     * @param boolean $linuxOnly If it will only check if the file is compatible for Linux.
     * @return boolean TRUE if the filename is a valid file name.
     */
    public static function isValidFileName($filename, $linuxOnly = false) {
        if (strlen($filename) == 0)
            return false;
        if (strpos($filename, "/") !== false)
            return false;
        if (strpos($filename, "\u{0000}") !== false)
            return false;
        if (POWERHOUSE_FILES_NOHIDDEN && substr($filename, 0, 1) == ".")
            return false;
        if (preg_match("/\.htaccess|(desktop|system|win(dows)?|boot).ini|.DS_Store/i", $filename))
            return false;
        if (!$linuxOnly && (preg_match(
                "/([<>:\"\\\\|?*\x{0000}-\x{001f}])|(CO(M[1-9]|N)|LPT[1-9]|PRN|AUX|NUL)|([.\s]$)/i",
                $filename) == 1))
            return false;
        return true;
    }

    /**
     * Hides all internal folders and system files.
     *
     * @param array $directoryFiles The directory files. Best used with the output of `scandir()`.
     * @return array The sanitized file list.
     */
    public static function sanitizeDirectory($directoryFiles) {
        $newList = [];
        foreach ($directoryFiles as $file) {
            if (self::isValidFileName($file))
                array_push($newList, $file);
        }
        return $newList;
    }

    /**
     * Check if a file is within the given directory.
     * @param string $parent The path to the parent directory.
     * @param string $filename The path to the file to check.
     * @return boolean If $filename is within $parent.
     */
    public static function withinDirectory($parent, $filename) {
        $base = realpath($parent);
        if (realpath($filename) === false || strncmp(realpath($filename), $base, strlen($base)) !== 0) {
            return false;
        } else {
            return true;
        }
    }

}