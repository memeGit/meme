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
<html >
<head>

<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<script src="http://code.jquery.com/jquery-latest.js" type="text/javascript"></script>
<link href="static/css/detail.css" rel="stylesheet" type="text/css">
</head>
<body id="page-post" class="main-body">
	<? require "header.php"?>      
<div id="container" style="">
	<div id="main">
	
		<div id="block-content">
			<div class="post-info-pad">
			
				<h1>
				<?php 
				// TODO
				?>
				</h1>
				<p>
				<a href="
				<?
					// TODO URL OF USER
				?>
				">
				<?php
				echo $uploaderid;
				?>
				</a>
				<span class="seperator">|</span>
				<?php
				// TODO
				echo $date_added;
				?>
				<span class="comment"><?php
				// TODO ��������
				?></span>
				<span class="loved"><span id="love_count_
				<?php 
				// TODO love count
				?>" votes="
				
				<?php 
				//TODO  VOTE COUNT
				?>
				
				" score="
				<?php 
				// TODO score
				?>
				">
				</span></span>		
				</p>
				<ul class="actions">
							<li><a id="post_view_love" rel="
							<?php 
							// TODO pic id
							?>
							" class="love " href="javascript:void(0);">Love</a></li>
				</ul>
					
		</div><!--end post-info-pad-->
		<div id="post-control-bar" class="spread-bar-wrap">
					
		<div class="spread-bar">
		<!-- JiaThis Button BEGIN -->
		<div id="ckepop">
			<span class="jiathis_txt">评论</span>
			<a class="jiathis_button_tools_1"></a>
			<a class="jiathis_button_tools_2"></a>
			<a class="jiathis_button_tools_3"></a>
			<a class="jiathis_button_tools_4"></a>
			<a href="http://www.jiathis.com/share?uid=1586402" class="jiathis jiathis_txt jiathis_separator jtico jtico_jiathis" target="_blank">分享</a>
			<a class="jiathis_counter_style"></a>
		</div>
		</div>
		<div class="post-next-prev">
							<a id="prev_post" class="prev-post" href="http://9gag.com/gag/3256248" onclick="_gaq.push(['_trackEvent', 'View-Post', 'Clicked', 'Previous', 1]);"></a>
							<a id="next_post" class="next-post" href="http://9gag.com/gag/3256314" onclick="_gaq.push(['_trackEvent', 'View-Post', 'Clicked', 'Next', 1]);"></a>
						</div>
<script type="text/javascript">var jiathis_config = {data_track_clickback:true};</script>
<script type="text/javascript" src="http://v2.jiathis.com/code/jia.js?uid=1586402" charset="utf-8"></script>
</div>
<!-- JiaThis Button END -->
		
		<!-- JiaThis Button BEGIN -->
<script type="text/javascript">var jiathis_config = {data_track_clickback:true};</script>
<script type="text/javascript" src="http://v2.jiathis.com/code/jiathis_r.js?type=left&amp;move=0&amp;uid=1586402" charset="utf-8"></script>
<!-- JiaThis Button END -->
	<div id="content">
		<div class="post-container">
		<div class="img-wrap">							
		<a href="/random">
		<img src="<?=$file_path.$file?>" alt="
		<?
		echo "filename";
		?>" border="0" style="max-width:800px"/>
		</a>
		
		
		
		</div><!--end image-wrap-->
		</div><!--end post-container-->
		<div class="comment-section">
		<h3 class="title" id="comments">评论</h3>
		<span class="report-and-source">
								<p>																																
								<a class="fix" href="<?php
			//					�ж��Ƿ��¼���ҵ�¼
								?>">帖子有问题</a>
								<span id="report-item-separator">|</span>
								<a class="report" href="">X和谐</a>
								<span id="report-item-separator">|</span>
								δ֪	</p>
		</span>
								<div id="entry-comments" style="text-align:center">
                                <?php 
								?>
								
								<!-- UY BEGIN -->
<div id="uyan_frame"></div>
<script type="text/javascript" id="UYScript" src="http://v1.uyan.cc/js/iframe.js?UYUserId=90227" async=""></script>
<!-- UY END -->
								</div>
							</div><!--end div.comment-section-->
							<br>
											
					
					</div>

				</div><!--end div.block-content-->

			</div><!--end div#main-->
<script type="text/javascript">
</script>


<div class="side-dock">
	      <div id="special-button">
		  <script type="text/javascript">rmt('http://goo.gl/ktrVc?a=148');</script>  
		  <a class="special-btn green" href="https://prenoon.com/signup" label="Sidebar" onclick="rmt('http://goo.gl/4L7Xz?a=402');">�㻹δ��¼</a>
			
	    </div>
		<div class="s-300">
<script type="text/javascript">
try {
GA_googleFillSlotWithSize("ca-pub-0268871989845966", "Top-Right-300x250", 300, 250);
} catch (e) {}
</script>
<div id="google_ads_div_Top-Right-300x250"><ins style="position:relative;width:300px;height:250px;border:none;display:inline-table;">
<ins style="position:relative;width:300px;height:250px;border:none;display:block;">
<iframe id="google_ads_iframe_Top-Right-300x250" name="google_ads_iframe_Top-Right-300x250" width="300" height="250" vspace="0" hspace="0" allowtransparency="true" scrolling="no" marginwidth="0" marginheight="0" frameborder="0" style="border:0px;left:0;position:absolute;top:0;" src="http://pubads.g.doubleclick.net/gampad/ads?correlator=1330165484054&amp;output=html&amp;impl=ifr&amp;client=ca-pub-0268871989845966&amp;slotname=Top-Right-300x250&amp;page_slots=Top-Right-300x250&amp;cookie=ID%3D2c8de1e47b8d646a%3AT%3D1329576818%3AS%3DALNI_MZbfaK_OJgtwVcE37f4xvON9zfePQ&amp;url=http%3A%2F%2F9gag.com%2Fgag%2F2140534&amp;ref=http%3A%2F%2Flocalhost%2Fprenoon%2Fdetail.php&amp;lmt=1330136684&amp;dt=1330165484063&amp;biw=1263&amp;bih=675&amp;adk=1086858102&amp;adx=861&amp;ady=142&amp;ifi=1&amp;oid=3&amp;u_tz=480&amp;u_his=4&amp;u_java=true&amp;u_h=800&amp;u_w=1280&amp;u_ah=760&amp;u_aw=1280&amp;u_cd=32&amp;u_nplug=28&amp;u_nmime=82&amp;flash=11.1.102&amp;gads=v2&amp;ga_vid=95337883.1330165484&amp;ga_sid=1330165484&amp;ga_hid=3029064"></iframe></ins></ins></div>
</div>
 <div id="post-gag-stay" class="_badge-sticky-elements" data-y="60">
 <div class="popular-block">
 <h3>�����ƽ�</h3>
	<ol>
<?php
// TODO	�Ƽ�ģ��
?>	
	</ol>
</div>
    </div>
    
</div><!--end div.side-dock-->


</div>
</body>

</html>