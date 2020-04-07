<?php

class APIEndpoint
{

    public function __construct($options)
    {
        try {
            if (!is_array($options)) {
                throw new Exception("$options is not an array.");
            }
        } catch (Exception $e) {
            self::handleEndpointException($e);
        }
    }

    public static function handleEndpointException($exception) {
        // build response
    }

}