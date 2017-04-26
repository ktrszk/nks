<?php

/* ====================================================================================================
   インポート
==================================================================================================== */
$DIR = "../";
$DIR_INC = $DIR."";

require_once($DIR_INC."_inc/project/import.php");
require_once($DIR_INC."_inc/class/News.php");

/* ====================================================================================================
   変数定義
==================================================================================================== */
$LIST_MAX = 12;

$NEW_PERIOD = 7;	// NEWを表示する日数
$NEW_DAY = compute_date(date('Y'), date('n'), date('j'), $NEW_PERIOD * -1);

/* ====================================================================================================
   実行処理
==================================================================================================== */
$NewsObj = new News($ENC_PHP, $ENC_DB);

// 総数を取得
if ($resultList = $NewsObj->get_list_by_search("", "1")) {
	$total = count($resultList);
} else {
	$total = 0;
	$error = $NewsObj->get_error();
}

if ($total > 0) {
	// ページャーを生成
	if (empty($_GET['p']) || $_GET['p'] < 0 || $total == 0) {
		$_GET['p'] = 0;
	} else if ($_GET['p'] >= $total / $LIST_MAX) {
		$_GET['p'] = ceil($total/$LIST_MAX) - 1;
	}
	$pager = get_pager_public($total, $LIST_MAX, $_GET['p'], '');
	
	// 一覧を取得
	$start = $_GET['p'] * $LIST_MAX;
	$count = min($total-$start, $LIST_MAX);
	$list = array_slice($resultList, $start, $count);
	$detailList = $NewsObj->get_details_by_id($list);
}

if (!is_numeric($_GET['id'])) {
	if ($newsList = $NewsObj->get_list(0,1,'1')) {
		$_GET['id'] = $newsList[0]['uid'];
	}
}

if (is_numeric($_GET['id'])) {
	$detail = $NewsObj->get_detail($_GET['id'],'1');
}

if (empty($detail)) {
	$notfound = "ご指定の新着情報は削除されたか、存在しません。";
}

require_once("_index.php");

?>
