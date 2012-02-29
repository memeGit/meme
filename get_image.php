<?php
	require "imagesharing/inc/config.php";
	$img_db = mysql_query($db_name,$conn);
	$sql = "select url from images.images;";
	
	$query = "select i.idx as idx, i.filename as filename, i.tn_filename as tn_filename, i.filepath as filepath, i.added as add_dt, i.ip as ip, i.filesize as filesize, sum(ih.kb) as bandwidth, count( ih.filename ) as ctr from images i left outer join imagehits ih on i.filename = ih.filename where i.prv=0 group by filename order by " .added . " desc limit " . 0 . "," . 30;
	$result = mysql_query($query) or die(mysql_error());
	if( !$result )
	{
		die("no pic");
	}
	$str ="{\"images\":[";
	$row = mysql_fetch_assoc($result);
	$str .=json_encode($row);
	
	while ($row = mysql_fetch_assoc($result)) 
	{	
		$str .= ",".json_encode($row);
	}	
	$str .= "]}";
	echo $str;
	mysql_free_result($result);

?>