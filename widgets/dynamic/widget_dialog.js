class DialogContent {

    constructor(domContent) {
        if (domContent instanceof Element)
            this.content = [domContent];
        else if (Array.isArray(domContent)) {
            for (var element of domContent) {
                if (!(element instanceof Element))
                    throw new Error("domContent array does not contain Element objects.");
            }
            this.content = domContent;
        } else throw new Error("Invalid domContent (must be Element or [Element])");
    }

}

class DialogWidget {

    static getDialogStyle(dialogName) {
        if (document.getElementById(`dialogStylesheet_${dialogName}`) == null) {
            var tag = document.createElement("link");

            tag.id = (`dialogStylesheet_${dialogName}`);
            tag.setAttribute("type", "text/css");
            tag.setAttribute("rel", "stylesheet");
            tag.setAttribute("href", ph.asset_manager.getThemeCSS("dialogs", "dialog_" + dialogName));

            document.head.appendChild(tag);
        }
    }

    static close(dialogId) {
        var d = document.getElementById(dialogId);
        d.parentElement.addEventListener("animationend", (event) => {
            // noinspection JSUnresolvedVariable
            d.parentNode.parentNode.removeChild(d.parentNode);
        });
        d.parentElement.classList.remove("shown");
    }

    constructor(name, content, options = {}) {
        this.name = name;
        DialogWidget.getDialogStyle(name);

        if (!(content instanceof DialogContent)) {
            throw new Error("Content provided for DialogWidget is not of the type DialogContent.")
        }

        this.content = content;
        if (this.options !== undefined && typeof this.options !== "object")
            throw new Error("Widget options must either be undefined or an object.");
        this.options = options;
    }

    render() {
        var dialogContainerId = (this.name)[0].toUpperCase() + this.name.substring(1) + "Container";
        var dialogId = (this.name)[0].toUpperCase() + this.name.substring(1);

        var finalDialogContainerId = "dialog" + dialogContainerId;
        var finalContainerId = "dialog" + dialogId;

        if (!this.options["stackable"]) {
            if (document.getElementById(finalContainerId) !== null)
                throw new Error("Dialog is already open.");
        } else {
            if (document.getElementById(finalContainerId) !== null) {
                var identification = Math.floor(Math.random() * 1000000);

                dialogContainerId += `_${identification}`;
                dialogId += `_${identification}`;

                finalDialogContainerId = "dialog" + dialogContainerId;
                finalContainerId = "dialog" + dialogId;
            }
        }

        var dialog_container = document.createElement("div");
        var dialog = document.createElement("div");

        dialog_container.classList.add("dialog_container");
        dialog_container.classList.add("dialog_container_" + this.name);
        dialog_container.classList.add("shown");
        dialog_container.setAttribute("id", finalDialogContainerId);

        dialog.classList.add("dialog");
        dialog.classList.add("dialog_" + this.name);
        dialog.setAttribute("id", finalContainerId);

        for (var child of this.content.content)
            dialog.appendChild(child);
        dialog_container.appendChild(dialog);

        ph.triggerCallbacks("dialogPreProcess", this.name, dialog_container);

        document.body.append(dialog_container);

        ph.triggerCallbacks("dialogPostProcess", this.name, dialog_container);
    }

}