// dependencies: ["widgets/dynamic/widget_dialog.js", "scripts/utils.js"]

class DialogError {

    static buildDialog(error) {
        // header
        var h = document.createElement("div");
        var h_i = document.createElement("img");
        var h_t = document.createElement("h3");

        h.classList.add("dialog_error_header");

        h_i.classList.add("dialog_error_icon");
        h_t.classList.add("dialog_error_title");

        // noinspection JSUnresolvedVariable
        h_i.setAttribute("src", POWERHOUSE_HTTP_ROOT + "/images/icon/error.svg");
        // noinspection JSUnresolvedVariable
        h_i.setAttribute("alt", "error icon");

        h.appendChild(h_i);
        h.appendChild(h_t);

        h_t.innerText = "Error?!";

        var c;

        if (error.response !== undefined
            && error.response.data !== undefined
            && error.response.data["error_info"] !== undefined) {
            // content
            c = document.createElement("div");
            let c_i = document.createElement("span");
            let c_m = document.createElement("div");
            let c_m_c = document.createElement("span");
            let c_m_n = document.createElement("span");
            let c_d = document.createElement("span");

            c.classList.add("powerhouse-error");

            c_i.classList.add("dialogError_intro");
            c_m.classList.add("dialogError_main");
            c_m_c.classList.add("dialogError_code");
            c_m_n.classList.add("dialogError_name");
            c_d.classList.add("dialogError_description");

            c_i.innerHTML = "It looks like Powerhouse ran into an error.";
            c_m_c.innerHTML = escapeHtml(error.response.data["error_info"]["powerhouse_code"]);
            c_m_n.innerHTML = escapeHtml(error.response.data["error_info"]["summary"]);
            c_d.innerHTML = escapeHtml(error.response.data["error_info"]["description"]);

            c_m.appendChild(c_m_c);
            c_m.appendChild(c_m_n);

            c.appendChild(c_i);
            c.appendChild(c_m);
            c.appendChild(c_d);

            if (error["trace"] !== undefined) {
                let c_t = document.createElement("span");
                c_t.classList.add("dialogError_trace");
                c_t.innerText = escapeHtml(error.response.data["error_info"]["trace"]);
                c.appendChild(c_t);
            }
        } else {
            // content
            c = document.createElement("div");
            let c_i = document.createElement("span");
            let c_d = document.createElement("span");
            let c_t = document.createElement("span");

            c.classList.add("client-error");

            c_i.classList.add("dialogError_intro");
            c_d.classList.add("dialogError_description");
            c_t.classList.add("dialogError_trace");

            c_i.innerHTML = "It looks like Powerhouse ran into an error.";
            c_d.innerText = escapeHtml(error.message);
            c_t.innerText = escapeHtml(error.stack);

            c_i.classList.add("dialogError_intro");

            c.appendChild(c_i);
            c.appendChild(c_d);
            c.appendChild(c_t);
        }

        c.classList.add("dialog_error_content");


        var f = document.createElement("div");
        var f_o = document.createElement("button");

        f.classList.add("dialog_error_footer");

        f_o.classList.add("dialog_error_ok");
        f_o.innerText = "OK";
        f_o.addEventListener("click", () => {
            DialogWidget.close(f.parentElement.id);
        });

        f.appendChild(f_o);

        return new DialogContent([h, c, f]);
    }

}