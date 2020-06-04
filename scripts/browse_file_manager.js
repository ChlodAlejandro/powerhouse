async function getFileList(directory = "") {
    const queryParameters = new URLSearchParams();

    if (directory !== "")
        queryParameters.append("dir", directory);

    var filesList = undefined;

    await axios.get(
        `${POWERHOUSE_HTTP_ROOT}/api/GET/files`
            + (directory !== "" ? `?${queryParameters.toString()}` : ""),
        {
            responseType: "json"
        }
    ).then(function (response) {
        filesList = response.data["files"];
    }).catch(function (e) {
        handleError(e);
    });

    return filesList;
}

async function updateFileList(directory = CURRENT_DIRECTORY) {
    triggerCallbacks("updateFileListBegin");

    var files = await getFileList(directory);
    if (files !== undefined) {
        var fileList = document.getElementById("fileList");
        fileList.innerHTML = "";
        buildFiles(fileList, files);
    } else
        triggerCallbacks("updateFileListError");

    triggerCallbacks("updateFileListEnd");

    return files !== undefined;
}