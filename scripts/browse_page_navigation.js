var previousDirectories = [CURRENT_DIRECTORY];

function cleanCurrentDirectory() {
    var leadingSlashClear = /\/+(.+?)/g.exec(CURRENT_DIRECTORY);
    if (leadingSlashClear !== null)
        CURRENT_DIRECTORY = leadingSlashClear[1];

    var trailingSlashClear = /(.+?)\/+/g.exec(CURRENT_DIRECTORY);
    if (trailingSlashClear !== null)
        CURRENT_DIRECTORY = trailingSlashClear[1];
}

function getTitle(directoryPath) {
    if (directoryPath.length === 0)
        return "Powerhouse";
    else return directoryPath.split("/").pop() + " | Powerhouse";
}

function enterDirectory(directoryPath) {
    var pageTitle = getTitle(directoryPath);
    window.history.pushState({
        page: previousDirectories.length
    }, pageTitle, `${POWERHOUSE_HTTP_ROOT}/${POWERHOUSE_FILES_SHORTHAND}/${directoryPath}`);
    document.title = pageTitle;

    previousDirectories.push(directoryPath);

    CURRENT_DIRECTORY = directoryPath;
    cleanCurrentDirectory();
    // noinspection JSIgnoredPromiseFromCall
    updateFileList();
    buildActionPanelDirectoryList(CURRENT_DIRECTORY);
}

window.onpopstate = function(e){
    console.log(e);
    console.log(previousDirectories);
    if (previousDirectories.length === 0) {
        return true;
    } else {
        previousDirectories.pop();
        CURRENT_DIRECTORY = previousDirectories[previousDirectories.length - 1];
        cleanCurrentDirectory();
        document.title = getTitle(CURRENT_DIRECTORY);

        // noinspection JSIgnoredPromiseFromCall
        updateFileList();
        buildActionPanelDirectoryList(CURRENT_DIRECTORY);
    }
    console.log(previousDirectories);
};