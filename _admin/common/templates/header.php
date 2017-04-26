<div id="header">
	<div class="inner">
		<div class="left"><?php
		if (!empty($_SESSION[$SYSTEM_SESSION]['system']) && $_SESSION[$SYSTEM_SESSION]['system'] == $SYSTEM_ID) :
		?><form name="menuform" method="post" action="">
			<select name="menu" class="sel" onchange="changeMenu()">
				<option value="">メニューを選択してください</option>
				<optgroup label="ホームページ管理メニュー">
					<?php for ($i=0; $i<count($SYSTEM_MENU); $i++) : ?>
					<option value="<?php echo $DIR_ADMIN.$SYSTEM_MENU[$i]['url']; ?>"<?php if ($SYSTEM_MENU[$i]['id'] == $MENU_ID) echo ' selected="selected"'; ?>><?php echo $SYSTEM_MENU[$i]['label']; ?></option>
					<?php endfor; ?>
				</optgroup>
			</select>
		</form><?php
		else :
			echo '<p>'.$CORPORATE_NAME.'　管理ページ</p>';
		endif;
		?></div>
		<?php if (!empty($_SESSION[$SYSTEM_SESSION]['system']) && $_SESSION[$SYSTEM_SESSION]['system'] == $SYSTEM_ID) : ?>
		<ul class="right">
			<li>Hello, <?php echo $_SESSION[$SYSTEM_SESSION]['name']; ?> 様</li>
			<li>| <a href="<?php echo $DIR; ?>" target="_blank">ホームページ確認</a></li>
			<li>| <a href="<?php echo $DIR_ADMIN; ?>menu.php">管理メニュー</a></li>
			<li>| <a href="<?php echo $DIR_ADMIN; ?>logout.php">ログアウト</a></li>
		</ul>
		<?php endif; ?>
	</div>
</div>

