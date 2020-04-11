<?php
require_once __DIR__. "/APIException.php";

class APIResponseBuilder
{

    public static function buildResponse($code, $response) {
        if ($response instanceof APIException) {
            http_response_code($response->httpCode);
            return json_encode([
                "code" => $response->code,
                "error" => true,
                "error_info" => $response->toObject()
            ]);
        } else if ($response instanceof Exception) {
            http_response_code(500);
            return json_encode([
                "code" => "500",
                "error" => true,
                "error_info" => (new APIException(
                    "500", null, $response
                ))->toObject()
            ]);
        } else {
            if (is_array($response)) {
                http_response_code(intval($code));
                return json_encode(array_merge(
                    [
                        "code" => $code,
                        "error" => false
                    ],
                    $response
                ));
            } else {
                $message = $response == null ? null : strval($response);
                $exception = new APIException(
                    $code, $message
                );
                http_response_code($exception->httpCode);
                return json_encode([
                    "code" => $code,
                    "error" => intval(substr($code, 0, 1)) > 3,
                    "error_info" => $exception->toObject()
                ]);
            }
        }
    }

}