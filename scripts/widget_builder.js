function buildFiles(targetDOM, fileList) {
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