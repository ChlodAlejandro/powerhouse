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