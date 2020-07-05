<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>Missing Functionality - Powerhouse</title>
		<!--<?php
			echo "\u{002d}\u{002d}\u{003e}";
			echo "<script>window.location.replace(\"index.php\")</script>";
			echo "\u{003c}\u{0021}\u{002d}\u{002d}";
		?>-->
	</head>
	<body style="background-color: var(--main-bg-color);">
		<div id="content">
			<img id="banner" src="../images/powerhouse-banner.png" alt="Powerhouse banner">

			<div id="missing_js" style="width: 50%; text-align: center">
				<h1>Missing Functionality</h1>
				<p>If you're reading this, you most likely don't have JavaScript enabled.</p>
				<p>We've got some bad news though: Powerhouse relies <b>HEAVILY</b> on JavaScript. So you'll need to allow Powerhouse to use JavaScript.</p>
				<p>When you've done so, refresh this page to continue.</p>
			</div>
			<div id="missing_php" style="width: 50%; text-align: center; display: none;">
				<h1>Missing Functionality</h1>
				<p>If you're seeing this, you most likely don't have PHP installed.</p>
				<p>PHP is required for Powerhouse to run correctly. You can learn more about PHP on the <a href="https://php.net">the PHP website</a>.</p>
				<p>Otherwise, make sure that the Powerhouse directory can use PHP.</p>
				<p>Once you've installed and enabled PHP, refresh this page to continue.</p>
			</div>
		</div>

		<link rel="stylesheet" href="styles/primary.css">

		<script>
			document.getElementById("missing_js").style.display = "none";
            document.getElementById("missing_php").style.display = "block";
		</script>
	</body>
</html>