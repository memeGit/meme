<? require "imagesharing/header2.php"; 
     $file = check_input($_GET['filename']);
     $view = check_input($_GET['view']);
        if ($file == "") {
                header("Location: " . $server_url);
                exit;
        }
        $t1=mktime(0,0,0,date("m"),date("d"),date("y"));
        $t2=($t1+24*60*50)-1;
        
        $currentip = $_SERVER['REMOTE_ADDR'];
        
        $query1 = "select * from images where filename='$file'";        
        $result1 = mysql_query($query1) or die("Query failed1.");
				if(mysql_num_rows($result1) ==0) { ?>
		<div id="error"><div class="msg" id="sucmsgid"> <?
	echo "请求的图片不存在"; ?>
	</div></div>
		<META HTTP-EQUIV="refresh" CONTENT="3;URL=gallery.php">
	<?
	}

		while ($row = mysql_fetch_array($result1))
		{
		$uploaderid=$row['userid'];
		$filesize1=$row['filesize'];
        $file_path=$row['filepath'];
		$date_added=date("jS F Y", $row[added]);

       }
	   if($filesize1=="" or $file_path=="")
	   {
			$err = "Image Not found";

			$query2 = "select filesize,filepath,filename,tn_filename from images order by rand() limit 1";        
			$result2 = mysql_query($query2) or die("Query failed2.");

			
	        while ($line1 = mysql_fetch_array($result2)) {         
	        $filesize1=$line1[filesize];
	        $file_path=$line1[filepath];
			}
	   }
        $query3 = "select count(*) as total from imagehits where filename='$file'";        
        $result3 = mysql_query($query3) or die("Query failed3.");
        while ($line2 = mysql_fetch_array($result3)) {         
        $view1=$line2[total];
        }
        
        
	$referer = $_SERVER['HTTP_REFERER'];
 /*       if($view1>0)
        $kb=$view1*$filesize1;
        else
        $kb=$filesize1;
		$timestamp=time();
        $sql="insert into imagehits set referer='".$referer."', kb=$kb, filename='".$file."',ip='".$currentip."',timestamp='".$timestamp."'";
        mysql_query($sql) or die("Query failed3.");
*/

		$timestamp=time();
        $sql="insert into imagehits set referer='".$referer."', kb=$filesize1, filename='".$file."',ip='".$currentip."',timestamp='".$timestamp."'";
        mysql_query($sql) or die("Query failed3.");


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:og="http://opengraphprotocol.org/schema/" xmlns:fb="http://www.facebook.com/2008/fbml">

