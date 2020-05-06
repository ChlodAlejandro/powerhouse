<?php
require_once "../env.php";

echo "const POWERHOUSE_HTTP_ROOT = \"" . POWERHOUSE_HTTP_ROOT . "\";" . PHP_EOL;
echo "const POWERHOUSE_DEV_PAGE = \"" . POWERHOUSE_DEV_PAGE . "\";" . PHP_EOL;

// TODO DIRECTORY THING
echo "const phDirectory = \"" . "/" . "\";" . PHP_EOL;

echo PHP_EOL;

echo "function getThemeCSS(ruleset) {" . PHP_EOL;
echo "    return `\${POWERHOUSE_HTTP_ROOT}/themes/theme_"
    . POWERHOUSE_APPEARANCE_THEME ."/theme_\${ruleset}.css`" . PHP_EOL;
echo "}" . PHP_EOL;

echo PHP_EOL;

echo "function getThemeScript(script) {" . PHP_EOL;
echo "    return `\${POWERHOUSE_HTTP_ROOT}/themes/theme_"
    . POWERHOUSE_APPEARANCE_THEME ."/scripts/\${script}.js`" . PHP_EOL;
echo "}" . PHP_EOL;

echo PHP_EOL;

echo "function getPath(file) {" . PHP_EOL;
echo "    return `\${POWERHOUSE_HTTP_ROOT}/\${file}`" . PHP_EOL;
echo "}" . PHP_EOL;