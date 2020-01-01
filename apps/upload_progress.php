<?php

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");

$up_name = "powerhouse_upload";

if (isset($_POST[ini_get("session.upload_progress.name")])) {
    $up_name = $_POST[ini_get("session.upload_progress.name")];
}
if (!isset($_SESSION[ini_get("session.upload_progress.prefix") . $up_name])) {
    exit(json_encode(array("error" => true, "error_message" => "No ongoing upload.")));
}

$progress = $_SESSION[ini_get("session.upload_progress.prefix") . $up_name];

$files = $progress["files"];
$returnArray = array();

foreach ($files as $file) {
    $returnArray[$file["name"]] = array(
        "done" => $file["done"],
        "startTime" => $file["start_time"],
        "processed" => $file["bytes_processed"]
    );
}

header("Content-Type: application/json");
echo json_encode($returnArray);