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
$PAGE_TITLE = "削除";
$SNAVI_ACT = 'article';

$SES_LABEL = "recruit_delete";

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
	
	$message = $PAGE_MENU."を削除しました。";
	require_once("templates/comp.php");
	exit;
}

// 登録内容取得
$RecruitObj = new Recruit($ENC_PHP, $ENC_DB);
if ($obj = $RecruitObj->get_detail($_GET['id'])) {
		
} else {
	$notfound = $RecruitObj->get_error();
}

// 削除処理
if (empty($notfound)) {
	if ($cmd == "comp") {
		
		// DB登録
		$RecruitObj = new Recruit($ENC_PHP, $ENC_DB);
		if ($RecruitObj->delete($_GET['id'])) {
			
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
		
	} else {
		
		extract($obj);
		
		list($disp_d,$disp_t) = explode(' ',$disp_time);
		list($disp_year,$disp_month,$disp_day) = explode('-',$disp_d);
		list($disp_hour,$disp_minute) = explode(':',$disp_t);
		
		$tpl = $RecruitObj->get_detail_tpl($_GET['id']);
		$item_num = count($tpl);
		for ($i=0; $i<$item_num; $i++) {
			$_POST['type'.$i] = '1';
			$_POST['title'.$i] = $tpl[$i]['title'];
			$_POST['content'.$i.'_1'] = $tpl[$i]['content'];
			$_POST['sort'.$i] = $tpl[$i]['sort'];
			$_POST['item_exist'.$i] = "1";
		}
		
	}
}

// 入力画面
require_once("templates/delete.php");
exit;

?>
