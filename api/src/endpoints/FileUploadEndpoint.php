<?php

require_once __DIR__ . "/../../../const.php";
require_once __DIR__ . "/../APIEndpoint.php";

class FileUploadEndpoint extends APIEndpoint
{
    // SINGLETON COMPONENTS

    /**
     * @var FileUploadEndpoint The variable holding this endpoint.
     */
    private static $instance = null;

    /**
     * Create a new FileUploadEndpoint. This must only be run once!
     */
    private function __construct() {}

    /**
     * @return FileUploadEndpoint The instance of this endpoint.
     */
    public static function i()
    {
        if (self::$instance == null) {
            self::$instance = new FileUploadEndpoint();
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

        if (!isset($_FILES["file"])) {
            echo APIResponseBuilder::buildResponse(400, new APIException("400-MIS"),
                "No file was provided to the uploader.");
            exit();
        }

        $file = $_FILES["file"];

        if ($file["error"] !== UPLOAD_ERR_OK) {
            switch($file["error"]) {
                case UPLOAD_ERR_INI_SIZE:
                case UPLOAD_ERR_FORM_SIZE: {
                    echo APIResponseBuilder::buildResponse(400, new APIException("413-UTL"));
                    exit(); break;
                }
                case UPLOAD_ERR_PARTIAL: {
                    echo APIResponseBuilder::buildResponse(400, new APIException("400-UPT"));
                    exit(); break;
                }
                case UPLOAD_ERR_NO_FILE: {
                    echo APIResponseBuilder::buildResponse(400, new APIException("400-UNF"));
                    exit(); break;
                }
                case UPLOAD_ERR_NO_TMP_DIR: {
                    echo APIResponseBuilder::buildResponse(400, new APIException("500-UTD"));
                    exit(); break;
                }
                case UPLOAD_ERR_CANT_WRITE: {
                    echo APIResponseBuilder::buildResponse(400, new APIException("500-UCW",
                        "Disk unwritable."));
                    exit(); break;
                }
                case UPLOAD_ERR_EXTENSION: {
                    echo APIResponseBuilder::buildResponse(400, new APIException("500-UEX"));
                    exit(); break;
                }
            }
        }

        /* redundant file size check */
        if ($file["size"] > POWERHOUSE_UPLOADS_MAXSIZE) {
            echo APIResponseBuilder::buildResponse(400, new APIException("413-UTL"));
            exit();
        }

        $real_root = null;
        $real_parent = null;
        if (isset($_POST["parent"])) {
            $parentDirectory =
                preg_replace('#(?:^(?:\\|/)+|(?:\\|/)+$)#', "", $_POST["parent"]);

            $real_root = realpath(POWERHOUSE_DIR_FILES);
            $real_parent = realpath($real_root . DIRECTORY_SEPARATOR . $parentDirectory);
            if (!$real_parent
                || substr($real_parent, 0, strlen($real_root)) !== $real_root) {

                echo APIResponseBuilder::buildResponse(400, new APIException("400-IFN"),
                    "The provided parent folder name is invalid or does not exist.");
                exit();
            }

            $finalPath = $real_parent
                . DIRECTORY_SEPARATOR
                . basename($file['name']);
        } else {
            $finalPath = POWERHOUSE_DIR_FILES . DIRECTORY_SEPARATOR . basename($file['name']);
        }

        if (!is_dir(dirname($finalPath))) {
            echo APIResponseBuilder::buildResponse(400, new APIException("400-IFN"),
                "The provided parent folder name is invalid or does not exist.");
            exit();
        }

        if (!is_writable(dirname($finalPath))) {
            echo APIResponseBuilder::buildResponse(500, new APIException("500-UCW"),
                "The target directory is unwritable.");
            exit();
        }

        if (is_file($finalPath) && (!isset($_POST["overwrite"]) || $_POST["overwrite"] != "true")) {
            echo APIResponseBuilder::buildResponse(400, new APIException("400-UCF"));
            exit();
        }

        $move_result = move_uploaded_file($file["tmp_name"], $finalPath);

        if ($move_result) {
            echo APIResponseBuilder::buildResponse(200, [
                "file" => [
                    "name" => basename($finalPath),
                    "parent" => str_replace("\\", "/",
                        substr($real_parent, strlen($real_root))),
                    "size" => filesize($finalPath),
                    "mtime" => filemtime($finalPath),
                    "ctime" => filectime($finalPath)
                ]
            ]);
            exit();
        } else {
            echo APIResponseBuilder::buildResponse(400, new APIException("500-UCW"),
                "If you are the server administrator, check your error logs.");
            exit();
        }

    }

}