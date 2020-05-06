var mdlScript = document.createElement("script");
mdlScript.toggleAttribute("defer", true);
// noinspection JSUnresolvedFunction
mdlScript.setAttribute("src", getThemeScript("material.min"));

document.head.append(mdlScript);