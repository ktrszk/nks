<?php

/* ====================================================================================================
   コンバート
==================================================================================================== */

/* データのタグや改行を変換
---------------------------------------------------------------------------------------------------- */
function convert_to_string($str) {
	if (get_magic_quotes_gpc()) {
		$str = stripslashes($str);
	}
	$str = str_replace("&", "&amp;", $str);
	$str = str_replace("<", "&lt;", $str);
	$str = str_replace(">", "&gt;", $str);
	$str = str_replace("\"", "&quot;", $str);
	$str = str_replace("'", "&#39;", $str);
	$str = str_replace(",", "&#44;", $str);
	$str = str_replace("\r\n", "\n", $str);
	$str = str_replace("\r", "\n", $str);
	return $str;
}

// 元に戻す
function convert_to_source($str) {
	$str = str_replace("&amp;", "&", $str);
	$str = str_replace("&lt;", "<", $str);
	$str = str_replace("&gt;", ">", $str);
	$str = str_replace("&quot;", "\"", $str);
	$str = str_replace("&#39;", "'", $str);
	$str = str_replace("&#44;", ",", $str);
	return $str;
}

/* データをHTML表示用に変換
---------------------------------------------------------------------------------------------------- */
function convert_to_html($str) {
	$str = str_replace("&amp;", "&", $str);
	$str = str_replace("&lt;", "<", $str);
	$str = str_replace("&gt;", ">", $str);
	$str = str_replace("&quot;", "\"", $str);
	$str = str_replace("&#39;", "'", $str);
	$str = str_replace("&#44;", ",", $str);
	$str = str_replace("\n", "<br />", $str);
	return $str;
}

function convert_to_wrap($str) {
	$str = str_replace("\n", "<br />", $str);
	return $str;
}

function convert_to_link($str) {
	$list = explode("\n",$str);
	$link = "";
	for ($i=0; $i<count($list); $i++) {
		if (preg_match("/^http/", $list[$i])) {
			$link .= '<a href="'.$list[$i].'" target="_blank">'.$list[$i].'</a>';
		} else {
			$link .= $list[$i];
		}
		$link .= '<br />';
	}
	return $link;
}

// CKEditor用
function convert_to_ckhtml($str) {
	$str = str_replace("&amp;", "&", $str);
	$str = str_replace("&lt;", "<", $str);
	$str = str_replace("&gt;", ">", $str);
	$str = str_replace("&quot;", "\"", $str);
	$str = str_replace("&#39;", "'", $str);
	$str = str_replace("&#44;", ",", $str);
	$str = str_replace("\n", "", $str);
	return $str;
}

/* データをSQL用に変換
---------------------------------------------------------------------------------------------------- */
function convert_to_sql($str, $type) {
	global $ENC_PHP, $ENC_DB;
	
	if ($type == "int") {
		$str = intval($str);
	} elseif ($type == "str") {
		$str = addslashes($str);
		$str = convert_encoding($str, $ENC_DB, $ENC_PHP);
	}
	
	return $str;
}

/* 文字コードを変換
---------------------------------------------------------------------------------------------------- */
function convert_encoding($string, $to, $from) {
	$det_enc = mb_detect_encoding($string, $from.",".$to);
	if ($det_enc and $det_enc != $to) {
		return mb_convert_encoding($string, $to, $det_enc);
	} else {
		return $string;
	}
}

function convert_array_encoding($array) {
	global $ENC_PHP, $ENC_DB;
	
	foreach ($array as $key => $value) {
		$value = convert_encoding($value, $ENC_PHP, $ENC_DB);
		$value = stripslashes($value);
		$array[$key] = $value;
	}
	return $array;
}

/* メール文面用に変換
---------------------------------------------------------------------------------------------------- */
function convert_to_mail($str) {
	global $ENC_PHP;
	
	$str = str_replace("&amp;", "&", $str);
	$str = str_replace("&lt;", "<", $str);
	$str = str_replace("&gt;", ">", $str);
	$str = str_replace("&quot;", "\"", $str);
	$str = str_replace("&#39;", "'", $str);
	$str = str_replace("&#44;", ",", $str);
	
	$str = str_replace("\r\n", "\n", $str);
	$str = str_replace("\r", "\n", $str);
	$str = mb_convert_kana($str, "KV", $ENC_PHP);	// 半角カナ
	
	return $str;
}

/* データを文字カウント用に変換
---------------------------------------------------------------------------------------------------- */
function convert_for_count($str) {
	$str = str_replace("&amp;", "&", $str);
	$str = str_replace("&lt;", "<", $str);
	$str = str_replace("&gt;", ">", $str);
	$str = str_replace("&quot;", "\"", $str);
	$str = str_replace("&#39;", "'", $str);
	$str = str_replace("&#44;", ",", $str);
	return $str;
}

function convert_to_omission($str, $max, $mark) {
	global $ENC_PHP;
	
	$length = mb_strlen(convert_for_count($str), $ENC_PHP);
	if ($length <= $max) {
		return $str;
	} else {
		return mb_substr($str, 0, $max-1, $ENC_PHP).$mark;
	}
}

/* ====================================================================================================
   日付の計算
==================================================================================================== */

// n日後、n日前の日付を求める
function compute_date($year, $month, $day, $addDays) {
	$baseSec = mktime(0, 0, 0, $month, $day, $year);	//基準日を秒で取得
	$addSec = $addDays * 86400;	//日数×１日の秒数
	$targetSec = $baseSec + $addSec;
	return date("Y-m-d", $targetSec);
}

