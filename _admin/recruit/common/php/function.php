<?php

/* テンプレートフィールドを取得
---------------------------------------------------------------------------------------------------- */
function get_tpl_item($num, $type, $title="", $content1="", $image1="", $sort="") {
	$cnt = $num + 1;
	
	$fcat = 1;
	
	$html = <<<EOL
		<div id="titem{$num}" class="titem">
			【{$cnt}】
			<p>項目名　
			<input type="text" name="title{$num}" class="txt" style="width:447px;" value="{$title}" /></p>

EOL;
	
	if ($type == '1') {
		$html .= <<<EOL
			<p>内容</p>
			<textarea name="content{$num}_1" class="txt" style="width:500px;height:60px;">{$content1}</textarea>

EOL;
	}
	
	$html .= <<<EOL
			<p class="spacer">並び順　
			<input type="text" name="sort{$num}" class="txt aright" style="width:50px;ime-mode:inactive;" value="{$sort}" /></p>
			<p class="spacer"><a href="javascript:removeItem('titem{$num}')">× 削除</a></p>
			<input type="hidden" name="type{$num}" value="{$type}" />
			<input type="hidden" name="item_exist{$num}" value="1" />
		</div>
EOL;
	
	return $html;
}

?>