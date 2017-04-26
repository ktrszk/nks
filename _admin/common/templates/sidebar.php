	<div id="sidebar">
		<div id="stitle">
			<table>
				<tr>
					<th><?php echo $MENU_TITLE; ?></th>
				</tr>
			</table>
		</div>
		
		<ul id="snavi" style="background-position: left <?php for ($i=0; $i<count($SNAVI_LIST); $i++) { if ($SNAVI_LIST[$i]['id'] == $SNAVI_ACT) { break; } } echo $i * 40; ?>px">
			<?php for ($i=0; $i<count($SNAVI_LIST); $i++) : ?>
			<li class="sbtn <?php echo ($SNAVI_LIST[$i]['id'] == $SNAVI_ACT) ? 'act' : 'no'; ?>"><a href="<?php echo $SNAVI_LIST[$i]['url']; ?>"><span><?php echo $SNAVI_LIST[$i]['label']; ?></span></a></li>
			<?php endfor; ?>
		</ul>
	</div>