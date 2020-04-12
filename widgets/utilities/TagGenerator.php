<?php
require_once __DIR__ . "/../../env.php";

class TagGenerator
{

    public static function getThemeCSS($ruleset, $theme = POWERHOUSE_APPEARANCE_THEME) {
        if (file_exists(POWERHOUSE_DIR_ROOT . "/themes/theme_" . $theme
            . "/theme_" . $ruleset . ".css"))
            return "<link rel=\"stylesheet\" type=\"text/css\" href=\""
                . POWERHOUSE_HTTP_ROOT .
                "/themes/theme_" . $theme ."/theme_" . $ruleset . ".css\">";
        else return "";
    }

    public static function getThemeScript($script, $theme = POWERHOUSE_APPEARANCE_THEME) {
        if (file_exists(POWERHOUSE_DIR_ROOT . "/themes/theme_" . $theme
            . "/scripts/" . $script . ".js"))
            return "<script src=\""
                . POWERHOUSE_HTTP_ROOT .
                "/themes/theme_" . $theme ."/scripts/" . $script . ".js\"></script>";
        else return "";
    }

}