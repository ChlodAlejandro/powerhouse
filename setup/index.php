<?php
$installed = file_exists(__DIR__ . "/../env.php");
?>
<!doctype html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <title>Powerhouse - the modern file server</title>

		<link rel="shortcut icon" href="../images/logo/favicon.ico" type="image/x-icon">

		<link rel="stylesheet" href="third-party/material.blue-indigo.min.css">
		<script src="third-party/material.min.js" defer></script>
		<script src="third-party/axios.min.js"></script>

        <link rel="stylesheet" href="styles/primary.css">
    </head>

    <body>
        <div id="content">Loading...</div>

		<script>
			async function loadWidget(widgetName) {
			    var content = document.getElementById("content");

                content.innerHTML = (await axios.get(widgetName + ".widget")).data;

                content.removeAttribute("class");
                var wiped = content.cloneNode(true);
                content.parentNode.replaceChild(wiped, content);
                content = wiped;

				var scripts = Array.prototype.slice.call(content.getElementsByTagName("script"));
				for (var i = 0; i < scripts.length; i++) {
					if (scripts[i].src !== "") {
						var tag = document.createElement("script");
						tag.src = scripts[i].src;
						document.getElementsByTagName("head")[0].appendChild(tag);
					} else {
						eval(scripts[i].innerHTML);
					}
				}
			}

			//loadWidget("intro");
            loadWidget("install");
		</script>
    </body>

    <!--

     POWERHOUSE.

     (o)> (*penguin noises*)
     / )
     ‾ ‾
    -->
</html>