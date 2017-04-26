// 入力欄の追加
function addItem(cmd, target, type) {
	var num = Number(document.editform.item_num.value);
	$.post("common/php/ajax.php?r="+Math.random(), {
		num : num,
		type : type,
		cmd : cmd
	}, function(result){
		//alert(result);
		$("#"+target).append(result);
		document.editform.item_num.value = num + 1;
	});
}

// 入力欄の削除
function removeItem(target) {
	$("#"+target).remove();
}
