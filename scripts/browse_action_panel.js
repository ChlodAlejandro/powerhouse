const layout_styles = ["grid", "details"];

function handleActionPanelSelect(target) {
    switch (target.getAttribute("data-selection")) {
        case "layoutSwitch": {
            /*
<ul class="mdl-menu mdl-menu--bottom-right mdl-js-menu mdl-js-ripple-effect"
    for="demo-menu-lower-right">
  <li class="mdl-menu__item">Some Action</li>
  <li class="mdl-menu__item">Another Action</li>
  <li disabled class="mdl-menu__item">Disabled Action</li>
  <li class="mdl-menu__item">Yet Another Action</li>
</ul>
             */
            var menu = document.createElement("ul");

            menu.classList.add("mdl-menu", "mdl-menu--bottom-right", "mdl-js-menu", "mdl-js-ripple-effect");
            menu.setAttribute("for", target.id);

            for (var style of layout_styles) {
                var item = document.createElement("li");

                item.classList.add("mdl-menu__item");
                item.innerText = style[0].toUpperCase() + style.substr(1);
                item.addEventListener("click", (event) => {
                    // noinspection JSUnresolvedVariable
                    document.getElementById("files").setAttribute("data-layout",
                        event.target.innerText.toLowerCase());
                });

                menu.appendChild(item);
            }

            document.body.appendChild(menu);

            break;
        }
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

console.log(options);
options.each((i, e) => {
    switch (e.getAttribute("data-ap-option-type")) {
        case "select": {
            handleActionPanelSelect(e);
            break;
        }
        case "dialog": {
            handleActionPanelDialog(e);
            break;
        }
    }

});

//<div id="ap_directory_list">
//     <div class="main" data-target-directory="">Main folder</div>
//     <div class="folder_separator material-icons">keyboard_arrow_right</div>
//     <div data-target-directory="images">images</div>
//     <div class="folder_separator material-icons">keyboard_arrow_right</div>
//     <div  data-target-directory="images/sizt">sizt</div>
// </div>

if (buildActionPanelDirectoryListSeparator === undefined) {
    var buildActionPanelDirectoryListSeparator = function() {
        var s = document.createElement("div");
        s.classList.add("folder_separator");
        s.innerText = ">";
        return s;
    }
}

function buildActionPanelDirectoryList(targetDirectory) {
    var parts = targetDirectory.split("/");
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
            console.log(targets[t]);
            directoryList.appendChild(targets[t]);
            directoryList.appendChild(buildActionPanelDirectoryListSeparator());
        }
    }
    directoryList.removeChild(directoryList.lastChild);

    upgradeActionPanelDirectoryList();
}

function upgradeActionPanelDirectoryList() {
    var parts = document.querySelectorAll("#ap_directory_list [data-target-directory]");
    for (let part of parts) {
        if (parts[parts.length - 1] === part)
            continue;
        part.addEventListener("click", () => {
            enterDirectory(part.getAttribute("data-target-directory"));
        });
    }
}