// nヶ月後、nヶ月前の日付を求める
function compute_month($year, $month, $day, $addMonths) {
    $month += $addMonths;
    $endDay = get_month_end_day($year, $month);
    if($day > $endDay) $day = $endDay;
    $dt = mktime(0, 0, 0, $month, $day, $year);
    return date("Y-m-d", $dt);
}

// 任意の年月の月末日を求める
function get_month_end_day($year, $month) {
    $dt = mktime(0, 0, 0, $month + 1, 0, $year);
    return date("d", $dt);
}

// 日付をRSSの日付フォーマットに変換する
function get_date_format_for_rss($date) {
	if (!empty($date)) {
		return date('D, d M Y H:i:s O', strtotime($date));
	} else {
		return "";
	}
}


/* ====================================================================================================
   画像
==================================================================================================== */

/* リサイズ
---------------------------------------------------------------------------------------------------- */
function resize_image($source, $fp, $w, $h=0, $wmin=0, $hmin=0){
	global $IMG_QUALITY;
	
	// ソース画像の解析
	list($sw, $sh, $type, $attr) = getimagesize($source);
	
	// 出力比率の計算
	if ($wmin && $hmin) {
		if ($sw > $sh) {
			$ratio = $hmin / $sh;
		} else {
			$ratio = $wmin / $sw;
		}
	} else {
		if ($h == 0 || $sw / $sh > $w / $h) {
			$ratio = $w / $sw;
		} else {
			$ratio = $h / $sh;
		}
	}
	
	// 出力画像のサイズ
	$fw = ceil($sw * $ratio);
	$fh = ceil($sh * $ratio);
	
	// 元画像の読み込み
	if ($type == 1) {
		$input = @imagecreatefromgif($source);
	} elseif ($type == 2) {
		$input = @imagecreatefromjpeg($source);
	} elseif ($type == 3) {
		$input = @imagecreatefrompng($source);
	}
	$output = @imagecreatetruecolor($fw,$fh); 	// 出力画像の作成
	
	imagecopyresampled($output, $input, 0, 0, 0, 0, $fw, $fh, $sw, $sh);	//コピー
	
	// ファイル生成
	if ($type == 1) {
		$success = imagegif($output, $fp);
	} elseif ($type == 2) {
		$success = imagejpeg($output, $fp, $IMG_QUALITY);
	} elseif ($type == 3) {
		$success = imagepng($output, $fp);
	}
	
	if ($success) {
		chmod($fp, 0666);
	}
	
	return $success;
}

/* 指定フォルダ内のファイルを全て削除する
---------------------------------------------------------------------------------------------------- */
function unlink_all_files($dir) {
	$d = dir($dir);
	
	while($f = $d->read()){
		$fp = $dir.$f;
		if(is_file($fp)){
			unlink($fp);
	    }
	}
}

// ====================================================================================================
// CSV
// ====================================================================================================
function analyzeCSV($csv, $db_enc="utf8", $csv_enc="sjis") {
	// CSV全体を文字列で読込
	$tempCSV = file_get_contents($csv);
	
	// CSVの文字コードを変換
	$tempCSV = mb_convert_encoding($tempCSV, $db_enc, $csv_enc);
	
	// CSV中の\を全角に置換
	$tempCSV = str_replace("\\","￥",$tempCSV);
	
	// 一時ファイルに保存
	$fp = tmpfile();
	fwrite($fp, $tempCSV);
	
	// ファイルポインタを先頭に
	rewind($fp);
	
	// ロケールを設定
	setlocale(LC_ALL, 'ja_JP.UTF-8');
	
	$file_array = array();
	$cnt = 0;
	
	while ($arr = fgetcsv($fp)) {
		// 空行以外を処理
		if (!(count($arr) == 1 && $arr[0] == "")) {
			if ($cnt == 0) {
				$label_array = $arr;
			} else {
				$obj = array();
				for ($i=0; $i<count($label_array); $i++) {
					$obj[$label_array[$i]] = convert_to_string(trim($arr[$i]));
				}
				
				array_push($file_array, $obj);
			}
			$cnt ++;
		}
	}
	
	return $file_array;
}

// ====================================================================================================
// ファイル
// ====================================================================================================
function output_file($path, $msg) {
	$fp = @fopen($path, "w") or die("Error!!n");
	fwrite($fp, $msg);
	fclose($fp);
}

function add_file($path, $msg) {
	$fp = @fopen($path, "a+") or die("Error!!n");
	fputs($fp, $msg);
	fclose($fp);
}

// ====================================================================================================
// ファイル
// ====================================================================================================
function location_distance($lat1, $lon1, $lat2, $lon2) {
	$lat_average = deg2rad( $lat1 + (($lat2 - $lat1) / 2) );//２点の緯度の平均
	$lat_difference = deg2rad( $lat1 - $lat2 );//２点の緯度差
	$lon_difference = deg2rad( $lon1 - $lon2 );//２点の経度差
	$curvature_radius_tmp = 1 - 0.00669438 * pow(sin($lat_average), 2);
	$meridian_curvature_radius = 6335439.327 / sqrt(pow($curvature_radius_tmp, 3));//子午線曲率半径
	$prime_vertical_circle_curvature_radius = 6378137 / sqrt($curvature_radius_tmp);//卯酉線曲率半径
	
	//２点間の距離
	$distance = pow($meridian_curvature_radius * $lat_difference, 2) + pow($prime_vertical_circle_curvature_radius * cos($lat_average) * $lon_difference, 2);
	return $distance = sqrt($distance);
}

?>