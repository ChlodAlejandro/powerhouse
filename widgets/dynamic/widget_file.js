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
        /*
        <div class="file">
            <meta name="type" content="file">
            <meta name="size" content="124982">
            <meta name="mtime" content="2141782">
            <meta name="ctime" content="21417821541">
            <img class="icon" src="images/md_ico/file.svg" alt="file">
            <p class="name file_name">testfile.file</p>
        </div>
         */
        var file_container = document.createElement("div");

        var file_container_type = document.createElement("meta");
        var file_container_size = document.createElement("meta");
        var file_container_mtime = document.createElement("meta");
        var file_container_ctime = document.createElement("meta");
        var file_container_icon = document.createElement("img");
        var file_container_name = document.createElement("p");

        file_container_type.setAttribute("name", "type");
        file_container_type.setAttribute("content", this.type);

        file_container_size.setAttribute("name", "size");
        file_container_size.setAttribute("content", this.size);

        file_container_mtime.setAttribute("name", "mtime");
        file_container_mtime.setAttribute("content", this.size);

        file_container_ctime.setAttribute("name", "ctime");
        file_container_ctime.setAttribute("content", this.size);

        file_container_icon.classList.add("icon");
        file_container_icon.setAttribute("src", /*getIcon(filename)*/ "images/md_ico/file.svg");
        file_container_icon.setAttribute("alt", this.type + " icon");

        file_container_name.classList.add("name");
        file_container_name.classList.add("file_name");
        file_container_name.innerHTML = this.name;
    }

}