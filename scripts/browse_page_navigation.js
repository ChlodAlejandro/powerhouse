class PowerhousePageNavigator {

    constructor() {
        this.previousDirectories = [CURRENT_DIRECTORY];
        this.cleanCurrentDirectory();

        window.onpopstate = (e) => {
            console.log(e);
            console.log(this.previousDirectories);
            if (this.previousDirectories.length === 0) {
                return true;
            } else {
                this.previousDirectories.pop();
                CURRENT_DIRECTORY = this.previousDirectories[this.previousDirectories.length - 1];
                this.cleanCurrentDirectory();
                document.title = this.getDirectoryPageTitle(CURRENT_DIRECTORY);

                // noinspection JSIgnoredPromiseFromCall
                ph.file_manager.updateFileList();
                ph.action_panel.buildActionPanelDirectoryList(CURRENT_DIRECTORY);

                ph.triggerCallbacks("directoryChanged", CURRENT_DIRECTORY);
            }
        };
    }

    cleanDirectoryPath(directory) {
        var newPath = directory;

        var leadingSlashClear = /^\/+(.+?)/g.exec(newPath);
        if (leadingSlashClear !== null)
            newPath = leadingSlashClear[1];

        var trailingSlashClear = /(.+?)\/+$/g.exec(newPath);
        if (trailingSlashClear !== null)
            newPath = trailingSlashClear[1];

        return newPath;
    }

    cleanCurrentDirectory() {
        CURRENT_DIRECTORY = this.cleanDirectoryPath(CURRENT_DIRECTORY);
    }

    getDirectoryPageTitle(directoryPath) {
        if (directoryPath.length === 0)
            return "Powerhouse";
        else return directoryPath.split("/").pop() + " | Powerhouse";
    }

    async enterDirectory(directoryPath) {
        var newDirectory = directoryPath;
        console.log("Entering " + newDirectory + "...");

        newDirectory = this.cleanDirectoryPath(directoryPath);
        if (newDirectory === null || newDirectory === undefined)
            newDirectory = directoryPath;

        if (await this.updateFileList(newDirectory)) {
            var pageTitle = this.getDirectoryPageTitle(newDirectory);
            window.history.pushState({
                page: this.previousDirectories.length
            }, pageTitle, `${POWERHOUSE_HTTP_ROOT}/${POWERHOUSE_FILES_SHORTHAND}/${newDirectory}`);
            document.title = pageTitle;

            this.previousDirectories.push(newDirectory);

            CURRENT_DIRECTORY = newDirectory;
            this.cleanCurrentDirectory();

            ph.action_panel.buildActionPanelDirectoryList(CURRENT_DIRECTORY);
            ph.triggerCallbacks("directoryChanged", CURRENT_DIRECTORY);
        } else {
            console.log("Couldn't enter " + newDirectory + ".");
        }
    }

}

ph.page_navigation = new PowerhousePageNavigator();