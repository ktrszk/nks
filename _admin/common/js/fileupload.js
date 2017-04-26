$(function(){
	createUploader();
	initFile();
});

// アップローダーの初期配置
function createUploader() {
	for (var i=0; i<FILE_NUM.length; i++) {
		for (var j=0; j<FILE_NUM[i]; j++) {
			addUploader(i, j);
		}
	}
}

// アップローダーの配置
function addUploader(cat, num) {
	var uploader = new qq.FileUploader({
		element: document.getElementById("file"+cat+"_"+num+"_ref"),
		action: '../common/php/fileuploader.php',
		debug: false,
		params: {
			page: FILE_LABEL,
			fcat: cat,
			fnum: num
		},
		onComplete: function(id, fileName, responseJSON) {
			//alert(responseJSON);
			//alert("filename : "+responseJSON.filename);
			$('#file'+responseJSON.fcat+'_'+responseJSON.fnum+'_img').html(getFileHtml(responseJSON.fcat, responseJSON.fnum, responseJSON.filename+"?r="+Math.random()));
			document.editform['file'+responseJSON.fcat+'_'+responseJSON.fnum].value = responseJSON.filename;
		}
	});
}

// ファイルの初期設定
function initFile() {
	for (var i=0; i<FILE_NUM.length; i++) {
		for (var j=0; j<FILE_NUM[i]; j++) {
			addFile(i, j);
		}
	}
}

// ファイルの設定
function addFile(fcat, fnum) {
	if (document.editform["file"+fcat+"_"+fnum].value != "") {
		$("#file"+fcat+"_"+fnum+"_img").html(getFileHtml(fcat, fnum, document.editform["file"+fcat+"_"+fnum].value));
	}
}

function getFileHtml(fcat, fnum, fname) {
	if (FILE_TYPE[fcat] == "Image") {
		return '<p><img src="'+FILE_DIR[fcat]+fname+'" /></p>';
	} else {
		return '<p><a href="'+FILE_DIR[fcat]+fname+'" target="_blank">ファイルを確認する</a></p>';
	}
}

// ファイル削除
function removeFile(fcat, fnum) {
	$('#file'+fcat+'_'+fnum+'_img').html('');
	document.editform['file'+fcat+'_'+fnum].value = '';
}

