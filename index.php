<?php
require_once __DIR__ . "/env.php";

// login page. soon.
$CD = "";
if (isset($_GET["ph-target-directory"])) {
    $CD = $_GET["ph-target-directory"];
}

require_once POWERHOUSE_DIR_ROOT . "/interface/browse/index.php";