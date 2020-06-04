var mdlScript = document.createElement("script");
mdlScript.toggleAttribute("defer", true);
// noinspection JSUnresolvedFunction
mdlScript.setAttribute("src", getThemeScript("inc/material.min"));

document.head.append(mdlScript);

registerHandler("buildActionPanelDirectoryListSeparator", function() {
    var s = document.createElement("div");
    s.classList.add("folder_separator", "material-icons");
    s.innerText = "keyboard_arrow_right";
    return s;
}, true);