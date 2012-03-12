
<?php require "imagesharing/header2.php";
$search_query = check_input($_REQUEST['query']);

$totalcount=$config[GalleryPhotoNo];
$limit = check_input($_REQUEST['limit']);
if ($limit == "") {
$limit = $config[GalleryPhotoPerPage];
}
$start = check_input($_REQUEST['start']);
if ($start == "") {
$start = 0;
}

$displaystart = $start + 1;
$displayend = ($start + $limit > $totalcount ? $totalcount : $start + $limit);
if ($displayend == $totalcount) {
$nextset = 0;
} else {
$nextset = ($totalcount - $displayend > $limit ? $limit: ($totalcount - $displayend));
}

$sort = check_input($_REQUEST['sort']);
if ($sort == "") {
$sort = "added";
}

if ($search_query!="") {
$query = "select i.filename as filename, i.tn_filename as tn_filename, i.filepath as filepath, i.added as add_dt, i.ip as ip, i.filesize as filesize, sum(ih.kb) as bandwidth, count( ih.filename ) as ctr from images i left outer join imagehits ih on i.filename = ih.filename where i.prv='0' and i.filename LIKE '%" . $search_query . "%' group by filename order by " . $sort . " desc limit " . $start . "," . $limit;

}

else {

$query = "select i.filename as filename, i.tn_filename as tn_filename, i.filepath as filepath, i.added as add_dt, i.ip as ip, i.filesize as filesize, sum(ih.kb) as bandwidth, count( ih.filename ) as ctr from images i left outer join imagehits ih on i.filename = ih.filename where i.prv=0 group by filename order by " . $sort . " desc limit " . $start . "," . $limit;
}
echo $query;
$result = mysql_query($query) or die("Query failed.");

$query_ti = "SELECT * from images where prv=0";
$result_ti = mysql_query($query_ti) or die("query_ti failed");
<<<<<<< HEAD
$totalimages = mysql_num_rows($result_ti);

