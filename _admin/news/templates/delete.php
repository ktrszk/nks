<?php
if (empty($LoginObj)) header("Location:/");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php require_once($DIR_TEMPLATE."meta.php"); ?>
<script type="text/javascript" src="../common/js/edit.js"></script>

<link href="common/css/edit.css" rel="stylesheet" type="text/css" />
</head>

<body class="col2">

<?php require_once($DIR_TEMPLATE."header.php"); ?>

<div id="main">
	<?php require_once("sidebar.php"); ?>
	
	<div id="contents">
		<div id="title">
			<h1><?php echo $PAGE_MENU; ?></h1>
		</div>
		
		<form name="editform" method="post" action="" onsubmit="return confirm('<?php echo $DELETE_CONFIRM; ?>')">
			<div class="content">
				<h2><?php echo $PAGE_TITLE; ?></h2>
				<div class="inner">
					<?php if (empty($notfound)) : ?>
					<?php if (!empty($error)) : ?><p class="error"><?php echo $error; ?></p><?php endif; ?>
					
					<p class="warning">下記の内容を削除してよろしければ「データ削除」ボタンをクリックしてください。</p>
					
					<div id="edit">
						<div class="edit end">
							<h3><a href="javascript:toggleEdit('1')">新着情報報</a></h3>
							<div id="edit1">
								<table>
									<tr>
										<th style="width:150px;">日付</th>
										<td><?php echo $year.' 年 '.$month.' 月 '.$day.' 日'; ?></td>
									</tr>
									<tr>
										<th>タイトル</th>
										<td><?php echo $title; ?></td>
									</tr>
									<tr>
										<th>本文</th>
										<td><?php echo convert_to_wrap($content); ?></td>
									</tr>
									<tr>
										<th>画像</th>
										<td><div class="flist"><?php $fcat=0; for ($i=0; $i<$FILE_NEWS[$fcat]['num']; $i++) : ?>
											<?php if (!empty($_POST['file'.$fcat.'_'.$i])) : ?><div class="fitem"><img src="<?php echo $DIR.$IMG_THUMB_PATH.$_POST['file'.$fcat.'_'.$i]; ?>" /></div><?php endif; ?>
										<?php endfor; ?></div></td>
									</tr>
									<tr>
										<th>添付ファイル</th>
										<td><?php $fcat=1; for ($i=0; $i<$FILE_NEWS[$fcat]['num']; $i++) : ?>
											<?php if (!empty($_POST['file'.$fcat.'_'.$i])) : ?><p><a href="<?php echo $DIR.$IMG_THUMB_PATH.$_POST['file'.$fcat.'_'.$i]; ?>" target="_blank"><?php echo (!empty($_POST['caption'.$fcat.'_'.$i])) ? $_POST['caption'.$fcat.'_'.$i] : '添付ファイル'.$i.'を表示する'; ?></a></p><?php endif; ?>
										<?php endfor; ?></td>
									</tr>
								<?php for ($i=1; $i<=$NEWS_LINKNUM; $i++) : ?>
									<tr>
										<th>リンク<?php echo $i; ?></th>
										<td>URL：<?php echo $_POST['link'.$i.'_url']; ?>
										<p class="spacer">開き方：<?php echo master_detail_param($CMN_LINKTARGET, $_POST['link'.$i.'_target']); ?></p></td>
									</tr>
								<?php endfor; ?>
									<tr>
										<th>公開日時</th>
										<td><?php echo $disp_year.' 年 '.$disp_month.' 月 '.$disp_day.' 日　'.$disp_hour.' 時 '.$disp_minute.' 分'; ?></td>
									</tr>
									<tr>
										<th>公開設定</th>
										<td><?php echo master_detail_param($CMN_DISPFLAG, $disp_flag); ?></td>
									</tr>
								</table>
							</div>
						</div>
					</div>
					<?php else : ?>
					<p><?php echo $notfound; ?></p>
					<?php endif; ?>
				</div>
			</div>
						
			<div class="control">
				<ul>
					<?php if (empty($notfound)) : ?>
					<li><input type="image" name="imageField" src="../common/images/delete_bt001.jpg" /></li>
					<li><a href="javascript:history.back()"><img src="../common/images/edit_bt004.jpg" alt="入力画面に戻る" width="200" height="40" /></a></li>
					<?php else : ?>
					<li><a href="list.php"><img src="../common/images/edit_bt005.jpg" alt="一覧に戻る" width="200" height="40" /></a></li>
					<?php endif; ?>
				</ul>
				<input type="hidden" name="cmd" value="comp" />
			</div>
		</form>
	</div>
</div>

<?php require_once($DIR_TEMPLATE."footer.php"); ?>

</body>
</html>