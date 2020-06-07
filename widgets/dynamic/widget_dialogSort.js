// dependencies: ["widgets/dynamic/widget_dialog.js"]

class DialogSort {

    static generateSortOptions(entriesElement) {
        var sortPattern = [];
        $(entriesElement).children(".dialog-sort-entry").each((i, e) => {
            console.log(e);
            console.log($(e).find(".dialog-sort-entry-variable"));
            sortPattern.push({
                variable: $(e).find(".dialog-sort-entry-variable select").val(),
                direction: $(e).find(".dialog-sort-entry-direction select").val()
            });
        });

        if (sortPattern.length === 0)
            sortPattern = ph.config.DEFAULT_SORT_PATTERN;

        return {
            patternList: PowerhouseFileManager.getSortVariables(),
            patterns: sortPattern
        };
    }

    static buildDialog() {
        var t = document.createElement("h3");

        t.innerText = "Sort";

        var d = document.createElement("div");

        var d_h = document.createElement("div");
        var d_e = document.createElement("div");
        var d_o = document.createElement("div");

        var d_h_e = document.createElement("div");
        var d_h_e_v = document.createElement("div");
        var d_h_e_d = document.createElement("div");
        var d_h_e_o = document.createElement("div");

        var d_o_a = document.createElement("button");
        var d_o_c = document.createElement("button");

        d_h_e.classList.add("dialog-sort-header");
        d_h_e.classList.add("dialog-sort-entry");

        d_h_e_v.classList.add("dialog-sort-entry-variable");
        d_h_e_d.classList.add("dialog-sort-entry-direction");
        d_h_e_o.classList.add("dialog-sort-entry-options");

        d_h_e_v.innerText = "Variable";
        d_h_e_d.innerText = "Direction";

        d_h_e.appendChild(d_h_e_v);
        d_h_e.appendChild(d_h_e_d);
        d_h_e.appendChild(d_h_e_o);

        d_h.appendChild(d_h_e);

        var createSortingLevel = (createOptions) => {
            var e = document.createElement("div");
            var e_v = document.createElement("div");
            var e_v_s = document.createElement("select");
            var e_d = document.createElement("div");
            var e_d_s = document.createElement("select");
            var e_o = document.createElement("div");
            var e_o_d = document.createElement("span");

            e.classList.add("dialog-sort-entry");

            e_v.classList.add("dialog-sort-entry-variable");
            e_d.classList.add("dialog-sort-entry-direction");
            e_o.classList.add("dialog-sort-entry-options");

            for (let variable of PowerhouseFileManager.getSortVariables()) {
                let o = document.createElement("option");

                o.innerText = variable.title;
                o.setAttribute("value", variable.variable);
                o.setAttribute("data-sort-type", variable.type);

                if (!nou(createOptions) && createOptions.variable === variable.variable)
                    o.toggleAttribute("selected", true);

                e_v_s.appendChild(o);
            }

            var updateTypes = () => {
                var type = $(e_v_s).find(":selected").attr("data-sort-type");
                if (type !== e_d_s.getAttribute("data-sort-type-directions")) {
                    e_d_s.innerHTML = "";
                    e_d_s.setAttribute("data-sort-type-directions", type);

                    let e_d_s_a = document.createElement("option");
                    e_d_s_a.setAttribute("value", "a");

                    let e_d_s_d = document.createElement("option");
                    e_d_s_d.setAttribute("value", "d");

                    if (!nou(createOptions) && createOptions.direction === "d")
                        e_d_s_d.toggleAttribute("selected", true);
                    else if (!nou(createOptions))
                        e_d_s_a.toggleAttribute("selected", true);

                    switch (type) {
                        case "number": {
                            e_d_s_a.innerText = "Increasing";
                            e_d_s_d.innerText = "Decreasing";
                            break;
                        }
                        case "date": {
                            e_d_s_a.innerText = "Oldest to Latest";
                            e_d_s_d.innerText = "Latest to Oldest";
                            break;
                        }
                        default: {
                            e_d_s_a.innerText = "Alphabetical";
                            e_d_s_d.innerText = "Reverse Alphabetical";
                        }
                    }

                    e_d_s.appendChild(e_d_s_a);
                    e_d_s.appendChild(e_d_s_d);
                }
            };

            e_v_s.addEventListener("change", updateTypes);

            updateTypes();

            e_o_d.classList.add("dialog-sort-entry-delete");
            e_o_d.innerText = "\u2715";
            e_o_d.addEventListener("click", () => {
                ph.triggerCallbacks("dialogSort_entryRemoved", e);
                e.parentElement.removeChild(e);
            });

            e_v.appendChild(e_v_s);
            e_d.appendChild(e_d_s);

            e_o.appendChild(e_o_d);

            e.appendChild(e_v);
            e.appendChild(e_d);
            e.appendChild(e_o);

            return e;
        };

        var existingSort = !u(ph.file_manager.currentSortPattern) ?
            ph.file_manager.currentSortPattern : ph.config.DEFAULT_SORT_PATTERN;

        for (var pattern of existingSort) {
            let level = createSortingLevel(pattern);
            d_e.appendChild(level);
            ph.triggerCallbacks("dialogSort_entryAdded", level);
        }

        d.classList.add("dialog-sort-panel");

        d_e.classList.add("dialog-sort-entries");
        d_o.classList.add("dialog-sort-options");

        d_o_a.classList.add("dialog-sort-add");
        d_o_c.classList.add("dialog-sort-clear");

        d_o_a.addEventListener("click", () => {
            let level = createSortingLevel();
            d_e.appendChild(level);
            ph.triggerCallbacks("dialogSort_entryAdded", level);
        });

        d_o_c.addEventListener("click", () => {
            d_e.innerHTML = "";
        });

        d_o_a.innerText = "Add";
        d_o_c.innerText = "Clear";

        d_o.appendChild(d_o_a);
        d_o.appendChild(d_o_c);

        d.appendChild(d_h);
        d.appendChild(d_e);
        d.appendChild(d_o);

        var f = document.createElement("div");
        var f_c = document.createElement("button");
        var f_s = document.createElement("button");

        f.classList.add("dialog-sort-actions");
        f_c.classList.add("dialog-sort-cancel");
        f_c.innerText = "Cancel";
        f_c.addEventListener("click", () => {
            ph.triggerCallbacks("dialogSort_cancelled", d);
            DialogWidget.close(f.parentElement.id);
        });
        f_c.setAttribute("type", "button");

        f_s.classList.add("dialog-sort-submit");
        f_s.innerText = "Sort";

        f_s.addEventListener("click", () => {
            var fileList = document.getElementById("fileList");
            ph.file_manager.buildFiles(fileList, ph.file_manager.currentFileList, this.generateSortOptions(d_e));
            ph.triggerCallbacks("dialogSort_applied", d);
            DialogWidget.close(f.parentElement.id);
        });

        f.appendChild(f_s);
        f.appendChild(f_c);

        return new DialogContent([t, d, f]);
    }

}