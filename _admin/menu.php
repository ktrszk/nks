<?php

/* ====================================================================================================
   インポート
==================================================================================================== */
$DIR = "../";
$DIR_INC = $DIR."";

require_once($DIR_INC."_inc/project/import.php");
require_once($DIR_INC."_inc/project/param_admin.php");

/* ====================================================================================================
   変数定義
==================================================================================================== */
$MENU_ID = "menu";
$PAGE_MENU = "総合メニュー";
$PAGE_TITLE = "一覧";

/* ====================================================================================================
   初期処理
==================================================================================================== */
require_once($DIR_TEMPLATE."init.php");

/* ====================================================================================================
   実行処理
==================================================================================================== */

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php require_once($DIR_TEMPLATE."meta.php"); ?>
<script type="text/javascript" src="../common/js/list.js"></script>
</head>

<body class="col1">

<?php require_once($DIR_TEMPLATE."header.php"); ?>

<div id="main">
	<div id="contents">
		<div id="title">
			<h1><?php echo $PAGE_MENU; ?></h1>
		</div>
		
		<form name="listform" method="post" action="">
			<div id="menu" class="content">
				<h2><?php echo $PAGE_TITLE; ?></h2>
				<div class="inner">
					<?php if (!empty($error)) : ?><p class="error"><?php echo $error; ?></p><?php endif; ?>
					
					<dl class="left">
						<dt>新着情報管理メニュー</dt>
						<dd>
							・<a href="news/list.php">一覧</a><br />
							・<a href="news/new.php">新規作成</a><br />
						</dd>
					</dl>
					
					<dl class="right">
						<dt>採用情報管理メニュー</dt>
						<dd>
							・<a href="recruit/list.php">一覧</a><br />
							・<a href="recruit/new.php">新規作成</a><br />
						</dd>
					</dl>
				</div>
			</div>
		</form>
	</div>
</div>

<?php require_once($DIR_TEMPLATE."footer.php"); ?>

</body>
</html>