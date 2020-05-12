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

var ph_callbacks = {};

function triggerCallbacks(name) {
    if (name === undefined) {
        console.error("Attempt made to trigger unspecified callback.")
        return;
    }

    if (ph_callbacks[name] !== undefined)
        for (let callback of ph_callbacks[name])
            callback(...Array.from(arguments).slice(1))
}

function registerCallbacks(name, callback) {
    if (ph_callbacks[name] === undefined)
        ph_callbacks[name] = [callback];
    else ph_callbacks[name].push(callback);
}

var ph_handlers = {
    buildActionPanelDirectoryListSeparator: function() {
        var s = document.createElement("div");
        s.classList.add("folder_separator");
        s.innerText = ">";
        return s;
    }
};

function callHandler(name) {
    if (name === undefined) {
        throw new Error("Attempt made to trigger unspecified handler.");
    }

    if (ph_handlers[name] !== undefined)
        return ph_handlers[name](...Array.from(arguments).slice(1))
}

function registerHandler(name, handler) {
    ph_handlers[name] = handler;
}