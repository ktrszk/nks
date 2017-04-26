<?php

require_once($DIR_INC."_inc/class/Login.php");

// ログインチェック
$LoginObj = new Login($ENC_PHP, $ENC_DB);
if (!$LoginObj->check_status($_SESSION[$SYSTEM_SESSION]['account'], $_SESSION[$SYSTEM_SESSION]['date'], $LoginObj->ROLE_LIST['ADMIN'])) {
	header("Location:".$DIR_ADMIN."index.php");
	exit;
}

?>