if ($totalcount>$totalimages) {
$totallimit=$totalimages;
=======
$totalimages = mysql_num_rows($result_ti);  

if ($totalcount>$totalimages) {
$totallimit=$totalimages; 
>>>>>>> 9c3d6a78f38234484b5d73dbc3ac79420cd57caa
}

else {
$totallimit=$totalcount; }

if ($displayend>$totalimages) {
$displaylimit=$totalimages;
}

else {
$displaylimit=$displayend; }

if ($search_query!="") {
$totallimit=mysql_num_rows($result);
if ($displaylimit>$totallimit){$displaylimit=$totallimit;}
}


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:og="http://opengraphprotocol.org/schema/" xmlns:fb="http://www.facebook.com/2008/fbml">

<!--

   ____                    __      __
  / __ \____ _____ _____ _/ /___  / /
<<<<<<< HEAD
 / /_/ / __ `/ __ `/ __ `/ / __ \/ /
 \__, / /_/ / /_/ / /_/ / / /_/ / /
/____/\__, /\__,_/\__, /_/\____/_/
     /____/      /____/
=======
 / /_/ / __ `/ __ `/ __ `/ / __ \/ / 
 \__, / /_/ / /_/ / /_/ / / /_/ / /  
/____/\__, /\__,_/\__, /_/\____/_/   
     /____/      /____/           
>>>>>>> 9c3d6a78f38234484b5d73dbc3ac79420cd57caa

-->

<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# ninegag: http://ogp.me/ns/fb/ninegag#">
<title>9GAG - Just for Fun!</title>

<meta name="title" content="9GAG - Just for Fun!" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<<<<<<< HEAD
<meta name="keywords" content="9gag,jokes,interesting, cool,fun collection, fun portfolio, admire,fun,humor,humour,just for fun,ç¬‘åœ–,ç¬‘ç‰‡,æ�žç¬‘,æ�žgag,ç¬‘è©±"/>
=======
<meta name="keywords" content="9gag,jokes,interesting, cool,fun collection, fun portfolio, admire,fun,humor,humour,just for fun,笑圖,笑片,搞笑,搞gag,笑話"/>
>>>>>>> 9c3d6a78f38234484b5d73dbc3ac79420cd57caa
<meta name="description" content="9GAG is the easiest way to have fun!"/>

<meta property="og:title" content="Just for Fun!"/>
<meta property="og:site_name" content="9GAG"/>
<meta property="og:url" content="http://9gag.com/"/>
<meta property="og:type" content="blog" />
<meta property="fb:app_id" content="111569915535689"/>
<meta property="fb:admins" content="833715432,615395260,511175491"/>

<meta property="og:image" content="http://d24w6bsrhbeh9d.cloudfront.net/img/9gag-fb-pic.png" />

<meta property="wb:webmaster" content="9b0f6143ed77469a" />

<meta name="viewport" content="width=device-width" />
<meta name="verify-v1" content="vvFhqhXLAn+191Kl3iZjjHHY6wzkyGG0CJqGMoFIZEg=" />


<link rel="alternate" href="rss/site/feed.rss" type="application/rss+xml" title="9GAG site feed" />
<<<<<<< HEAD
<link rel="stylesheet" href="./9gag_static/d24w6bsrhbeh9d.cloudfront.net/css/screen-v5.3.9.css" media="screen,projection" type="text/css" />
<link rel="stylesheet" href="./9gag_static/d24w6bsrhbeh9d.cloudfront.net/css/lang/zh_CN.css" media="screen,projection" type="text/css" />



<link rel="shortcut icon" href="./9gag_static/d24w6bsrhbeh9d.cloudfront.net/img/favicon_v2.png" />
<link rel="apple-touch-icon-precomposed" media="screen and (resolution: 163dpi)" href="./9gag_static/d24w6bsrhbeh9d.cloudfront.net/img/icon57.png" />
<link rel="apple-touch-icon-precomposed" media="screen and (resolution: 132dpi)" href="./9gag_static/d24w6bsrhbeh9d.cloudfront.net/img/icon72.png" />
<link rel="apple-touch-icon-precomposed" media="screen and (resolution: 326dpi)" href="./9gag_static/d24w6bsrhbeh9d.cloudfront.net/img/icon114.png" />


<script type="text/javascript" src="./9gag_static/d24w6bsrhbeh9d.cloudfront.net/js/mootools/mootools-1.4.1-yui-compressed.js"></script>
=======
<link rel="stylesheet" href="./d24w6bsrhbeh9d.cloudfront.net/css/screen-v5.3.9.css" media="screen,projection" type="text/css" />
<link rel="stylesheet" href="./d24w6bsrhbeh9d.cloudfront.net/css/lang/zh_CN.css" media="screen,projection" type="text/css" />



<link rel="shortcut icon" href="./d24w6bsrhbeh9d.cloudfront.net/img/favicon_v2.png" />
<link rel="apple-touch-icon-precomposed" media="screen and (resolution: 163dpi)" href="./d24w6bsrhbeh9d.cloudfront.net/img/icon57.png" />
<link rel="apple-touch-icon-precomposed" media="screen and (resolution: 132dpi)" href="./d24w6bsrhbeh9d.cloudfront.net/img/icon72.png" />
<link rel="apple-touch-icon-precomposed" media="screen and (resolution: 326dpi)" href="./d24w6bsrhbeh9d.cloudfront.net/img/icon114.png" />


<script type="text/javascript" src="./d24w6bsrhbeh9d.cloudfront.net/js/mootools/mootools-1.4.1-yui-compressed.js"></script>
>>>>>>> 9c3d6a78f38234484b5d73dbc3ac79420cd57caa




<<<<<<< HEAD
<script type="text/javascript" src="./9gag_static/d24w6bsrhbeh9d.cloudfront.net/js/Libraries-v1.3.js"></script>
<script type="text/javascript" src="./9gag_static/d24w6bsrhbeh9d.cloudfront.net/js/gag.min-v2.5.3.js"></script>
=======
<script type="text/javascript" src="./d24w6bsrhbeh9d.cloudfront.net/js/Libraries-v1.3.js"></script>
<script type="text/javascript" src="./d24w6bsrhbeh9d.cloudfront.net/js/gag.min-v2.5.3.js"></script>
>>>>>>> 9c3d6a78f38234484b5d73dbc3ac79420cd57caa



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

<<<<<<< HEAD

<div id="tmp-img" style="display:none"></div>
<script type="text/javascript">
function rmt(l) { var img = new Image(); img.src = l; document.getElementById('tmp-img').appendChild(img); }
=======
 
<div id="tmp-img" style="display:none"></div>
<script type="text/javascript"> 
function rmt(l) { var img = new Image(); img.src = l; document.getElementById('tmp-img').appendChild(img); } 
>>>>>>> 9c3d6a78f38234484b5d73dbc3ac79420cd57caa
function myWindow(location, address, gaCategory, gaAction) { _gaq.push(['_trackEvent', gaCategory, gaAction,  address, 1]); var w = 640; var h = 460; var sTop = window.screen.height/2-(h/2); var sLeft = window.screen.width/2-(w/2); var sharer = window.open(address, "Share on Facebook", "status=1,height="+h+",width="+w+",top="+sTop+",left="+sLeft+",resizable=0"); }
function twttrWindow(location, address, gaCategory, gaAction) { _gaq.push(['_trackEvent', gaCategory, gaAction,  address, 1]); var w = 640; var h = 460; var sTop = window.screen.height/2-(h/2); var sLeft = window.screen.width/2-(w/2); var sharer = window.open(address, "Share on Twitter", "status=1,height="+h+",width="+w+",top="+sTop+",left="+sLeft+",resizable=0"); }
</script>

<<<<<<< HEAD
<script type='text/javascript' src='./9gag_static/partner.googleadservices.com/gampad/google_service.js'> </script>
=======
<script type='text/javascript' src='./partner.googleadservices.com/gampad/google_service.js'> </script>
>>>>>>> 9c3d6a78f38234484b5d73dbc3ac79420cd57caa
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

<<<<<<< HEAD
=======




					
	


>>>>>>> 9c3d6a78f38234484b5d73dbc3ac79420cd57caa
	<div id="headbar-wrap">

		<div id="searchbar_container">
		<div id="searchbar_wrapper">
			<div id="header_searchbar"  style="display:none;">
				<div id="search_wrapper">
					<form action="http://9gag.com/search">
							<input id="sitebar_search_header" type="text" class="search search_input" name="query" tabindex="1" placeholder="Search"/>
					</form>
				</div>
			</div>
		</div>
		</div>

		<div id="head-bar">

								<h1><a class="snowman" href="http://www.facebook.com/9gag" target="_blank" onclick="_gaq.push(['_trackEvent', 'Facebook-Page', 'Clicked', 'Nav', 1]);">Facebook</a><a href="index.php">9GAG</a></h1>
				<ul class="main-menu" style="overflow:visible">


<<<<<<< HEAD
					<li><a class="current" href="hot.php">Hot</a></li>

										<li><a href="fast.php" onclick="_gaq.push(['_trackEvent', 'Lab', 'Clicked', 'Go', 1]); ">Fast</a></li>

										<li><a class="add-post " href="submit.php?type=url" onclick="_gaq.push(['_trackEvent', 'New-Post', 'Clicked', 'Headbar', 1]);">Upload</a></li>

=======
					<li><a class="current" href="hot.php">笑料</a></li>
					
										<li><a href="fast.php" onclick="_gaq.push(['_trackEvent', 'Lab', 'Clicked', 'Go', 1]); ">Fast</a></li>

										<li><a class="add-post " href="submit.php" onclick="_gaq.push(['_trackEvent', 'New-Post', 'Clicked', 'Headbar', 1]);">Upload</a></li>
					
>>>>>>> 9c3d6a78f38234484b5d73dbc3ac79420cd57caa

				</ul>
				<ul class="main-2-menu">

<<<<<<< HEAD



				<li id="headbar-signup-button">
												<a class="signup-button green" href="signup.php" label="Header" onclick=" rmt('./9gag_static/goo.gl/4L7Xz@a=965');">Y U No Signup?!</a>
											</li>


										<li><a href="login.php" class="button">Login</a></li>

=======
				

				
				<li id="headbar-signup-button">
												<a class="signup-button green" href="signup.php" label="Header" onclick=" rmt('./goo.gl/4L7Xz@a=965');">Y U No Signup?!</a>
											</li>
										

										<li><a href="login.php" class="button">登录</a></li>
					
>>>>>>> 9c3d6a78f38234484b5d73dbc3ac79420cd57caa
					<li><a class="shuffle-button" href="random"><strong>Shuffle</strong></a></li>
					<li><a class="search-button search-toggler" href="javascript:void(0);"><strong>Search</strong></a></li>

				</ul>


<<<<<<< HEAD

=======
				
>>>>>>> 9c3d6a78f38234484b5d73dbc3ac79420cd57caa

			</div>
		</div>


<div id="container" style="">
<<<<<<< HEAD
<div id="main">
		<div id="block-content">
			<div class="filter-bar ">
				<ul class="content-type">
										<li> <a class="current" href="hot.php"><strong>Hot</strong></a></li>
					<li> <a class="" href="trending.php"><strong>trending</strong></a></li>
					<li> <a class="" href="vote.php"><strong>Vote</strong></a></li>
=======
<div id="main">	
		<div id="block-content">
			<div class="filter-bar ">
				<ul class="content-type">
										<li> <a class="current" href="hot.php"><strong>熱門</strong></a></li>
					<li> <a class="" href="trending.php"><strong>趨勢</strong></a></li>
					<li> <a class="" href="vote.php"><strong>Vote</strong></a></li>	
>>>>>>> 9c3d6a78f38234484b5d73dbc3ac79420cd57caa
				</ul>
<a class="safe-mode-toggle " href="pref/safe-browse@enable=0&url=_252F&nsfw=1">&nbsp;</a>

			</div>
<<<<<<< HEAD
			<div id="content" listPage="hot.php">
=======
			<div id="content" listPage="hot.php">			
>>>>>>> 9c3d6a78f38234484b5d73dbc3ac79420cd57caa
				<div id="view-controller">
					<div id="view-info" class="list-tips">																<div id="shortcut-event-label" style="display:none">Tip-Press-3</div>
								<span><b>Tip</b>: Help improve 9GAG by reporting spam &amp; voting new posts on the <a href="vote.php">Vote</a> page.</span>
								<a href="#keyboard" class="keyboard_link">We love your keyboard!</a>
<<<<<<< HEAD

					</div>
				</div>

=======
								
					</div>
				</div>
				
>>>>>>> 9c3d6a78f38234484b5d73dbc3ac79420cd57caa
<div id="entry-list" class="list">
	<ul id="entry-list-ul" class="col-1">

<?
                    $ctr = 0;
                    while ($line = mysql_fetch_array($result)) {
						$ctr++;
						$short_name = substr($line[filename], 0, 30);
?>

<li class=" entry-item" data-url="http://9gag.com/gag/2644365" data-text="I&#039;ll just tell him I have a nose fetish." gagId="2644365" itemType="list" id="entry-2644365">

<div class="content">
		<div class="img-wrap">
<<<<<<< HEAD

		<!--<a href="imagesharing/view2.php?filename=<?=$line[filename]?>">-->
		<!--<a href="gag/2644365"  target="_blank" >-->
		<!--
			src="./9gag_static/d24w6bsrhbeh9d.cloudfront.net/photo/2644365_460s.jpg"

=======
		
		<!--<a href="imagesharing/view2.php?filename=<?=$line[filename]?>">-->
		<!--<a href="gag/2644365"  target="_blank" >-->
		<!--
			src="./d24w6bsrhbeh9d.cloudfront.net/photo/2644365_460s.jpg"
			
>>>>>>> 9c3d6a78f38234484b5d73dbc3ac79420cd57caa
			src="<?$file_path.$file?>"
		-->
		<a href="detail.php?filename=<?=$line[filename]?>">
		<img src="<?=$line[filepath].$line[filename] ?>" alt="I&#039;ll just tell him I have a nose fetish." border="0" style="max-width:450px"/>
		</a>
	</div>
	<div class="fatbigdick"></div>

</div><!--end div.content-->

<div class="info jump_stop jump_focus" >
    <div class="sticky-items" id="sticky-item-2644365">
		<h1><a href="gag/2644365"  target="_blank" >I&#039;ll just tell him I have a nose fetish.</a></h1>
	<h4>
		<a href="klopezq_93">klopezq_93</a>
<<<<<<< HEAD
		<p>20 å°�æ™‚å‰�</p>
	</h4>


=======
		<p>20 小時前</p>
	</h4>

	
>>>>>>> 9c3d6a78f38234484b5d73dbc3ac79420cd57caa
<p>
	<span class="comment">
            27    	</span>
	<span id="love_count_2644365" class="loved" votes="19472" score="0">19472</span>

<<<<<<< HEAD

=======
        
>>>>>>> 9c3d6a78f38234484b5d73dbc3ac79420cd57caa
</p>

<ul class="actions">
<li>
    <a class="comment " href="gag/2644365#comments" onclick="window.location =  'gag/2644365#comments';"><span>Comment</span></a>
</li>
<li>
    <a id="vote-up-btn-2644365" class="love badge-vote-up " entryId="2644365" href="javascript:void(0);"> <span>Love</span></a>
</li>
</ul>


<div class="sharing-box" >
<hr class="arrow" />
<<<<<<< HEAD

=======
		
>>>>>>> 9c3d6a78f38234484b5d73dbc3ac79420cd57caa
<ul class="sharing weibo" >
<li class="facebook sharing-row" id="share1-2644365" >


<<<<<<< HEAD

<span id="list-share-weibo-2644365">
<iframe allowTransparency="true" frameborder="0" scrolling="no" src="./9gag_static/hits.sinajs.cn/A1/weiboshare.html@url=http_253A_252F_252F9gag.com_252Fgag_252F2644365&type=2&count=1&appkey=494936745&title=I%26_2523039_253B032FCC07D5" width="80" height="24"></iframe></span>

<div class="facebook_share_size_Small" onclick="myWindow('Facebook Share', './9gag_static/www.facebook.com/sharer/sharer.php@u=http_253A_252F_252F9gag.com_252Fgag_252F2644365', 'Facebook-Share-List', 'Clicked');">
    <span class="FacebookConnectButton FacebookConnectButton_Small">
        <span class="FacebookConnectButton_Text">Share</span>
    </span>
=======
 
<span id="list-share-weibo-2644365">
<iframe allowTransparency="true" frameborder="0" scrolling="no" src="./hits.sinajs.cn/A1/weiboshare.html@url=http_253A_252F_252F9gag.com_252Fgag_252F2644365&type=2&count=1&appkey=494936745&title=I%26_2523039_253B032FCC07D5" width="80" height="24"></iframe></span>

<div class="facebook_share_size_Small" onclick="myWindow('Facebook Share', './www.facebook.com/sharer/sharer.php@u=http_253A_252F_252F9gag.com_252Fgag_252F2644365', 'Facebook-Share-List', 'Clicked');">
    <span class="FacebookConnectButton FacebookConnectButton_Small">
        <span class="FacebookConnectButton_Text">Share</span>
    </span> 
>>>>>>> 9c3d6a78f38234484b5d73dbc3ac79420cd57caa
    <span class="facebook_share_count_nub_right"></span>
    <span class="facebook_share_count facebook_share_count_right">
        <span class="facebook_share_count_inner">576</span>
    </span>
</div>
</li>

</ul>
</div>
<<<<<<< HEAD
<a class="fix" href="./9gag_static/https@9gag.com/login@ref=_252Ffix_252F2644365">Fix this post</a>
=======
<a class="fix" href="./https@9gag.com/login@ref=_252Ffix_252F2644365">Fix this post</a>
>>>>>>> 9c3d6a78f38234484b5d73dbc3ac79420cd57caa



    </div>

</div><!--end div.info-->
</li>








<<<<<<< HEAD

=======
						
>>>>>>> 9c3d6a78f38234484b5d73dbc3ac79420cd57caa
<?
					}
?>

<<<<<<< HEAD
        <?
=======
        <? 
>>>>>>> 9c3d6a78f38234484b5d73dbc3ac79420cd57caa
        mysql_free_result($result);
        mysql_close($link);
        ?>





	</ul>
</div><!--end entry-list-->

<<<<<<< HEAD


    <div id="pagination" class="flip" style="text-align:center">

=======
				
				    
    <div id="pagination" class="flip" style="text-align:center">
        
>>>>>>> 9c3d6a78f38234484b5d73dbc3ac79420cd57caa
        <a id="next_button" class='next' href="hot/id/2625004" style="width:700px;display:none;" plink="/hot/" data-more="2625004" list="hot">I want more fun!</a>
        <a id="more_button" class='next' href="hot/id/2625004" style="width:700px" data-more="2625004" plink="/hot/" currPage="5453" list="hot">More</a>
        <img id="more_img" src="img/loading.gif" style="display:none"></img>
    </div><!--end pagination-->



<<<<<<< HEAD

=======
			
>>>>>>> 9c3d6a78f38234484b5d73dbc3ac79420cd57caa
			</div><!--end div#content-->
		</div><!--end div#block-content-->
</div><!--end div#main-->




<div class="side-dock">


<<<<<<< HEAD


				<script type="text/javascript">rmt('./9gag_static/goo.gl/ktrVc@a=189');</script>

	<div id="special-button">
				<a class="special-btn green" href="signup.php" label="Sidebar" onclick="rmt('./9gag_static/goo.gl/4L7Xz@a=325');">Y U No Signup?!</a>
			</div>



=======
	
	
				<script type="text/javascript">rmt('./goo.gl/ktrVc@a=189');</script>

	<div id="special-button">
				<a class="special-btn green" href="signup.php" label="Sidebar" onclick="rmt('./goo.gl/4L7Xz@a=325');">Y U No Signup?!</a>
			</div>
		

	
>>>>>>> 9c3d6a78f38234484b5d73dbc3ac79420cd57caa
							<div class="s-300">
<script type='text/javascript'>
try {
GA_googleFillSlotWithSize("ca-pub-0268871989845966", "Top-Right-300x250", 300, 250);
} catch (e) {}
</script>
</div>
<<<<<<< HEAD


=======
		
	
>>>>>>> 9c3d6a78f38234484b5d73dbc3ac79420cd57caa
		<div class="social-block">
	<h3>Show your love to 9GAG</h3>
	<div class="facebook-like">
		<fb:like href="http://facebook.com/9gag" send="false" width="270" show_faces="true" font="" label="Sidebar"></fb:like>
	</div>

<<<<<<< HEAD

		 <div class="weibo-follow">
	 <iframe width="136" height="24" frameborder="0" allowtransparency="true" marginwidth="0" marginheight="0" scrolling="no" frameborder="No" border="0" src="./9gag_static/widget.weibo.com/relationship/followbutton.php@language=zh_cn&width=136&height=24&uid=1727916553&style=2&btn=red&dpc=1"></iframe>	 </div>

=======
	
		 <div class="weibo-follow">
	 <iframe width="136" height="24" frameborder="0" allowtransparency="true" marginwidth="0" marginheight="0" scrolling="no" frameborder="No" border="0" src="./widget.weibo.com/relationship/followbutton.php@language=zh_cn&width=136&height=24&uid=1727916553&style=2&btn=red&dpc=1"></iframe>	 </div>
	
>>>>>>> 9c3d6a78f38234484b5d73dbc3ac79420cd57caa
	<div class="google-plus">
			<p>Recommend on Google</p>
			<g:plusone size="medium" href="http://9gag.com"></g:plusone>
	</div>
</div>

<<<<<<< HEAD

		<div id="top-gag-stay">
							<div class="s-300">
<iframe id="sidebar-ads2" src="./9gag_static/d24w6bsrhbeh9d.cloudfront.net/static/ads/sidebar-ads2.html" scrolling="no" height="250px" width="320px" marginheight="0" marginwidth="0" frameborder="0"></iframe>
</div>



<div class="popular-block">
	<h3>è¯šæ„�æŽ¨ä»‹</h3>
	<ol>
						<a class="wrap" href="gag/2659799@ref=discuss"  onclick="GAG.GA.track('RelatedContent', 'Clicked-PopularPost', 'gag/2659799', 1)" >
<li>
						<img src="./9gag_static/d24w6bsrhbeh9d.cloudfront.net/photo/2659799_220x145.jpg" alt="Hard to unsee it.." />
=======
	
		<div id="top-gag-stay">
							<div class="s-300">
<iframe id="sidebar-ads2" src="./d24w6bsrhbeh9d.cloudfront.net/static/ads/sidebar-ads2.html" scrolling="no" height="250px" width="320px" marginheight="0" marginwidth="0" frameborder="0"></iframe>
</div>
		

						
<div class="popular-block">
	<h3>诚意推介</h3>
	<ol>
						<a class="wrap" href="gag/2659799@ref=discuss"  onclick="GAG.GA.track('RelatedContent', 'Clicked-PopularPost', 'gag/2659799', 1)" >
<li>
						<img src="./d24w6bsrhbeh9d.cloudfront.net/photo/2659799_220x145.jpg" alt="Hard to unsee it.." />
>>>>>>> 9c3d6a78f38234484b5d73dbc3ac79420cd57caa
						<h4>Hard to unsee it..</h4>
		<p class="meta">
			<span class="comment">
                        77            			</span>
			<span class="loved">11871</span>
		</p>
				<span class="medal-gold"></span>
		</li>
	</a>

							<a class="wrap" href="gag/2659791@ref=discuss"  onclick="GAG.GA.track('RelatedContent', 'Clicked-PopularPost', 'gag/2659791', 1)" >
<li>
<<<<<<< HEAD
						<img src="./9gag_static/d24w6bsrhbeh9d.cloudfront.net/photo/2659791_220x145.jpg" alt="How I feel.." />
=======
						<img src="./d24w6bsrhbeh9d.cloudfront.net/photo/2659791_220x145.jpg" alt="How I feel.." />
>>>>>>> 9c3d6a78f38234484b5d73dbc3ac79420cd57caa
						<h4>How I feel..</h4>
		<p class="meta">
			<span class="comment">
                        54            			</span>
			<span class="loved">14101</span>
		</p>
				<span class="medal-silver"></span>
		</li>
	</a>

							<a class="wrap" href="gag/2659832@ref=discuss"  onclick="GAG.GA.track('RelatedContent', 'Clicked-PopularPost', 'gag/2659832', 1)" >
<li>
<<<<<<< HEAD
				<img src="./9gag_static/d24w6bsrhbeh9d.cloudfront.net/img/nsfw-thumbnail.jpg" alt="NSFW" />
=======
				<img src="./d24w6bsrhbeh9d.cloudfront.net/img/nsfw-thumbnail.jpg" alt="NSFW" />
>>>>>>> 9c3d6a78f38234484b5d73dbc3ac79420cd57caa
				<h4>When you see it</h4>
		<p class="meta">
			<span class="comment">
                        14            			</span>
			<span class="loved">8107</span>
		</p>
				<span class="medal-bronze"></span>
		</li>
	</a>

<<<<<<< HEAD

	</ol>
</div>

<div class="message-block">
	<h3>Hey..</h3>
	<p>Press <b>Ctrl+D</b> or <b>âŒ˜+D</b> (if you're using Mac) to bookmark 9GAG now!</p>
</div>



<div class="section-2">
<div class="wrap">

<ul class="info footer-left">
	<li>9GAG &copy; 2011</li>
	<li>Â·<a class="badge-language-selector" href="javascript:void(0);">&#31777;&#39636;&#20013;&#25991; ( zh_CN )</a></li>
</ul><!--end ul.footer-left-->

<ul class="info footer-right">
	<li><a href="about">å…³äºŽ</a></li>
	<li>Â·<a href="rules">9 æ¢�è¦�å‰‡</a></li>
	<li>Â·<a href="faq">å¸¸è§�é—®é¢˜</a></li>
	<li>Â·<a href="tos">æ�¡æ¬¾</a></li>
	<li>Â·<a href="privacy">ç§�éš�</a></li>
	<li>Â·<a href="contact">è�”ç»œ</a></li>
=======
				
	</ol>
</div>
		
<div class="message-block">
	<h3>Hey..</h3>
	<p>Press <b>Ctrl+D</b> or <b>⌘+D</b> (if you're using Mac) to bookmark 9GAG now!</p>
</div>

		
        		
<div class="section-2">
<div class="wrap">
    
<ul class="info footer-left">
	<li>9GAG &copy; 2011</li>
	<li>·<a class="badge-language-selector" href="javascript:void(0);">&#31777;&#39636;&#20013;&#25991; ( zh_CN )</a></li>
</ul><!--end ul.footer-left-->
	
<ul class="info footer-right">
	<li><a href="about">关于</a></li>
	<li>·<a href="rules">9 條規則</a></li>
	<li>·<a href="faq">常见问题</a></li>
	<li>·<a href="tos">条款</a></li>
	<li>·<a href="privacy">私隐</a></li>
	<li>·<a href="contact">联络</a></li>
>>>>>>> 9c3d6a78f38234484b5d73dbc3ac79420cd57caa
</ul><!--end ul.footer-right-->

</div>
</div>

<<<<<<< HEAD

	</div><!--end div#top-gag-stay-->


=======
        
	</div><!--end div#top-gag-stay-->
	
    
>>>>>>> 9c3d6a78f38234484b5d73dbc3ac79420cd57caa
</div><!--end div.side-dock-->


</div><!--end #content-->

<div id="footer" class="">
<<<<<<< HEAD


=======
	
			
>>>>>>> 9c3d6a78f38234484b5d73dbc3ac79420cd57caa
		<div id="main-bottom-ad-tray">
			<div>
<script type='text/javascript'>
try {
GA_googleFillSlotWithSize("ca-pub-0268871989845966", "Banner-bottom-728x90", 728, 90);
} catch(e) {}
</script>
</div>
		</div>
<<<<<<< HEAD




=======
		
		
			
    
>>>>>>> 9c3d6a78f38234484b5d73dbc3ac79420cd57caa
</div><!--end div#footer-->

<a id="footer-back-to-top" class="WhiteButton badge-back-to-top offscreen">
    <strong>Back to Top</strong>
    <span></span>
</a>

<div id="overlay-shadow" class="hide"></div>
<div id="overlay-container" class="hide" >

<<<<<<< HEAD

=======
	
>>>>>>> 9c3d6a78f38234484b5d73dbc3ac79420cd57caa
<div id="modal-report" class="modal-box hide">
	<div class="content">
 	   <a href="javascript:void(0);" class="close-btn"></a>
		<form id="form-modal-report" class="modal" action="" onsubmit="return false;">
<<<<<<< HEAD
			<h3>å›žå ±</h3>
=======
			<h3>回報</h3>
>>>>>>> 9c3d6a78f38234484b5d73dbc3ac79420cd57caa
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
<<<<<<< HEAD
			<li><a class="cancel" href="javascript:void(0);">å�–æ¶ˆ</a></li>
=======
			<li><a class="cancel" href="javascript:void(0);">取消</a></li>
>>>>>>> 9c3d6a78f38234484b5d73dbc3ac79420cd57caa
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
<<<<<<< HEAD
	</div>
=======
	</div>                
>>>>>>> 9c3d6a78f38234484b5d73dbc3ac79420cd57caa
</div>


<div id="modal-language" class="modal-box hide">
	<div class="content">
		<a href="javascript:void(0);" class="close-btn badge-language-close"></a>
		<form id="form-modal-language" class="modal" action="" onsubmit="return false;">
			<h3>Languages</h3>
			<h4>Choose your language</h4>
			<div class="field">
<<<<<<< HEAD

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
				<input id="lang-ru" class="" type="radio" name="lang-code" value="ru" ></input>Ð ÑƒÑ�Ñ�ÐºÐ¸Ð¹
				</label>

				<label for="lang-tr">
				<input id="lang-tr" class="" type="radio" name="lang-code" value="tr" ></input>T&uuml;rk&ccedil;e
				</label>

=======
												
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
				
>>>>>>> 9c3d6a78f38234484b5d73dbc3ac79420cd57caa
			</div>
		</form>
	</div>

	<div class="actions">
		<ul class="buttons">
<<<<<<< HEAD
			<li><a class="cancel badge-language-close" href="javascript:void(0);">å�–æ¶ˆ</a></li>
			<li><a id="language-submit-button" class="button submit-button" href="javascript:void(0);">å„²å­˜</a></li>
=======
			<li><a class="cancel badge-language-close" href="javascript:void(0);">取消</a></li>
			<li><a id="language-submit-button" class="button submit-button" href="javascript:void(0);">儲存</a></li>
>>>>>>> 9c3d6a78f38234484b5d73dbc3ac79420cd57caa
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

<script type="text/javascript">
(function() {
 var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
<<<<<<< HEAD
 po.src = './9gag_static/https@apis.google.com/js/plusone.js';
=======
 po.src = './https@apis.google.com/js/plusone.js';
>>>>>>> 9c3d6a78f38234484b5d73dbc3ac79420cd57caa
 var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
 })();
</script>
<div id="fb-root"></div>
<<<<<<< HEAD
<script src="./9gag_static/connect.facebook.net/en_US/all.js" type="text/javascript"></script>
<script src="./9gag_static/d24w6bsrhbeh9d.cloudfront.net/js/FB.Share.1.0.2.js" type="text/javascript"></script>
=======
<script src="./connect.facebook.net/en_US/all.js" type="text/javascript"></script>
<script src="./d24w6bsrhbeh9d.cloudfront.net/js/FB.Share.1.0.2.js" type="text/javascript"></script>
>>>>>>> 9c3d6a78f38234484b5d73dbc3ac79420cd57caa


<script type="text/javascript">
//<![CDATA[
<!--
window.addEvent("domready", function() {

	$$('a.twitter_connect').setStyle('display', '');

	$$('a.twitter_connect').addEvent('click', function(e) {
	e.preventDefault();
	var next = $(this).get('next');
	if (next && next.length>0) {
		next = '&amp;next='+next;
	}

	window.location = "connect@twitter_login=1"+next;
	});

});
// -->
//]]>
</script>


<!-- Quantcast Tag -->
<script type="text/javascript">
var _qevents = _qevents || [];

(function() {
var elem = document.createElement('script');
<<<<<<< HEAD
elem.src = (document.location.protocol == "https:" ? "./9gag_static/https@secure/" : "./9gag_static/edge/") + ".quantserve.com/quant.js";
=======
elem.src = (document.location.protocol == "https:" ? "./https@secure/" : "./edge/") + ".quantserve.com/quant.js";
>>>>>>> 9c3d6a78f38234484b5d73dbc3ac79420cd57caa
elem.async = true;
elem.type = "text/javascript";
var scpt = document.getElementsByTagName('script')[0];
scpt.parentNode.insertBefore(elem, scpt);
})();

_qevents.push({
qacct:"p-f8Bn5MbvAQbXQ"
});
</script>

<noscript>
<div style="display:none;">
<<<<<<< HEAD
<img src="./9gag_static/pixel.quantserve.com/pixel/p-f8Bn5MbvAQbXQ.gif" border="0" height="1" width="1" alt="Quantcast"/>
=======
<img src="./pixel.quantserve.com/pixel/p-f8Bn5MbvAQbXQ.gif" border="0" height="1" width="1" alt="Quantcast"/>
>>>>>>> 9c3d6a78f38234484b5d73dbc3ac79420cd57caa
</div>
</noscript>
<!-- End Quantcast tag -->






</body>
</html>
