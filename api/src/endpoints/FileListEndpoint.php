<?php

require_once __DIR__ . "/../../../const.php";
require_once __DIR__ . "/../APIEndpoint.php";
require_once __DIR__ . "/../utility/FileCheckpoints.php";

class FileListEndpoint extends APIEndpoint
{
    // SINGLETON COMPONENTS

    /**
     * @var FileListEndpoint The variable holding this endpoint.
     */
    private static $instance = null;

    /**
     * Create a new FileListEndpoint. This must only be run once!
     */
    private function __construct() {}

    /**
     * @return FileListEndpoint The instance of this endpoint.
     */
    public static function i()
    {
        if (self::$instance == null) {
            self::$instance = new FileListEndpoint();
        }

        return self::$instance;
    }

    // ENDPOINT COMPONENTS

    public function getAllowedMethods()
    {
        return ["GET"];
    }

    public function execute()
    {
        parent::execute();
        header("Content-Type: application/json");

        if (!FileDirectoryVerifier::$ok) {
            echo APIResponseBuilder::buildResponse(502, FileDirectoryVerifier::$issue);
            exit();
        }

        $subdirectory = isset($_GET["dir"]) && strlen($_GET["dir"]) > 0 ? (DIRECTORY_SEPARATOR . $_GET["dir"]) : "";

        $directory = realpath(POWERHOUSE_DIR_FILES . $subdirectory);
        if (strlen($subdirectory) > 0 &&
                (!FileCheckpoints::isValidFileName(basename($subdirectory))
                || !FileCheckpoints::withinDirectory(POWERHOUSE_DIR_FILES, $directory))
            || !file_exists($directory)
            || !is_dir($directory)) {
            echo APIResponseBuilder::buildResponse("400-DIR", null);
            exit();
        }

        $files = FileCheckpoints::sanitizeDirectory(scandir($directory));
        $finalOutput = [];
        foreach ($files as $file) {
            $filepath = realpath($directory . "/" . $file);
            $isFile = is_file($filepath);
            $finalOutput[$file] = [
                "type" => $isFile ? "file" : "dir",
                "size" => $isFile ? filesize($filepath) : 0,
                "mtime" => filemtime($filepath),
                "ctime" => filectime($filepath)
            ];
        }

        echo APIResponseBuilder::buildResponse(200, ["files" => $finalOutput]);
    }

}