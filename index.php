<?php
require_once __DIR__ . "/widgets/utilities/TagGenerator.php";
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Powerhouse</title>

        <?php
		$requiredStyles = ["action_panel", "dialog", "files"];

		require("widgets/header_preload.php");
		?>

		<!-- File manager. Mandatory for pages accessing file database. -->
		<script src="scripts/file_manager.js"></script>

		<!-- Required widgets go here. -->
		<script src="widgets/dynamic/widget_file.js"></script>

        <?php require("widgets/header_postload.php") ?>
    </head>
    <body>
		<header>
			<a href="."><img src="images/powerhouse-banner.png" alt="POWERHOUSE"></a>
		</header>

		<!-- MAIN CONTENT -->

		<!-- Action Panel -->

		<div id="action_panel">
			<div class="ap_left">
				<div class="ap_directory">
					<a id="ap_home" class="icon" data-tooltip="Return to main folder">folder</a>
					<div>Main folder</div>
				</div>
			</div>
			<div class="ap_right">
				<a id="selectOpen_sort"
				    class="selectDropdownButton"
				    data-handler="selectSortType"
				    data-tooltip="Sort">list</a>
				<a id="selectOpen_layout"
				   class="selectDropdownButton"
				   data-dialog="selectLayout"
				   data-tooltip="Change Layout">apps</a>
				<a id="dialogOpen_newFolder"
				    class="dialogButton"
				    data-dialog="dialogNewFolder"
				    data-tooltip="New Folder">create_new_folder</a>
				<a id="dialogOpen_upload"
				    class="dialogButton"
				    data-dialog="dialogUpload"
				    data-tooltip="Upload">cloud_upload</a>
			</div>
		</div>

		<!-- Files List -->

		<div id="files" class="files_layout_grid">
<!--		<div id="files" class="files_layout_details">-->
			<div class="file files_header">
				<span class="file_icon"></span>
				<span class="file_name">Name</span>
				<span class="file_size">Size</span>
				<span class="file_mtime">Last Modified</span>
				<span class="file_ctime">Created</span>
			</div>
		</div>

		<!-- Dialog Boxes -->

<!--		<div id="dialogNewFolderContainer" class="dialog_container">-->
<!--			<div id="dialogNewFolder" class="dialog">-->
<!--				<h3>New Folder</h3><br/>-->
<!--				<form name="newFolderForm" method="POST" action="interface/mkdir.php" enctype="application/x-www-form-urlencoded">-->
<!--					<div class="new-folder-name-input mdl-textfield mdl-js-textfield mdl-textfield--floating-label">-->
<!--						<input class="mdl-textfield__input" type="text" id="folderName" name="folderName">-->
<!--						<label class="mdl-textfield__label" for="folderName">Folder Name</label>-->
<!--					</div>-->
<!--					<button name="submit" class="new-folder-submit mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--colored">-->
<!--						Create-->
<!--					</button>-->
<!--				</form>-->
<!--			</div>-->
<!--		</div>-->
<!--		<div id="dialogUploadContainer" class="dialog_container">-->
<!--			<div id="dialogUpload" class="dialog">-->
<!--				<h3>Upload</h3><br/>-->
<!--				<div class="upload-queue">-->
<!--					<table class="uploading-files">-->
<!--						<tr class="ongoing-upload" for="testfile.png">-->
<!--							<td class="icon"><img src="images/md_ico/file.svg" alt="file"></td>-->
<!--							<td class="filename">testfile.png</td>-->
<!--							<td class="upload_progress">75.12%</td>-->
<!--						</tr>-->
<!--						<tr><td class="separator" colspan="3"><hr/></td></tr>-->
<!--						<tr>-->
<!--							<td colspan="3" class="hint">Click on the icon of a file to cancel its upload.</td>-->
<!--						</tr>-->
<!--					</table>-->
<!--				</div>-->
<!--				<form id="uploadForm" name="uploadForm" method="POST" action="interface/upload.php" enctype="multipart/form-data">-->
<!--					<input type="hidden" name="--><?php //echo ini_get("session.upload_progress.name"); ?><!--" value="powerhouse_upload" />-->
<!--					<input type="hidden" name="MAX_FILE_SIZE" value="1023999999">-->
<!--					<input type="file" id="uploadFiles" name="files[]" multiple>-->
<!--					<label for="uploadFiles" id="uploadBox" class="no-select">Drag files here to upload or click here to select files.</label>-->
<!--					<button name="submit" class="upload-submit mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--colored">-->
<!--						Upload-->
<!--					</button>-->
<!--				</form>-->
<!--			</div>-->
<!--		</div>-->

		<!-- Scripts -->

<!--		<script>-->
<!--			const fadeSpeed = 200;-->
<!--			var dlg_newFolderContainer = $("#dialogNewFolderContainer");-->
<!---->
<!--			var dialogBoxes = $(".dialog");-->
<!--			for (let i = 0; i < dialogBoxes.length; i++) {-->
<!--				$(dialogBoxes[i]).parent().fadeOut(0);-->
<!--				$(dialogBoxes[i]).parent().on("click", (event) => {-->
<!--					if (event.target === event.currentTarget) {-->
<!--						$(dialogBoxes[i]).parent().fadeOut(200);-->
<!--						$(dialogBoxes[i]).removeClass("shown");-->
<!--					}-->
<!--				});-->
<!--			}-->
<!---->
<!--			var dialogButtons = $(".dialogButton");-->
<!--			for (let i = 0; i < dialogButtons.length; i++) {-->
<!--				$(dialogButtons[i]).on("click", () => {-->
<!--					var dialogTarget = $("#" + dialogButtons[i].getAttribute("for"));-->
<!--					dialogTarget.addClass("shown");-->
<!--					dialogTarget.parent().fadeIn(fadeSpeed);-->
<!--				});-->
<!--			}-->
<!---->
<!--			var uploadQueueIcons = $("#dialogUpload .upload-queue td.icon");-->
<!--			for (let i = 0; i < uploadQueueIcons.length; i++) {-->
<!--				$(uploadQueueIcons[i]).on("hover", () => {-->
<!--					uploadQueueIcons[i].firstChild.src = "images/md_ico/clear.svg";-->
<!--				}, () => {-->
<!--					uploadQueueIcons[i].firstChild.src = "images/md_ico/file.svg";-->
<!--				});-->
<!--			}-->
<!--		</script>-->
		<script src="scripts/uploader.js"></script>
    </body>
	<script>
		(async function() {
		    buildFiles(document.getElementById("files"), await getFileList());
		})();
	</script>
    <?php require("widgets/body_postload.php"); ?>

<!--

 POWERHOUSE.

 (o)> (*penguin noises*)
 / )
 ‾ ‾
-->
</html>