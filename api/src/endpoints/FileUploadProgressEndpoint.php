<?php

require_once __DIR__ . "/../../../const.php";
require_once __DIR__ . "/../APIEndpoint.php";

class FileUploadProgressEndpoint extends APIEndpoint
{
    // SINGLETON COMPONENTS

    /**
     * @var FileUploadProgressEndpoint The variable holding this endpoint.
     */
    private static $instance = null;

    /**
     * Create a new FileUploadProgressEndpoint. This must only be run once!
     */
    private function __construct() {}

    /**
     * @return FileUploadProgressEndpoint The instance of this endpoint.
     */
    public static function i()
    {
        if (self::$instance == null) {
            self::$instance = new FileUploadProgressEndpoint();
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

        $prog_pref = ini_get("session.upload_progress.prefix");
        $prog_name = POWERHOUSE_UPLOADS_PROGRESSTOKEN;

        $token = null;

        if (isset($_GET["upload_token"]))
            $token = $_GET["upload_token"];
        else if (isset($_GET[$prog_name]))
            $token = $_GET[$prog_name];
        else {
            echo APIResponseBuilder::buildResponse(400, new APIException("400-MIS"),
                "No upload progress token was provided.");
            exit();
        }

        if (!isset($_SESSION[$prog_pref . $token])) {
            echo APIResponseBuilder::buildResponse(400, new APIException("400-ARG"),
                "Upload progress token is invalid.");
            exit();
        }

        $progress = $_SESSION[$prog_pref . $token];
        $out = [];

        foreach ($progress["files"] as $file) {
            array_push($out, [
                "name" => $file["name"],
                "error" => $file["error"],
                "done" => $file["done"],
                "upload_start_time" => $file["start_time"],
                "upload_done_bytes" => $file["bytes_processed"]
            ]);
        }

        echo APIResponseBuilder::buildResponse(200, [
            "done" => $progress["done"],
            "bytes_expected" => $progress["content_length"],
            "bytes_uploaded" => $progress["bytes_processed"],
            "progress" => $progress["bytes_processed"] / $progress["content_length"],
            "upload_start_time" => $progress["start_time"],
            "files" => $out
        ]);
    }

}