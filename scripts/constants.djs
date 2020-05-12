<?php
require_once "../env.php";
?>
const POWERHOUSE_HTTP_ROOT = "<?php echo POWERHOUSE_HTTP_ROOT ?>";
const POWERHOUSE_DEV_PAGE = "<?php echo POWERHOUSE_DEV_PAGE ?>";
const POWERHOUSE_FILES_SHORTHAND = "<?php echo POWERHOUSE_FILES_SHORTHAND ?>";

function getThemeCSS(subfolder, ruleset) {
    if (ruleset === undefined) {
        ruleset = subfolder;
        subfolder = undefined;
    }
    return `${POWERHOUSE_HTTP_ROOT}/themes/theme_<?php echo POWERHOUSE_APPEARANCE_THEME ?>/`
        + (subfolder ? `${subfolder}/` : "") + `theme_${ruleset}.css`;
}

function getThemeScript(subfolder, script) {
    if (script === undefined) {
        script = subfolder;
        subfolder = undefined;
    }
    return `${POWERHOUSE_HTTP_ROOT}/themes/theme_<?php echo POWERHOUSE_APPEARANCE_THEME ?>/scripts/`
        + (subfolder ? `${subfolder}/` : "") + `${script}.js`;
}

function getPath(file) {
    return `${POWERHOUSE_HTTP_ROOT}/${file}`;
}

function getThemePath(file) {
    return `${POWERHOUSE_HTTP_ROOT}/themes/theme_<?php echo POWERHOUSE_APPEARANCE_THEME ?>/${file}`;
}