<!--

   ____                    __      __
  / __ \____ _____ _____ _/ /___  / /
 / /_/ / __ `/ __ `/ __ `/ / __ \/ / 
 \__, / /_/ / /_/ / /_/ / / /_/ / /  
/____/\__, /\__,_/\__, /_/\____/_/   
     /____/      /____/           

-->

<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# ninegag: http://ogp.me/ns/fb/ninegag#">
<title>9GAG - I&#039;ll just tell him I have a nose fetish.</title>

<meta name="title" content="9GAG - I&#039;ll just tell him I have a nose fetish." />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<meta name="keywords" content="9gag,jokes,interesting, cool,fun collection, fun portfolio, admire,fun,humor,humour,just for fun,笑圖,笑片,搞笑,搞gag,笑話"/>
<meta name="description" content="9GAG is the easiest way to have fun!"/>

<meta property="og:title" content="I&#039;ll just tell him I have a nose fetish."/>
<meta property="og:site_name" content="9GAG"/>
<meta property="og:url" content="http://9gag.com/gag/2644365"/>
<meta property="og:type" content="article" />
<meta property="fb:app_id" content="111569915535689"/>
<meta property="fb:admins" content="833715432,615395260,511175491"/>

<meta property="og:image" content="http://d24w6bsrhbeh9d.cloudfront.net/photo/2644365_220x145.jpg" />
<link rel="image_src" href="./d24w6bsrhbeh9d.cloudfront.net/photo/2644365_220x145.jpg" / >

<meta property="wb:webmaster" content="9b0f6143ed77469a" />

<meta name="viewport" content="width=device-width" />
<meta name="verify-v1" content="vvFhqhXLAn+191Kl3iZjjHHY6wzkyGG0CJqGMoFIZEg=" />


<link rel="alternate" href="../rss/site/feed.rss" type="application/rss+xml" title="9GAG site feed" />
<link rel="stylesheet" href="./d24w6bsrhbeh9d.cloudfront.net/css/screen-v5.3.9.css" media="screen,projection" type="text/css" />
<link rel="stylesheet" href="./d24w6bsrhbeh9d.cloudfront.net/css/lang/zh_CN.css" media="screen,projection" type="text/css" />



<link rel="shortcut icon" href="./d24w6bsrhbeh9d.cloudfront.net/img/favicon_v2.png" />
<link rel="apple-touch-icon-precomposed" media="screen and (resolution: 163dpi)" href="./d24w6bsrhbeh9d.cloudfront.net/img/icon57.png" />
<link rel="apple-touch-icon-precomposed" media="screen and (resolution: 132dpi)" href="./d24w6bsrhbeh9d.cloudfront.net/img/icon72.png" />
<link rel="apple-touch-icon-precomposed" media="screen and (resolution: 326dpi)" href="./d24w6bsrhbeh9d.cloudfront.net/img/icon114.png" />


<script type="text/javascript" src="./d24w6bsrhbeh9d.cloudfront.net/js/mootools/mootools-1.4.1-yui-compressed.js"></script>




<script type="text/javascript" src="./d24w6bsrhbeh9d.cloudfront.net/js/Libraries-v1.3.js"></script>
<script type="text/javascript" src="./d24w6bsrhbeh9d.cloudfront.net/js/gag.min-v2.5.3.js"></script>



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
<body id="page-post" class="main-body ">
<div id="tmp-img" style="display:none"></div>
<script type="text/javascript"> 
function rmt(l) { var img = new Image(); img.src = l; document.getElementById('tmp-img').appendChild(img); } 
function myWindow(location, address, gaCategory, gaAction) { _gaq.push(['_trackEvent', gaCategory, gaAction,  address, 1]); var w = 640; var h = 460; var sTop = window.screen.height/2-(h/2); var sLeft = window.screen.width/2-(w/2); var sharer = window.open(address, "Share on Facebook", "status=1,height="+h+",width="+w+",top="+sTop+",left="+sLeft+",resizable=0"); }
function twttrWindow(location, address, gaCategory, gaAction) { _gaq.push(['_trackEvent', gaCategory, gaAction,  address, 1]); var w = 640; var h = 460; var sTop = window.screen.height/2-(h/2); var sLeft = window.screen.width/2-(w/2); var sharer = window.open(address, "Share on Twitter", "status=1,height="+h+",width="+w+",top="+sTop+",left="+sLeft+",resizable=0"); }
</script>
<script type='text/javascript' src='./partner.googleadservices.com/gampad/google_service.js'> </script>
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

								<h1><a class="snowman" href="././www.facebook.com/9gag" target="_blank" onclick="_gaq.push(['_trackEvent', 'Facebook-Page', 'Clicked', 'Nav', 1]);">Facebook</a><a href="index.php">9GAG</a></h1>
				<ul class="main-menu" style="overflow:visible">


					<li><a class="" href="./hot">笑料</a></li>
					
										<li><a href="./fast" onclick="_gaq.push(['_trackEvent', 'Lab', 'Clicked', 'Go', 1]); ">Fast</a></li>

										<li><a class="add-post " href="./submit" onclick="_gaq.push(['_trackEvent', 'New-Post', 'Clicked', 'Headbar', 1]);">Upload</a></li>
					

				</ul>
				<ul class="main-2-menu">

				

				
																				<li id="headbar-signup-button">
												<a class="signup-button green" href="././https@9gag.com/signup" label="Header" onclick=" rmt('././goo.gl/4L7Xz@a=169');">Y U No Signup?!</a>
											</li>
										

										<li><a href="././https@9gag.com/login" class="button">登录</a></li>
					
					<li><a class="shuffle-button" href="./random"><strong>Shuffle</strong></a></li>
					<li><a class="search-button search-toggler" href="javascript:void(0);"><strong>Search</strong></a></li>

				</ul>


				

			</div>
		</div>


<div id="container" style="">
				<div id="main">
				<div id="block-content">
					<div class="post-info-pad">
						<h1>I&#039;ll just tell him I have a nose fetish.</h1>
						<p>
							<a href="./klopezq_93">klopezq_93</a>
							<span class="seperator">|</span>
							20 小時前							<span class="comment"><fb:comments-count href="http://9gag.com/gag/2644365"></fb:comments-count></span>
							<span class="loved"><span id="love_count_2644365" votes="19501" score="0">19501</span></span>
																					
							
						</p>
						<ul class="actions">
							<li><a id="post_view_love" rel="2644365" class="love " href="javascript:void(0);">Love</a></li>
						</ul>
										
										</div><!--end post-info-pad-->
		
					<div id="post-control-bar" class="spread-bar-wrap">
						<div class="spread-bar">
														<div class="facebook-share-btn"><a class="facebook-share-button" name="fb_share" type="button_count" share_url="http://9gag.com/gag/2644365"></a> </div>
							<div class="facebook-btn"><fb:like href="http://9gag.com/gag/2644365" send="false" layout="button_count" width="90px" show_faces="false" font="" label="Post"></fb:like> </div>
							<div class="google-btn"><g:plusone size="medium" href="http://9gag.com/gag/2644365"></g:plusone> </div>
							<div class="stumbleupon-btn">
								<su:badge layout="1" location="http://9gag.com/gag/2644365?ref=stumbleupon"></su:badge> <script type="text/javascript"> (function() { var li = document.createElement('script'); li.type = 'text/javascript'; li.async = true;  li.src = '././https@platform.stumbleupon.com/1/widgets.js';  var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(li, s);  })(); </script>							</div>
						</div>

												<div class="post-next-prev">
							<a id="prev_post" class="prev-post" href="1776033" onclick="_gaq.push(['_trackEvent', 'View-Post', 'Clicked', 'Previous', 1]);"></a>
							<a id="next_post" class="next-post" href="2626194" onclick="_gaq.push(['_trackEvent', 'View-Post', 'Clicked', 'Next', 1]);"></a>
						</div>
											</div>
					<div id="content">
						<div class="post-container">
						<div class="img-wrap">
													
							
							<!--nemo
							<a href="./random">
							
							src="./d24w6bsrhbeh9d.cloudfront.net/photo/2644365_700b.jpg"
							-->
							
							<a href="<?= $file_path.$file ?>">
							<img src="<?=$file_path.$file?>" alt="I&#039;ll just tell him I have a nose fetish." border="0" style="max-width:800px"/>
							</a>
																			</div><!--end image-wrap-->
						</div><!--end post-container-->

																											
							<div class="comment-section">
								<h3 class="title" id="comments">留言</h3>
								<span class="report-and-source">
								<p>
																																								<a class="fix" href="././https@9gag.com/login@ref=_252Ffix_252F2644365">Fix this post</a>
								<span id="report-item-separator">|</span>
																																																		<a class="report" entryId="2644365" href="././https@9gag.com/login@ref=_252Fgag_252F2644365_253Freport_253D1">Report post</a>
																	<span id="report-item-separator">|</span>
																
																		unknown source																	</p>
								</span>
								<div id="entry-comments" style="text-align:center">
                                                                        <fb:comments href="http://9gag.com/gag/2644365" num_posts="10" width="700"></fb:comments>									<p class="facebook-init-failed" style="display:none"></p>
								</div>
							</div><!--end div.comment-section-->
							<br/>
											
					
					</div>
				</div>
			</div>
<script type="text/javascript">
</script>


<div class="side-dock">


	
	
				<script type="text/javascript">rmt('././goo.gl/ktrVc@a=489');</script>

	<div id="special-button">
				<a class="special-btn green" href="././https@9gag.com/signup" label="Sidebar" onclick="rmt('./goo.gl/4L7Xz@a=902');">Y U No Signup?!</a>
			</div>
		

	
							<div class="s-300">
<script type='text/javascript'>
try {
GA_googleFillSlotWithSize("ca-pub-0268871989845966", "Top-Right-300x250", 300, 250);
} catch (e) {}
</script>
</div>
		
	
	
	
        <div>
        		<div class="popular-block">
	<h3>诚意推介</h3>
	<ol>
						<a class="wrap" href="2599496"  onclick="GAG.GA.track('RelatedContent', 'Clicked-Post-Sidebar', '2599496', 1)" >
<li>
						<img src="./d24w6bsrhbeh9d.cloudfront.net/photo/2599496_220x145.jpg" alt="When you see the Girl/Boy you like." />
						<h4>When you see the Girl/Boy you like.</h4>
		<p class="meta">
			<span class="comment">
                        69            			</span>
			<span class="loved">46515</span>
		</p>
		</li>
	</a>

							<a class="wrap" href="2558210"  onclick="GAG.GA.track('RelatedContent', 'Clicked-Post-Sidebar', '2558210', 1)" >
<li>
						<img src="./d24w6bsrhbeh9d.cloudfront.net/photo/2558210_220x145_v1.jpg" alt="I used to be a wall" />
						<h4>I used to be a wall</h4>
		<p class="meta">
			<span class="comment">
                        138            			</span>
			<span class="loved">45956</span>
		</p>
		</li>
	</a>

							<a class="wrap" href="2587890"  onclick="GAG.GA.track('RelatedContent', 'Clicked-Post-Sidebar', '2587890', 1)" >
<li>
						<img src="./d24w6bsrhbeh9d.cloudfront.net/photo/2587890_220x145.jpg" alt="Watch out we got a badass over here" />
						<h4>Watch out we got a badass over here</h4>
		<p class="meta">
			<span class="comment">
                        252            			</span>
			<span class="loved">52391</span>
		</p>
		</li>
	</a>

							<a class="wrap" href="2626455"  onclick="GAG.GA.track('RelatedContent', 'Clicked-Post-Sidebar', '2626455', 1)" >
<li>
						<img src="./d24w6bsrhbeh9d.cloudfront.net/photo/2626455_220x145.jpg" alt="With luck, I&#039;ll get a kiss" />
						<h4>With luck, I&#039;ll get a kiss</h4>
		<p class="meta">
			<span class="comment">
                        176            			</span>
			<span class="loved">51139</span>
		</p>
		</li>
	</a>

							<a class="wrap" href="2607364"  onclick="GAG.GA.track('RelatedContent', 'Clicked-Post-Sidebar', '2607364', 1)" >
<li>
						<img src="./d24w6bsrhbeh9d.cloudfront.net/photo/2607364_220x145.jpg" alt="That&#039;s gotta hurt!" />
						<h4>That&#039;s gotta hurt!</h4>
		<p class="meta">
			<span class="comment">
                        87            			</span>
			<span class="loved">52897</span>
		</p>
		</li>
	</a>

							<a class="wrap" href="2611243"  onclick="GAG.GA.track('RelatedContent', 'Clicked-Post-Sidebar', '2611243', 1)" >
<li>
						<img src="./d24w6bsrhbeh9d.cloudfront.net/photo/2611243_220x145_v1.jpg" alt="Reason why I don&#039;t let my gf play my Xbox" />
						<h4>Reason why I don&#039;t let my gf play my Xbox</h4>
		<p class="meta">
			<span class="comment">
                        179            			</span>
			<span class="loved">42294</span>
		</p>
		</li>
	</a>

							<a class="wrap" href="2578425"  onclick="GAG.GA.track('RelatedContent', 'Clicked-Post-Sidebar', '2578425', 1)" >
<li>
						<img src="./d24w6bsrhbeh9d.cloudfront.net/photo/2578425_220x145.jpg" alt="Growing a moustache" />
						<h4>Growing a moustache</h4>
		<p class="meta">
			<span class="comment">
                        270            			</span>
			<span class="loved">46012</span>
		</p>
		</li>
	</a>

							<a class="wrap" href="2632173"  onclick="GAG.GA.track('RelatedContent', 'Clicked-Post-Sidebar', '2632173', 1)" >
<li>
						<img src="./d24w6bsrhbeh9d.cloudfront.net/photo/2632173_220x145.jpg" alt="That awkward moment when you.." />
						<h4>That awkward moment when you..</h4>
		<p class="meta">
			<span class="comment">
                        138            			</span>
			<span class="loved">45111</span>
		</p>
		</li>
	</a>

							<a class="wrap" href="2584791"  onclick="GAG.GA.track('RelatedContent', 'Clicked-Post-Sidebar', '2584791', 1)" >
<li>
						<img src="./d24w6bsrhbeh9d.cloudfront.net/photo/2584791_220x145_v1.jpg" alt="Dexter&#039;s Laboratory or The Big Bang Theory?" />
						<h4>Dexter&#039;s Laboratory or The Big Bang Theory?</h4>
		<p class="meta">
			<span class="comment">
                        234            			</span>
			<span class="loved">50659</span>
		</p>
		</li>
	</a>

				
	</ol>
</div>
    </div>
    
</div><!--end div.side-dock-->


</div><!--end #content-->

<div id="footer" class="">
	
			
		<div id="main-bottom-ad-tray">
			<div>
<script type='text/javascript'>
try {
GA_googleFillSlotWithSize("ca-pub-0268871989845966", "Banner-bottom-728x90", 728, 90);
} catch(e) {}
</script>
</div>
		</div>
		
		
			
    	<div class="section-2">
		<div class="wrap">
						
<ul class="info footer-left">
	<li>9GAG &copy; 2011</li>
	<li>·<a class="badge-language-selector" href="javascript:void(0);">&#31777;&#39636;&#20013;&#25991; ( zh_CN )</a></li>
</ul><!--end ul.footer-left-->
	
<ul class="info footer-right">
	<li><a href="./about">关于</a></li>
	<li>·<a href="./rules">9 條規則</a></li>
	<li>·<a href="./faq">常见问题</a></li>
	<li>·<a href="./tos">条款</a></li>
	<li>·<a href="./privacy">私隐</a></li>
	<li>·<a href="./contact">联络</a></li>
</ul><!--end ul.footer-right-->

					</div><!--end wrap-->
	</div><!--end div.section-2-->
    
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





<div style="display:none;">
<span id="siteDomain">9gag.com</span>
<span id="backUrl">%2Fgag%2F2644365</span>
<span id="fb-app-id">111569915535689</span>
<span id="fbTimelineApi">ninegag:laugh_at?funny_post</span>
<span id="nsuon">1</span>
</div>

<script type="text/javascript">
(function() {
 var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
 po.src = './https@apis.google.com/js/plusone.js';
 var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
 })();
</script>
<div id="fb-root"></div>
<script src="./connect.facebook.net/en_US/all.js" type="text/javascript"></script>
<script src="./d24w6bsrhbeh9d.cloudfront.net/js/FB.Share.1.0.2.js" type="text/javascript"></script>


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

	window.location = "./connect@twitter_login=1"+next;
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
elem.src = (document.location.protocol == "https:" ? "./https@secure/" : "./edge/") + ".quantserve.com/quant.js";
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
<img src="./pixel.quantserve.com/pixel/p-f8Bn5MbvAQbXQ.gif" border="0" height="1" width="1" alt="Quantcast"/>
</div>
</noscript>
<!-- End Quantcast tag -->






</body>
</html>
