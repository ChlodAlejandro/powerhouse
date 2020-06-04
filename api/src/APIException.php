<?php
require_once __DIR__ . "/../../const.php";

class APIException
{
    /**
     * @var array An array of Powerhouse error codes and their respective HTTP code and short and long messages. This array only includes errors that Powerhouse throws.
     */
    private static $httpCodeMessages = [
        "400-DIR" => [
            "http_code" => 400,
            "message_short" => "Invalid Directory",
            "message_long" => "The directory provided is not a valid directory."
        ],
        "405" => [
            "http_code" => 405,
            "message_short" => "Method Not Allowed",
            "message_long" => "The request method is known by the server but has been disabled and cannot be used."
        ],
        "500" => [
            "http_code" => 500,
            "message_short" => "Internal Server Error",
            "message_long" => "The server encountered an unexpected condition which prevented it from fulfilling the request."
        ]
    ];

    /**
     * @var string The short message that describes this exception briefly.
     */
    public $shortMessage;

    /**
     * @var string The long message that describes this exception precisely.
     */
    public $longMessage;

    /**
     * @var int The Powerhouse code that represents this exception.
     */
    public $code;

    /**
     * @var int The HTTP code that represents this exception.
     */
    public $httpCode;

    /**
     * @var Exception The exception that may have caused the API exception.
     */
    public $baseException;

    /**
     * Create a new APIException object.
     * @param string $code The Powerhouse code that represents this exception.
     * @param array $message The message pair that describes this exception.
     * @param Exception $baseException The exception that may have caused the API exception.
     */
    public function __construct($code = "500", $message = null, $baseException = null) {
        $this->code = $code;

        if ($message !== null) {
            $newCode = intval($code);
            $this->httpCode = $newCode === 0 ? 500 : $newCode;
            $this->shortMessage = $message["short"];
            $this->longMessage = $message["long"];
        } else {
            if (array_key_exists(strval($code), APIException::$httpCodeMessages)) {
                $phError = APIException::$httpCodeMessages[strval($code)];
                $this->httpCode = $phError["http_code"];
                $this->shortMessage = $phError["message_short"];
                $this->longMessage = $phError["message_long"];
            }
        }

        $this->baseException = $baseException;
    }

    /**
     * Handle an unknown exception that occurs within the endpoint.
     * @param Exception $exception The exception that occurred.
     */
    public static function handleEndpointException($exception) {
        echo APIResponseBuilder::buildResponse(500, $exception);
        exit();
    }

    public static function sanitizeTrace($traceArray) {
        foreach ($traceArray as $traceIndex => $traceItem) {
            if (isset($traceItem["file"]))
                $traceArray[$traceIndex]["file"] =
                    str_replace(POWERHOUSE_DIR_ROOT, "PH_ROOT", $traceItem["file"]);
        }
        return $traceArray;
    }

    /**
     * Pull the details of an exception into a JSON-parsable array.
     * @param Exception $baseException The base exception
     * @return array The exception details in a JSON-parsable array.
     */
    public static function pullBaseExceptionDetails($baseException) {
        return [
            "message" => $baseException->getMessage(),
            "code" => $baseException->getCode(),
            "trace" => self::sanitizeTrace($baseException->getTrace())
        ];
    }

    /**
     * Convert the array into a JSON-parsable object.
     * @return array An array that may be converted into a JSON format.
     */
    public function toObject() {
        $e = [
            "powerhouse_code" => $this->code,
            "http_code" => $this->httpCode,
            "summary" => $this->shortMessage,
            "description" => $this->longMessage
        ];
        if ($this->baseException != null && DEBUG_MODE)
            $e["base"] = self::pullBaseExceptionDetails($this->baseException);
        return $e;
    }

}