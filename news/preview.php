<?php

/* ====================================================================================================
   インポート
==================================================================================================== */
$DIR = "../";
$DIR_INC = $DIR."";

require_once($DIR_INC."_inc/project/import.php");
require_once($DIR_INC."_inc/project/param_admin.php");
require_once($DIR_INC."_inc/class/News.php");

/* ====================================================================================================
   変数定義
==================================================================================================== */
$MENU_ID = "news";
$LIST_MAX = 12;

$NEW_PERIOD = 7;	// NEWを表示する日数
$NEW_DAY = compute_date(date('Y'), date('n'), date('j'), $NEW_PERIOD * -1);

/* ====================================================================================================
   初期処理
==================================================================================================== */
require_once($DIR_TEMPLATE."init.php");

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

// プレビュー情報
$detail = $_POST;

$detail['date'] = $_POST['year'].'-'.$_POST['month'].'-'.$_POST['day'];

for ($i=1; $i<=$FILE_NEWS[0]['num']; $i++) {
	if (!empty($detail['file0_'.($i-1)])) {
		$detail['img'.$i] = $detail['file0_'.($i-1)];
	}
}

for ($i=1; $i<=$FILE_NEWS[1]['num']; $i++) {
	if (!empty($detail['file1_'.($i-1)])) {
		$detail['pdf'.$i] = $detail['file1_'.($i-1)];
		$detail['pdf'.$i.'_title'] = $detail['caption1_'.($i-1)];
	}
}

require_once("_index.php");

?>
