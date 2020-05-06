<?php

require_once __DIR__ . "/../env.php";
require_once __DIR__ . "/utilities/TagGenerator.php";

echo '<!-- Auto-generated code. Expect mess. -->' . PHP_EOL;

echo TagGenerator::getThemeScript("body-postload") . PHP_EOL;

echo PHP_EOL . '<!-- End of auto-generated code. -->' . PHP_EOL;
