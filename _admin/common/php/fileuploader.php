<?php

/* ====================================================================================================
   インポート
==================================================================================================== */
$DIR = "../../../";
$DIR_INC = $DIR."";

require_once($DIR_INC."_inc/project/import.php");
require_once($DIR_INC."_inc/project/param_admin.php");
require_once($DIR_INC."_inc/class/qqFileUploader.php");
require 'jsonwrapper.php';

/* ====================================================================================================
   変数定義
==================================================================================================== */
$MENU_ID = "fileuploader";

/* ====================================================================================================
   初期処理
==================================================================================================== */
require_once($DIR_TEMPLATE."init.php");

/* ====================================================================================================
   実行処理
==================================================================================================== */
extract($_REQUEST);

// list of valid extensions, ex. array("jpeg", "xml", "bmp")
$allowedExtensions = array();
if ($UPLOAD_INFO[$page][$fcat]['type'] == "Image") {
	for ($i=0; $i<count($IMG_ALLOWED_TYPE); $i++) {
		array_push($allowedExtensions, $IMG_ALLOWED_TYPE[$i]['label']);
	}
}

// max file size in bytes
$sizeLimit = 10 * 1024 * 1024;

$uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
$result = $uploader->handleUpload($DIR.$IMG_PATH);

if (!empty($result['filename'])) {
	
	$fn = $result['filename'];
	$fp = $DIR.$IMG_PATH.$fn;
	
	$fileInfo = $UPLOAD_INFO[$page];
	
	// 書き出し
	if ($UPLOAD_INFO[$page][$fcat]['type'] == "Image") {
		for ($i=0; $i<count($fileInfo[$fcat]['dir']); $i++) {
			if (!empty($fileInfo[$fcat]['dir'][$i]['w']) || !empty($fileInfo[$fcat]['dir'][$i]['h'])) {
				if (!resize_image($fp, $DIR.$fileInfo[$fcat]['dir'][$i]['path'].$fn, $fileInfo[$fcat]['dir'][$i]['w'], $fileInfo[$fcat]['dir'][$i]['h'])) {
					$result['error'] = "画像をコピーできませんでした。";
				}
			} elseif (!empty($fileInfo[$fcat]['dir'][$i]['wmin']) && !empty($fileInfo[$fcat]['dir'][$i]['hmin'])) {
				if (!resize_image($fp, $DIR.$fileInfo[$fcat]['dir'][$i]['path'].$fn, '', '', $fileInfo[$fcat]['dir'][$i]['wmin'], $fileInfo[$fcat]['dir'][$i]['hmin'])) {
					$result['error'] = "画像をコピーできませんでした。";
				}
			} else {
				if (!copy($fp, $DIR.$fileInfo[$fcat]['dir'][$i]['path'].$fn)) {
					$result['error'] = "画像をコピーできませんでした。";
				}
			}
		}
		
		// サムネイル書き出し：サムネイルなし指定、一時ファイル削除
		if(!in_array($page, $UPLOAD_NOTHUMB)) {
			if (!resize_image($fp, $DIR.$IMG_THUMB_PATH.$fn, $IMG_THUMB_WIDTH)) {
				$result['error'] = "サムネイルをコピーできませんでした。";
			}
		}
		
		// 元ファイル削除指定
		if (in_array($page, $UPLOAD_NOSOURCE)) {
			@unlink($fp);
		}
		
	} else {
		for ($i=0; $i<count($fileInfo[$fcat]['dir']); $i++) {
			if (!copy($fp, $DIR.$fileInfo[$fcat]['dir'][$i]['path'].$fn)) {
				$result['error'] = "ファイルをコピーできませんでした。";
			}
		}
	}
	
	$result['fcat'] = $fcat;
	$result['fnum'] = $fnum;
}

// to pass data through iframe you will need to encode all html tags
echo htmlspecialchars(json_encode($result), ENT_NOQUOTES);
