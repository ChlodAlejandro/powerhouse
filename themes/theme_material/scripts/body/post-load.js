(async () => {
    // Please keep these in sequence. Thanks.

    /* 1 */
    $(".icon").each((i, e) => {
        e.classList.add("material-icons");
    });

    /* 2 */
    ph_material.build_tooltips();

})();