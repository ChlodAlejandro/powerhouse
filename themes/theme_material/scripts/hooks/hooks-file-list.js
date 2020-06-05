registerCallbacks("updateFileListBegin", () => {
    var action_panel = document.getElementById("action_panel");
    var files = document.getElementById("files");

    var p = document.createElement("div");
    p.id = "files_loading_indicator";
    p.classList.add("mdl-progress", "mdl-js-progress", "mdl-progress__indeterminate");

    action_panel.parentNode.insertBefore(p, action_panel.nextSibling);

    var b = document.createElement("div");
    b.id = "files_interface_block";
    files.insertBefore(b, files.firstChild);

    componentHandler.upgradeDom();
});

registerCallbacks("updateFileListEnd", () => {
    var loading_indicator = document.getElementById("files_loading_indicator");
    var files_interface_block = document.getElementById("files_interface_block");

    $(loading_indicator).remove();
    files_interface_block.classList.add("closing");
    files_interface_block.addEventListener("animationend", (e) => {
        // noinspection JSUnresolvedVariable
        e.target.parentElement.removeChild(e.target);
    });
});