<?php
if (empty($LoginObj)) header("Location:/");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php require_once($DIR_TEMPLATE."meta.php"); ?>
</head>

<body class="col2">

<?php require_once($DIR_TEMPLATE."header.php"); ?>

<div id="main">
	<?php require_once("sidebar.php"); ?>
	
	<div id="contents">
		<div id="title">
			<h1><?php echo $PAGE_MENU; ?></h1>
		</div>
		
		<form name="editform" method="post" action="">
			<div class="content">
				<h2><?php echo $PAGE_TITLE; ?></h2>
				<div class="inner">
					<p><?php echo $message; ?></p>
				</div>
			</div>
						
			<div class="control">
				<ul>
					<li><a href="list.php<?php echo (strpos($SES_LABEL,"_new") > 0) ? '' : "?c=Search"; ?>"><img src="../common/images/edit_bt005.jpg" alt="一覧に戻る" width="200" height="40" /></a></li>
				</ul>
			</div>
		</form>
	</div>
</div>

<?php require_once($DIR_TEMPLATE."footer.php"); ?>

</body>
</html>