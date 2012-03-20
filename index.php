
<?php
session_start();
require "imagesharing/header2.php";
$search_query = check_input($_REQUEST['query']);
$totalcount = $config[GalleryPhotoNo];
$limit = check_input($_REQUEST['limit']);
if ($limit == "") {
	$limit = $config[GalleryPhotoPerPage];
}
$start = check_input($_REQUEST['start']);
if ($start == "") {
	$start = 0;
}
$displaystart = $start +1;
$displayend = ($start + $limit > $totalcount ? $totalcount : $start + $limit);
if ($displayend == $totalcount) {
	$nextset = 0;
} else {
	$nextset = ($totalcount - $displayend > $limit ? $limit : ($totalcount - $displayend));
}

$sort = check_input($_REQUEST['sort']);
if ($sort == "") {
	$sort = "added";
}

if ($search_query != "") {
	$query = "select i.filename as filename, i.tn_filename as tn_filename, i.filepath as filepath, i.added as add_dt, i.ip as ip, i.filesize as filesize, sum(ih.kb) as bandwidth, count( ih.filename ) as ctr from images i left outer join imagehits ih on i.filename = ih.filename where i.prv='0' and i.filename LIKE '%" . $search_query . "%' group by filename order by " . $sort . " desc limit " . $start . "," . $limit;

} else {

	$query = "select i.filename as filename, i.tn_filename as tn_filename, i.filepath as filepath, i.added as add_dt, i.ip as ip, i.filesize as filesize, sum(ih.kb) as bandwidth, count( ih.filename ) as ctr from images i left outer join imagehits ih on i.filename = ih.filename where i.prv=0 group by filename order by " . $sort . " desc limit " . $start . "," . $limit;
}

$result = mysql_query($query) or die("Query failed.");

$query_ti = "SELECT * from images where prv=0";
$result_ti = mysql_query($query_ti) or die("query_ti failed");
$totalimages = mysql_num_rows($result_ti);

