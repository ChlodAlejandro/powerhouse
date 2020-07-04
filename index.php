<?php
require_once __DIR__ . "/const.php";

// login page. soon.
$CD = "";
if (isset($_GET["ph-target-directory"])) {
    $CD = $_GET["ph-target-directory"];
    while (substr($CD, 0, 1)) {
        $CD = substr($CD, 1);
    }
}

require_once POWERHOUSE_DIR_ROOT . "/interface/browse/index.php";