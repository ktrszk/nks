<?php

/* ====================================================================================================
   インポート
==================================================================================================== */
$DIR = "../../";
$DIR_INC = $DIR."";

require_once($DIR_INC."_inc/project/import.php");
require_once($DIR_INC."_inc/project/param_admin.php");
require_once($DIR_INC."_inc/class/Recruit.php");
require_once($DIR_INC."_inc/class/RecruitValidator.php");

/* ====================================================================================================
   変数定義
==================================================================================================== */
$MENU_ID = "recruit";
$MENU_TITLE = "採用情報管理";
$PAGE_MENU = "採用情報";
$PAGE_TITLE = "一覧";
$SNAVI_ACT = 'article';

$SES_LABEL = "recruit_list";

$LIST_MAX = 20;

/* ====================================================================================================
   初期処理
==================================================================================================== */
require_once($DIR_TEMPLATE."init.php");

/* ====================================================================================================
   実行処理
==================================================================================================== */
$SearchObj = new Recruit($ENC_PHP, $ENC_DB);

if ($cmd == "sort") {
	$ValidatorObj = new RecruitValidator($ENC_PHP, $PHP_DB);
	
	foreach ($_POST as $key => $value) {
		if (is_numeric(strpos($key,"sort-"))) {
			$error = $ValidatorObj->validate_sort($value);
			if (empty($error)) {
				$uid = str_replace("sort-","",$key);
				if ($SearchObj->update_sort($uid, $value) == FALSE) {
					$err = $SearchObj->get_error();
					break;
				}
			} else {
				break;
			}
		}
	}
	if (empty($error)) $success = "並び順を保存しました。";
}

if ($cmd == "search") {
	// 検索条件の保存
	$_SESSION[$SES_LABEL] = $_POST;
	header("Location:list.php?c=Search");
	exit;
} elseif (empty($_GET['c'])) {
	unset($_SESSION[$SES_LABEL]);
}

// 総数を取得
if ($resultList = $SearchObj->get_list_by_search($_SESSION[$SES_LABEL], "", $_SESSION[$SES_LABEL]['s'], $_SESSION[$SES_LABEL]['sa'])) {
	$total = count($resultList);
} else {
	$total = 0;
	$error = $SearchObj->get_error();
}

