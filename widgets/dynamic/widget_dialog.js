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

    static close(dialogId) {
        var d = document.getElementById(dialogId);
        d.parentElement.addEventListener("animationend", (event) => {
            // noinspection JSUnresolvedVariable
            d.parentNode.parentNode.removeChild(d.parentNode);
        });
        d.parentElement.classList.remove("shown");
    }

    constructor(name, content) {
        this.name = name;

        if (!(content instanceof DialogContent)) {
            throw new Error("Content provided for DialogWidget is not of the type DialogContent.")
        }

        this.content = content;
    }

    render() {
        var dialogContainerId = (this.name)[0].toUpperCase() + this.name.substring(1) + "Container";
        var dialogId = (this.name)[0].toUpperCase() + this.name.substring(1);

        if (document.getElementById(this.name) !== null)
            throw new Error("Dialog is already open.");

        var dialog_container = document.createElement("div");
        var dialog = document.createElement("div");

        dialog_container.classList.add("dialog_container");
        dialog_container.classList.add("shown");
        dialog_container.setAttribute("id", "dialog" + dialogContainerId);

        dialog.classList.add("dialog");
        dialog.setAttribute("id", "dialog" + dialogId);

        for (var child of this.content.content)
            dialog.appendChild(child);
        dialog_container.appendChild(dialog);

        if (typeof dialogPreProcess === "function")
            dialogPreProcess(this.name, dialog_container);

        document.body.append(dialog_container);

        if (typeof dialogPostProcess === "function")
            dialogPostProcess(this.name, dialog_container);
    }

}