<?php

require_once($DIR_INC."_inc/class/Validator.php");

class NewsValidator extends Validator {
	
	public function __construct($php, $db) {
		parent::__construct($php, $db);
	}
	
	/* 初期化
	---------------------------------------------------------------------------------------------------- */
	public function init() {
		$post = array();
		
		$post['year'] = date('Y');
		$post['month'] = date('m');
		$post['day'] = date('d');
		$post['link1_target'] = '1';
		$post['link2_target'] = '1';
		$post['link3_target'] = '1';
		$post['disp_year'] = date('Y');
		$post['disp_month'] = date('m');
		$post['disp_day'] = date('d');
		$post['disp_flag'] = '1';
		
		return $post;
		
	}
	
	/* フォーマット
	---------------------------------------------------------------------------------------------------- */
	public function format($post) {
		
		$post['year'] = $this->format_kana($post['year'], "n");
		$post['month'] = $this->format_kana($post['month'], "n");
		$post['day'] = $this->format_kana($post['day'], "n");
		$post['link1_url'] = $this->format_kana($post['link1_url'], "a");
		$post['link2_url'] = $this->format_kana($post['link2_url'], "a");
		$post['link3_url'] = $this->format_kana($post['link3_url'], "a");
		$post['disp_year'] = $this->format_kana($post['disp_year'], "n");
		$post['disp_month'] = $this->format_kana($post['disp_month'], "n");
		$post['disp_day'] = $this->format_kana($post['disp_day'], "n");
		$post['disp_hour'] = $this->format_kana($post['disp_hour'], "n");
		$post['disp_minute'] = $this->format_kana($post['disp_minute'], "n");
		
		return $post;
		
	}
	
	/* バリデート
	---------------------------------------------------------------------------------------------------- */
	public function validate($post) {
		if ($this->validate_require($post['year']) || $this->validate_require($post['month']) || $this->validate_require($post['day']) || $this->validate_require($post['disp_hour']) || $this->validate_require($post['disp_minute'])) {
			$err .= "日付を選択してください。<br />";
		} elseif ($this->validate_type($post['year'],'numeric') || $this->validate_type($post['month'],'numeric') || $this->validate_type($post['day'],'numeric')) {
			$err .= "日付を数字で選択してください。<br />";
		} elseif (!checkdate($post['month'], $post['day'], $post['year'])) {
			$err .= "日付を実在する日付で選択してください。<br />";
		}
		
		if ($this->validate_require($post['title'])) $err .= "タイトルを入力してください。<br />";
		
		if ($this->validate_require($post['disp_year']) || $this->validate_require($post['disp_month']) || $this->validate_require($post['disp_day']) || $this->validate_require($post['disp_hour']) || $this->validate_require($post['disp_minute'])) {
			$err .= "公開日時を選択してください。<br />";
		} elseif ($this->validate_type($post['disp_year'],'numeric') || $this->validate_type($post['disp_month'],'numeric') || $this->validate_type($post['disp_day'],'numeric') || $this->validate_type($post['disp_hour'],'numeric') || $this->validate_type($post['disp_minute'],'numeric')) {
			$err .= "公開日時を数字で選択してください。<br />";
		} elseif (!checkdate($post['disp_month'], $post['disp_day'], $post['disp_year'])) {
			$err .= "公開日時を実在する日付で選択してください。<br />";
		} elseif ($post['disp_hour'] < 0 || $post['disp_hour'] >= 24 || $post['disp_minute'] < 0 || $post['disp_minute'] >= 60) {
			$err .= "公開日時を選択肢から選択してください。<br />";
		}
		
		if ($this->validate_require($post['disp_flag'])) $err .= "公開設定を選択してください。<br />";
		
		return $err;
		
	}
	
}

?>