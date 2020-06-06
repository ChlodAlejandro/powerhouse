class PowerhouseFileManager {

    prepareFileList() {
        this.fileList = document.getElementById("files");
        this.fileList.setAttribute("data-layout", ph.config.DEFAULT_DISPLAY);

        this.fileList.addEventListener("click", (e) => {
            console.log(e);
            var fileList = document.getElementById("fileList");

            // noinspection JSUnresolvedVariable
            if (e.target === fileList
                || e.target.classList.contains("files_select_clear")
                || e.target.parentElement.classList.contains("files_select_clear")) {
                $(fileList).children(".file").each((i, el) => {
                    el.classList.remove("selected");
                });
            }
        });

        ph.triggerCallbacks("fileListPrepared", this.fileList);
    }

    async getFileList(directory = "") {
        var filesList = undefined;

        await axios.get(
            POWERHOUSE_ENDPOINTS.GET["files/list"],
            {
                params: {
                    dir: directory ? directory : undefined
                },
                responseType: "json"
            }
        ).then(function (response) {
            filesList = response.data["files"];
        }).catch(handleError);

        return filesList;
    }

    async updateFileList(directory = CURRENT_DIRECTORY) {
        ph.triggerCallbacks("updateFileListBegin");

        var files = await this.getFileList(directory);
        if (files !== undefined) {
            var fileList = document.getElementById("fileList");
            fileList.innerHTML = "";
            this.buildFiles(fileList, files);
        } else
            ph.triggerCallbacks("updateFileListError");

        ph.triggerCallbacks("updateFileListEnd");

        return files !== undefined;
    }

    selectAllFiles() {
        if (this.fileList !== undefined)
            $(this.fileList).find("#fileList").children(".file").each(
                (i, e) => {
                    console.log(e);
                    e.classList.add("selected");
                    ph.triggerCallbacks("fileSelected", e);
                });
    }

    buildFiles(targetDOM, fileList) {
        if (Object.keys(fileList).length > 0) {
            var files = {};
            var directories = {};

            for (var fsobj of Object.keys(fileList).sort((a, b) => a.localeCompare(b))) {
                if (fileList.hasOwnProperty(fsobj)) {
                    if (fileList[fsobj]["type"] === "dir")
                        directories[fsobj] = fileList[fsobj];
                    else
                        files[fsobj] = fileList[fsobj];
                }
            }

            for (var directory in directories) {
                if (directories.hasOwnProperty(directory)) {
                    targetDOM.appendChild((new FileWidget({
                        "name": directory,
                        ...directories[directory]
                    })).render());
                }
            }

            for (var file in files) {
                if (files.hasOwnProperty(file)) {
                    targetDOM.appendChild((new FileWidget({
                        "name": file,
                        ...files[file]
                    })).render());
                }
            }
        } else {
            var notice = document.createElement("div");
            var n_i = document.createElement("div"); // to be set by theme. by default contains no content.
            var n_s = document.createElement("h2");
            var n_d = document.createElement("p");

            notice.classList.add("notice", "no-files");
            n_i.classList.add("notice-icon");
            n_s.classList.add("notice-summary");
            n_d.classList.add("notice-description");

            n_s.innerText = "No Files";
            n_d.innerText = "This folder is empty. You should probably put something in it.";

            notice.appendChild(n_i);
            notice.appendChild(n_s);
            notice.appendChild(n_d);

            targetDOM.appendChild(notice);
        }
    }
}

ph.file_manager = new PowerhouseFileManager();