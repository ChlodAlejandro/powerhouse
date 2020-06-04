// dependencies: ["widgets/dynamic/widget_dialog.js"]

class DialogNewFolder {

    static buildDialog(currentDirectory) {
        var t = document.createElement("h3");

        var f = document.createElement("form");
        var f_i = document.createElement("div");
        var f_i_i = document.createElement("input");
        var f_i_l = document.createElement("label");
        var f_b = document.createElement("div");
        var f_b_c = document.createElement("button");
        var f_b_s = document.createElement("button");

        t.innerText = "New Folder";
        f.name = "newFolderForm";
        f.setAttribute("method", "POST");
        // noinspection JSUnresolvedVariable
        f.setAttribute("action", POWERHOUSE_HTTP_ROOT + "/api/POST/mkdir.php");
        f.setAttribute("enctype", "application/x-www-form-urlencoded");

        f_i.classList.add("dialog-new-folder-name-input");
        f_i_i.setAttribute("type", "text");
        f_i_i.setAttribute("id", "dialogNewFolder_folderName");
        f_i_i.setAttribute("name", "ph_folderName");
        f_i_l.setAttribute("for", "dialogNewFolder_folderName");
        f_i_l.innerText = "Folder Name";

        f_b.classList.add("dialog-new-folder-actions");
        f_b_c.classList.add("dialog-new-folder-cancel");
        f_b_c.innerText = "Cancel";
        f_b_c.addEventListener("click", () => {
            DialogWidget.close(f.parentElement.id);
        });
        f_b_c.setAttribute("type", "button");

        f_b_s.name = "submit";
        f_b_s.classList.add("dialog-new-folder-submit");
        f_b_s.innerText = "Create";

        f_b.appendChild(f_b_s);
        f_b.appendChild(f_b_c);

        f_i.appendChild(f_i_i);
        f_i.appendChild(f_i_l);

        f.append(f_i);
        f.append(f_b);

        return new DialogContent([t, f]);
    }

}