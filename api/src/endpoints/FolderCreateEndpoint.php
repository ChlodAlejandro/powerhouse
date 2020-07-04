<?php

require_once __DIR__ . "/../../../const.php";
require_once __DIR__ . "/../APIEndpoint.php";
require_once __DIR__ . "/../APIException.php";
require_once __DIR__ . "/../utility/FileCheckpoints.php";

class FolderCreateEndpoint extends APIEndpoint
{
    // SINGLETON COMPONENTS

    /**
     * @var FolderCreateEndpoint The variable holding this endpoint.
     */
    private static $instance = null;

    /**
     * Create a new FileListEndpoint. This must only be run once!
     */
    private function __construct() {}

    /**
     * @return FolderCreateEndpoint The instance of this endpoint.
     */
    public static function i()
    {
        if (self::$instance == null) {
            self::$instance = new FolderCreateEndpoint();
        }

        return self::$instance;
    }

    // ENDPOINT COMPONENTS

    public function getAllowedMethods()
    {
        return ["POST"];
    }

    public function execute()
    {
        parent::execute();
        header("Content-Type: application/json");

        if (!FileDirectoryVerifier::$ok) {
            echo APIResponseBuilder::buildResponse(502, FileDirectoryVerifier::$issue);
            exit();
        }

        if (!isset($_POST["folder_name"])) {
            echo APIResponseBuilder::buildResponse(400, new APIException("400-MIS"),
                "The folder name was not specified.");
            exit();
        }

        $folder_name = $_POST["folder_name"];

        if (!FileCheckpoints::isValidFileName($folder_name)) {
            echo APIResponseBuilder::buildResponse(400, new APIException("400-IFN"),
                "The provided new folder name is invalid.");
            exit();
        }

        $parent = "";
        if (isset($_POST["parent"]))
            $parent = preg_replace('#(?:^(?:\\|/)+|(?:\\|/)+$)#', "", $_POST["parent"]);

        $real_root = realpath(POWERHOUSE_DIR_FILES);
        $real_parent = realpath($real_root . DIRECTORY_SEPARATOR . $parent);
        if (!$real_parent
            || substr($real_parent, 0, strlen($real_root)) !== $real_root) {

            echo APIResponseBuilder::buildResponse(400, new APIException("400-IFN"),
                "The provided parent folder name is invalid or does not exist.");
            exit();
        }

        mkdir($real_parent . DIRECTORY_SEPARATOR . $folder_name);

        echo APIResponseBuilder::buildResponse(201, ["success" => true]);
    }

}