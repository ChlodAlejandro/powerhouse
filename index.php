<?php
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Powerhouse</title>

		<link rel="stylesheet" type="text/css" href="css/standard.css">
		<link rel="stylesheet" type="text/css" href="css/main.css">

		<script src="scripts/jquery-3.3.1.js"></script>
		<script defer src="scripts/material-1.3.0.min.js"></script>
    </head>
    <body>
		<header>
			<a href="."><img src="images/powerhouse-banner.png" alt="POWERHOUSE"></a>
		</header>

		<!-- MAIN CONTENT -->

		<!-- Action Panel -->

		<div id="action_panel">
			<div class="ap_left">
				<a class="mdl_ico">folder</a>
				<div>Main folder</div>
			</div>
			<div class="ap_right">
				<a class="dialogButton" for="dialogNewFolder">create_new_folder</a>
				<a class="dialogButton" for="dialogUpload">cloud_upload</a>
			</div>
		</div>

		<!-- Files List -->

		<div id="files">
			<div class="file">
				<img class="icon" src="images/md_ico/file.svg" alt="file">
				<p class="name">testfile.file</p>
			</div>
		</div>

		<!-- Dialog Boxes -->

		<div id="dialogNewFolderContainer" class="dialog_container">
			<div id="dialogNewFolder" class="dialog">
				<h3>New Folder</h3><br/>
				<form name="newFolderForm" method="POST" action="apps/mkdir.php" enctype="application/x-www-form-urlencoded">
					<div class="new-folder-name-input mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<input class="mdl-textfield__input" type="text" id="folderName" name="folderName">
						<label class="mdl-textfield__label" for="folderName">Folder Name</label>
					</div>
					<button name="submit" class="new-folder-submit mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--colored">
						Create
					</button>
				</form>
			</div>
		</div>
		<div id="dialogUploadContainer" class="dialog_container">
			<div id="dialogUpload" class="dialog">
				<h3>Upload</h3><br/>
				<div class="upload-queue">
					<table class="uploading-files">
						<tr class="ongoing-upload" for="testfile.png">
							<td class="icon"><img src="images/md_ico/file.svg" alt="file"></td>
							<td class="filename">testfile.png</td>
							<td class="upload_progress">75.12%</td>
						</tr>
						<tr><td class="separator" colspan="3"><hr/></td></tr>
						<tr>
							<td colspan="3" class="hint">Click on the icon of a file to cancel its upload.</td>
						</tr>
					</table>
				</div>
				<form id="uploadForm" name="uploadForm" method="POST" action="apps/upload.php" enctype="multipart/form-data">
					<input type="hidden" name="<?php echo ini_get("session.upload_progress.name"); ?>" value="powerhouse_upload" />
					<input type="hidden" name="MAX_FILE_SIZE" value="1023999999">
					<input type="file" id="uploadFiles" name="files[]" multiple>
					<label for="uploadFiles" id="uploadBox" class="no-select">Drag files here to upload or click here to select files.</label>
					<button name="submit" class="upload-submit mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--colored">
						Upload
					</button>
				</form>
			</div>
		</div>

		<!-- Tooltips -->

		<div class="mdl-tooltip" data-mdl-for="fileUpload">
			Upload
		</div>
		<div class="mdl-tooltip" data-mdl-for="folderNew">
			New Folder
		</div>

		<!-- Scripts -->

		<script>
			const fadeSpeed = 200;
			var dlg_newFolderContainer = $("#dialogNewFolderContainer");

			var dialogBoxes = $(".dialog");
			for (let i = 0; i < dialogBoxes.length; i++) {
				$(dialogBoxes[i]).parent().fadeOut(0);
				$(dialogBoxes[i]).parent().click((event) => {
					if (event.target === event.currentTarget) {
						$(dialogBoxes[i]).parent().fadeOut(200);
						$(dialogBoxes[i]).removeClass("shown");
					}
				});
			}

			var dialogButtons = $(".dialogButton");
			for (let i = 0; i < dialogButtons.length; i++) {
				$(dialogButtons[i]).click(() => {
					var dialogTarget = $("#" + dialogButtons[i].getAttribute("for"));
					dialogTarget.addClass("shown");
					dialogTarget.parent().fadeIn(fadeSpeed);
				});
			}

			var uploadQueueIcons = $("#dialogUpload .upload-queue td.icon");
			for (let i = 0; i < uploadQueueIcons.length; i++) {
				$(uploadQueueIcons[i]).hover(() => {
					uploadQueueIcons[i].firstChild.src = "images/md_ico/clear.svg";
				}, () => {
					uploadQueueIcons[i].firstChild.src = "images/md_ico/file.svg";
				});
			}
		</script>
		<script src="scripts/uploader.js"></script>
    </body>

<!--

 POWERHOUSE. Copyright (c) 2019. All Rights Reserved.

 (o)> (*penguin noises*)
 / )
 ‾ ‾
-->
</html>