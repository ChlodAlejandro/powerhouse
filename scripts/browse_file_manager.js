async function getFileList(directory = "") {
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