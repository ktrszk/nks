<?php

/* ====================================================================================================
   インポート
==================================================================================================== */
$DIR = "../";
$DIR_INC = $DIR."";

require_once($DIR_INC."_inc/project/import.php");
require_once($DIR_INC."_inc/project/param_admin.php");
require_once($DIR_INC."_inc/class/Login.php");

/* ====================================================================================================
   変数定義
==================================================================================================== */
$PAGE_TITLE = "ログイン";

/* ====================================================================================================
   実行処理
==================================================================================================== */
if ($cmd == "login") {
	// 入力チェック
	if (empty($account)) $error .= "ユーザー名を入力してください。<br />";
	if (empty($password)) $error .= "パスワードを入力してください。<br />";
	
	// ログインチェック
	if (empty($error)) {
		$LoginObj = new Login($ENC_PHP, $ENC_DB);
		
		if ( $user = $LoginObj->login_system($account, $password) ) {
			if ($user['role'] >= $LoginObj->ROLE_LIST['ADMINS']) {
				session_regenerate_id(TRUE);
				
				$date = date('Ymd');
				$_SESSION[$SYSTEM_SESSION]['account'] = crypt($account, $date);
				$_SESSION[$SYSTEM_SESSION]['date'] = $date;
				$_SESSION[$SYSTEM_SESSION]['role'] = $user['role'];
				$_SESSION[$SYSTEM_SESSION]['id'] = $user['id'];
				$_SESSION[$SYSTEM_SESSION]['name'] = $user['name'];
				$_SESSION[$SYSTEM_SESSION]['system'] = $SYSTEM_ID;
				
				header("Location:menu.php");
				exit;
			}
		}
		
		$error .= "ユーザー名もしくはパスワードが違います。<br />";
	}
}

unset($_SESSION[$SYSTEM_SESSION]);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php require_once($DIR_TEMPLATE."meta.php"); ?>
</head>

<body>

<?php require_once($DIR_TEMPLATE."header.php"); ?>

<div id="main" class="col1">
	<div id="contents">
		<div id="login"> 
			<dl>
				<dt>Login</dt>
				<dd>
					<form name="form1" method="post" action="">
						<?php if (!empty($error)) : ?><p class="error"><?php echo $error; ?></p><?php endif; ?>
						<table>
							<tr>
								<th>ユーザー名</th>
								<td><input type="text" name="account" class="txt" style="width:240px;ime-mode:inactive;" value="<?php echo $account; ?>" /></td>
							</tr>
							<tr>
								<th>パスワード</th>
								<td><input type="password" name="password" class="txt" style="width:240px;ime-mode:inactive;" /></td>
							</tr>
						</table>
						<p class="aright">
							<input type="image" name="imageField" src="common/images/login_bt001.jpg" />
							<input type="hidden" name="cmd" value="login" />
						</p>
					</form>
				</dd>
			</dl>
		</div>
	</div>
</div>

<?php require_once($DIR_TEMPLATE."footer.php"); ?>

</body>
</html>