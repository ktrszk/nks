<?php

/* ====================================================================================================
   インポート
==================================================================================================== */
$DIR = "";
$DIR_INC = $DIR."";

require_once($DIR_INC."_inc/project/import.php");
require_once($DIR_INC."_inc/class/News.php");

/* ====================================================================================================
   変数定義
==================================================================================================== */

/* ====================================================================================================
   実行処理
==================================================================================================== */
$NewsObj = new News($ENC_PHP, $ENC_DB);
$newsList = $NewsObj->get_list(0,5,'1');

?>
<!DOCTYPE HTML>
<html lang="ja">
<head>
<meta charset="utf-8" />
<title>建物総合管理/ビルメンテナンスのNKSコーポレーション(新潟管財)</title>

<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="Description" content="建物総合管理/ビルメンテナンスのNKSコーポレーション(新潟管財)。お客さまの大切な財産・健康を守り、安心・安全・笑顔あふれる環境をつくること、それが私たちの仕事です。皆さまの快適な環境をつくる仕事に携わるものとして、あらゆる事業活動を通じて、持続可能な(Sustainability)社会の発展に貢献していきます。" />
<meta name="Keywords" content="新潟管財,NKSコーポレーション,アスパック,ビルメンテナンス,建物総合管理,指定管理者制度,省エネ事業" />

<link rel="shortcut icon" href="favicon.ico" />
<link href="assets/css/style.css" rel="stylesheet" media="screen" />
<script type="text/javascript" src="assets/js/script.js"></script>

<!--[if lt IE 9]>
<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<!--[if lte IE 6 ]>
<script type="text/javascript" src="common/js/DD_belatedPNG.js"></script>
<script type="text/javascript" src="common/js/ie6.js"></script>
<![endif]-->

</head>

<body id="index" class="home">
	<noscript></noscript>
<div id="wrapper">
<header id="header">
<section class="body clearfix">
<h1><img src="common/img/header_logo.gif" width="160" height="70" alt="NKSコーポレーション" title="NKSコーポレーション" /></h1>
<nav id="gnavi">
<ul>
<li><a href="news/"><img src="common/img/header_menu1_off.gif" width="160" height="70" alt="新着情報" title="新着情報" /></a></li>
<li><a href="service/"><img src="common/img/header_menu2_off.gif" width="160" height="70" alt="業務内容" title="業務内容" /></a></li>
<li><a href="company/"><img src="common/img/header_menu3_off.gif" width="160" height="70" alt="企業情報" title="企業情報" /></a></li>
<li><a href="recruit/"><img src="common/img/header_menu4_off.gif" width="160" height="70" alt="採用情報" title="採用情報" /></a></li>
<li><a href="contact/" rel="colorboxIframe"><img src="common/img/header_menu5_off.gif" width="160" height="70" alt="お問い合わせ" title="お問い合わせ" /></a></li>
</ul>
</nav>
</section>
</header><!-- /#header -->

<article id="contents">
<section id="top_article">
<article id="concept" class="body">
<p><img src="assets/img/concept1.png" width="226" height="51" alt="環境を創る" title="環境を創る" /></p>
<p><img src="assets/img/concept2.png" width="288" height="50" alt="陰ながら支える" title="陰ながら支える" /></p>
<p><img src="assets/img/concept3.png" width="378" height="50" alt="空に向かって伸びる" title="空に向かって伸びる" /></p>
<p id="concept_logo"><img src="assets/img/concept4.png" width="390" height="68" alt="NKSコーポレーション(新潟管財)" title="NKSコーポレーション(新潟管財)" /></p>
</article><!-- /#concept -->

