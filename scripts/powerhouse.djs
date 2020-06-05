<?php
require_once "../const.php";
?>
const POWERHOUSE_HTTP_ROOT = "<?php echo POWERHOUSE_HTTP_ROOT ?>";
const POWERHOUSE_DEV_PAGE = "<?php echo POWERHOUSE_DEV_PAGE ?>";
const POWERHOUSE_FILES_SHORTHAND = "<?php echo POWERHOUSE_FILES_SHORTHAND ?>";

const POWERHOUSE_ENDPOINTS = {
    "GET": {
        "files/list": "<?php echo POWERHOUSE_HTTP_ROOT ?>/api/GET/files/list.php"
    },

    "POST": {
        "folder/create": "<?php echo POWERHOUSE_HTTP_ROOT ?>/api/POST/folder/create.php"
    }
}

function getThemeCSS(subfolder, ruleset) {
    if (ruleset === undefined) {
        ruleset = subfolder;
        subfolder = undefined;
    }
    return `${POWERHOUSE_HTTP_ROOT}/themes/theme_<?php echo POWERHOUSE_APPEARANCE_THEME ?>/styles/`
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

    var outputs = [];

    if (ph_callbacks[name] !== undefined)
        for (let callback of ph_callbacks[name])
            outputs.push(callback(...Array.from(arguments).slice(1)));

    return outputs;
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
    },
    actionPanelSelect: function() {
        console.log("Your Powerhouse theme does not support this function.");
    }
};

function callHandler(name) {
    if (name === undefined) throw new Error("Attempt made to trigger unspecified handler.");

    if (ph_handlers[name] !== undefined)
        return ph_handlers[name](...Array.from(arguments).slice(1))
    else
        throw new Error("Attempt made to handle an unregistered handler. Has your theme registered this handler?\n\nConfused? Themes (in most cases) are supposed to register handlers. Handlers are theme-specific functions required by Powerhouse in order to make actions specific for that theme.");
}

function registerHandler(name, handler, override = false) {
    if (ph_handlers[name] !== undefined && !override)
        throw new Error("Attempting to register a handler already registered previously.");

    ph_handlers[name] = handler;
}