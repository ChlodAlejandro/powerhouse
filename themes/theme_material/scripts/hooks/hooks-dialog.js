ph.registerCallbacks("dialogPreProcess", (dialogName, dialogContainer) => {
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
            submit.setAttribute("disabled", "true");
            (async () => {
                var form = dialogContainer.querySelector("form");

                var load_c = document.createElement("div");
                var load = document.createElement("div");
                load.classList.add("mdl-spinner", "mdl-spinner--single-color", "mdl-js-spinner", "is-active");
                load_c.appendChild(load);
                load_c.classList.add("dialog-new-folder-load_container");
                submit_container.insertBefore(load_c, submit_container.firstChild);

                componentHandler.upgradeDom();

                var data = serializeForm(form).toString();
                var err;
                var response;
                try {
                    response = await axios({
                        method: form.getAttribute("method"),
                        url: form.getAttribute("action"),
                        data: data,
                        responseType: "json"
                    });
                } catch (e) {
                    response = e.response;
                    err = e;
                }

                if (response !== undefined && !response.data.error) {
                    ph_material.toast("Folder created successfully.");
                    DialogWidget.close(dialogContainer.querySelector(".dialog").id);

                    (() => {ph.file_manager.updateFileList();})();
                } else if (response !== undefined && response.data !== undefined && response.data.error) {
                    handleError(err, {render: false, log: true});
                    ph_material.snackbar("Folder not created.",
                        () => {
                            handleError(err, {render: true, log: false});
                        }, "Details");
                } else {
                    ph_material.toast("Folder not created. (reason unknown)");
                }

                submit.removeAttribute("disabled");
                load_c.parentElement.removeChild(load_c);
            })();
            e.preventDefault();
            return false;
        });

        let cancel = $(dialogContainer).find(".dialog-new-folder-cancel")[0];
        cancel.classList.add("mdl-button", "mdl-js-button", "mdl-js-ripple-effect");
    } else if (dialogName === "sort") {
        let submit = $(dialogContainer).find(".dialog-sort-submit")[0];
        submit.classList.add("mdl-button", "mdl-js-button", "mdl-button--raised", "mdl-js-ripple-effect",
            "mdl-button--colored");

        let cancel = $(dialogContainer).find(".dialog-sort-cancel")[0];
        cancel.classList.add("mdl-button", "mdl-js-button", "mdl-js-ripple-effect");

        $(dialogContainer).find(".dialog-sort-options button").each((i, el) => {
            console.log(el);
            el.classList.add("mdl-button", "mdl-js-button", "mdl-button--raised", "mdl-js-ripple-effect");
        });
    } else if (dialogName === "error") {
        let ok = $(dialogContainer).find(".dialog_error_ok")[0];
        ok.classList.add("mdl-button", "mdl-js-button", "mdl-button--raised", "mdl-js-ripple-effect",
            "mdl-button--colored");
    }
});

ph.registerCallbacks("dialogPostProcess", (dialogName, dialogContainer) => {
    componentHandler.upgradeDom();
    if (dialogName === "newFolder") {
        ($(dialogContainer).find("div.dialog-new-folder-name-input input")[0]).focus();
    }
});

ph.registerCallbacks("dialogSort_entryAdded", (entry) => {
    $(entry).find(".dialog-sort-entry-delete").attr("data-tooltip", "Delete Entry");
    ph_material.build_tooltips();
});

ph.registerCallbacks("dialogSort_entryRemoved", (entry) => {
    var tooltipTarget = $(entry).find(".dialog-sort-entry-delete")[0].id;
    $(`.tooltip[data-target-element-id='${tooltipTarget}']`).remove();
});

ph.registerCallbacks("dialogSort_applied", () => {
    ph_material.toast("New sorting pattern applied.");
});

ph.registerCallbacks("dialogSort_cancelled", () => {

});