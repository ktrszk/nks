<?php

/* ====================================================================================================
   インポート
==================================================================================================== */
$DIR = "../../";
$DIR_INC = $DIR."";

require_once($DIR_INC."_inc/project/import.php");
require_once($DIR_INC."_inc/project/param_admin.php");
require_once($DIR_INC."_inc/class/Recruit.php");
require_once($DIR_INC."_inc/class/RecruitValidator.php");

require_once("common/php/function.php");

/* ====================================================================================================
   変数定義
==================================================================================================== */
$MENU_ID = "recruit";
$MENU_TITLE = "採用情報管理";
$PAGE_MENU = "採用情報";
$PAGE_TITLE = "新規作成";
$SNAVI_ACT = 'article';

$SES_LABEL = "recruit_new";

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

$RecruitObj = new Recruit($ENC_PHP, $ENC_DB);

if ($cmd == "comp") {
	
	$ValidatorObj = new RecruitValidator($ENC_PHP, $ENC_DB);
	
	// フォーマット
	$_POST = $ValidatorObj->format($_POST);
	extract($_POST);
	
	// バリデート
	$error = $ValidatorObj->validate($_POST, $RecruitObj);
	
	if (empty($error)) {
		// DB登録
		if ($RecruitObj->insert($_POST)) {
			
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
			$error = $RecruitObj->get_error();
		}
	}
	
} elseif (empty($cmd)) {
	
	// 初期化
	$ValidatorObj = new RecruitValidator($ENC_PHP, $ENC_DB);
	$_POST = $ValidatorObj->init();
	extract($_POST);
	
	// コピー
	if (is_numeric($_GET['copy'])) {
		$RecruitObj = new Recruit($ENC_PHP, $ENC_DB);
		if ($obj = $RecruitObj->get_detail($_GET['copy'])) {
			extract($obj);
			$tpl = $RecruitObj->get_detail_tpl($_GET['copy']);
			$item_num = count($tpl);
			for ($i=0; $i<$item_num; $i++) {
				$_POST['type'.$i] = '1';
				$_POST['title'.$i] = $tpl[$i]['title'];
				$_POST['content'.$i.'_1'] = $tpl[$i]['content'];
				$_POST['sort'.$i] = $tpl[$i]['sort'];
				$_POST['item_exist'.$i] = "1";
			}
		} else {
			$error = "コピー元の情報を取得できませんでした。";
		}
	}
	
}

// 入力画面
require_once("templates/edit.php");

?>
