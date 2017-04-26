// パスワードを忘れた方
function openReminder() {
	$('#reminder').toggle('fast');
}

// メニューの切替
function changeMenu() {
	if (document.menuform.menu.value != "") {
		location.href = document.menuform.menu.value;
	}
}

// 指定チェックボックスのすべてON/OFFを設定
function checkboxAll(f,n,flag) {
	for (var i=0; i<document[f][n].length; i++) {
		document[f][n][i].checked = flag;
	}
}

/* ====================================================================================================
   プレビュー
==================================================================================================== */
function preview(url) {
	document.editform.action = url;
	document.editform.target = "_blank";
	document.editform.submit();
	
	document.editform.action = "";
	document.editform.target = "_self";
}

