<?php
require_once __DIR__ . "/../../const.php";

class APIException
{
    /**
     * @var array An array of Powerhouse error codes and their respective HTTP code and short and long messages. This array only includes errors that Powerhouse throws.
     */
    private static $httpCodeMessages = [
        "400-ARG" => [
            "http_code" => 400,
            "message_short" => "Invalid Argument",
            "message_long" => "The one or multiple of the arguments provided is invalid."
        ],
        "400-DIR" => [
            "http_code" => 400,
            "message_short" => "Invalid Directory",
            "message_long" => "The directory provided is not a valid nor existing directory."
        ],
        "400-IFN" => [
            "http_code" => 400,
            "message_short" => "Invalid Filename",
            "message_long" => "The provided file or folder name is not a valid name for a file or folder."
        ],
        "400-MIS" => [
            "http_code" => 400,
            "message_short" => "Missing Argument",
            "message_long" => "The request is missing a required argument."
        ],
        "400-UCF" => [
            "http_code" => 400,
            "message_short" => "Upload Conflict",
            "message_long" => "The file being uploaded conflicts with another file already on the server."
        ],
        "400-UPT" => [
            "http_code" => 400,
            "message_short" => "Partial Upload",
            "message_long" => "The file only uploaded partway before finishing."
        ],
        "400-UNF" => [
            "http_code" => 400,
            "message_short" => "Missing Argument",
            "message_long" => "The request is missing a required argument. No file was provided to the uploader."
        ],
        "405" => [
            "http_code" => 405,
            "message_short" => "Method Not Allowed",
            "message_long" => "The request method is known by the server but has been disabled and cannot be used."
        ],
        "413-UTL" => [
            "http_code" => 413,
            "message_short" => "File Too Large",
            "message_long" => "The file being uploaded exceeds the allowed size."
        ],
        "500" => [
            "http_code" => 500,
            "message_short" => "Internal Server Error",
            "message_long" => "The server encountered an unexpected condition which prevented it from fulfilling the request."
        ],
        "500-UTD" => [
            "http_code" => 500,
            "message_short" => "Temporary Directory Unavailable",
            "message_long" => "Uploads cannot be processed at the moment because a file is missing."
        ],
        "500-UCW" => [
            "http_code" => 500,
            "message_short" => "I/O Error",
            "message_long" => "Uploads cannot be processed at the moment due to a disk issue."
        ],
        "500-UEX" => [
            "http_code" => 500,
            "message_short" => "Upload Cancelled",
            "message_long" => "The upload was cancelled."
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
     * @param null $additive
     * @return array An array that may be converted into a JSON format.
     */
    public function toObject($additive = null) {
        $e = [
            "powerhouse_code" => $this->code,
            "http_code" => $this->httpCode,
            "summary" => $this->shortMessage,
            "description" => $this->longMessage . ($additive != null ? " " . $additive : "")
        ];
        if ($this->baseException != null && DEBUG_MODE)
            $e["base"] = self::pullBaseExceptionDetails($this->baseException);
        return $e;
    }

}