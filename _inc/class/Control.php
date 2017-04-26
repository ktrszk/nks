<?php

require_once($DIR_INC."_inc/class/Connection.php");

class Control extends Connection {
	
	protected $MENU_NAME = "";
	protected $TABLE_NAME = "";
	
	protected $LIST_COLUMN = "";
	protected $DETAILS_COLUMN = "";
	
	public function __construct($php, $db) {
		parent::__construct($php, $db);
	}
	
	/* ====================================================================================================
	   データ取得
	==================================================================================================== */
	// 総数を取得
	public function get_count($disp="") {
		if ($this->connect()) {
			$sql = "SELECT COUNT(*) FROM ".$this->TABLE_ID.$this->TABLE_NAME." WHERE delete_flag = '0'";
			if (is_numeric($disp)) {
				$sql .= " AND disp_flag = :disp_flag";
				if ($disp == '1') $sql .= " AND disp_time <= '".date('Y-m-d H:i')."'";
			}
			if ($sth = $this->start_select_prepare($sql)) {
				if (is_numeric($disp)) $sth->bindValue(':disp_flag', convert_to_sql($disp,"str"));
				
				return $this->get_prepare_rows($sth);
			}
		}
		return FALSE;
	}
	
	/* 一覧
	---------------------------------------------------------------------------------------------------- */
	// 一覧を取得
	public function get_list($offset, $limit, $disp="", $sort="", $desc="", $search="") {
		if ($this->connect()) {
			$list = array();
			
			$sql = "SELECT ".$this->LIST_COLUMN." FROM ".$this->TABLE_ID.$this->TABLE_NAME." WHERE delete_flag = '0'";
			if (is_numeric($disp)) {
				$sql .= " AND disp_flag = :disp_flag";
				if ($disp == '1') $sql .= " AND disp_time <= '".date('Y-m-d H:i')."'";
			}
			$sql .= $this->get_sort_sql($sort, $desc);
			if ($limit > 0) {
				$sql .= " LIMIT :offset, :limit";
			}
			
			if ($sth = $this->start_select_prepare($sql)) {
				if (is_numeric($disp)) $sth->bindValue(':disp_flag', convert_to_sql($disp,"str"));
				if ($limit > 0) {
					$sth->bindValue(':offset', convert_to_sql($offset,"int"), PDO::PARAM_INT);
					$sth->bindValue(':limit', convert_to_sql($limit,"int"), PDO::PARAM_INT);
				}
				
				if ($this->execute_select_prepare($sth)) {
					while ($row = $this->get_fetch_prepare_array($sth)) {
						$row = convert_array_encoding($row);
						array_push($list, $row);
					}
				}
			}
			
			return $list;
		}
		return FALSE;
	}
	
	// 検索結果の一覧を取得
	public function get_list_by_search($search, $disp="", $sort="", $desc="") {
		if ($this->connect()) {
			$list = array();
			
			$sql = "SELECT uid FROM ".$this->TABLE_ID.$this->TABLE_NAME." WHERE delete_flag = '0'";
			if (is_numeric($disp)) {
				$sql .= " AND disp_flag = :disp_flag";
				if ($disp == '1') $sql .= " AND disp_time <= '".date('Y-m-d H:i')."'";
			}
			
			$sql .= $this->get_sort_sql($sort, $desc);
			
			if ($sth = $this->start_select_prepare($sql)) {
				if (is_numeric($disp)) $sth->bindValue(':disp_flag', convert_to_sql($disp,"str"));
				
				if ($this->execute_select_prepare($sth)) {
					while ($row = $this->get_fetch_prepare_array($sth)) {
						array_push($list, $row['uid']);
					}
				}
			}
			
			return $list;
		}
		return FALSE;
	}
	
	// UIDをキーとした一覧を取得
	public function get_list_as_uid($disp="", $sort="", $desc="") {
		if ($this->connect()) {
			$list = array();
			
			$sql = "SELECT ".$this->LIST_COLUMN." FROM ".$this->TABLE_ID.$this->TABLE_NAME." WHERE delete_flag = '0'";
			if (is_numeric($disp)) {
				$sql .= " AND disp_flag = :disp_flag";
				if ($disp == '1') $sql .= " AND disp_time <= '".date('Y-m-d H:i')."'";
			}
			
			$sql .= $this->get_sort_sql($sort, $desc);
			
			if ($sth = $this->start_select_prepare($sql)) {
				if (is_numeric($disp)) $sth->bindValue(':disp_flag', convert_to_sql($disp,"str"));
				
				if ($rs = $this->execute_select_prepare($sth)) {
					while ($row = $this->get_fetch_prepare_array($sth)) {
						$row = convert_array_encoding($row);
						$list[$row['uid']] = $row;
					}
				}
			}
			
			return $list;
		}
		return FALSE;
	}
	
	/* 詳細
	---------------------------------------------------------------------------------------------------- */
	// 詳細を取得
	public function get_detail($id, $disp="") {
		if ($this->connect()) {
			$sql = "SELECT * FROM ".$this->TABLE_ID.$this->TABLE_NAME." WHERE delete_flag = '0' AND uid = :uid";
			if (is_numeric($disp)) {
				$sql .= " AND disp_flag = :disp_flag";
				if ($disp == '1') $sql .= " AND disp_time <= '".date('Y-m-d H:i')."'";
			}
			
			if ($sth = $this->start_select_prepare($sql)) {
				$sth->bindValue(':uid', convert_to_sql($id, "int"));
				if (is_numeric($disp)) $sth->bindValue(':disp_flag', convert_to_sql($disp,"str"));
				
				if ($this->execute_select_prepare($sth)) {
					if ($row = $this->get_fetch_prepare_array($sth)) {
						$row = convert_array_encoding($row);
						return $row;
					}
				}
			}
			$this->err = "選択された".$this->MENU_NAME."は存在しません。";
		}
		return FALSE;
	}
	
