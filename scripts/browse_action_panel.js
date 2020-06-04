function handleActionPanelOption(target) {
    switch (target.getAttribute("data-ap-option-type")) {
        case "select":
            callHandler("actionPanelSelect", target);
            break;
        case "dialog":
            handleActionPanelDialog(target);
            break;
    }
}

function handleActionPanelDialog(target) {
    switch (target.getAttribute("data-dialog")) {
        case "newFolder": {
            target.addEventListener("click", () => {
                new DialogWidget("newFolder", DialogNewFolder.buildDialog(CURRENT_DIRECTORY)).render();
            });
            break;
        }
        case "upload": {

            break;
        }
    }
}

var options = $("#ap_options").children();

options.each((i, e) => {
    handleActionPanelOption(e);
});

function buildActionPanelDirectoryList(targetDirectory) {
    var directoryList = document.getElementById("ap_directory_list");

    var m = document.createElement("div");
    m.classList.add("main");
    m.setAttribute("data-target-directory", "");
    m.innerText = "Main folder";

    var targets = [m];

    var tree = "";
    var treeParts = targetDirectory.split("/");
    for (var i in treeParts) {
        if (treeParts.hasOwnProperty(i)) {
            if (treeParts[i].trim().length === 0)
                continue;
            var d = document.createElement("div");
            var nextDir = `${tree.length > 0 ? `${tree}/` : ""}${treeParts[i]}`;
            d.setAttribute("data-target-directory", nextDir);
            tree = nextDir;
            d.innerText = treeParts[i];
            targets.push(d);
        }
    }

    directoryList.innerHTML = "";
    for (var t in targets) {
        if (targets.hasOwnProperty(t)) {
            directoryList.appendChild(targets[t]);
            directoryList.appendChild(callHandler("buildActionPanelDirectoryListSeparator"));
        }
    }
    directoryList.removeChild(directoryList.lastChild);

    upgradeActionPanelDirectoryList();
    triggerCallbacks("actionPanelDirectoryPostBuild");
}

function upgradeActionPanelDirectoryList() {
    var parts = document.querySelectorAll("#ap_directory_list [data-target-directory]");
    for (let part of parts) {
        if (parts[parts.length - 1] === part)
            continue;
        part.addEventListener("click", () => {
            // noinspection JSIgnoredPromiseFromCall
            enterDirectory(part.getAttribute("data-target-directory"));
        });
    }
}