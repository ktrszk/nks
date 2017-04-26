<?php

class Login {
	
	// ユーザーリスト
	private $USER_LIST = array(
		0 => array(	// 管理者
			'id'=>'1',
			'account'=>'nksadmin',
			'password'=>'19640526',
			'name'=>'管理者',
			'type'=>'ADMIN'
		)
	);
	
	// ユーザータイプ別の権限
	private $ROLE_LIST = array(
		'ROOT'=>'10',
		'ADMIN'=>'5'
	);
	
	public function __construct($php, $db) {
	}
	
	public function __get($key) {
		return $this->$key;
	}
	
	// ログイン時のチェック
	public function login_system($account, $password) {
		foreach ($this->USER_LIST as $i => $user) {
			if ($account == $user['account'] && $password == $user['password']) {
				$user['role'] = $this->ROLE_LIST[$user['type']];
				return $user;
			}
		}
		return FALSE;
	}
	
	// ページ毎のアカウント有効チェック
	public function check_status($account, $date, $role='5') {
		foreach ($this->USER_LIST as $i => $user) {
			if ($account == crypt($user['account'], $date)) {
				if ($this->ROLE_LIST[$user['type']] >= $role) {
					return TRUE;
				} else {
					unset($_SESSION['user']);
					return FALSE;
				}
			}
		}
		unset($_SESSION['user']);
		return FALSE;
	}
	
}

?>