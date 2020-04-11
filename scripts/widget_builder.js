function buildFiles(targetDOM, filelist) {
    var files = {};
    var directories = {};
    for (var fsobj of Object.keys(filelist).sort((a, b) => a.localeCompare(b))) {
        if (filelist.hasOwnProperty(fsobj)) {
            if (filelist[fsobj]["type"] === "dir")
                directories[fsobj] = filelist[fsobj];
            else
                files[fsobj] = filelist[fsobj];
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
}