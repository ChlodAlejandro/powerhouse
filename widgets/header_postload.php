<?php

require_once __DIR__ . "/../const.php";
require_once __DIR__ . "/utilities/TagGenerator.php";

echo '<!-- Auto-generated code. Expect mess. -->' . PHP_EOL;

echo TagGenerator::getThemeScript("header.post-load") . PHP_EOL;

echo '<!-- The widget builder. Must be loaded AFTER widgets. -->';
echo '<script src="' . POWERHOUSE_HTTP_ROOT . '/scripts/widget_builder.js"></script>';

echo PHP_EOL . '<!-- End of auto-generated code. -->' . PHP_EOL;