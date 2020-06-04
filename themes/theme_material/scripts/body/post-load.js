(async () => {
    // Please keep these in sequence. Thanks.

    /* 1 */
    $(".icon").each((i, e) => {
        e.classList.add("material-icons");
    });

    /* 2 */
    $("[data-tooltip]").each((i, e) => {
        var target = $(e);
        if (target.attr("id") === undefined || target.attr("id").length === 0) {
            target.attr("id", "tooltip-" + Math.floor(Math.random * 100000));
        }
        var id = target.attr("id");

        var tooltip = document.createElement("div");
        tooltip.classList.add("tooltip");
        tooltip.classList.add("tooltip-larger");
        tooltip.setAttribute("data-target-element-id", id);
        tooltip.innerText = target.attr("data-tooltip");

        $(tooltip).insertAfter(document.body.lastChild);
    });

    /* 3 */
    $(".tooltip").each((i, e) => {
        e.classList.add("mdl-tooltip");
        e.setAttribute("data-mdl-for",
            e.getAttribute("data-target-element-id"));
    });
})();