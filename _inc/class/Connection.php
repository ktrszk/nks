<?php

class Connection {
	// サーバー接続設定
	private $DB_HOST = "fsv00114401.mysql.db.fsv.jp";
	private $DB_USER = "nkswxYZyz";
	private $DB_PASS = "UVNPNPabAB";
	private $DB_NAME = "mysql";
	protected $TABLE_ID = "nks_";
	
	// 文字コード
	protected $enc_php;
	protected $enc_db;
	
	protected $con;	// 接続変数
	protected $err;	// エラー
	
	public function __construct($php, $db) {
		$this->enc_php = $php;
		$this->enc_db = $db;
	}
	
	public function __get($key) {
		return $this->$key;
	}
	
	public function __set($key, $value) {
		$this->$key = $value;
	}
	
	public function set_db($db) {
		$this->DB_HOST = $db['host'];
		$this->DB_USER = $db['user'];
		$this->DB_PASS = $db['password'];
		$this->DB_NAME = $db['name'];
	}
	
	// エラーを返す
	public function get_error() {
		return $this->err;
	}
	
	// 接続
	protected function connect() {
		if (empty($this->con)) {
			try {
				$this->con = new PDO('mysql:host='.$this->DB_HOST.';dbname='.$this->DB_NAME.';', $this->DB_USER, $this->DB_PASS);
			} catch(PDOException $e) {
				$this->err = "データベースに接続できませんでした。";
				return FALSE;
			}
			
			$this->con->query("SET NAMES ".$this->enc_db.";");
		}
		return TRUE;
	}
	
	// 接続を閉じる
	public function close() {
		if (!empty($this->con)) {
			$this->con = NULL;
		}
	}
	
	// DB処理
	protected function execution($sql) {
		return $this->con->query($sql);
	}
	
	// レコード数を取得
	protected function get_rows($rs) {
		//return $rs->fetchColumn();
	}
	
	// SQLからレコード数を取得
	protected function get_rows_by_sql($sql) {
		if ($rs = $this->execution($sql)) {
			return $rs->fetchColumn();
		}
		return FALSE;
	}
	
	// レコードを取得
	protected function get_fetch_array($rs) {
		return $rs->fetch(PDO::FETCH_ASSOC);
	}
	
	// 最後に挿入したレコードのIDを取得
	public function get_insert_id() {
		return $this->con->lastInsertId();
	}
	
	/* プレースホルダ
	---------------------------------------------------------------------------------------------------- */
	// プレースホルダ
	public function start_prepare($sql) {
		return $this->con->prepare($sql);
	}
	
	// プレースホルダ実行
	public function execute_prepare($sth, $list) {
		for ($i=0; $i<count($list); $i++) {
			foreach ($list[$i] as $key => $value) {
				$sth->bindValue($key, $value);
			}
			if (!$sth->execute()) return FALSE;
		}
		return TRUE;
	}
	
	// SELECTプレースホルダ
	public function start_select_prepare($sql) {
		return $this->con->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
	}
	
	// SELECTプレースホルダ実行
	public function execute_select_prepare($sth) {
		return $sth->execute();
	}
	
	// プレースホルダのレコード数を取得
	protected function get_prepare_rows($sth) {
		if ($sth->execute()) {
			return $sth->fetchColumn();
		}
		return FALSE;
	}
	
	// レコードを取得
	protected function get_fetch_prepare_array($sth) {
		return $sth->fetch(PDO::FETCH_ASSOC);
	}
	
	/* トランザクション
	---------------------------------------------------------------------------------------------------- */
	// トランザクション開始
	public function start_transaction() {
		if ($this->connect()) {
			return $this->con->beginTransaction();
		}
		return FALSE;
	}
	
	// トランザクション終了
	public function end_transaction($commit) {
		if ($commit) {
			return $this->con->commit();
		} else {
			return $this->con->rollback();
		}
	}
	
}

?>