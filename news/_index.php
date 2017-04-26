<!DOCTYPE HTML>
<html lang="ja">
<head>
<meta charset="utf-8" />
<title>NEWS | 建物総合管理/ビルメンテナンスのNKSコーポレーション(新潟管財)</title>

<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="Description" content="建物総合管理/ビルメンテナンスのNKSコーポレーション(新潟管財)。お客さまの大切な財産・健康を守り、安心・安全・笑顔あふれる環境をつくること、それが私たちの仕事です。皆さまの快適な環境をつくる仕事に携わるものとして、あらゆる事業活動を通じて、持続可能な(Sustainability)社会の発展に貢献していきます。" />
<meta name="Keywords" content="新潟管財,NKSコーポレーション,アスパック,ビルメンテナンス,建物総合管理,指定管理者制度,省エネ事業" />

<link rel="shortcut icon" href="../favicon.ico" />
<link href="assets/css/style.css" rel="stylesheet" media="screen" />
<script type="text/javascript" src="assets/js/script.js"></script>
<script type="text/javascript" src="../common/js/heightLine.js"></script>

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
<li><a href="../news/"><img src="../common/img/header_menu1_on.gif" width="160" height="70" alt="新着情報" title="新着情報" /></a></li>
<li><a href="../service/"><img src="../common/img/header_menu2_off.gif" width="160" height="70" alt="業務内容" title="業務内容" /></a></li>
<li><a href="../company/"><img src="../common/img/header_menu3_off.gif" width="160" height="70" alt="企業情報" title="企業情報" /></a></li>
<li><a href="../recruit/"><img src="../common/img/header_menu4_off.gif" width="160" height="70" alt="採用情報" title="採用情報" /></a></li>
<li><a href="../contact/" rel="colorboxIframe"><img src="../common/img/header_menu5_off.gif" width="160" height="70" alt="お問い合わせ" title="お問い合わせ" /></a></li>
</ul>

</nav>
</section>
</header><!-- /#header -->

<article id="contents">
<section id="pagetitle" class="body">
<h1><a href="../news/"><img src="assets/img/pagetitle.gif" width="191" height="45" alt="NEWS 新着情報" title="NEWS 新着情報" /></a></h1>
</section><!-- /#pagetitle -->

<section id="entry" class="body clearfix">
<?php if (empty($notfound)) : ?>
<?php if (!empty($detail['img1']) || !empty($detail['img2']) || !empty($detail['img3'])) : ?><div class="image"><?php for ($i=1; $i<=$FILE_NEWS[0]['num']; $i++) : if (!empty($detail['img'.$i])) : ?><p><img src="<?php echo $DIR_INC.$FILE_NEWS[0]['dir'][0]['path'].$detail['img'.$i]; ?>" alt="" /></p><?php endif; endfor; ?></div><?php endif; ?>
<div class="article"<?php if (empty($detail['img1']) && empty($detail['img2']) && empty($detail['img3'])) echo ' style="width:auto;"'; ?>>
<hgroup>
<h1 class="entry_title"><?php echo $detail['title']; ?></h1>
<h2 class="entry_date">‘<?php echo date('y  m/d', strtotime($detail['date'])); ?> </h2>
</hgroup>
<article>
<?php echo convert_to_ckhtml($detail['content']); ?>
<?php if (!empty($detail['pdf1']) || !empty($detail['pdf2']) || !empty($detail['pdf3'])) : ?>
<dl>
<dt>●ダウンロード</dt>
<dd>
<ul>
<?php for ($i=1; $i<=$FILE_NEWS[1]['num']; $i++) : if ($detail['pdf'.$i]) : ?>
<li><a href="<?php echo $DIR_INC.$FILE_NEWS[1]['dir'][0]['path'].$detail['pdf'.$i]; ?>" target="_blank"><?php echo (!empty($detail['pdf'.$i.'_title'])) ? $detail['pdf'.$i.'_title'] : '添付ファイル'.$i.'を表示する'; ?></a></li>
<?php endif; endfor; ?>
</ul>
</dd>
</dl>
<?php endif; ?>
<?php if (!empty($detail['link1_url']) || !empty($detail['link2_url']) || !empty($detail['link3_url'])) : ?>
<dl>
<dt>●関連リンク</dt>
<dd>
<ul>
<?php for ($i=1; $i<=$NEWS_LINKNUM; $i++) : if ($detail['link'.$i.'_url']) : ?>
<li><a href="<?php echo $detail['link'.$i.'_url']; ?>" target="<?php echo ($detail['link'.$i.'_target'] == '1') ? '_self' : '_blank'; ?>"><?php echo $detail['link'.$i.'_url']; ?></a></li>
<?php endif; endfor; ?>
</ul>
</dd>
</dl>
<?php endif; ?>
</article>
</div>
<?php else : ?>
<?php echo $notfound; ?>
<?php endif; ?>
</section><!-- /#entry -->

<section id="archives_area">
<section id="archives" class="body">
<h1 id="archive_title"><img src="assets/img/archive_title.gif" width="100" height="40" alt="過去の記事" title="過去の記事" /></a></h1>
<article>
<ul class="clearfix">

<?php for ($i=0; $i<count($list); $i++) : $details = $detailList[$list[$i]]; ?>
<li class="clearfix heightLine-a<?php echo floor($i/3); ?>">
<div class="entry_thumbnail"><p><img src="<?php echo (!empty($details['img1'])) ? $DIR_INC.$FILE_NEWS[0]['dir'][1]['path'].$details['img1'] : 'assets/img/noimg.gif'; ?>" alt="<?php echo $details['title']; ?>" title="<?php echo $details['title']; ?>" /></p></div>
<div class="entry_date">‘<?php echo date('y  m/d', strtotime($details['date'])); ?><?php if ($details['date'] >= $NEW_DAY) : ?><img src="assets/img/icon_new.gif" width="35" height="9" alt="NEW" title="NEW" /><?php endif; ?></div>
<div class="entry_title"><?php if (empty($details['content']) && empty($details['link1_url']) && empty($details['link2_url']) && empty($details['link3_url'])) : ?>
<?php echo $details['title']; ?></span><?php elseif (empty($details['content']) && !empty($details['link1_url']) && empty($details['link2_url']) && empty($details['link3_url'])) : ?>
<a href="<?php echo $details['link1_url']; ?>" target="<?php echo ($details['link1_target'] == "1") ? '_self' : '_blank'; ?>"><?php echo $details['title']; ?></a></span><?php else : ?>
<a href="?id=<?php echo $details['uid']; ?>"><?php echo $details['title']; ?></a></span><?php endif; ?></div>
</li>
<?php endfor; ?>

</ul>
</article>
<ul id="pagenavi">
<?php echo $pager; ?>
<!--
<li class="current">1</li>
<li><a href="">2</a></li>
<li><a href="">3</a></li>
-->
</ul>
</section><!-- /#archives -->
</section><!-- /#archives_area -->

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