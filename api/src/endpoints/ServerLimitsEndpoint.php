<?php

require_once __DIR__ . "/../../../const.php";
require_once __DIR__ . "/../APIEndpoint.php";

class ServerLimitsEndpoint extends APIEndpoint
{
    // SINGLETON COMPONENTS

    /**
     * @var ServerLimitsEndpoint The variable holding this endpoint.
     */
    private static $instance = null;

    /**
     * Create a new ServerLimitsEndpoint. This must only be run once!
     */
    private function __construct()
    {
    }

    /**
     * @return ServerLimitsEndpoint The instance of this endpoint.
     */
    public static function i()
    {
        if (self::$instance == null) {
            self::$instance = new ServerLimitsEndpoint();
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

        return APIResponseBuilder::buildResponse(200, [
            "file_size" => POWERHOUSE_UPLOADS_MAXSIZE,
            "files_per_upload" => POWERHOUSE_UPLOADS_SIMULTANEOUS
        ]);
    }

}