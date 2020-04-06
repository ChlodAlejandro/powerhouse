async function getFileList(directory = "") {
    const queryParameters = new URLSearchParams();

    if (directory !== "")
        queryParameters.append("directory", directory);

    // noinspection JSUnresolvedVariable
    var filesList;

    // noinspection JSUnresolvedVariable
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