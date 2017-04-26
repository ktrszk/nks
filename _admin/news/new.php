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
$PAGE_TITLE = "新規作成";
$SNAVI_ACT = 'article';

$SES_LABEL = "news_new";

/* ====================================================================================================
   初期処理
==================================================================================================== */
require_once($DIR_TEMPLATE."init.php");

/* ====================================================================================================
   実行処理
==================================================================================================== */
$_GET['id'] = "";

// 完了画面
if ($_SESSION[$SES_LABEL]['comp'] == 1) {
	unset($_SESSION[$SES_LABEL]);
	
	$message = $PAGE_MENU."を登録しました。";
	require_once('templates/comp.php');
	exit;
}

$NewsObj = new News($ENC_PHP, $ENC_DB);

if ($cmd == "comp") {
	
	$ValidatorObj = new NewsValidator($ENC_PHP, $ENC_DB);
	
	// フォーマット
	$_POST = $ValidatorObj->format($_POST);
	extract($_POST);
	
	// バリデート
	$error = $ValidatorObj->validate($_POST, $NewsObj);
	
	if (empty($error)) {
		// DB登録
		if ($NewsObj->insert($_POST)) {
			
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
	
	// 初期化
	$ValidatorObj = new NewsValidator($ENC_PHP, $ENC_DB);
	$_POST = $ValidatorObj->init();
	extract($_POST);
	
}

// 入力画面
require_once("templates/edit.php");

?>
