registerCallbacks("dialogPreProcess", (dialogName, dialogContainer) => {
    if (dialogName === "newFolder") {
        let inputBody = $(dialogContainer).find("div.dialog-new-folder-name-input");
        inputBody[0].classList.add("mdl-textfield", "mdl-js-textfield", "mdl-textfield--floating-label");
        let inputFolderName = inputBody.find("input")[0];
        inputFolderName.classList.add("mdl-textfield__input");
        let labelFolderName = inputBody.find("label")[0];
        labelFolderName.classList.add("mdl-textfield__label");

        let submit = $(dialogContainer).find(".dialog-new-folder-submit")[0];

        let submit_container = document.createElement("div");

        submit_container.classList.add("dialog-new-folder-submit_container");

        submit.parentElement.insertBefore(submit_container, submit);
        submit_container.appendChild(submit);

        submit.classList.add("mdl-button", "mdl-js-button", "mdl-button--raised", "mdl-js-ripple-effect",
            "mdl-button--colored");

        dialogContainer.addEventListener("submit", (e) => {
            e.preventDefault();

            var load_c = document.createElement("div");
            var load = document.createElement("div");
            load.classList.add("mdl-spinner", "mdl-spinner--single-color", "mdl-js-spinner", "is-active");
            load_c.appendChild(load);
            load_c.classList.add("dialog-new-folder-load_container");
            submit_container.insertBefore(load_c, submit_container.firstChild);

            componentHandler.upgradeElement(load);

            // do work

            load_c.parentElement.removeChild(load_c);

            // if it works, close the dialog
            
            return false;
        });

        let cancel = $(dialogContainer).find(".dialog-new-folder-cancel")[0];
        cancel.classList.add("mdl-button", "mdl-js-button", "mdl-js-ripple-effect");
    } else if (dialogName === "error") {
        let ok = $(dialogContainer).find(".dialog_error_ok")[0];
        ok.classList.add("mdl-button", "mdl-js-button", "mdl-button--raised", "mdl-js-ripple-effect",
            "mdl-button--colored");
    }
});

registerCallbacks("dialogPostProcess", (dialogName, dialogContainer) => {
    componentHandler.upgradeElement(dialogContainer);
    ($(dialogContainer).find("div.dialog-new-folder-name-input input")[0]).focus();
});