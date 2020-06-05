ph.registerCallbacks("actionPanelDirectoryPostBuild", () => {
    var dl = document.querySelector("#ap_directory_list");
    $(document.getElementById("ap_directory_list_dropdown")).remove();

    var problematic = [];
    for (var i = 0; i < dl.childElementCount; i++) {
        if (dl.children[i].offsetTop + dl.children[i].offsetHeight >
            dl.offsetTop + dl.offsetHeight ||
            dl.children[i].offsetLeft + dl.children[i].offsetWidth >
            dl.offsetLeft + dl.offsetWidth) {

            problematic.push(dl.children[i]);
        }
    }

    if (problematic.length > 0) {
        for (let child of problematic) {
            dl.removeChild(child);
        }

        var lastChild;
        while (dl.lastElementChild.classList.contains("folder-separator"))
            dl.removeChild(dl.lastChild);

        lastChild = dl.removeChild(dl.lastChild);

        problematic = [lastChild, ...problematic];
        problematic = problematic.filter((v) => {
            return v.getAttribute("data-target-directory") !== null;
        });

        dl.appendChild(ph.callHandler("buildActionPanelDirectoryListSeparator"));

        var m = document.createElement("div");
        m.id = "ap_directory_list_expand";
        m.classList.add("material-icons");
        m.innerHTML = "more_horiz";
        dl.appendChild(m);

        var d = document.createElement("ul");

        d.id = "ap_directory_list_dropdown";
        d.classList.add("mdl-menu", "mdl-menu--bottom-left", "mdl-js-menu", "mdl-js-ripple-effect");
        d.setAttribute("for", "ap_directory_list_expand");

        for (let target of problematic) {
            let t = document.createElement("li");
            let t_i = document.createElement("span");
            let t_n = document.createElement("span");

            t.classList.add("mdl-menu__item");
            t.setAttribute("data-target-directory",
                target.getAttribute("data-target-directory"));

            t_i.classList.add("icon", "material-icons");
            t_i.innerHTML = "folder";

            t_n.innerText = target.innerText;

            t.appendChild(t_i);
            t.appendChild(t_n);

            d.appendChild(t);
        }

        for (let part of d.children) {
            if (part.getAttribute("data-target-directory") === CURRENT_DIRECTORY)
                continue;
            part.addEventListener("click", () => {
                enterDirectory(part.getAttribute("data-target-directory"));
            });
        }

        document.body.appendChild(d);

        componentHandler.upgradeDom();
    }
});