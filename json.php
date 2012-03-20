<?php
/*
 * Created on 2012-3-18
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 require "imagesharing/inc/config.php";
 	
 	$type = $_GET["type"];
 	$begin = $_GET["begin"];
 	$num = $_GET["count"];
	$query = "select i.idx as idx, i.filename as filename, i.tn_filename as tn_filename, i.filepath as filepath, i.added as add_dt, i.ip as ip, i.filesize as filesize, sum(ih.kb) as bandwidth, count( ih.filename ) as ctr from images i left outer join imagehits ih on i.filename = ih.filename where i.prv=0 group by filename ";
	$orderby = "order by "; 
	$wh=" desc limit " . $begin . "," . $num;
	switch($type){
		case 'hot':
		$orderby=$orderby." ".ctr;
		break;
		case 'random':
		$orderby=$orderby." rand()";
		break;
		default:
		$orderby="";
	}
	//echo $query;
	//echo $orderby;
	//echo $wh;
	$query=$query." ".$orderby." ".$wh;
	
	$result = mysql_query($query) or die(mysql_error());
/**	$row = mysql_fetch_assoc($result);
	if( $row )
	{
		$str ="{\"images\":[";	
		$str .=json_encode($row);
	
		while ($row = mysql_fetch_assoc($result)) 
		{	
			$str .= ",".json_encode($row);
		}		
		$str .= "]}";
	}
*/
$response = "{\"ok\":true,\"items\":{";
$is_first= 1;
$ctr = $begin;
while ($line = mysql_fetch_array($result)) {
	$ctr++;
	
	$short_name = substr($line[filename], 0, 30);
	$data_url = "url";
	$image_title = "title".strval($ctr);
	$meme_id = "meme_id".strval($ctr);
	$id="id".strval($ctr);
	$love_count=100;
	$score = 100;
	$usr_id="user";
	$comment_url="comment_url";	
	$time = "time";
	$comment_count = 100;
	
	if($is_first !=1 )
	{
		$response .=",";
	}else{
		$is_first = 0;
	}
	$response .="\"entry-".$ctr."\":";
	$body = "";
	$body .="<li class=\"entry-item\" data-url=\"".$data_url."\" data-text=\"";
	$body .=$image_title;
	$body .="\" gagId=\"".$meme_id."\"itemType=\"list\" id=\"".$id."\">";
	
	$body .= "<div class=\"content\">"; 
	$body .= "<div class=\"img-wrap\">";
	$body .= "<a href=\"detail.php?filename=".$line[filename]."\">";
	$body .= "<img src=\"";
	$body .= $line[filepath].$line[filename]."\" alt=\"";
	$body .= $image_title."\"  border=\"0\" style=\"max-width:450px\"/></a></div>";
	
	$body .= "<div class=\"fatbigdick\"></div></div>";
	$body .= "<div class=\"info jump_stop jump_focus\">";
	$body .= "<div class=\"sticky-items\" id=\"sticky-item-".$id."\">";
	
	$body .= "<h1><a href=\"gag/2644365\"  target=\"_blank\" >".$image_title."</a></h1>";
	$body .= "<h4><a href=\"".$usr_id."\">".$usr_id."</a>";
	$body .= "<p>".$time."</p></h4>";
	$body .= "<p><span class=\"comment\">".$comment_count."</span>";
	
	$body .= "<span id=\"love_count_".$id."class=\"loved\" votes=\"".$love_count;
	$body .= "\" score=\"0\">".$score."</span><p>";
	$body .= "<ul class=\"actions\"><li>";

	$body .= "<a class=\"comment\" href=\"".$comment_url."\"onclick=\"window.location = ".$comment_url.";\"><span>".$text_comment."</span></a>";
	$body .="</li><li>";
	$body .= "<a id=\"vote-up-btn-2644365\"";
	$body .= "class=\"love badge-vote-up\"";
	$body .= "entryId=\"2644365\"";
	$body .= "href=\"javascript:void(0);\"> <span>".$text_love."</span></a>";

	$body .="</li><ul></div></div><div></li>";
	
	$body = json_encode($body);
	
	$response .=$body;
?>
        
<?
}
$response .="},\"prevId\":".$ctr; 	
$response .="}";
	echo ($response);
	mysql_free_result($result);
	 
?>
