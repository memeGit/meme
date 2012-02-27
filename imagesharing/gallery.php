<? require "header.php";
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

                                $result = mysql_query($query) or die("Query failed.");
								
		$query_ti = "SELECT * from images where prv=0";
        $result_ti = mysql_query($query_ti) or die("query_ti failed");
		$totalimages = mysql_num_rows($result_ti);  
								
if ($totalcount>$totalimages) {
$totallimit=$totalimages; 
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

<div id="wrapper">
<div  style="width:760;">
	<center>
		<h4> <font face="Comic Sans MS" size="4" color="#FF0000">Photo Gallery<br /></font></h4>
	</center>
	<br />
	<hr />
	<br />

	<form name="images" id="images" action="gallery.php" method="post" style="margin-bottom: 0px;">
	<div align="center" style="color: #000080;">
		Image name: <input type="text" name="query" /><br />
		Images per page: <input type="text" name="limit" value="<?= $limit ?>" size="3" maxlength="4">&nbsp;&nbsp;&nbsp;&nbsp;Sort by: <select name="sort" size="1"><option value="added" <?= ($sort == "added" ? "selected" : "") ?>>Date/Time Added</option><option value="filename" <?= ($sort == "filename" ? "selected" : "") ?>>Image Name</option><option value="filesize" <?= ($sort == "filesize" ? "selected" : "") ?>>File Size</option><option value="ctr" <?= ($sort == "ctr" ? "selected" : "") ?>>Views</option></select>&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" name="btn" value="View" style="font-size: large;">
	</div>
	<br />
	<br />
	<div id="error" style="display:none;"><div class="msg" id="sucmsgid"></div></div>
	<div class="displayimage" id="displayimage">
		<table border="0" width="100%" cellpadding="2" cellspacing="0">
			<tr>
                <td width="20%" valign="top" align="left" nowrap><br /></td>
                <td width="60%" valign="top" align="center" nowrap><span class="fontcolor"><b>Displaying images <?= $displaystart ?> to <?= $displaylimit ?> of <?= $totallimit ?>.</b></td>
				
 <td width="40%" valign="top" align="center" nowrap><? if ($start > 0) { ?><a style="color: #0000cd;" href="<?= $PHP_SELF ?>?limit=<?= $limit ?>&start=<?= $start - $limit?>">Previous Page</a><? } ?><? if (($start + $limit)<$totallimit){ ?><a style="color: #0000cd;" href="<?= $PHP_SELF ?>?limit=<?= $limit ?>&start=<?= $start + $limit?>"> - Next Page</a><? } ?></td>
				
				
			</tr>
		</table><br><br>
		<table border="0" width="100%" cellpadding="2" cellspacing="0">
			<tr>
				<?
					$ctr = 0;
					while ($line = mysql_fetch_array($result)) {
                        $ctr++;
					$short_name = substr($line[filename], 0, 30);
				?>
                <td valign="top" align="center"><div name="galimage" id="<?=$line[filename]?>"><a href="view.php?filename=<?= $line[filename] ?>"><img class="displayimage" src="<?=$line[filepath].$line[tn_filename] ?>" alt="<?= $line[filename]?>" title="<?= $line[filename]?>" ></a><br /><br /><? if($auth_gid=="1" || $auth_gid=="2") {?></div><input type="checkbox" name="deleteFN[]" onclick="change(this);" value="<?= $line[filename] ?>"><?}?>  <?=$short_name?></td>
				<?
                    if ($ctr % 3 == 0) {
				?>
            </tr>
<tr height="30"></tr>


			<?}}?>
			</tr>

		</table>

			</div>

	<? 
    mysql_free_result($result);
    mysql_close($link);
	?>
<br />

		<table border="0" width="100%" cellpadding="2" cellspacing="0">
			<tr>
                <td width="20%" valign="top" align="left" nowrap><br /></td>
                <td width="60%" valign="top" align="center" nowrap><span class="fontcolor"><b>Displaying images <?= $displaystart ?> to <?= $displaylimit ?> of <?= $totallimit ?>.</b></td>
				
				
				
                                                <td width="40%" valign="top" align="center" nowrap><? if ($start > 0) { ?><a style="color: #0000cd;" href="<?= $PHP_SELF ?>?limit=<?= $limit ?>&start=<?= $start - $limit?>">Previous Page</a><? } ?><? if (($start + $limit)<$totallimit){ ?><a style="color: #0000cd;" href="<?= $PHP_SELF ?>?limit=<?= $limit ?>&start=<?= $start + $limit?>"> - Next Page</a><? } ?></td>
				
				
			</tr>
		</table>
		
<br /><br />		
<? if($auth_gid=="1" || $auth_gid=="2") {?>	<table border="0" width="100%" cellpadding="2" cellspacing="0">
        <tr bgcolor="#dcdcdc">
                <td align="center" class="cell"><input type="button" name="btn" value="Delete"  onClick="return deleteimage();"></td>
        </tr>
	</table><?}?>        
</form>

<?if (($ads == "1" && !$auth_id) || ($ads == "2") ) { ?> <center><br /><br /> <?=$config[footer]?> </center> <br /><br /> <?}?>

</div>
</div>
<? require_once("footer.php"); ?>