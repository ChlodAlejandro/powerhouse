<?php
require_once "../const.php";
?>
const ph = {};

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

class PowerhouseAssetManager {
    getThemeCSS(subfolder, ruleset) {
        if (ruleset === undefined) {
            ruleset = subfolder;
            subfolder = undefined;
        }
        return `${POWERHOUSE_HTTP_ROOT}/themes/theme_<?php echo POWERHOUSE_APPEARANCE_THEME ?>/styles/`
            + (subfolder ? `${subfolder}/` : "") + `theme_${ruleset}.css`;
    }

    getThemeScript(subfolder, script) {
        if (script === undefined) {
            script = subfolder;
            subfolder = undefined;
        }
        return `${POWERHOUSE_HTTP_ROOT}/themes/theme_<?php echo POWERHOUSE_APPEARANCE_THEME ?>/scripts/`
            + (subfolder ? `${subfolder}/` : "") + `${script}.js`;
    }

    getPath(file) {
        return `${POWERHOUSE_HTTP_ROOT}/${file}`;
    }

    getThemePath(file) {
        return `${POWERHOUSE_HTTP_ROOT}/themes/theme_<?php echo POWERHOUSE_APPEARANCE_THEME ?>/${file}`;
    }
}

ph.asset_manager = new PowerhouseAssetManager();

ph.callbacks = {};

ph.triggerCallbacks = function(name) {
    if (name === undefined) {
        console.error("Attempt made to trigger unspecified callback.")
        return;
    }

    var outputs = [];

    if (ph.callbacks[name] !== undefined)
        for (let callback of ph.callbacks[name])
            outputs.push(callback(...Array.from(arguments).slice(1)))

    return outputs;
}

ph.registerCallbacks = function(name, callback) {
    if (ph.callbacks[name] === undefined)
        ph.callbacks[name] = [callback];
    else ph.callbacks[name].push(callback);
}

ph.handlers = {
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

ph.callHandler = function (name) {
    if (name === undefined) throw new Error("Attempt made to trigger unspecified handler.");

    if (ph.handlers[name] !== undefined)
        return ph.handlers[name](...Array.from(arguments).slice(1))
    else
        throw new Error("Attempt made to handle an unregistered handler. Has your theme registered this handler?\n\nConfused? Themes (in most cases) are supposed to register handlers. Handlers are theme-specific functions required by Powerhouse in order to make actions specific for that theme.");
}

ph.registerHandler = function (name, handler, override = false) {
    if (ph.handlers[name] !== undefined && !override)
        throw new Error("Attempting to register a handler already registered previously.");

    ph.handlers[name] = handler;
}