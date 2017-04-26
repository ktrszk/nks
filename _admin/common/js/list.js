$(function(){
	$("#list table").each(function(){
		$(this).find("tr:even").addClass("even");
	});
	$("#list table tr").hover(
		function() {
			$(this).addClass("hover");
		},
		function() {
			$(this).removeClass("hover");
		}
	);
});

/* ====================================================================================================
   制御
==================================================================================================== */
// ページャー
function changePage(num) {
	document.listform.p.value = num;
	document.listform.submit();
}

// ソート
function changeSort(key, asc) {
	document.listform.p.value = "";
	document.listform.s.value = key;
	document.listform.sa.value = asc;
	document.listform.submit();
}

// 処理実行
function executeCmd() {
	document.listform.cmd.value = document.listform.cmdlist.value;
	document.listform.submit();
}
