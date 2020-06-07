document.body.addEventListener("keydown", ev => {
    if (ev.ctrlKey && ev.key.toLowerCase() === "a")
        ph.file_manager.selectAllFiles();
});