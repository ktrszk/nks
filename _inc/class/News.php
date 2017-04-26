<?php

require_once($DIR_INC."_inc/class/Control.php");

class News extends Control {
	
	protected $MENU_NAME = "新着情報";
	protected $TABLE_NAME = "news";
	
	protected $LIST_COLUMN = "uid,date,title,content,link1_url,link1_target,link2_url,link3_url";
	protected $DETAILS_COLUMN = "uid,date,title,content,img1,link1_url,link1_target,link2_url,link3_url,disp_time,disp_flag";
	
	public function __construct($php, $db) {
		parent::__construct($php, $db);
	}
	
	/* ====================================================================================================
	   共通
	==================================================================================================== */
	// ORDER句
	protected function get_sort_sql($sort="", $desc="") {
		$sql = "";
		if ($sort == "1") {
			$sql .= " ORDER BY date";
			if ($desc == "1") $sql .= " DESC";
		} elseif ($sort == "2") {
			$sql .= " ORDER BY title";
			if ($desc == "1") $sql .= " DESC";
		} elseif ($sort == "3") {
			$sql .= " ORDER BY disp_flag";
			if ($desc == "1") $sql .= " DESC";
			$sql .= ", disp_time";
			if ($desc == "1") $sql .= " DESC";
		} else {
			$sql .= " ORDER BY date DESC, disp_time DESC, uid DESC";
		}
		return $sql;
	}
	
	// プレースホルダ用の配列に格納
	protected function get_item($obj) {
		global $NEWS_LINKNUM, $FILE_NEWS;
		
		$item = array(
			":date" => sprintf('%04d-%02d-%02d',$obj['year'],$obj['month'],$obj['day']),
			":title" => convert_to_sql($obj['title'],"str"),
			":content" => convert_to_sql($obj['content'],"str"),
			":disp_time" => sprintf('%04d-%02d-%02d %02d:%02d',$obj['disp_year'],$obj['disp_month'],$obj['disp_day'],$obj['disp_hour'],$obj['disp_minute']),
			":disp_flag" => convert_to_sql($obj['disp_flag'],"str")
		);
		
		for ($i=0; $i<$FILE_NEWS[0]['num']; $i++) {
			$item[':img'.($i+1)] = convert_to_sql($obj['file0_'.$i],"str");
		}
		
		for ($i=0; $i<$FILE_NEWS[1]['num']; $i++) {
			$item[':pdf'.($i+1)] = convert_to_sql($obj['file1_'.$i],"str");
			$item[':pdf'.($i+1).'_title'] = convert_to_sql($obj['caption1_'.$i],"str");
		}
		
		for ($i=1; $i<=$NEWS_LINKNUM; $i++) {
			$item[':link'.$i.'_url'] = convert_to_sql($obj['link'.$i.'_url'],"str");
			$item[':link'.$i.'_target'] = convert_to_sql($obj['link'.$i.'_target'],"str");
		}
		
		return $item;
	}
	
}

?>