	// 指定IDの詳細を取得
	public function get_details_by_id($id) {
		if ($this->connect()) {
			$list = array();
			
			$sql = "SELECT ".$this->DETAILS_COLUMN." FROM ".$this->TABLE_ID.$this->TABLE_NAME." WHERE delete_flag = '0'";
			
			// ID
			if (is_array($id)) {
				$sql .= " AND uid IN (";
				for ($i=0; $i<count($id); $i++) {
					if ($i > 0) $sql .= ",";
					$sql .= ":uid".$i;
				}
				$sql .= ")";
			}
			
			if ($sth = $this->start_select_prepare($sql)) {
				if (is_array($id)) {
					for ($i=0; $i<count($id); $i++) {
						$sth->bindValue(':uid'.$i, convert_to_sql($id[$i], "int"));
					}
				}
				
				if ($this->execute_select_prepare($sth)) {
					while ($row = $this->get_fetch_prepare_array($sth)) {
						$row = convert_array_encoding($row);
						$list[$row['uid']] = $row;
					}
				}
			}
			
			return $list;
		}
		return FALSE;
	}
	
	/* ====================================================================================================
	   データ更新
	==================================================================================================== */
	// 新規追加
	public function insert($obj) {
		global $SYSTEM_SESSION;
		
		if ($this->connect()) {
			// カラム=>値
			$item = $this->get_item($obj);
			
			// 固有項目
			$item[":update_user"] = convert_to_sql($_SESSION[$SYSTEM_SESSION]['id'],"int");
			
			// SQL
			$col = "";
			$cnt = 0;
			foreach ($item as $k => $v) {
				if ($cnt > 0) {
					$col .= ",";
				}
				$col .= $k;
				$cnt ++;
			}
			$sql = "INSERT INTO ".$this->TABLE_ID.$this->TABLE_NAME."(".str_replace(":","",$col).",delete_flag,insert_time,update_time) VALUES(".$col.",'0',now(),now())";
			
			if ($sth = $this->start_prepare($sql)) {
				$list = array();
				array_push($list, $item);
				
				if ($this->execute_prepare($sth, $list)) {
					return TRUE;
				} else {
					$this->err = $this->MENU_NAME."を登録できませんでした。";
				}
			}
		}
		return FALSE;
	}
	
	// 更新
	public function update($obj, $id) {
		global $SYSTEM_SESSION;
		
		if ($this->connect()) {
			// カラム=>値
			$item = $this->get_item($obj);
			
			// 固有項目
			$item[":update_user"] = convert_to_sql($_SESSION[$SYSTEM_SESSION]['id'],"int");
			
			// SQL
			$col = "";
			$cnt = 0;
			foreach ($item as $k => $v) {
				if ($cnt > 0) {
					$col .= ",";
				}
				$col .= str_replace(":","",$k)." = ".$k;
				$cnt ++;
			}
			$sql = "UPDATE ".$this->TABLE_ID.$this->TABLE_NAME." SET ".$col.",update_time = now() WHERE uid = :uid";

			if ($sth = $this->start_prepare($sql)) {
				// WHERE句のプレースホルダ
				$item[':uid'] = convert_to_sql($id,"int");
				
				$list = array();
				array_push($list, $item);
				
				if ($this->execute_prepare($sth, $list)) {
					return TRUE;
				} else {
					$this->err = $this->MENU_NAME."を更新できませんでした。";
				}
			}
		}
		return FALSE;
	}
	
	// 並び順更新
	public function update_sort($id, $sort) {
		global $SYSTEM_SESSION;
		
		if ($this->connect()) {
			$sql = "UPDATE ".$this->TABLE_ID.$this->TABLE_NAME." SET sort = :sort, update_time = now(), update_user = :update_user WHERE uid = :uid";
			
			if ($sth = $this->start_prepare($sql)) {
				$list = array();
				$item = array(
					":sort" => convert_to_sql($sort,"int"),
					":uid" => convert_to_sql($id, "int"),
					":update_user" => convert_to_sql($_SESSION[$SYSTEM_SESSION]['id'], "int")
				);
				array_push($list, $item);
				
				if ($this->execute_prepare($sth, $list)) {
					return TRUE;
				} else {
					$this->err = $this->MENU_NAME."（No.：".sprintf("%04d",$id)."）を登録できませんでした。";
				}
			}
		}
		return FALSE;
	}
	
	// 削除
	public function delete($id) {
		global $SYSTEM_SESSION;
		
		if ($this->connect()) {
			$sql = "UPDATE ".$this->TABLE_ID.$this->TABLE_NAME." SET delete_flag = '1', update_time = now(), update_user = :update_user WHERE uid = :uid";
			
			if ($sth = $this->start_prepare($sql)) {
				$list = array();
				$item = array(
					":uid" => convert_to_sql($id, "int"),
					":update_user" => convert_to_sql($_SESSION[$SYSTEM_SESSION]['id'], "int")
				);
				array_push($list, $item);
				
				if ($this->execute_prepare($sth, $list)) {
					return TRUE;
				} else {
					$this->err = $this->MENU_NAME."を削除できませんでした。";
				}
			}
		}
		return FALSE;
	}
	
	/* ====================================================================================================
	   共通
	==================================================================================================== */
	// ORDER句
	protected function get_sort_sql($sort="", $desc="") {
		$sql = "";
		return $sql;
	}
	
	// プレースホルダ用の配列に格納
	protected function get_item($obj) {
		$item = array();
		return $item;
	}
	
}

?>