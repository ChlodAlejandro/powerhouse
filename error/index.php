<?php
require_once __DIR__ . "/../const.php";
require_once __DIR__ . "/../widgets/utilities/TagGenerator.php";

function parseError($error) {
    try {
		$error_info = json_decode(
				base64_decode($error), true, 512, JSON_THROW_ON_ERROR);
	} catch (Exception $e) {
		$error_info = [
			"code" => "500",
			"summary" => "Internal Server Error",
			"description" => "The server encountered an unexpected condition which prevented it from fulfilling the request.",
			"base" => $e
		];
	}

    $final_output = "";

    if (isset($error_info["code"]) && $error_info["code"] != null)
        $final_output .= $error_info["code"];
    else
    	$final_output .= "500";

    if (isset($error_info["summary"]) && $error_info["summary"] != null) {
		$final_output .= " " . $error_info["summary"];
    }
    if (isset($error_info["description"]) && $error_info["description"] != null) {
        $final_output .= PHP_EOL . PHP_EOL . $error_info["description"];
	}

    if (isset($error_info["base"]) && $error_info["base"] != null) {
        $final_output .= PHP_EOL . PHP_EOL . "[TRACE]" . PHP_EOL . base64_encode(json_encode($error_info["base"]));
    }

	return $final_output;
}

function getTraces() {
    $info = [];

    $info["UA"] = $_SERVER["HTTP_USER_AGENT"];
    $info["TIME"] = time();

    if (isset($_GET["ref"])) {
    	$info["REF"] = $_GET["ref"];
	}
    if (isset($_POST["ref"])) {
        $info["REF"] = $_POST["ref"];
    }
    if (!isset($info["REF"])) {
        $info["REF"] = "no-ref";
    }

	return base64_encode(json_encode($info));
}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>Error | Powerhouse</title>

		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<?php echo TagGenerator::getThemeCSS("global") ?>
		<link rel="icon" type="image/ico" href="../favicon.ico">

		<style>
			html, body {
				margin: 0;
				width: 100vw;
				height: 100vh;
			}

			body {
				display: flex;

				justify-content: center;
				align-items: center;
			}

			#content {
				display: flex;
				flex-direction: column;

				justify-content: center;
				align-items: center;

				text-align: center;
			}

			#banner {
				height: 5vmin;
				width: auto;

				text-align: center;

				display: block;
			}

			#errorIcon {
				width: 15vmin;
				height: auto;
			}

			#details {
				padding: 8px;
				height: 100px;
				width: 50vw;
				border-radius: 10px;
				overflow: auto;
				overflow-wrap: break-word;
				white-space: pre-line;

				font-family: monospace;
				background-color: rgba(0, 0, 0, 0.2);
			}

			#footer {
				margin: 32px;
			}
		</style>
	</head>
	<body>
		<div id="content">
			<img id="errorIcon" src="../images/icon/error.svg" alt="error icon">
			<h1>That wasn't supposed to happen...</h1>
			<p>Sorry, but it looks like something really bad went wrong.</p>
			<p>If this keeps happening, please report the issue to the <a href="<?php echo POWERHOUSE_DEV_PAGE ?>">Powerhouse development page</a>.</p>
			<div id="details"><?php
			if (!isset($_GET["error"]) && !isset($_POST["error"])) {
				echo "It looks like... no exception occurred? This is pretty weird.";
			} else if (isset($_GET["error"])) {
                echo parseError($_GET["error"]) . PHP_EOL . PHP_EOL . "[INFO]" . PHP_EOL . getTraces();
			} else {
                echo parseError($_POST["error"]) . PHP_EOL . PHP_EOL . "[INFO]" . PHP_EOL . getTraces();
			}

			?></div>
			<div id="footer">
				<a href="../">
					<img id="banner" src="../images/powerhouse-banner.png" alt="click here to go back to the main page">
				</a>
			</div>
		</div>
	</body>

<!--

 POWERHOUSE.

 Sorry for the error.

 (o)> (*sad penguin noises*)
 / )
 ‾ ‾
-->
</html>