if ($total > 0) {
	// ページャーを生成
	if (empty($_SESSION[$SES_LABEL]['p']) || $_SESSION[$SES_LABEL]['p'] < 0 || $total == 0) {
		$_SESSION[$SES_LABEL]['p'] = 0;
	} else if ($_SESSION[$SES_LABEL]['p'] >= $total / $LIST_MAX) {
		$_SESSION[$SES_LABEL]['p'] = ceil($total/$LIST_MAX) - 1;
	}
	$pager = get_pager_html($total, $LIST_MAX, $_SESSION[$SES_LABEL]['p']);
	
	// 一覧を取得
	$start = $_SESSION[$SES_LABEL]['p'] * $LIST_MAX;
	$count = min($total-$start, $LIST_MAX);
	$list = array_slice($resultList, $start, $count);
	$detailList = $SearchObj->get_details_by_id($list);
	
	$DISPFLAG_OBJ = master_list_object($CMN_DISPFLAG);
	$AREA_OBJ = master_list_object($REC_AREA);
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php require_once($DIR_TEMPLATE."meta.php"); ?>
<script type="text/javascript" src="../common/js/list.js"></script>
</head>

<body class="col2">

<?php require_once($DIR_TEMPLATE."header.php"); ?>

<div id="main">
	<?php require_once("sidebar.php"); ?>
	
	<div id="contents">
		<div id="title">
			<h1><?php echo $PAGE_MENU; ?></h1>
			<p class="right"><a href="new.php"><img src="../common/images/list_bt001.jpg" alt="新規作成" width="200" height="40" /></a></p>
		</div>
		
		<form name="listform" method="post" action="">
			<div class="content">
				<h2><?php echo $PAGE_TITLE; ?></h2>
				<div class="inner">
					<?php if (!empty($success)) : ?><p class="success"><?php echo $success; ?></p><?php endif; ?>
					<?php if (!empty($error)) : ?><p class="error"><?php echo $error; ?></p><?php endif; ?>
					
					<?php if ($total > 0) echo $pager; ?>
					
					<div id="list">
						<div id="lcontrol">
							<div class="left">
								<select name="cmdlist" class="txt vmiddle">
									<option value="sort">並び順を保存</option>
								</select>
								<a href="javascript:executeCmd()"><img src="../common/images/list_bt002.jpg" class="vmiddle" width="60" height="28" /></a>
							</div>
						</div>
						
						<?php if ($total > 0) : ?>
						<table class="list">
							<tr>
								<th<?php $ss = 1; if ($_SESSION[$SES_LABEL]['s']==$ss) echo ($_SESSION[$SES_LABEL]['sa']=="0") ? ' class="sort1"' : ' class="sort2"'; ?> style="width:60px;"><a href="javascript:changeSort(<?php echo $ss; ?>,<?php echo ($_SESSION[$SES_LABEL]['s']==$ss && $_SESSION[$SES_LABEL]['sa']=="0") ? '1' : '0'; ?>)">並び順</a></th>
								<th<?php $ss = 2; if ($_SESSION[$SES_LABEL]['s']==$ss) echo ($_SESSION[$SES_LABEL]['sa']=="0") ? ' class="sort1"' : ' class="sort2"'; ?> style="width:210px;"><a href="javascript:changeSort(<?php echo $ss; ?>,<?php echo ($_SESSION[$SES_LABEL]['s']==$ss && $_SESSION[$SES_LABEL]['sa']=="0") ? '1' : '0'; ?>)">エリア</a></th>
								<th<?php $ss = 3; if ($_SESSION[$SES_LABEL]['s']==$ss) echo ($_SESSION[$SES_LABEL]['sa']=="0") ? ' class="sort1"' : ' class="sort2"'; ?>><a href="javascript:changeSort(<?php echo $ss; ?>,<?php echo ($_SESSION[$SES_LABEL]['s']==$ss && $_SESSION[$SES_LABEL]['sa']=="0") ? '1' : '0'; ?>)">タイトル</a></th>
								<th<?php $ss = 4; if ($_SESSION[$SES_LABEL]['s']==$ss) echo ($_SESSION[$SES_LABEL]['sa']=="0") ? ' class="sort1"' : ' class="sort2"'; ?> style="width:100px;"><a href="javascript:changeSort(<?php echo $ss; ?>,<?php echo ($_SESSION[$SES_LABEL]['s']==$ss && $_SESSION[$SES_LABEL]['sa']=="0") ? '1' : '0'; ?>)">公開状態</a></th>
								<th style="width:40px;">コピー</th>
							</tr>
							<?php for ($i=0; $i<count($list); $i++) : $detail = $detailList[$list[$i]]; ?>
							<tr>
								<td><input type="text" name="sort-<?php echo $detail['uid']; ?>" class="txt aright" style="width:40px;ime-mode:inactive;" value="<?php echo $detail['sort']; ?>" /></td>
								<td><?php echo $AREA_OBJ[$detail['area']]['label']; ?></td>
								<td><a href="edit.php?id=<?php echo $detail['uid']; ?>"><?php echo $detail['title']; ?></a></td>
								<td><?php if (date('Y-m-d H:i') < $detail['disp_time']) : ?><p class="disp2"><?php echo $CMN_DISPTIME_BEFORE; ?></p><span class="small"><?php echo date('Y/m/d H:i',strtotime($detail['disp_time'])); ?></span>
								<?php else : ?><p class="disp<?php echo $detail['disp_flag']; ?>"><?php echo $DISPFLAG_OBJ[$detail['disp_flag']]['list']; ?></p><?php endif; ?></td>
								<td><a href="new.php?copy=<?php echo $detail['uid']; ?>">コピー</a></td>
							</tr>
							<?php endfor; ?>
						</table>
						
						<?php else : ?>
						<p>データがありません。</p>
						<?php endif; ?>
						
						<input type="hidden" name="p" value="" />
						<input type="hidden" name="s" value="<?php echo $_SESSION[$SES_LABEL]['s']; ?>" />
						<input type="hidden" name="sa" value="<?php echo $_SESSION[$SES_LABEL]['sa']; ?>" />
						<input type="hidden" name="cmd" value="search" />
					</div>
					
					<?php if ($total > 0) echo $pager; ?>
				</div>
			</div>
		</form>
	</div>
</div>

<?php require_once($DIR_TEMPLATE."footer.php"); ?>

</body>
</html>