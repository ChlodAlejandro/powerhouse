var previousDirectories = [CURRENT_DIRECTORY];

function cleanDirectoryPath(directory) {
    var newPath = directory;

    var leadingSlashClear = /^\/+(.+?)/g.exec(newPath);
    if (leadingSlashClear !== null)
        newPath = leadingSlashClear[1];

    var trailingSlashClear = /(.+?)\/+$/g.exec(newPath);
    if (trailingSlashClear !== null)
        newPath = trailingSlashClear[1];

    return newPath;
}

function cleanCurrentDirectory() {
    CURRENT_DIRECTORY = cleanDirectoryPath(CURRENT_DIRECTORY);
}

cleanCurrentDirectory();

function getTitle(directoryPath) {
    if (directoryPath.length === 0)
        return "Powerhouse";
    else return directoryPath.split("/").pop() + " | Powerhouse";
}

async function enterDirectory(directoryPath) {
    var newDirectory = directoryPath;
    console.log("Entering " + newDirectory + "...");

    newDirectory = cleanDirectoryPath(directoryPath);
    if (newDirectory === null || newDirectory === undefined)
        newDirectory = directoryPath;

    if (await updateFileList(newDirectory)) {
        var pageTitle = getTitle(newDirectory);
        window.history.pushState({
            page: previousDirectories.length
        }, pageTitle, `${POWERHOUSE_HTTP_ROOT}/${POWERHOUSE_FILES_SHORTHAND}/${newDirectory}`);
        document.title = pageTitle;

        previousDirectories.push(newDirectory);

        CURRENT_DIRECTORY = newDirectory;
        cleanCurrentDirectory();

        buildActionPanelDirectoryList(CURRENT_DIRECTORY);
        triggerCallbacks("directoryChanged", CURRENT_DIRECTORY);
    } else {
        console.log("Couldn't enter " + newDirectory + ".");
    }
}

window.onpopstate = (e) => {
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

        triggerCallbacks("directoryChanged", CURRENT_DIRECTORY);
    }
};