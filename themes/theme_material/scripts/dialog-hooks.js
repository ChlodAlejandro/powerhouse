var dialogPreProcess = (dialogName, dialogContainer) => {
    if (dialogName === "newFolder") {
/*
<div id="dialogNewFolderContainer" class="dialog_container">
    <div id="dialogNewFolder" class="dialog">
        <h3>New Folder</h3><br/>
        <form name="newFolderForm" method="POST" action="browse/mkdir.php" enctype="application/x-www-form-urlencoded">
            <div class="new-folder-name-input mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input" type="text" id="folderName" name="folderName">
                <label class="mdl-textfield__label" for="folderName">Folder Name</label>
            </div>
            <button name="submit" class="new-folder-submit mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--colored">
                Create
            </button>
        </form>
    </div>
</div>
 */
        let inputBody = $(dialogContainer).find("div.dialog-new-folder-name-input");
        inputBody[0].classList.add("mdl-textfield", "mdl-js-textfield", "mdl-textfield--floating-label");
        let inputFolderName = inputBody.find("input")[0];
        inputFolderName.classList.add("mdl-textfield__input");
        let labelFolderName = inputBody.find("label")[0];
        labelFolderName.classList.add("mdl-textfield__label");

        let submit = $(dialogContainer).find(".dialog-new-folder-submit")[0];
        submit.classList.add("mdl-button", "mdl-js-button", "mdl-button--raised", "mdl-js-ripple-effect",
            "mdl-button--colored");

        let cancel = $(dialogContainer).find(".dialog-new-folder-cancel")[0];
        cancel.classList.add("mdl-button", "mdl-js-button", "mdl-js-ripple-effect");
    } else if (dialogName === "error") {
        let ok = $(dialogContainer).find(".dialog_error_ok")[0];
        ok.classList.add("mdl-button", "mdl-js-button", "mdl-button--raised", "mdl-js-ripple-effect",
            "mdl-button--colored");
    }
};

var dialogPostProcess = (dialogName, dialogContainer) => {
    componentHandler.upgradeDom();
}