<?php
require_once("../../env.php");

if ($_SERVER['REQUEST_METHOD'] != "GET") {
    http_response_code(405);
}