<article id="news" class="body">
<h1><img src="assets/img/news_title.png" width="458" height="60" alt="LATEST NEWS 新着情報" title="LATEST NEWS 新着情報" /></h1>
<ul>
<?php for ($i=0; $i<count($newsList); $i++) : ?>
<li><span class="news_item"><span class="date"><?php echo date('y/m/d', strtotime($newsList[$i]['date'])); ?></span><?php if (empty($newsList[$i]['content']) && empty($newsList[$i]['link1_url']) && empty($newsList[$i]['link2_url']) && empty($newsList[$i]['link3_url'])) : ?>
<?php echo $newsList[$i]['title']; ?></span><?php elseif (empty($newsList[$i]['content']) && !empty($newsList[$i]['link1_url']) && empty($newsList[$i]['link2_url']) && empty($newsList[$i]['link3_url'])) : ?>
<a href="<?php echo $newsList[$i]['link1_url']; ?>" target="<?php echo ($newsList[$i]['link1_target'] == "1") ? '_self' : '_blank'; ?>"><?php echo $newsList[$i]['title']; ?></a></span><?php else : ?>
<a href="news/?id=<?php echo $newsList[$i]['uid']; ?>"><?php echo $newsList[$i]['title']; ?></a></span><?php endif; ?></li>
<?php endfor; ?>
</ul>
<div class="btn_more">
<a href="news/"><img src="assets/img/news_btn1_off.png" width="140" height="37" alt="新着情報" title="新着情報" /></a>
</div>
</article><!-- /#news -->

<article id="service">
<h1><img src="assets/img/service_title.png" width="309" height="60" alt="SERVICE 業務内容" title="SERVICE 業務内容" /></h1>
<!-- <p>ダミー文です。ヨーロッパでは、ギリシャの財政危機を引き金に信用不安が広がり、<br />
世界経済にも大きな影響を与えている。１２年のヨーロッパ経済の<br />
見通しについて、パリ支局・野尻仁記者が報告する。ダミー文です。ヨーロッパでは、<br />
ギリシャの財政危機を引き金に信用不安が広がり、世界経済にも大きな影響を与えている。<br />
１２年のヨーロッパ経済の見通しについて、パリ支局・野尻仁記者が報告する。</p> -->
<div class="btn_more">
<ul class="clearfix">
<li><a href="service/#building_management"><img src="assets/img/service_btn1_off.png" width="232" height="48" alt="建物総合管理業務" title="建物総合管理業務" /></a></li>
<li><a href="service/#designated_manager"><img src="assets/img/service_btn2_off.png" width="232" height="48" alt="指定管理者業務" title="指定管理者業務" /></a></li>
<li><a href="service/#enegy_conservation"><img src="assets/img/service_btn3_off.png" width="232" height="48" alt="省エネ業務" title="省エネ業務" /></a></li>
<li><a href="service/#management_products"><img src="assets/img/service_btn4_off.png" width="232" height="48" alt="建物管理商品販売" title="建物管理商品販売" /></a></li>
</ul>
</div>
</article><!-- /#service -->

<article id="company" class="body">
<div id="company_contents">
<h1><img src="assets/img/company_title.png" width="327" height="60" alt="COMPANY 企業情報" title="COMPANY 企業情報" /></h1>
<!-- <p>ダミー文です。ヨーロッパでは、ギリシャの財政危機を引き金に信用不安が広がり、<br />
世界経済にも大きな影響を与えている。１２年のヨーロッパ経済の<br />
見通しについて、パリ支局・野尻仁記者が報告する。ダミー文です。ヨーロッパでは、<br />
ギリシャの財政危機を引き金に信用不安が広がり、世界経済にも大きな影響を与えている。<br />
１２年のヨーロッパ経済の見通しについて、パリ支局・野尻仁記者が報告する。</p> -->
<div class="btn_more">
<ul class="clearfix">
<li><a href="company/#greeting"><img src="assets/img/company_btn1_off.png" width="150" height="48" alt="ご挨拶" title="ご挨拶" /></a></li>
<li><a href="company/#philosophy"><img src="assets/img/company_btn2_off.png" width="150" height="48" alt="企業理念" title="企業理念" /></a></li>
<li><a href="company/#outline"><img src="assets/img/company_btn3_off.png" width="150" height="48" alt="会社概要" title="会社概要" /></a></li>
<li><a href="company/#csr"><img src="assets/img/company_btn5_off.png" width="150" height="48" alt="CSR" title="CSR" /></a></li>
</ul>
</div>
</div><!-- /#company_contents -->
</article><!-- /#company -->

