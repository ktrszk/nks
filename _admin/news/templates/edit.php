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
<script type="text/javascript" src="../common/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="common/js/ckeditor.js"></script>
<link href="../common/css/fileuploader.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../common/js/fileupload.js"></script>
<script type="text/javascript" src="../common/js/fileuploader.js"></script>
<script type="text/javascript">
var FILE_LABEL = '<?php echo $SES_LABEL; ?>';
var FILE_NUM = [<?php
	for ($i=0; $i<count($FILE_NEWS); $i++) {
		if ($i > 0) echo ",";
		echo $FILE_NEWS[$i]['num'];
	}
?>];
var FILE_TYPE = [<?php
	for ($i=0; $i<count($FILE_NEWS); $i++) {
		if ($i > 0) echo ",";
		echo "'".$FILE_NEWS[$i]['type']."'";
	}
?>];
var FILE_DIR = [<?php
	for ($i=0; $i<count($FILE_NEWS); $i++) {
		if ($i > 0) echo ",";
		echo ($FILE_NEWS[$i]['type'] == "Image") ? "'".$DIR.$IMG_THUMB_PATH."'" : "'".$DIR.$IMG_PATH."'";
	}
?>];
</script>
</head>

<body class="col2">

<?php require_once($DIR_TEMPLATE."header.php"); ?>

