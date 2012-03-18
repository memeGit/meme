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
	echo $query;
	echo $orderby;
	echo $wh;
	$query=$query." ".$orderby." ".$wh;
	
	$result = mysql_query($query) or die(mysql_error());
	$row = mysql_fetch_assoc($result);
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
	echo $str;
	mysql_free_result($result);
	 
?>
