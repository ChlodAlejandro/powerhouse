<?php
// NOTE: This file is to be loaded in by index.php in the root directory.
// This is because this directory itself may NOT be accessed due to its
// htaccess, which prevents users from directly interacting with the
// `browse` directory.

if (!isset($CD))
	$CD = "";

require_once __DIR__ . "/../../env.php";
require_once POWERHOUSE_DIR_ROOT . "/widgets/utilities/TagGenerator.php";
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

		<script>
			const CURRENT_DIRECTORY = "<?php echo $CD ?>";
		</script>

		<!-- File manager. Mandatory for pages accessing file database. -->
		<script src="<?php echo POWERHOUSE_HTTP_ROOT ?>/scripts/file_manager.js"></script>

		<!-- Required widgets go here. -->
		<?php echo TagGenerator::getThemeScript("dialog-hooks") . PHP_EOL ?>
		<?php echo TagGenerator::getRootScript("widgets/dynamic/widget_file") ?>
        <?php echo TagGenerator::getRootScript("widgets/dynamic/widget_dialog") ?>
        <?php echo TagGenerator::getRootScript("widgets/dynamic/widget_dialogNewFolder") ?>

        <?php require("widgets/header_postload.php") ?>
    </head>
    <body>
		<header>
			<a href="<?php echo POWERHOUSE_HTTP_ROOT ?>"><img src="<?php echo TagGenerator::getRootPath("images/powerhouse-banner.png") ?>" alt="POWERHOUSE"></a>
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
			<div id="ap_options" class="ap_right">
				<a id="selectOpen_sort"
				   class="selectDropdownButton"
				   data-ap-option-type="select"
				   data-selection="selectSortType"
				   data-tooltip="Sort">list</a>
				<a id="selectOpen_layout"
				   class="selectDropdownButton"
				   data-ap-option-type="select"
				   data-selection="layoutSwitch"
				   data-tooltip="Change Layout">apps</a>
				<a id="dialogOpen_newFolder"
				   class="dialogButton"
				   data-ap-option-type="dialog"
				   data-dialog="newFolder"
				   data-tooltip="New Folder">create_new_folder</a>
				<a id="dialogOpen_upload"
				   class="dialogButton"
				   data-ap-option-type="dialog"
				   data-dialog="upload"
				   data-tooltip="Upload">cloud_upload</a>
			</div>
		</div>

		<!-- Files List -->

		<div id="files" data-layout="grid" data-sort="alpha">
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
		<?php echo TagGenerator::getRootScript("scripts/uploader") ?>
        <?php echo TagGenerator::getRootScript("scripts/action_panel") ?>
    </body>
	<script>
		(async function() {
		    buildFiles(document.getElementById("files"), await getFileList(CURRENT_DIRECTORY));
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