<?php

class Validator {
	protected $enc_php;
	private $enc_db;
	
	public function __construct($php, $db) {
		$this->enc_php = $php;
		$this->enc_db = $db;
	}
	
	/* フォーマット
	---------------------------------------------------------------------------------------------------- */
	
	// カナ変換
	protected function format_kana($value, $option) {
		if (!empty($value)) {
			$value = mb_convert_kana($value, $option, $this->enc_php);
		}
		return $value;
	}
	
	/* バリデート
	---------------------------------------------------------------------------------------------------- */
	
	// 必須チェック
	protected function validate_require($value) {
		if (empty($value) && !is_numeric($value)) return TRUE;
		return FALSE;
	}
	
	// 形式チェック
	protected function validate_format($value, $format) {
		if (!preg_match($format, $value)) return TRUE;
		return FALSE;
	}
	
	// 文字数チェック
	protected function validate_length($value, $min, $max) {
		$value = convert_for_count($value);
		if ($min == NULL) {
			if (mb_strlen($value,$this->enc_php) > $max) return TRUE;
		} elseif ($max == NULL) {
			if (mb_strlen($value,$this->enc_php) < $min) return TRUE;
		} elseif (mb_strlen($value,$this->enc_php) < $min || mb_strlen($value,$this->enc_php) > $max) {
			return TRUE;
		}
		return FALSE;
	}
	
	// データ型チェック
	protected function validate_type($value, $type) {
		if ($type == "numeric") {
			return !is_numeric($value);
		} elseif ($type == "array") {
			return !is_array($value);
		}
	}
	
}

?>