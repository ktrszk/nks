<?php

/* ====================================================================================================
   インポート
==================================================================================================== */
$DIR = "../../";
$DIR_INC = $DIR."";

require_once($DIR_INC."_inc/project/import.php");
require_once($DIR_INC."_inc/project/param_admin.php");
require_once($DIR_INC."_inc/class/News.php");
require_once($DIR_INC."_inc/class/NewsValidator.php");

/* ====================================================================================================
   変数定義
==================================================================================================== */
$MENU_ID = "news";
$MENU_TITLE = "新着情報管理";
$PAGE_MENU = "新着情報";
$PAGE_TITLE = "編集";
$SNAVI_ACT = 'article';

$SES_LABEL = "news_edit";

/* ====================================================================================================
   初期処理
==================================================================================================== */
require_once($DIR_TEMPLATE."init.php");

/* ====================================================================================================
   実行処理
==================================================================================================== */

// 完了画面
if ($_SESSION[$SES_LABEL]['comp'] == 1) {
	unset($_SESSION[$SES_LABEL]);
	
	$message = $PAGE_MENU."を編集しました。";
	require_once('templates/comp.php');
	exit;
}

// 登録内容取得
$NewsObj = new News($ENC_PHP, $ENC_DB);
if ($obj = $NewsObj->get_detail($_GET['id'])) {
	
} else {
	$notfound = $NewsObj->get_error();
}

// 編集処理
if (empty($notfound)) {
	if ($cmd == "comp") {
		
		$ValidatorObj = new NewsValidator($ENC_PHP, $ENC_DB);
		
		// フォーマット
		$_POST = $ValidatorObj->format($_POST);
		extract($_POST);
		
		// バリデート
		$error = $ValidatorObj->validate($_POST, $NewsObj, $_GET['id']);
		
		if (empty($error)) {
			// DB登録
			if ($NewsObj->update($_POST, $_GET['id'])) {
				
				// 完了画面へ転送（F5による二重登録防止）
				$_SESSION[$SES_LABEL]['comp'] = 1;
				
				if (isset($_SERVER['HTTPS']) and $_SERVER['HTTPS'] == 'on') {
					$protocol = 'https://';
				} else {
					$protocol = 'http://';
				}
				$url  = $protocol.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
				
				header("Location:".$url);
				exit;
				
			} else {
				$error = $NewsObj->get_error();
			}
		}
		
	} elseif (empty($cmd)) {
		
		extract($obj);
		
		for ($i=0; $i<$FILE_NEWS[0]['num']; $i++) {
			$_POST['file0_'.$i] = $obj['img'.($i+1)];
		}
		for ($i=0; $i<$FILE_NEWS[1]['num']; $i++) {
			$_POST['file1_'.$i] = $obj['pdf'.($i+1)];
			$_POST['caption1_'.$i] = $obj['pdf'.($i+1).'_title'];
		}
		for ($i=1; $i<=$NEWS_LINKNUM; $i++) {
			$_POST['link'.$i.'_url'] = $obj['link'.$i.'_url'];
			$_POST['link'.$i.'_target'] = $obj['link'.$i.'_target'];
		}
		
		list($year,$month,$day) = explode('-',$date);
		list($disp_d,$disp_t) = explode(' ',$disp_time);
		list($disp_year,$disp_month,$disp_day) = explode('-',$disp_d);
		list($disp_hour,$disp_minute) = explode(':',$disp_t);
		
	}
}

// 入力画面
require_once("templates/edit.php");

?>
