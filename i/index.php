<?php
require_once __DIR__ . "/../const.php";

// Check if logged in, etc.
$CD = "";
if (isset($_GET["ph-target-directory"])) {
    $CD = $_GET["ph-target-directory"];
}

include_once POWERHOUSE_DIR_ROOT . "/interface/browse/index.php";