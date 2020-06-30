var layout_styles = ["grid", "details"]

ph.registerHandler("buildActionPanelDirectoryListSeparator", function() {
    var s = document.createElement("div");
    s.classList.add("folder_separator", "material-icons");
    s.innerText = "keyboard_arrow_right";
    return s;
}, true);

ph.registerHandler("actionPanelSelect", (target) => {
    switch (target.getAttribute("data-selection")) {
        case "layoutSwitch": {
            let menu = document.createElement("ul");

            menu.classList.add("mdl-menu", "mdl-menu--bottom-right", "mdl-js-menu", "mdl-js-ripple-effect");
            menu.setAttribute("for", target.id);

            for (let style of layout_styles) {
                let item = document.createElement("li");

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
            componentHandler.upgradeDom();
            break;
        }
    }
}, true);