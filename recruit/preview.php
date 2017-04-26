<?php

/* ====================================================================================================
   インポート
==================================================================================================== */
$DIR = "../";
$DIR_INC = $DIR."";

require_once($DIR_INC."_inc/project/import.php");
require_once($DIR_INC."_inc/project/param_admin.php");

/* ====================================================================================================
   変数定義
==================================================================================================== */
$MENU_ID = "recruit";

/* ====================================================================================================
   実行処理
==================================================================================================== */

// プレビュー情報
$detail = $_POST;

$tpl = array();
for ($i=0; $i<$item_num; $i++) {
	if ($_POST['item_exist'.$i] == "1") {
		$obj = array();
		$obj['type'] = '1';
		$obj['title'] = $_POST['title'.$i];
		$obj['content'] = $_POST['content'.$i.'_1'];
		
		array_push($tpl, $obj);
	}
}

?>
<!DOCTYPE HTML>
<html lang="ja">
<head>
<meta charset="utf-8" />
<title>RECRUIT | 建物総合管理/ビルメンテナンスのNKSコーポレーション(新潟管財)</title>

<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="Description" content="建物総合管理/ビルメンテナンスのNKSコーポレーション(新潟管財)。お客さまの大切な財産・健康を守り、安心・安全・笑顔あふれる環境をつくること、それが私たちの仕事です。皆さまの快適な環境をつくる仕事に携わるものとして、あらゆる事業活動を通じて、持続可能な(Sustainability)社会の発展に貢献していきます。" />
<meta name="Keywords" content="新潟管財,NKSコーポレーション,アスパック,ビルメンテナンス,建物総合管理,指定管理者制度,省エネ事業" />

<link rel="shortcut icon" href="../favicon.ico" />
<link href="assets/css/style.css" rel="stylesheet" media="screen" />
<script type="text/javascript" src="assets/js/script.js"></script>

<!--[if lt IE 9]>
<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<!--[if lte IE 6 ]>
<script type="text/javascript" src="../common/js/DD_belatedPNG.js"></script>
<script type="text/javascript" src="../common/js/ie6.js"></script>
<![endif]-->

</head>

<body id="index" class="home">
	<noscript></noscript>
<header id="header">
<section class="body clearfix">
<h1><a href="../"><img src="../common/img/header_logo.gif" width="160" height="70" alt="NKSコーポレーション" title="NKSコーポレーション" /></a></h1>
<nav id="gnavi">
<ul>
<li><a href="../news/"><img src="../common/img/header_menu1_off.gif" width="160" height="70" alt="新着情報" title="新着情報" /></a></li>
<li><a href="../service/"><img src="../common/img/header_menu2_off.gif" width="160" height="70" alt="業務内容" title="業務内容" /></a></li>
<li><a href="../company/"><img src="../common/img/header_menu3_off.gif" width="160" height="70" alt="企業情報" title="企業情報" /></a></li>
<li><a href="../recruit/"><img src="../common/img/header_menu4_on.gif" width="160" height="70" alt="採用情報" title="採用情報" /></a></li>
<li><a href="../contact/" rel="colorboxIframe"><img src="../common/img/header_menu5_off.gif" width="160" height="70" alt="お問い合わせ" title="お問い合わせ" /></a></li>
</ul>

</nav>
</section>
</header><!-- /#header -->

<article id="contents">

<div id="contents_rows" class="body clearfix">
<div id="sidearea">
<section id="pagetitle" class="body">
<h1><img src="assets/img/pagetitle.gif" width="265" height="103" alt="RECRUIT 採用情報" title="RECRUIT 採用情報" /></h1>
</section><!-- /#pagetitle -->
<nav>
<ul>
<?php for ($i=0; $i<count($REC_AREA); $i++) : ?>
<li><a href="?area=<?php echo $REC_AREA[$i]['id']; ?>"><img src="assets/img/menu_area<?php echo $REC_AREA[$i]['id']; ?>_<?php echo $area == $REC_AREA[$i]['id'] ? 'on' : 'off'; ?>.gif" width="265" height="40" alt="<?php echo $REC_AREA[$i]['title']; ?>" title="<?php echo $REC_AREA[$i]['title']; ?>" /></a></li>
<?php endfor; ?>
</ul>
</nav>
</div>

<article>
<section>
<h2><?php echo $detail['title']; ?></h2>
<table>
<?php
for ($i=0; $i<count($tpl); $i++) :
?>
<tr><th><?php echo $tpl[$i]['title']; ?></th><td><?php echo convert_to_wrap($tpl[$i]['content']); ?></td></tr>
<?php endfor; ?>
</table>
</section>

</article>

</article><!-- /#contents -->

<footer id="footer">
<section>
<a href="#index" id="pagetop"><img src="../common/img/btn_pagetop_off.gif" width="22" height="34" alt="Back to PageTop" title="Back to PageTop"></a>
</section>
<section class="body clearfix">
<p class="copyright"><img src="../common/img/footer_logo.gif" width="268" height="69" alt="" title=""></p>
<div id="privacy" class="right"><a href="../privacy/" rel="colorboxIframe"><img src="../common/img/footer_privacy_off.gif" width="71" height="5" alt="PRIVACY POLICY" title="PRIVACY POLICY" /></a></div>
</section>
</footer><!-- /#footer -->

</body>
</html>