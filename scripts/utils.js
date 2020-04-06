function handleError(error, options = {}) {
    // noinspection JSUnresolvedVariable
    console.error([
        "=".repeat(75),
        "An error occured!!!",
        "",
        "If your copy of Powerhouse is unmodified, please report this",
        "to the Powerhouse developers at " + POWERHOUSE_DEV_PAGE + ".",
        "",
        "A full stacktrace of the error is provided below:",
        error,
        "=".repeat(75)
    ].join("\n"));
}