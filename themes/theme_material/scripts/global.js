var mdlScript = document.createElement("script");
mdlScript.toggleAttribute("defer", true);
// noinspection JSUnresolvedFunction
mdlScript.setAttribute("src", ph.asset_manager.getThemeScript("inc/material.min"));

document.head.append(mdlScript);

ph.registerHandler("buildActionPanelDirectoryListSeparator", function() {
    var s = document.createElement("div");
    s.classList.add("folder_separator", "material-icons");
    s.innerText = "keyboard_arrow_right";
    return s;
}, true);

var ph_material = {};

ph_material.buildSnackbar = (timeout) => {
    var snackbarContainer = document.createElement("div");
    var s_t = document.createElement("div");
    var s_b = document.createElement("button");

    snackbarContainer.id = "snackbar-" + (Math.floor(Math.random() * 1000000));
    snackbarContainer.classList.add("mdl-js-snackbar", "mdl-snackbar");

    s_t.classList.add("mdl-snackbar__text");
    s_b.classList.add("mdl-snackbar__action");
    s_b.setAttribute("type", "button");

    snackbarContainer.appendChild(s_t);
    snackbarContainer.appendChild(s_b);

    document.body.appendChild(snackbarContainer);
    componentHandler.upgradeDom();

    setTimeout(() => {
        snackbarContainer.parentElement.removeChild(snackbarContainer);
    }, timeout + 2000);

    return snackbarContainer;
}

ph_material.toast = (text, timeout = 2000) => {
    var snackbarContainer = ph_material.buildSnackbar(timeout);

    var snackbarData = {
        message: text,
        timeout: timeout
    };
    // noinspection JSUnresolvedFunction
    snackbarContainer.MaterialSnackbar.showSnackbar(snackbarData);
}
ph_material.snackbar = (text, action, actionText, timeout = 5000) => {
    var snackbarContainer = ph_material.buildSnackbar(timeout);

    var snackbarData = {
        message: text,
        timeout: timeout,
        actionHandler: action,
        actionText: actionText
    };
    // noinspection JSUnresolvedFunction
    snackbarContainer.MaterialSnackbar.showSnackbar(snackbarData);
}

ph_material.build_tooltips = () => {
    $("[data-tooltip]:not(.initialized)").each((i, e) => {
        e.classList.add("initialized");

        var target = $(e);
        if (target.attr("id") === undefined || target.attr("id").length === 0) {
            target.attr("id", "tooltip-" + Math.floor(Math.random() * 100000));
        }
        var id = target.attr("id");

        var tooltip = document.createElement("div");
        tooltip.classList.add("tooltip");
        tooltip.classList.add("tooltip-larger");
        tooltip.setAttribute("data-target-element-id", id);
        tooltip.innerText = target.attr("data-tooltip");

        $(tooltip).insertAfter(document.body.lastChild);
    });

    $(".tooltip:not(.initialized)").each((i, e) => {
        e.classList.add("initialized");

        e.classList.add("mdl-tooltip");
        e.setAttribute("data-mdl-for",
            e.getAttribute("data-target-element-id"));
    });

    componentHandler.upgradeDom();
}