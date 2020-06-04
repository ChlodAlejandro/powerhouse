const layout_styles = ["grid", "details"];
const sort_types = {
    "alpha": "Alphabetical",
    "size": "Size",
    "type": "Type",
    "mtime": "Modified Time",
    "ctime": "Created Time"
};

registerHandler("actionPanelSelect", (target) => {
    switch (target.getAttribute("data-selection")) {
        case "selectSortType": {
            let menu = document.createElement("ul");

            menu.classList.add("mdl-menu", "mdl-menu--bottom-right", "mdl-js-menu", "mdl-js-ripple-effect");
            menu.setAttribute("for", target.id);

            for (let sortType of Object.keys(sort_types)) {
                let item = document.createElement("li");

                item.classList.add("mdl-menu__item");
                item.innerText = sort_types[sortType][0].toUpperCase() + sort_types[sortType].substr(1);
                item.setAttribute("data-sort-type", sortType);

                item.addEventListener("click", (event) => {
                    // noinspection JSUnresolvedFunction
                    document.getElementById("files").setAttribute("data-sort",
                        event.target.getAttribute("data-sort-type"));
                    // noinspection JSUnresolvedFunction
                    triggerCallbacks("filesSortChange", event.target.getAttribute("data-sort-type"));
                });

                menu.appendChild(item);
            }

            document.body.appendChild(menu);
            componentHandler.upgradeElement(menu);
            break;
        }
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
            componentHandler.upgradeElement(menu);
            break;
        }
    }
}, true);