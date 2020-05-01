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

    static dialogs = [];

    constructor(name, content) {
        this.name = name;

        if (!(this.content instanceof DialogContent)) {
            throw new Error("Content provided for DialogWidget is not of the type DialogContent.")
        }

        this.content = content;
    }

    render() {
        var dialog_container = document.createElement("div");
        var dialog = document.createElement("div");

        dialog_container.classList.add("dialog_container");
        dialog_container.setAttribute("id", "dialog"
            + (this.name)[0].toUpperCase() + this.name.substring(1) + "Container");

        dialog.classList.add("dialog");
        dialog.setAttribute("id", "dialog"
            + (this.name)[0].toUpperCase() + this.name.substring(1));

        for (var child of this.content.content)
            dialog.appendChild(child);
        dialog_container.appendChild(dialog);
    }

}

