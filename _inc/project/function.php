<?php

/* ====================================================================================================
   マスター関数
==================================================================================================== */

function master_list_object($list, $param='id') {
	for ($i=0; $i<count($list); $i++) {
		$obj[$list[$i][$param]] = $list[$i];
	}
	return $obj;
}

function master_list_id($list, $param='id') {
	$obj = array();
	for ($i=0; $i<count($list); $i++) {
		array_push($obj,$list[$i][$param]);
	}
	return $obj;
}

function master_detail($list, $id) {
	for ($i=0; $i<count($list); $i++) {
		if ($list[$i]['id'] == $id) {
			return $list[$i];
		}
	}
	return "";
}

function master_detail_param($list, $id, $param="label") {
	for ($i=0; $i<count($list); $i++) {
		if ($list[$i]['id'] == $id) {
			return $list[$i][$param];
		}
	}
	return "";
}

function master_list_category($list,$param="category") {
	$obj = array();
	for ($i=0; $i<count($list); $i++) {
		if (!is_array($obj[$list[$i][$param]])) {
			$obj[$list[$i][$param]] = array();
		}
		array_push($obj[$list[$i][$param]], $list[$i]);
	}
	return $obj;
}

/* ====================================================================================================
   ページャー
==================================================================================================== */

function get_pager_html($total, $limit, $num) {
	$dsp = 10;
	
	$html = '<div class="pager">';
	$html .= '<p>全'.$total.'件中'.min($total-($limit * $num),$limit).'件表示</p>';
	
	if ($total > 0) {
		$max = ceil($total/$limit) - 1;
		
		$html .= '<ul>';
		
		if ($num > 0) {
			$html .= '<li><a href="javascript:changePage('.($num-1).')">&laquo; prev</a></li>';
		} else {
			$html .= '<li>&laquo; prev</li>';
		}
		
		// 表示部
		$start = $num - ($dsp / 2 - 1);
		if ($start < 0) {
			$end = $dsp - 1;
		} else {
			$end = $num + ($dsp / 2);
		}
		
		for ($i=0; $i<=$max; $i++) {
			// 省略部があるとき
			if (($i == 1 && $start > 1) || ($i == $max-1 && $end < $max - 1)) {
				$html .= '<li>..</li>';
			}
			
			if ($i==0 || $i==$max || ($i>=$start && $i<=$end)) {
				if ($num == $i) {
					$html .= '<li><em>'.($i+1).'</em></li>';
				} else {
					$html .= '<li><a href="javascript:changePage('.$i.')" class="page">'.($i+1).'</a></li>';
				}
			}
		}
		
		if ($num < $max) {
			$html .= '<li><a href="javascript:changePage('.($num+1).')">next &raquo;</a></li>';
		} else {
			$html .= '<li>next &raquo;</li>';
		}
		
		$html .= '</ul>';
	}
	
	$html .= '</div>';
	
	return $html;
}

function get_pager_public($total, $limit, $num, $url, $op="") {
	$html = "";
	
	if ($total > 0) {
		$max = ceil($total/$limit) - 1;
		
		if ($max == 0) return $html;
		
		for ($i=0; $i<=$max; $i++) {
			if ($num == $i) {
				$html .= '<li class="current">'.($i+1).'</li>';
			} else {
				$html .= '<li><a href="'.$url.'?p='.$i.$op.'">'.($i+1).'</a></li>';
			}
		}
	}
	
	return $html;
}

// ブログ用
function get_pager_blog($total, $limit, $num, $url, $op="") {
	$dsp = 10;
	$html = "";
	
	if ($total > 0) {
		$max = ceil($total/$limit) - 1;
		
		if ($max == 0) return $html;
		
		$html .= '<ul>';
		
		if ($num > 0) {
			$html .= '<li><a href="'.$url.'?p='.($num-1).$op.'">&laquo; 前のページ</a>｜</li>';
		}
		
		// 表示部
		$start = $num - ($dsp / 2 - 1);
		if ($start < 0) {
			$end = $dsp - 1;
		} else {
			$end = $num + ($dsp / 2);
		}
		
		for ($i=0; $i<=$max; $i++) {
			// 省略部があるとき
			if (($i == 1 && $start > 1) || ($i == $max-1 && $end < $max - 1)) {
				$html .= '<li>..｜</li>';
			}
			
			if ($i==0 || $i==$max || ($i>=$start && $i<=$end)) {
				if ($num == $i) {
					$html .= '<li><em>'.($i+1).'</em>｜</li>';
				} else {
					$html .= '<li><a href="'.$url.'?p='.$i.$op.'">'.($i+1).'</a>｜</li>';
				}
			}
		}
		
		if ($num < $max) {
			$html .= '<li><a href="'.$url.'?p='.($num+1).$op.'">次のページ &raquo;</a></li>';
		}
		
		$html .= '</ul>';
	}
	
	return $html;
}

function get_user_pager($total, $limit, $num) {
	$html = "";
	
	if ($num > 0) {
		$html .= '<a href="javascript:changePage('.($num - 1).');">前へ</a>';
	} else {
		$html .= '前へ';
	}
	
	$html .= ' | ';
	
	if ($num < ceil($total / $limit) - 1) {
		$html .= '<a href="javascript:changePage('.($num + 1).');">次へ</a>';
	} else {
		$html .= '次へ';
	}
	
	return $html;
}


/* ====================================================================================================
   比較関数
==================================================================================================== */

function compare_by_date($a, $b) {
	if ($a['date'] < $b['date']) return 1;
	if ($a['date'] > $b['date']) return -1;
	return 0;
}

?>