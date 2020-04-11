<?php
require_once __DIR__ . "/APIResponseBuilder.php";

abstract class APIEndpoint
{
    /**
     * @return array Must return a string array of allowed functions.
     */
    abstract public function getAllowedMethods();

    public function execute() {
        if (!in_array($_SERVER["REQUEST_METHOD"], $this->getAllowedMethods())) {
            echo APIResponseBuilder::buildResponse("405", null);
            exit();
        }
    }
}