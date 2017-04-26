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
<script type="text/javascript" src="common/js/edit.js"></script>
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
					<span class="require">※</span>は入力必須項目です。<br />
					「表示を確認する」では、募集要項の並び順は入力順になります。保存後は反映されます。</p>
					
					<div id="edit">
						<div class="edit end">
							<h3><a href="javascript:toggleEdit('1')">採用情報</a></h3>
							<div id="edit1">
								<table>
									<tr>
										<th style="width:150px;">タイトル <span class="require">※</span></th>
										<td><input type="text" name="title" class="txt" style="width:500px;" value="<?php echo $title; ?>" /></td>
									</tr>
									<tr>
										<th>エリア <span class="require">※</span></th>
										<td colspan="3"><select name="area">
											<option value="">選択してください</option>
										<?php for ($i=0; $i<count($REC_AREA); $i++) : ?>
											<option value="<?php echo $REC_AREA[$i]['id']; ?>"<?php if ($area == $REC_AREA[$i]['id']) echo ' selected="selected"'; ?>><?php echo $REC_AREA[$i]['label']; ?></option>
										<?php endfor; ?>
										</select></td>
									</tr>
									<tr>
										<th>募集要項</th>
										<td><div id="tlist"><?php
										if ($item_num > 0) {
											$cnt = 0;
											for ($i=0; $i<$item_num; $i++) {
												if ($_POST['item_exist'.$i] == "1") {
													echo get_tpl_item($cnt, '1', $_POST['title'.$i], $_POST['content'.$i.'_1'], $_POST['file1_'.$i.'_1'], $_POST['sort'.$i]);
													$cnt ++;
												}
											}
											$item_num = $cnt;
										}
										?></div>
										<p><a href="javascript:addItem('GET_TPL_ITEM','tlist','1')"><img src="../common/images/list_bt003.jpg" alt="追加" width="60" height="28" /></a></p>
										<input name="item_num" type="hidden" value="<?php echo $item_num; ?>" /></td>
									</tr>
									<tr>
										<th>並び順 <span class="require">※</span></th>
										<td><input type="text" name="sort" class="txt" style="width:50px;text-align:right;ime-mode:inactive;" value="<?php echo $sort; ?>" /></td>
									</tr>
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
				<p class="right"><a href="javascript:preview('<?php echo $DIR_PREVIEW; ?>recruit/preview.php')"><img src="../common/images/preview_bt002.jpg" alt="表示を確認する" width="200" height="40" /></a></p>
				<?php endif; ?>
				<input type="hidden" name="cmd" value="comp" />
			</div>
		</form>
	</div>
</div>

<?php require_once($DIR_TEMPLATE."footer.php"); ?>

</body>
</html>