<div id="main">
	<?php require_once("sidebar.php"); ?>
	
	<div id="contents">
		<div id="title">
			<h1><?php echo $PAGE_MENU; ?></h1>
			<?php if (!empty($_GET['id']) && empty($notfound)) : ?><p class="right"><a href="delete.php?id=<?php echo $_GET['id']; ?>"><img src="../common/images/delete_bt001.jpg" alt="データ削除" width="200" height="40" /></a></p><?php endif; ?>
		</div>
		
		<form name="editform" method="post" action="" onsubmit="return confirm('<?php echo $SEND_CONFIRM; ?>')">
			<div class="content">
				<h2><?php echo $PAGE_TITLE; ?></h2>
				<div class="inner">
					<?php if (empty($notfound)) : ?>
					<?php if (!empty($error)) : ?><p class="error"><?php echo $error; ?></p><?php endif; ?>
					
					<p class="warning">下記の内容を入力して「この内容で保存する」ボタンをクリックしてください。<br />
					<span class="require">※</span>は入力必須項目です。</p>
					
					<div id="edit">
						<div class="edit end">
							<h3><a href="javascript:toggleEdit('1')">新着情報</a></h3>
							<div id="edit1">
								<table>
									<tr>
										<th style="width:150px;">日付 <span class="require">※</span></th>
										<td><select name="year">
											<?php for ($i=$CMN_DISPYEAR_MIN; $i<=$CMN_DISPYEAR_MAX; $i++) : ?>
											<option value="<?php echo $i; ?>"<?php if ($year == $i) echo ' selected="selected"'; ?>><?php echo $i; ?></option>
											<?php endfor; ?>
										</select> 年
										<select name="month">
											<?php for ($i=1; $i<=12; $i++) : $m = sprintf('%02d',$i); ?>
											<option value="<?php echo $m; ?>"<?php if ($month == $m) echo ' selected="selected"'; ?>><?php echo $m; ?></option>
											<?php endfor; ?>
										</select> 月
										<select name="day">
											<?php for ($i=1; $i<=31; $i++) : $d = sprintf('%02d',$i); ?>
											<option value="<?php echo $d; ?>"<?php if ($day == $d) echo ' selected="selected"'; ?>><?php echo $d; ?></option>
											<?php endfor; ?>
										</select> 日</td>
									</tr>
									<tr>
										<th>タイトル <span class="require">※</span></th>
										<td><input type="text" name="title" class="txt" style="width:500px;" value="<?php echo $title; ?>" /></td>
									</tr>
									<tr>
										<th>本文</th>
										<td id="ckeditor"><textarea id="editor1" name="content" class="ckeditor"></textarea></td>
									</tr>
									<tr>
										<th>画像</th>
										<td id="image"><div class="flist"><?php $fcat = 0; for ($i=0; $i<$FILE_NEWS[$fcat]['num']; $i++) : ?>
											<div class="fitem">
												<div class="fimg" id="file<?php echo $fcat; ?>_<?php echo $i; ?>_img"></div>
												
												<div class="fbtn">
													<div class="left" id="file<?php echo $fcat; ?>_<?php echo $i; ?>_ref"><noscript>JavaScriptをONにしてください。</noscript></div>
													<p class="right"><a href="javascript:removeFile(<?php echo $fcat; ?>,<?php echo $i; ?>)"><img src="../common/images/file_bt002.jpg" alt="削除" width="70" height="28" /></a></p>
												</div>
												
												<input type="text" name="file<?php echo $fcat; ?>_<?php echo $i; ?>" value="<?php echo $_POST['file'.$fcat."_".$i] ?>" style="display:none;" />
											</div>
										<?php endfor; ?></div></td>
									</tr>
									<tr>
										<th>添付ファイル</th>
										<td id="pdf"><div class="flist"><?php $fcat = 1; for ($i=0; $i<$FILE_NEWS[$fcat]['num']; $i++) : ?>
											<div class="fitem">
												<div class="fimg" id="file<?php echo $fcat; ?>_<?php echo $i; ?>_img"></div>
												
												<div class="fbtn">
													<div class="left" id="file<?php echo $fcat; ?>_<?php echo $i; ?>_ref"><noscript>JavaScriptをONにしてください。</noscript></div>
													<p class="right"><a href="javascript:removeFile(<?php echo $fcat; ?>,<?php echo $i; ?>)"><img src="../common/images/file_bt002.jpg" alt="削除" width="70" height="28" /></a></p>
												</div>
												
												<p class="spacer">リンクタイトル：<br /><textarea name="caption<?php echo $fcat; ?>_<?php echo $i; ?>" class="txt" style="width:140px;height:40px;"><?php echo $_POST['caption'.$fcat.'_'.$i]; ?></textarea></p>
												<input type="text" name="file<?php echo $fcat; ?>_<?php echo $i; ?>" value="<?php echo $_POST['file'.$fcat."_".$i] ?>" style="display:none;" />
											</div>
										<?php endfor; ?></div></td>
									</tr>
								<?php for ($i=1; $i<=$NEWS_LINKNUM; $i++) : ?>
									<tr>
										<th>リンク<?php echo $i; ?></th>
										<td>URL：<input type="text" name="link<?php echo $i; ?>_url" class="txt" style="width:450px;" value="<?php echo $_POST['link'.$i.'_url']; ?>" />
										<p class="spacer">開き方：<?php for ($j=0; $j<count($CMN_LINKTARGET); $j++) : ?>
											<label><input type="radio" name="link<?php echo $i; ?>_target" class="chk" value="<?php echo $CMN_LINKTARGET[$j]['id']; ?>"<?php if ($_POST['link'.$i.'_target'] == $CMN_LINKTARGET[$j]['id']) echo ' checked="checked"'; ?> /> <?php echo $CMN_LINKTARGET[$j]['label']; ?></label>　　
										<?php endfor; ?></p></td>
									</tr>
								<?php endfor; ?>
									<tr>
										<th>公開日時 <span class="require">※</span></th>
										<td><select name="disp_year">
											<?php for ($i=$CMN_DISPYEAR_MIN; $i<=$CMN_DISPYEAR_MAX; $i++) : ?>
											<option value="<?php echo $i; ?>"<?php if ($disp_year == $i) echo ' selected="selected"'; ?>><?php echo $i; ?></option>
											<?php endfor; ?>
										</select> 年
										<select name="disp_month">
											<?php for ($i=1; $i<=12; $i++) : $m = sprintf('%02d',$i); ?>
											<option value="<?php echo $m; ?>"<?php if ($disp_month == $m) echo ' selected="selected"'; ?>><?php echo $m; ?></option>
											<?php endfor; ?>
										</select> 月
										<select name="disp_day">
											<?php for ($i=1; $i<=31; $i++) : $d = sprintf('%02d',$i); ?>
											<option value="<?php echo $d; ?>"<?php if ($disp_day == $d) echo ' selected="selected"'; ?>><?php echo $d; ?></option>
											<?php endfor; ?>
										</select> 日　
										<select name="disp_hour">
											<?php for ($i=0; $i<24; $i++) : $h = sprintf('%02d',$i); ?>
											<option value="<?php echo $h; ?>"<?php if ($disp_hour == $h) echo ' selected="selected"'; ?>><?php echo $h; ?></option>
											<?php endfor; ?>
										</select> 時
										<select name="disp_minute">
											<?php for ($i=0; $i<60; $i++) : $mi = sprintf('%02d',$i); ?>
											<option value="<?php echo $mi; ?>"<?php if ($disp_minute == $mi) echo ' selected="selected"'; ?>><?php echo $mi; ?></option>
											<?php endfor; ?>
										</select> 分</td>
									</tr>
									<tr>
										<th>公開設定 <span class="require">※</span></th>
										<td><?php for ($i=0; $i<count($CMN_DISPFLAG); $i++) : ?>
											<label><input type="radio" name="disp_flag" class="chk" value="<?php echo $CMN_DISPFLAG[$i]['id']; ?>"<?php if ($disp_flag == $CMN_DISPFLAG[$i]['id']) echo ' checked="checked"'; ?> /> <?php echo $CMN_DISPFLAG[$i]['label']; ?></label>　　
										<?php endfor; ?></td>
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
					<li><input type="image" name="imageField" src="../common/images/edit_bt003.jpg" /></li>
					<li><a href="javascript:document.editform.reset()"><img src="../common/images/edit_bt002.jpg" alt="リセット" width="200" height="40" /></a></li>
					<?php else : ?>
					<li><a href="list.php"><img src="../common/images/edit_bt005.jpg" alt="一覧に戻る" width="200" height="40" /></a></li>
					<?php endif; ?>
				</ul>
				<?php if (empty($notfound)) : ?>
				<p class="right"><a href="javascript:preview('<?php echo $DIR_PREVIEW; ?>news/preview.php')"><img src="../common/images/preview_bt002.jpg" alt="表示を確認する" width="200" height="40" /></a></p>
				<?php endif; ?>
				<input type="hidden" name="cmd" value="comp" />
			</div>
		</form>
	</div>