<article id="recruit">
<h1><img src="assets/img/recruit_title.png" width="274" height="53" alt="RECRUIT 採用情報" title="RECRUIT 採用情報" /></h1>
<!-- <p>ダミー文です。ヨーロッパでは、ギリシャの財政危機を引き金に信用不安が広がり、<br />
世界経済にも大きな影響を与えている。１２年のヨーロッパ経済の<br />
見通しについて、パリ支局・野尻仁記者が報告する。ダミー文です。ヨーロッパでは、<br />
ギリシャの財政危機を引き金に信用不安が広がり、世界経済にも大きな影響を与えている。<br />
１２年のヨーロッパ経済の見通しについて、パリ支局・野尻仁記者が報告する。</p> -->
<div class="btn_more">
<a href="recruit/"><img src="assets/img/recruit_btn1_off.png" width="140" height="37" alt="詳細はこちら" title="詳細はこちら" /></a>
</div>
</article><!-- /#recruit -->
</section><!-- /#top_article -->

<section id="top_bg_item1">
<div id="bird1"><img src="assets/img/bg_item_bird1.png" width="383" height="329" /></div>
</section><!-- /#top_bg_item1 -->

<section id="top_bg_item2">
<div id="airplane"><img src="assets/img/bg_item_airplane.png" width="791" height="219" /></div>
</section><!-- /#top_bg_item2 -->

<section id="top_bg_item3">
<div id="tree"><img src="assets/img/bg_item_tree.png" width="913" height="793" /></div>
</section><!-- /#top_bg_item3 -->

<section id="top_bg_item4">
<div id="balloon_cloud"><img src="assets/img/bg_item_balloon_cloud.png" width="1126" height="470" /></div>
<div id="balloons"><img src="assets/img/bg_item_balloons.png" width="506" height="391" /></div>
</section><!-- /#top_bg_item4 -->

<section id="top_bg_item5">
<div id="balloon1"><img src="assets/img/bg_item_balloon1.png" width="350" height="429" /></div>
</section><!-- /#top_bg_item5 -->

<section id="top_bg_item6">
<div id="balloon2"><img src="assets/img/bg_item_balloon2.png" width="749" height="270" /></div>
</section><!-- /#top_bg_item6 -->

<section id="top_bg_item7">
<div id="balloon3"><img src="assets/img/bg_item_balloon3.png" width="400" height="189" /></div>
</section><!-- /#top_bg_item7 -->

<section id="top_bg_item8">
<div id="bird2"><img src="assets/img/bg_item_bird2.png" width="443" height="331" /></div>
</section><!-- /#top_bg_item8 -->

<section id="top_bg_item9">
<div id="balloon4"><img src="assets/img/bg_item_balloon4.png" width="292" height="205" /></div>
</section><!-- /#top_bg_item9 -->

<section id="top_bg_item10">
<div id="bird3"><img src="assets/img/bg_item_bird3.png" width="235" height="107" /></div>
</section><!-- /#top_bg_item10 -->

</article><!-- /#contents -->

<footer id="footer">
<section>
<a href="#index" id="pagetop"><img src="common/img/btn_pagetop_off.gif" width="22" height="34" alt="Back to PageTop" title="Back to PageTop"></a>
</section>
<section class="body clearfix">
<p class="copyright"><img src="common/img/footer_logo.gif" width="268" height="69" alt="" title=""></p>
<div id="privacy" class="right"><a href="privacy/" rel="colorboxIframe"><img src="common/img/footer_privacy_off.gif" width="71" height="5" alt="PRIVACY POLICY" title="PRIVACY POLICY" /></a></div>
</section>
</footer><!-- /#footer -->

</div><!-- /#wrapper -->

</body>
</html>