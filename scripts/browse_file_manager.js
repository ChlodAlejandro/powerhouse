class PowerhouseFileManager {

    static getSortVariables() {
        if (PowerhouseFileManager.fieldSort === undefined)
            PowerhouseFileManager.fieldSort = (field, fileA, fileB) => {
                if (typeof fileA[field] === "string" && typeof fileB[field] === "string") {
                    return fileA[field].toLowerCase() === fileB[field].toLowerCase() ? 0 :
                        (fileA[field].toLowerCase() < fileB[field].toLowerCase() ? -1 : 1);
                } else
                    return fileA[field] === fileB[field] ? 0 :
                        (fileA[field] < fileB[field] ? -1 : 1);
            };
        if (PowerhouseFileManager.dirSort === undefined)
            PowerhouseFileManager.dirSort = (fileA, fileB, fallbackFieldSort = "name") => {
                if (fileA.type === "dir" && fileB.type === "file")
                    return -1;
                else if (fileB.type === "dir" && fileA.type === "file")
                    return 1;
                else if (equalsAll("dir", fileA, fileB))
                    return this.fieldSort(fallbackFieldSort, fileA, fileB);
                else return false;
            };

        return [
            {
                title: "Name",
                variable: "name",
                type: "string",
                sortingFunction: (fileA, fileB) => {
                    var ds = this.dirSort(fileA, fileB);
                    if (ds === false)
                        return this.fieldSort("name", fileA, fileB);
                    else return ds;
                }
            },
            {
                title: "Size",
                variable: "size",
                type: "number",
                sortingFunction: (fileA, fileB) => {
                    var ds = this.dirSort(fileA, fileB, "size");
                    if (ds === false)
                        return this.fieldSort("size", fileA, fileB);
                    else return ds;
                }
            },
            {
                title: "Modified Time",
                variable: "mtime",
                type: "date",
                sortingFunction: (fileA, fileB) => {
                    var ds = this.dirSort(fileA, fileB, "mtime");
                    if (ds === false)
                        return this.fieldSort("mtime", fileA, fileB);
                    else return ds;
                }
            },
            {
                title: "Created Time",
                variable: "ctime",
                type: "date",
                sortingFunction: (fileA, fileB) => {
                    var ds = this.dirSort(fileA, fileB, "ctime");
                    if (ds === false)
                        return this.fieldSort("ctime", fileA, fileB);
                    else return ds;
                }
            },
            {
                title: "Extension",
                variable: "ext",
                type: "string",
                sortingFunction: (fileA, fileB) => {
                    var ds = this.dirSort(fileA, fileB, "name");
                    if (ds !== false)
                        return ds;

                    var extA =  /(?:\.([^.]+))?$/.exec(fileA.name)[1];
                    var extB =  /(?:\.([^.]+))?$/.exec(fileB.name)[1];

                    if (u(extA) && !u(extB))
                        return 1;
                    else if (!u(extA) && u(extB))
                        return -1;
                    else if (u(extA) && u(extB))
                        return 0;

                    return extA.toLowerCase() === extB.toLowerCase() ? 0 :
                        (extA.toLowerCase() < extB.toLowerCase() ? -1 : 1);
                }
            }
        ];
    }

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

    buildFiles(targetDOM, fileList, sortOptions) {
        targetDOM.innerHTML = "";

        if (fileList.length > 0) {
            fileList = this.sort(fileList, sortOptions);

            for (var file of fileList) {
                targetDOM.appendChild((new FileWidget({
                    ...file
                })).render());
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

        this.currentFileList = fileList;
    }

    sort(fileList, sortOptions) {
        var patternList;
        var patterns;
        if (u(sortOptions)) {
            patternList = PowerhouseFileManager.getSortVariables();
            patterns = !u(this.currentSortPattern) ? this.currentSortPattern : ph.config.DEFAULT_SORT_PATTERN;
        } else {
            patternList = sortOptions.patternList;
            patterns = sortOptions.patterns;

            this.currentSortPattern = patterns;
        }

        fileList.sort((fileA, fileB) => {
            for (let pattern of patterns) {
                var res = patternList
                    .find(e => e.variable === pattern.variable)
                    .sortingFunction(fileA, fileB);

                if (res !== 0)
                    return pattern.direction === "a" ? res : res * -1;
            }
            return 0;
        });

        return fileList;
    }
}

ph.file_manager = new PowerhouseFileManager();