</div>

<script type="text/javascript">
// This is a check for the CKEditor class. If not defined, the paths must be checked.
if ( typeof CKEDITOR == 'undefined' ) {
	document.write(
		'<strong><span style="color: #ff0000">Error</span>: CKEditor not found</strong>.' +
		'This sample assumes that CKEditor (not included with CKFinder) is installed in' +
		'the "/ckeditor/" path. If you have it installed in a different place, just edit' +
		'this file, changing the wrong paths in the &lt;head&gt; (line 5) and the "BasePath"' +
		'value (line 32).' ) ;
} else {
	var editor = CKEDITOR.replace( 'editor1' );
	editor.setData( '<?php echo convert_to_ckhtml($content); ?>' );

	// Just call CKFinder.SetupCKEditor and pass the CKEditor instance as the first argument.
	// The second parameter (optional), is the path for the CKFinder installation (default = "/ckfinder/").
	//CKFinder.setupCKEditor( editor, '../common/ckfinder/' ) ;

	// It is also possible to pass an object with selected CKFinder properties as a second argument.
	// CKFinder.SetupCKEditor( editor, { BasePath : '../../', RememberLastFolder : false } ) ;
}
</script>

<?php require_once($DIR_TEMPLATE."footer.php"); ?>

</body>
</html>