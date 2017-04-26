<?php

require_once($DIR_INC."_inc/class/Validator.php");

class RecruitValidator extends Validator {
	
	public function __construct($php, $db) {
		parent::__construct($php, $db);
	}
	
	/* 初期化
	---------------------------------------------------------------------------------------------------- */
	public function init() {
		$post = array();
		
		$post['disp_year'] = date('Y');
		$post['disp_month'] = date('m');
		$post['disp_day'] = date('d');
		$post['disp_flag'] = 1;
		
		return $post;
		
	}
	
	/* フォーマット
	---------------------------------------------------------------------------------------------------- */
	public function format($post) {
		
		$post['disp_year'] = $this->format_kana($post['disp_year'], "n");
		$post['disp_month'] = $this->format_kana($post['disp_month'], "n");
		$post['disp_day'] = $this->format_kana($post['disp_day'], "n");
		$post['disp_hour'] = $this->format_kana($post['disp_hour'], "n");
		$post['disp_minute'] = $this->format_kana($post['disp_minute'], "n");
		
		for ($i=0; $i<$post['item_num']; $i++) {
			$post['sort'.$i] = $this->format_kana($post['sort'.$i], "n");
		}
		
		return $post;
		
	}
	
	/* バリデート
	---------------------------------------------------------------------------------------------------- */
	public function validate($post) {
		
		if ($this->validate_require($post['title'])) $err .= "タイトルを入力してください。<br />";
		if ($this->validate_require($post['area'])) $err .= "エリアを選択してください。<br />";
		
		$cnt = 1;
		for ($i=0; $i<$post['item_num']; $i++) {
			if ($post['item_exist'.$i] == "1") {
				if ($this->validate_require($post['title'.$i])) $err .= "募集要項【".$cnt."】の質問を入力してください。<br />";
				if (!$this->validate_require($post['sort'.$i])) {
					if ($this->validate_type($post['sort'.$i],"numeric")) $err .= "募集要項【".$cnt."】の並び順を数字で入力してください。<br />";
				}
				$cnt ++;
			}
		}
		
		if ($this->validate_require($post['sort'])) {
			$err .= "並び順を入力してください。<br />";
		} elseif ($this->validate_type($post['sort'],'numeric')) {
			$err .= "並び順を数字で入力してください。<br />";
		}
		
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
	
	public function validate_posting($post) {
		
		if ($this->validate_require($post['t_name'])) $err .= "被推薦者の名前を入力してください。<br />";
		if ($this->validate_require($post['r_name'])) $err .= "推薦者の名前を入力してください。<br />";
		if ($this->validate_require($post['r_city'])) $err .= "お住まいの市町村を選択してください。<br />";
		if ($this->validate_require($post['reco'])) $err .= "推薦文を入力してください。<br />";
		
		if ($this->validate_require($post['r_zip1']) || $this->validate_require($post['r_zip2'])) {
			$err .= "推薦者の郵便番号を入力してください。<br />";
		} elseif ($this->validate_type($post['r_zip1'],"numeric") || $this->validate_type($post['r_zip2'],"numeric")) {
			$err .= "推薦者の郵便番号を数字で入力してください。<br />";
		} elseif ($this->validate_length($post['r_zip1'],3,3) || $this->validate_length($post['r_zip2'],4,4)) {
			$err .= "推薦者の郵便番号を上3桁、下4桁で入力してください。<br />";
		}
		if ($this->validate_require($post['r_address'])) $err .= "推薦者の住所を入力してください。<br />";
		if ($this->validate_require($post['r_tel1']) || $this->validate_require($post['r_tel2']) || $this->validate_require($post['r_tel3'])) {
			$err .= "推薦者の電話番号を入力してください。<br />";
		} elseif ($this->validate_type($post['r_tel1'],"numeric") || $this->validate_type($post['r_tel2'],"numeric") || $this->validate_type($post['r_tel3'],"numeric")) {
			$err .= "推薦者の電話番号を数字で入力してください。<br />";
		}
		if ($this->validate_require($post['r_email'])) {
			$err .= "推薦者のメールアドレスを入力してください。<br />";
		} elseif ($this->validate_format($post['r_email'],"/^([a-zA-Z0-9])+([a-z,A-Z,0-9,\/,\.,\$,_,-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/")) {
			$err .= "推薦者のメールアドレスを正確に入力してください。<br />";
		}
		
		if (!$this->validate_require($post['t_zip1']) || !$this->validate_require($post['t_zip2'])) {
			if ($this->validate_require($post['t_zip1']) || $this->validate_require($post['t_zip2'])) {
				$err .= "被推薦者の郵便番号をすべて入力してください。<br />";
			} elseif ($this->validate_type($post['t_zip1'],"numeric") || $this->validate_type($post['t_zip2'],"numeric")) {
				$err .= "被推薦者の郵便番号を数字で入力してください。<br />";
			} elseif ($this->validate_length($post['t_zip1'],3,3) || $this->validate_length($post['t_zip2'],4,4)) {
				$err .= "被推薦者の郵便番号を上3桁、下4桁で入力してください。<br />";
			}
		}
		if (!$this->validate_require($post['t_tel1']) || !$this->validate_require($post['t_tel2']) || !$this->validate_require($post['t_tel3'])) {
			if ($this->validate_require($post['t_tel1']) || $this->validate_require($post['t_tel2']) || $this->validate_require($post['t_tel3'])) {
				$err .= "被推薦者の電話番号をすべて入力してください。<br />";
			} elseif ($this->validate_type($post['t_tel1'],"numeric") || $this->validate_type($post['t_tel2'],"numeric") || $this->validate_type($post['t_tel3'],"numeric")) {
				$err .= "被推薦者の電話番号を数字で入力してください。<br />";
			}
		}
		if (!$this->validate_require($post['t_email'])) {
			if ($this->validate_format($post['t_email'],"/^([a-zA-Z0-9])+([a-z,A-Z,0-9,\/,\.,\$,_,-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/")) {
				$err .= "被推薦者のメールアドレスを正確に入力してください。<br />";
			}
		}
		
		return $err;
		
	}
	
	public function validate_sort($sort) {
		
		if ($this->validate_require($sort)) {
			$err .= "並び順を入力してください。<br />";
		} elseif ($this->validate_type($sort,"numeric")) {
			$err .= "並び順を半角数字で入力してください。<br />";
		}
		
		return $err;
		
	}
	
}

?>