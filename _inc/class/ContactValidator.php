<?php

require_once($DIR_INC."_inc/class/Validator.php");

class ContactValidator extends Validator {
	
	public function __construct($php, $db) {
		parent::__construct($php, $db);
	}
	
	/* 初期化
	---------------------------------------------------------------------------------------------------- */
	public function init() {
		$post = array();
		
		return $post;
		
	}
	
	/* フォーマット
	---------------------------------------------------------------------------------------------------- */
	public function format($post) {
		
		$post['kana01'] = $this->format_kana($post['kana01'], "CHV");
		$post['kana02'] = $this->format_kana($post['kana02'], "CHV");
		$post['email1'] = $this->format_kana($post['email1'], "a");
		$post['email2'] = $this->format_kana($post['email2'], "a");
		$post['tel1'] = $this->format_kana($post['tel1'], "n");
		$post['tel2'] = $this->format_kana($post['tel2'], "n");
		$post['tel3'] = $this->format_kana($post['tel3'], "n");
		
		return $post;
		
	}
	
	public function format_add($post) {
		
		return $post;
		
	}
	
	/* バリデート
	---------------------------------------------------------------------------------------------------- */
	public function validate($post) {
		if ($this->validate_require($post['name01']) || $this->validate_require($post['name02'])) $err .= "氏名を入力してください。<br />";
		if ($this->validate_require($post['kana01']) || $this->validate_require($post['kana02'])) $err .= "氏名フリガナを入力してください。<br />";
		
		if ($this->validate_require($post['email'])) {
			$err .= "メールアドレスを入力してください。<br />";
		} elseif ($this->validate_format($post['email'],"/^([a-zA-Z0-9])+([a-z,A-Z,0-9,\/,\.,\$,_,-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/")) {
			$err .= "メールアドレスを正確に入力してください。<br />";
		} elseif ($post['email'] != $post['email2']) {
			$err .= "メールアドレスが確認用と一致していません。<br />";
		}
		
		if ($this->validate_require($post['tel1']) || $this->validate_require($post['tel2']) || $this->validate_require($post['tel3'])) $err .= "連絡先電話番号を入力してください。<br />";
		if ($this->validate_require($post['category'])) {
			$err .= "お問い合わせ内容を選択してください。<br />";
		} elseif ($this->validate_require($post['message'])) {
			$err .= "お問い合わせ内容を入力してください。<br />";
		}
		
		return $err;
		
	}
	
}

?>