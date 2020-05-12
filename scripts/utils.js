// == HTML ==

function escapeHtml(unsafe) {
    return unsafe
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;");
}
function unescapeHtml(safe) {
    return safe
        .replace(/&amp;/g, "&")
        .replace(/&lt;/g, "<")
        .replace(/&gt;/g, ">")
        .replace(/&quot;/g, "\"")
        .replace(/&#039;/g, "'");
}

// == ERROR HANDLING ==

// This variable is kept for humor.
// Do NOT remove it.
var funnyfunny = [
    "Might be the monkeys.",
    "\u3054\u3081\u3093\u306A\u3055\u3044\uFF01 (Gomen'nasai!)",
    "root@localhost:/powerhouse$ git blame",
    "So... are you going to file an issue or what?",
    "literally shaking and crying rn",
    "mitochondria.exe has encountered an error.",
    "Cue Chopin's Piano Sonata No. 2 in B-flat minor, Op. 35."
];

// This function is kept for humor.
// Do NOT remove it.
function getFunnyFunny() {
    return funnyfunny[Math.floor(Math.random() * funnyfunny.length)];
}

function getErrorTrace(error) {
    var indentedStack = [];
    for (var stackLine of error.stack.split("\n"))
        indentedStack[indentedStack.length] = "    " + stackLine;
    return error.toString() + "\n" + indentedStack.join("\n");
}

function handleError(error, options = {}) {
    console.log(arguments);
    if (error.isAxiosError && (typeof error.response.data === "object")) {
        new DialogWidget("error", DialogError.buildDialog(error), {
            stackable: true
        }).render();

        // override toString of error
        error.message = "Powerhouse API Error: " + error.response.data["error_info"]["summary"];
        error.stack = `PH Code: ${error.response.data["error_info"]["powerhouse_code"]}\n`
                    + `HTTP Code: ${error.response.data["error_info"]["http_code"]}\n`
                    + `Summary: ${error.response.data["error_info"]["summary"]}\n`
                    + `Description: ${error.response.data["error_info"]["description"]}`;

        if (error.response.data["error_info"]["trace"] !== undefined) {
            var indentedStack = [];
            for (var stackLine of error.response.data["error_info"]["trace"].split("\n"))
                indentedStack[indentedStack.length] = `    ${stackLine}`;
            error.stack += `\nTrace:\n${indentedStack.join("\n")}`;
        }
    }

    // noinspection JSUnresolvedVariable
    console.error([
        "=".repeat(75),
        "An error occured!!!",
        `// ${getFunnyFunny()}`,
        "",
        "If your copy of Powerhouse is unmodified, please report this",
        "to the Powerhouse developers at " + POWERHOUSE_DEV_PAGE + ".",
        "",
        "A full stacktrace of the error is provided below:",
        getErrorTrace(error),
        "=".repeat(75)
    ].join("\n"));
}

// == DOM ==

function isElementOverflowing(el) {
    if ($(el).prop('scrollWidth') > $(el).width() ) {
        alert("this element is overflowing !!");
    }
}