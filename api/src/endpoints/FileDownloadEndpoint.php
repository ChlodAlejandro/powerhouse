<?php

require_once __DIR__ . "/../../../const.php";
require_once __DIR__ . "/../APIEndpoint.php";

class FileDownloadEndpoint extends APIEndpoint
{
    // SINGLETON COMPONENTS

    /**
     * @var FileDownloadEndpoint The variable holding this endpoint.
     */
    private static $instance = null;

    /**
     * Create a new FileDownloadEndpoint. This must only be run once!
     */
    private function __construct() {}

    /**
     * @return FileDownloadEndpoint The instance of this endpoint.
     */
    public static function i()
    {
        if (self::$instance == null) {
            self::$instance = new FileDownloadEndpoint();
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

        if (!isset($_GET["file"])) {
            echo APIResponseBuilder::buildResponse(400, new APIException("400-MIS"),
                "No file path was provided.");
            exit();
        }

        $real_root = realpath(POWERHOUSE_DIR_FILES);
        $real_file = realpath($real_root . DIRECTORY_SEPARATOR . $_GET["file"]);
        if (!$real_file
            || substr($real_file, 0, strlen($real_root)) !== $real_root) {

            echo APIResponseBuilder::buildResponse(400, new APIException("400-IFN"),
                "The provided parent folder name is invalid or does not exist.");
            exit();
        }

        if (!is_readable($real_file)) {
            echo APIResponseBuilder::buildResponse(500, new APIException("500-UCW"),
                "The file requested is unreadable.");
            exit();
        }

        $file_content = file_get_contents($real_file);

        if (!$file_content) {
            echo APIResponseBuilder::buildResponse(500, new APIException("500-UCW"),
                "There was an error in reading the contents of the requested file.");
            exit();
        }

        http_response_code(200);
        if (isset($_GET["disposition"])) {
            switch ($_GET["disposition"]) {
                case "inline": {
                    header("Content-Disposition: inline");
                    header("Content-Type: " . mime_content_type($real_file));
                    break;
                }
                case "attachment": break;
                default:
                    echo APIResponseBuilder::buildResponse(500, new APIException("400-ARG"),
                        "Parameter \"disposition\" can only be \"inline\" or \"attachment\".");
                    exit();
            }
        }

        if ($_GET["disposition"] != "inline") {
            header("Content-Disposition: attachment; filename=" . basename($real_file));
            header("Content-Description: File Transfer");
            header("Content-Type: application/octet-stream");
            header("Content-Transfer-Encoding: binary");
        }

        // Make sure we don't output anything but the file.
        ob_clean();
        flush();
        echo $file_content;
    }

}