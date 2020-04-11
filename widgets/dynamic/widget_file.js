'use strict';

class FileWidget {

    constructor(options) {
        if (options["name"] === undefined
            || (options["type"] !== "dir" && options["type"] !== "file")
            || typeof(options["size"]) !== "number"
            || typeof(options["mtime"]) !== "number"
            || typeof(options["ctime"]) !== "number") {
            handleError(new Error(
                "One of the FileWidget arguments were undefined or invalid."
            ));
        } else {
            this.name = options["name"];
            this.type = options["type"];
            this.size = options["size"];
            this.mtime = options["mtime"];
            this.ctime = options["ctime"];

        }
    }

    render() {
        var file_container = document.createElement("div");

        var file_container_type = document.createElement("meta");
        var file_container_size = document.createElement("meta");
        var file_container_mtime = document.createElement("meta");
        var file_container_ctime = document.createElement("meta");
        var file_container_icon = document.createElement("img");
        var file_container_name = document.createElement("p");

        file_container.classList.add("file");

        file_container_type.setAttribute("name", "type");
        file_container_type.setAttribute("content", this.type);

        file_container_size.setAttribute("name", "size");
        file_container_size.setAttribute("content", this.size);

        file_container_mtime.setAttribute("name", "mtime");
        file_container_mtime.setAttribute("content", this.size);

        file_container_ctime.setAttribute("name", "ctime");
        file_container_ctime.setAttribute("content", this.size);

        file_container_icon.classList.add("icon");
        file_container_icon.setAttribute("src", /*getIcon(filename)*/
            this.type === "file" ? "images/md_ico/file.svg" : "images/md_ico/folder.svg");
        file_container_icon.setAttribute("alt", this.type + " icon");

        file_container_name.classList.add("name");
        file_container_name.classList.add("file_name");
        file_container_name.innerHTML = this.name;

        file_container.appendChild(file_container_type);
        file_container.appendChild(file_container_size);
        file_container.appendChild(file_container_mtime);
        file_container.appendChild(file_container_ctime);
        file_container.appendChild(file_container_icon);
        file_container.appendChild(file_container_name);

        return file_container;
    }

}