<?php
require_once __DIR__ . "/../../const.php";

class TagGenerator
{

    public static function getThemeCSS($ruleset, $theme = POWERHOUSE_APPEARANCE_THEME) {
        if (file_exists(POWERHOUSE_DIR_ROOT . "/themes/theme_" . $theme
            . "/styles/theme_" . $ruleset . ".css"))
            return "<link rel=\"stylesheet\" type=\"text/css\" href=\""
                . POWERHOUSE_HTTP_ROOT .
                "/themes/theme_" . $theme ."/styles/theme_" . $ruleset . ".css\">";
        else return "";
    }

    public static function getThemeScript($script, $theme = POWERHOUSE_APPEARANCE_THEME) {
        if (file_exists(POWERHOUSE_DIR_ROOT . "/themes/theme_" . $theme
            . "/scripts.json")) {
            $script_index = json_decode(file_get_contents(
                POWERHOUSE_DIR_ROOT . "/themes/theme_" . $theme
                . "/scripts.json"), true);

            $split = explode(".", $script);
            $target = $script_index;
            foreach ($split as $item) {
                if (isset($target[$item]))
                    $target = $target[$item];
                else return "";
            }

            if (is_string($target))
                return "<script src=\""
                    . POWERHOUSE_HTTP_ROOT . "/themes/theme_" . $theme . "/scripts/" . $target . "\"></script>";
            else if (is_array($target)) {
                $outputTag = "";
                foreach ($target as $script_location)
                    $outputTag .= "<script src=\""
                        . POWERHOUSE_HTTP_ROOT . "/themes/theme_" . $theme . "/scripts/" . $script_location
                        . "\"></script>";
                return $outputTag;
            }
            else return "";
        }
        if (file_exists(POWERHOUSE_DIR_ROOT . "/themes/theme_" . $theme
            . "/scripts/" . $script . ".js"))
            return "<script src=\""
                . POWERHOUSE_HTTP_ROOT .
                "/themes/theme_" . $theme ."/scripts/" . $script . ".js\"></script>";
        else return "";
    }

    public static function getRootScript($file) {
        if (file_exists(POWERHOUSE_DIR_ROOT . "/" . $file . ".js"))
            return "<script src=\""
                . POWERHOUSE_HTTP_ROOT . "/" . $file . ".js\"></script>";
        else return "";
    }

    public static function getRootCSS($file) {
        if (file_exists(POWERHOUSE_DIR_ROOT . "/" . $file . ".css"))
            return "<link rel=\"stylesheet\" type=\"text/css\" href=\""
                . POWERHOUSE_HTTP_ROOT . "/" . $file . ".css\">";
        else return "";
    }

    public static function getRootPath($file) {
        return POWERHOUSE_HTTP_ROOT . "/" . $file;
    }

}