if ($totalcount > $totalimages) {
	$totallimit = $totalimages;
} else {
	$totallimit = $totalcount;
}
if ($displayend > $totalimages) {
	$displaylimit = $totalimages;
} else {
	$displaylimit = $displayend;
}
if ($search_query != "") {
	$totallimit = mysql_num_rows($result);
	if ($displaylimit > $totallimit) {
		$displaylimit = $totallimit;
	}
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:og="http://opengraphprotocol.org/schema/" xmlns:fb="http://www.facebook.com/2008/fbml">

<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# ninegag: http://ogp.me/ns/fb/ninegag#">
<title>srt - 为乐而生</title>
<meta name="title" content="9GAG - Just for Fun!" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<meta name="keywords" content="9gag,jokes,interesting, cool,fun collection, fun portfolio, admire,fun,humor,humour,just for fun,笑圖,笑片,搞笑,搞gag,笑話"/>
<meta name="description" content="9GAG is the easiest way to have fun!"/>
<meta property="og:title" content="Just for Fun!"/>
<meta property="og:site_name" content="9GAG"/>
<meta property="og:url" content="http://9gag.com/"/>
<meta property="og:type" content="blog" />
<meta property="fb:app_id" content="111569915535689"/>
<meta property="og:image" content="http://d24w6bsrhbeh9d.cloudfront.net/img/9gag-fb-pic.png" />
<meta property="wb:webmaster" content="9b0f6143ed77469a" />
<meta name="viewport" content="width=device-width" />
<meta name="verify-v1" content="vvFhqhXLAn+191Kl3iZjjHHY6wzkyGG0CJqGMoFIZEg=" />
<link rel="alternate" href="rss/site/feed.rss" type="application/rss+xml" title="9GAG site feed" />
<link rel="stylesheet" href="./9gag_static/d24w6bsrhbeh9d.cloudfront.net/css/screen-v5.4.3.css" media="screen,projection" type="text/css" />
<link rel="stylesheet" href="./9gag_static/d24w6bsrhbeh9d.cloudfront.net/css/lang/zh_CN.css" media="screen,projection" type="text/css" />
<link rel="shortcut icon" href="./9gag_static/d24w6bsrhbeh9d.cloudfront.net/img/favicon_v2.png" />
<link rel="apple-touch-icon-precomposed" media="screen and (resolution: 163dpi)" href="./9gag_static/d24w6bsrhbeh9d.cloudfront.net/img/icon57.png" />
<link rel="apple-touch-icon-precomposed" media="screen and (resolution: 132dpi)" href="./9gag_static/d24w6bsrhbeh9d.cloudfront.net/img/icon72.png" />
<link rel="apple-touch-icon-precomposed" media="screen and (resolution: 326dpi)" href="./9gag_static/d24w6bsrhbeh9d.cloudfront.net/img/icon114.png" />
<script type="text/javascript" src="./9gag_static/d24w6bsrhbeh9d.cloudfront.net/js/mootools/mootools-1.4.1-yui-compressed.js"></script>
<script type="text/javascript" src="./9gag_static/d24w6bsrhbeh9d.cloudfront.net/js/Libraries-v1.3.js"></script>
<script type="text/javascript" src="./9gag_static/d24w6bsrhbeh9d.cloudfront.net/js/gag.min-v2.8.3.js"></script>

<!-- Google Analytics -->
<!--ipt type="text/javascript">

var _gaq = _gaq || [];
_gaq.push(['_setAccount', 'UA-4838180-1']);
_gaq.push(['_setDomainName', '.9gag.com']);
_gaq.push(['_deleteCustomVar', 1]);
_gaq.push(['_trackPageview']);

(function() {
 var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
 ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
 var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
 })();

</scri-->
</head>

<body id="page-landing" class="main-body ">


<div id="tmp-img" style="display:none"></div>
<script type="text/javascript">
function rmt(l) { var img = new Image(); img.src = l; document.getElementById('tmp-img').appendChild(img); }
function fbWindow(location, address, gaCategory, gaAction, entryLink) { _gaq.push(['_trackEvent', gaCategory, gaAction, entryLink, 1]); var w = 640; var h = 460; var sTop = window.screen.height/2-(h/2); var sLeft = window.screen.width/2-(w/2); var sharer = window.open(address, "Share on Facebook", "status=1,height="+h+",width="+w+",top="+sTop+",left="+sLeft+",resizable=0"); }
function twttrWindow(location, address, gaCategory, gaAction, entryLink) { _gaq.push(['_trackEvent', gaCategory, gaAction, entryLink, 1]); var w = 640; var h = 460; var sTop = window.screen.height/2-(h/2); var sLeft = window.screen.width/2-(w/2); var sharer = window.open(address, "Share on Twitter", "status=1,height="+h+",width="+w+",top="+sTop+",left="+sLeft+",resizable=0"); }
</script>

<script type='text/javascript' src='./9gag_static/partner.googleadservices.com/gampad/google_service.js'> </script>
<script type='text/javascript'>
try {
GS_googleAddAdSenseService("ca-pub-0268871989845966");
GS_googleEnableAllServices();
} catch (e) {
}
</script>


<script type='text/javascript'>
try {
GA_googleUseIframeRendering();
} catch (e) {
}
</script>
<!--
	move to header.php
-->
  <?
	require "header.php";
  ?>


<div id="container" style="">

<div id="main">

	<div id="block-content">
		<div class="filter-bar ">
			<ul class="content-type">
				<li> <a class="current" href="index.php"><strong><?=$text_hot?></strong></a></li>
				<li> <a class="" href="trending"><strong><?=$text_trend?></strong></a></li>
				<li> <a class="" href="vote"><strong><?=$text_vote?></strong></a></li>
			</ul>

				<a class="safe-mode-toggle " href="pref/safe-browse@enable=0&url=_252F">&nbsp;</a>
		</div>
	<div id="content" listPage="hot">
		<div id="view-controller">
				<div id="view-info" class="list-tips">
					<div id="shortcut-event-label" style="display:none">Tips</div>
						<span><?=$text_index_hint?></span>
							<a href="#keyboard" class="keyboard_link">Use SRT Like A Boss!</a>
					</div>
				</div>
	<div id="entry-list" class="list">
		<ul id="entry-list-ul" class="col-1">


	</ul>
</div><!--end entry-list-->



    <div id="pagination" class="flip" style="text-align:center">

        <a id="next_button" class='next' href="hot/id/2625004" style="width:700px;display:none;" plink="/hot/" data-more="0" data-count="10" list="hot">I want more fun!</a>
        <a id="more_button" class='next' href="hot/id/2625004" style="width:700px" data-more="0" data-count="10" plink="/hot/" currPage="5453" list="hot">更多</a>
        <img id="more_img" src="img/loading.gif" style="display:none"></img>
    </div><!--end pagination-->




			</div><!--end div#content-->
		</div><!--end div#block-content-->
</div><!--end div#main-->




<div class="side-dock">
	<script type="text/javascript">rmt('./9gag_static/goo.gl/ktrVc@a=189');</script>
	<div id="special-button">
		<a class="special-btn green" href="signup.php" label="Sidebar" onclick="rmt('./9gag_static/goo.gl/4L7Xz@a=325');">你还没登录</a>
	</div>
<div class="s-300">
<script type='text/javascript'>
try {
GA_googleFillSlotWithSize("ca-pub-0268871989845966", "Top-Right-300x250", 300, 250);
} catch (e) {}
<?
//TODO google adds
?>
</script>
</div>
<div class="social-block">
	<h3>show your love to syt</h3>
	<div class="facebook-like">
		<fb:like href="http://facebook.com/9gag" send="false" width="270" show_faces="true" font="" label="Sidebar"></fb:like>
	</div>
	<div class="weibo-follow">
	 <iframe width="136" height="24" frameborder="0" allowtransparency="true" marginwidth="0" marginheight="0" scrolling="no" frameborder="No" border="0" src="./9gag_static/widget.weibo.com/relationship/followbutton.php@language=zh_cn&width=136&height=24&uid=1727916553&style=2&btn=red&dpc=1"></iframe>	 </div>

	<div class="google-plus">
			<p>Recommend on Google</p>
			<g:plusone size="medium" href="http://9gag.com"></g:plusone>
	</div>
	<?
	//TODO follow
	?>
</div>
<div id="top-gag-stay">
	<div class="s-300">
	<iframe id="sidebar-ads2" src="./9gag_static/d24w6bsrhbeh9d.cloudfront.net/static/ads/sidebar-ads2.html" scrolling="no" height="250px" width="320px" marginheight="0" marginwidth="0" frameborder="0"></iframe>
</div>
<div class="popular-block">
	<h3><?=$text_index_popular?></h3>
	<?
	//TODO 推荐
	?>
</div>

<div class="message-block">
	<h3>Hey..</h3>
	<p>Press <b>Ctrl+D</b> or <b>⌘+D</b> (if you're using Mac) to bookmark 9GAG now!</p>
</div>

<?
//move to footer
require "footer.php"
?>


</div><!--end div#top-gag-stay-->
</div><!--end div.side-dock-->
</div><!--end #content-->
<div id="footer" class="">
<div id="main-bottom-ad-tray">
	<div>
		<script type='text/javascript'>
			try {
				GA_googleFillSlotWithSize("ca-pub-0268871989845966", "Banner-bottom-728x90", 728, 90);
			} catch(e) {}
		<!-- TODO google ads-->
		</script>
	</div>
</div>
</div><!--end div#footer-->

<div id="overlay-shadow" class="hide"></div>
<div id="overlay-container" class="hide" >


<div id="modal-report" class="modal-box hide">
	<div class="content">
 	   <a href="javascript:void(0);" class="close-btn"></a>
		<form id="form-modal-report" class="modal" action="" onsubmit="return false;">
			<h3>回報</h3>
			<h4>Why are you reporting this post?</h4>
			<input id="report_entry_id" type="hidden" name="entryId" value=""/>
			<div class="field">
				<label for="violation"><input id="violation" type="radio" name="report-reason" value="1"/> Contains a trademark or copyright violation</label>
				<label for="solicitation"><input id="solicitation" type="radio" name="report-reason" value="2"/> Spam, blatant advertising, or solicitation</label>
				<label for="offensive"><input id="offensive" type="radio" name="report-reason" value="3"/> Contains offensive materials/nudity</label>
				<label for="repost"><input id="repost" type="radio" name="report-reason" value="4"/> Repost of this post&darr;</label>
			</div>
			<div class="field">
				<input id="repost_link" type="text" class="text" placeholder="http://9gag.com/gag/post_ID" />
			</div>
		</form>
	</div>
	<div class="actions">
		<ul class="buttons">
			<li><a class="cancel" href="javascript:void(0);">取消</a></li>
			<li><a class="button submit-button" href="javascript:void(0);">Send</a></li>
			<li class="hide"><a class="button loading" href="javascript:void(0);"></a></li>
		</ul>
	</div>
</div>

<div id="modal-share" class="modal-box hide">
	<div class="content">
 	   <a href="javascript:void(0);" class="close-btn"></a>
		<form id="form-modal-share" class="modal" action="">
				</form>
	</div>
</div>


<div id="modal-language" class="modal-box hide">
	<div class="content">
		<a href="javascript:void(0);" class="close-btn badge-language-close"></a>
		<form id="form-modal-language" class="modal" action="" onsubmit="return false;">
			<h3>Languages</h3>
			<h4>Choose your language</h4>
			<div class="field">

				<label for="lang-en">
				<input id="lang-en" class="" type="radio" name="lang-code" value="en" ></input>English
				</label>

				<label for="lang-zh">
				<input id="lang-zh" class="" type="radio" name="lang-code" value="zh" ></input>&#32321;&#39636;&#20013;&#25991;
				</label>

				<label for="lang-zh_CN">
				<input id="lang-zh_CN" class="current" type="radio" name="lang-code" value="zh_CN" checked="checked"></input>&#31777;&#39636;&#20013;&#25991;
				</label>

				<label for="lang-fr">
				<input id="lang-fr" class="" type="radio" name="lang-code" value="fr" ></input>fran&#xE7;ais
				</label>

				<label for="lang-de">
				<input id="lang-de" class="" type="radio" name="lang-code" value="de" ></input>Deutsch
				</label>

				<label for="lang-ja">
				<input id="lang-ja" class="" type="radio" name="lang-code" value="ja" ></input>&#26085;&#26412;&#35486;
				</label>

				<label for="lang-es">
				<input id="lang-es" class="" type="radio" name="lang-code" value="es" ></input>Espa&ntilde;ol
				</label>

				<label for="lang-pt">
				<input id="lang-pt" class="" type="radio" name="lang-code" value="pt" ></input>Portugu&#234;s
				</label>

				<label for="lang-ru">
				<input id="lang-ru" class="" type="radio" name="lang-code" value="ru" ></input>Русский
				</label>

				<label for="lang-tr">
				<input id="lang-tr" class="" type="radio" name="lang-code" value="tr" ></input>T&uuml;rk&ccedil;e
				</label>

			</div>
		</form>
	</div>

	<div class="actions">
		<ul class="buttons">
			<li><a class="cancel badge-language-close" href="javascript:void(0);">取消</a></li>
			<li><a id="language-submit-button" class="button submit-button" href="javascript:void(0);">儲存</a></li>
		</ul>
	</div>
</div><!--end div#modal-language-->

			<div class="keyboard-instruction hide">
				<h3>9GAG Keyboard Shortcuts</h3>
				<div class="keyboard-img"></div>
				<ul class="key">
					<li><strong>R</strong> - random</li>
					<li><strong>C</strong> - comment</li>
					<li><strong>H</strong> - hate</li>
					<li><strong>J</strong> - next</li>
					<li><strong>K</strong> - previous</li>
					<li><strong>L</strong> - like</li>
				</ul>
				<p>Click anywhere to close</p>
			</div>


</div><!--end overlay-container-->




<input id="unlimitedScroll" type="hidden" value="1"></input>

<div style="display:none;">
<span id="siteDomain">9gag.com</span>
<span id="backUrl">%2F</span>
<span id="fb-app-id">111569915535689</span>
<span id="fbTimelineApi">ninegag:laugh_at?funny_post</span>
<span id="entryAge">218</span>
<span id="nsuon">1</span>
</div>

<noscript>
<div style="display:none;">
<img src="./9gag_static/pixel.quantserve.com/pixel/p-f8Bn5MbvAQbXQ.gif" border="0" height="1" width="1" alt="Quantcast"/>
</div>
</noscript>
<!-- End Quantcast tag -->



<a id="footer-back-to-top" class="WhiteButton badge-back-to-top">
    <strong><?=$text_util_back_top?></strong>
    <span></span>
</a>

 <script>
 GAG.Ajax.LoadPage.loadPage();
 </script>
</body>
</html>
