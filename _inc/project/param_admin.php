<?php

$SYSTEM_ID = "NKS_ADMIN";
$SYSTEM_SESSION = "nks_admin";

$SYSTEM_MENU = array(
	0 => array('id'=>'news','label'=>'新着情報管理','url'=>'news/list.php'),
	1 => array('id'=>'recruit','label'=>'採用情報管理','url'=>'recruit/list.php')
);

// 公開日時
$CMN_DISPYEAR_MIN = $SYSTEM_START_YEAR;
$CMN_DISPYEAR_MAX = date('Y') + 1;

// 更新時の確認メッセージ
$SEND_CONFIRM = "この内容で送信します。よろしいですか？";

// 削除時の確認メッセージ
$DELETE_CONFIRM = "削除します。よろしいですか？";

// アップロードを許可する画像の形式
$IMG_ALLOWED_TYPE = array(
	0 => array("type"=>1, "label"=>"gif"),
	1 => array("type"=>2, "label"=>"jpg"),
	2 => array("type"=>3, "label"=>"png")
);

// アップロード時に参照する配列
$UPLOAD_INFO = array(
	'news_new'=>$FILE_NEWS,
	'news_edit'=>$FILE_NEWS
);
// アップロードのサムネイルなし指定：$UPLOAD_INFOのキーを指定
$UPLOAD_NOTHUMB = array();
// アップロードの元ファイル削除指定：$UPLOAD_INFOのキーを指定
$UPLOAD_NOSOURCE = array();

/* ====================================================================================================
   コード表　※変更時要注意
==================================================================================================== */

// 公開設定
$CMN_DISPFLAG = array(
	0 => array('id'=>'1','label'=>'公開','list'=>'公開中'),
	1 => array('id'=>'2','label'=>'非公開','list'=>'非公開')
);
$CMN_DISPTIME_BEFORE = "公開日時前";
$CMN_DISPTIME_AFTER = "公開終了";

// リンクターゲット
$CMN_LINKTARGET = array(
	0 => array('id'=>'1','label'=>'同一ウィンドウ'),
	1 => array('id'=>'2','label'=>'別ウィンドウ')
);

?>