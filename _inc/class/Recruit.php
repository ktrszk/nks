<?php

require_once($DIR_INC."_inc/class/Control.php");

class Recruit extends Control {
	
	protected $MENU_NAME = "採用情報";
	protected $TABLE_NAME = "recruit";
	
	protected $LIST_COLUMN = "uid,title,area";
	protected $DETAILS_COLUMN = "uid,title,area,sort,disp_time,disp_flag";
	
	public function __construct($php, $db) {
		parent::__construct($php, $db);
	}
	
	/* ====================================================================================================
	   データ取得
	==================================================================================================== */
	
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
			
			if (!empty($search['area'])) {
				$sql .= " AND area = :area";
			}
			
			$sql .= $this->get_sort_sql($sort, $desc);
			if ($limit > 0) {
				$sql .= " LIMIT :offset, :limit";
			}
			
			if ($sth = $this->start_select_prepare($sql)) {
				if (is_numeric($disp)) $sth->bindValue(':disp_flag', convert_to_sql($disp,"str"));
				if (!empty($search['area'])) $sth->bindValue(':area', convert_to_sql($search['area'],"int"));
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
	
	// 追加項目を取得
	public function get_detail_tpl($id) {
		if ($this->connect()) {
			$list = array();
			
			$sql = "SELECT * FROM ".$this->TABLE_ID.$this->TABLE_NAME."_item WHERE recruit_id = :recruit_id ORDER BY sort,uid";
			
			if ($sth = $this->start_select_prepare($sql)) {
				$sth->bindValue(':recruit_id', convert_to_sql($id,"int"));
				
				if ($this->execute_select_prepare($sth)) {
					while ($row = $this->get_fetch_prepare_array($sth)) {
						array_push($list, $row);
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
			if ($this->start_transaction()) {
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
						$complete = TRUE;
						
						// 追加項目
						$id = $this->get_insert_id();
						$complete = $this->insert_item($obj, $id);
						
						if ($complete) {
							$this->end_transaction(TRUE);
							return TRUE;
						}
					} else {
						$this->err = $this->MENU_NAME."を登録できませんでした。";
					}
				}
				
				$this->end_transaction(FALSE);
			} else {
				$this->err = $this->MENU_NAME."のトランザクションを開始できませんでした。";
			}
		}
		return FALSE;
	}
	
	// 追加項目の登録
	private function insert_item($obj, $id) {
		$complete = TRUE;
		
		$list = $this->get_tpl_item($obj, $id);
		
		if (count($list) > 0) {
			$col = "";
			$cnt = 0;
			foreach ($list[0] as $k => $v) {
				if ($cnt > 0) {
					$col .= ",";
				}
				$col .= $k;
				$cnt ++;
			}
			$sql = "INSERT INTO ".$this->TABLE_ID.$this->TABLE_NAME."_item(".str_replace(":","",$col).") VALUES(".$col.")";
			
			if ($sth = $this->start_prepare($sql)) {
				if ($this->execute_prepare($sth, $list)) {
					
				} else {
					$this->err = "募集要項を登録できませんでした。";
					$complete = FALSE;
				}
			} else {
				$this->err = "募集要項を登録準備できませんでした。";
				$complete = FALSE;
			}
		}
		
		return $complete;
	}
	
	// 更新
	public function update($obj, $id) {
		global $SYSTEM_SESSION;
		
		if ($this->connect()) {
			if ($this->start_transaction()) {
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
						$complete = TRUE;
						
						// 追加項目の更新
						$complete = $this->update_item($obj, $id);
						
						if ($complete) {
							$this->end_transaction(TRUE);
							return TRUE;
						}
					} else {
						$this->err = $this->MENU_NAME."を更新できませんでした。";
					}
				}
				
				$this->end_transaction(FALSE);
			} else {
				$this->err = $this->MENU_NAME."のトランザクションを開始できませんでした。";
			}
		}
		return FALSE;
	}
	
	// 追加項目の更新
	private function update_item($obj, $id) {
		$complete = TRUE;
		
		// 既存情報を削除
		
		$sql = "DELETE FROM ".$this->TABLE_ID.$this->TABLE_NAME."_item WHERE recruit_id = :recruit_id";
			
		if ($sth = $this->start_prepare($sql)) {
			$list = array();
			
			array_push($list, array(":recruit_id"=>convert_to_sql($id, "int")));
			
			if ($this->execute_prepare($sth, $list)) {
				// 新規追加
				$complete = $this->insert_item($obj, $id);
			} else {
				$this->err = "募集要項を削除できませんでした。";
				$complete = FALSE;
			}
			
		} else {
			$this->err = "募集要項を削除準備できませんでした。";
			$complete = FALSE;
		}
		
		return $complete;
	}
	
	/* ====================================================================================================
	   共通
	==================================================================================================== */
	// ORDER句
	protected function get_sort_sql($sort="", $desc="") {
		$sql = "";
		if ($sort == "1") {
			$sql .= " ORDER BY sort";
			if ($desc == "1") $sql .= " DESC";
		} elseif ($sort == "2") {
			$sql .= " ORDER BY area";
			if ($desc == "1") $sql .= " DESC";
		} elseif ($sort == "3") {
			$sql .= " ORDER BY title";
			if ($desc == "1") $sql .= " DESC";
		} elseif ($sort == "4") {
			$sql .= " ORDER BY disp_flag";
			if ($desc == "1") $sql .= " DESC";
			$sql .= ", disp_time";
			if ($desc == "1") $sql .= " DESC";
		} else {
			$sql .= " ORDER BY sort, uid DESC";
		}
		return $sql;
	}
	
	// プレースホルダ用の配列に格納
	protected function get_item($obj) {
		$item = array(
			":title" => convert_to_sql($obj['title'],"str"),
			":area" => convert_to_sql($obj['area'],"int"),
			":sort" => convert_to_sql($obj['sort'],"int"),
			":disp_time" => sprintf('%04d-%02d-%02d %02d:%02d',$obj['disp_year'],$obj['disp_month'],$obj['disp_day'],$obj['disp_hour'],$obj['disp_minute']),
			":disp_flag" => convert_to_sql($obj['disp_flag'],"str")
		);
		
		return $item;
	}
	
	// 追加項目
	private function get_tpl_item($obj, $id) {
		$list = array();
		
		for ($i=0; $i<$obj['item_num']; $i++) {
			if ($obj['item_exist'.$i] == '1') {
				$item = array(
					":recruit_id" => convert_to_sql($id,"int"),
					":title" => convert_to_sql($obj['title'.$i],"str"),
					":content" => convert_to_sql($obj['content'.$i.'_1'],"str"),
					":sort" => convert_to_sql($obj['sort'.$i],"int")
				);
				array_push($list, $item);
			}
		}
		
		return $list;
	}
	
}

?>