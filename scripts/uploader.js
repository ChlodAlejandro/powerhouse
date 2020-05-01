$('#uploadForm').onsubmit = () => {
	axios.post('interface/upload.php', $('#uploadForm').serialize());
	return false;
};

function checkUploadStatus() {
	var ongoingUploads = $(".ongoing-upload");
	if (ongoingUploads.length !== 0) {
		for (var i = 0; i < ongoingUploads.length; i++) {
			console.log(ongoingUploads[i].getAttribute("for"));
		}
	}
}