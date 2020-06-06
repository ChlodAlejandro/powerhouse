'use strict';

function formatBytes(bytes, decimals = 2) {
    if (bytes === 0) return '0 B';

    const k = 1024;
    const dm = decimals < 0 ? 0 : decimals;
    const sizes = ['B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];

    const i = Math.floor(Math.log(bytes) / Math.log(k));

    return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
}

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

        var file_container_icon = document.createElement("img");
        var file_container_name = document.createElement("span");
        var file_container_type = document.createElement("span");
        var file_container_size = document.createElement("span");
        var file_container_mtime = document.createElement("span");
        var file_container_ctime = document.createElement("span");

        file_container.classList.add("file");

        if (this.type !== "file") {
            file_container.classList.add("dir");
        }

        file_container_icon.classList.add("file_icon");
        file_container_icon.setAttribute("src", /*getIcon(filename)*/
            this.type === "file" ?
                ph.asset_manager.getPath("images/md_ico/file.svg") :
                ph.asset_manager.getPath("images/md_ico/folder.svg"));
        file_container_icon.setAttribute("alt", this.type + " icon");

        file_container_name.classList.add("file_name");
        file_container_name.innerHTML = this.name;

        file_container_type.classList.add("file_type");
        file_container_type.setAttribute("name", "type");
        file_container_type.setAttribute("content", this.type);
        file_container_type.innerHTML = this.type.substring(0, 1).toUpperCase() + this.type.substring(1);

        file_container_size.classList.add("file_size");
        file_container_size.setAttribute("name", "size");
        file_container_size.setAttribute("content", this.size);
        file_container_size.innerHTML = this.type === "file" ? formatBytes(this.size) : "";

        file_container_mtime.classList.add("file_mtime");
        file_container_mtime.setAttribute("name", "mtime");
        file_container_mtime.setAttribute("content", this.mtime);
        file_container_mtime.innerHTML = new Date(this.mtime * 1000).toLocaleString();

        file_container_ctime.classList.add("file_ctime");
        file_container_ctime.setAttribute("name", "ctime");
        file_container_ctime.setAttribute("content", this.ctime);
        file_container_ctime.innerHTML = new Date(this.ctime * 1000).toLocaleString();

        file_container.addEventListener("click", async () => {
            if (file_container.classList.contains("selected")) {
                if (file_container.hasAttribute("data-sel-time")) {
                    var selectTime = file_container.getAttribute("data-sel-time");
                    if (!Number.isNaN(+(selectTime))) {
                        if ((Date.now() - selectTime) >= ph.config.FOLDER_OPEN_TIME) {
                            file_container.classList.remove("selected");
                            ph.triggerCallbacks("fileDeselected", file_container);
                        } else {
                            if (file_container.classList.contains("dir"))
                                await ph.navigation.enterDirectory(
                                    (CURRENT_DIRECTORY.length > 0 ? `${CURRENT_DIRECTORY}/` : "") +
                                    `${this.name}`);
                            // else open file preview window
                        }
                    } else
                        file_container.classList.remove("selected");
                } else
                    file_container.classList.remove("selected");
            } else {
                file_container.classList.add("selected");
                file_container.setAttribute("data-sel-time", `${Date.now()}`);

                ph.triggerCallbacks("fileSelected", file_container);
            }
        });

        file_container.appendChild(file_container_icon);
        file_container.appendChild(file_container_name);
        file_container.appendChild(file_container_type);
        file_container.appendChild(file_container_size);
        file_container.appendChild(file_container_mtime);
        file_container.appendChild(file_container_ctime);

        return file_container;
    }

}