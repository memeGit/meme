<? require_once("header.php"); 

if($auth_gid!=="1" && $auth_gid!=="2") {

	header("Location: logout.php");	exit;

	}


        $link = mysql_connect($db_server, $db_user, $db_password) or die("Could not connect.");
        mysql_select_db($db_name) or die("Could not select database.");        
        
        $limit = $_REQUEST['limit'];
        if ($limit == "") {
                $limit = 20;
        }
        $start = $_REQUEST['start'];
        if ($start == "") {
                $start = 0;
        }
        $sort = $_REQUEST['sort'];
        if ($sort == "") {
                $sort = "id";
        }

        $totalcount = 0;
        $query1 = "SELECT count(imagename) as ct from reports";
    $result1 = mysql_query($query1) or die("Query failed1.");
        while ($line = mysql_fetch_array($result1)) {
                        $totalcount = $line[ct];
        }
        mysql_free_result($result1);

        $displaystart = $start + 1;
        $displayend = ($start + $limit > $totalcount ? $totalcount : $start + $limit);
        if ($displayend == $totalcount) {
                $nextset = 0;
        } else {
                $nextset = ($totalcount - $displayend > $limit ? $limit: ($totalcount - $displayend));
        }


		       //         $query = "select i.filename as filename, i.tn_filename as tn_filename, i.filepath as filepath, i.added as add_dt, i.ip as ip, i.filesize as filesize, sum(ih.kb) as bandwidth, count( ih.filename ) as ctr from images i left outer join imagehits ih on i.filename = ih.filename group by filename order by " . $sort . " desc limit " . $start . "," . $limit;
						
$query2 = "select r.id as id, r.reporterid as reporterid, r.uploaderid as uploaderid, r.timestamp as timestamp, r.imagename as imagename, r.ip as ip, i.tn_filename as tn_filename, i.filepath as filepath from reports r left outer join images i on r.imagename = i.filename order by ".$sort."";
				
//	$query2 = "select * from reports order by id limit " . $start . "," . $limit;
				
    $result2 = mysql_query($query2) or die(mysql_error());
?>
<div style="width:770px;">
<center>
<h4> <font face="Comic Sans MS" size="4" color="#FF0000">Abuse Reports<br>        </font></h4></center>
<br>
<hr>
<br>
You can click on the image name to view more information about it or delete it.<br>
If the image is adult or inappropriate you can suspend the uploader and delete the image.<br>
If the image is not adult or inappropriate you can suspend the reporter and delete the report.<br>
You can click on uploader id or reporter id to edit their account or suspend any of them.<br><br><br>
<form name="reports" id="reports" action="<?= $_SERVER['PHP_SELF'] ?>" method="post" style="margin-bottom: 0px;" >
<div align="center" style="color: #000080;">Reports per page: <input type="text" name="limit" value="<?= $limit ?>" size="3" maxlength="4">&nbsp;&nbsp;&nbsp;&nbsp;Sort by: <select name="sort" size="1"><option value="date" <?= ($sort == "timestamp" ? "selected" : "") ?>>Date/Time Added</option><option value="imagename" <?= ($sort == "imagename" ? "selected" : "") ?>>Image Name</option><option value="reporterid" <?= ($sort == "reporterid" ? "selected" : "") ?>>Reporter ID</option><option value="uploaderid" <?= ($sort == "uploaderid" ? "selected" : "") ?>>Uploader ID</option></select>&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" name="btn" value="View"></div>
<br>
<br>
<div id="error"style="display:none;"><div class="msg" id="sucmsgid"></div></div>
<div id="displayimage">
<table border="0" width="95%" cellpadding="2" cellspacing="0">
        <tr>

                <td width="60%" valign="top" align="center" nowrap><strong>Displaying abuse reports <?= $displaystart ?> to <?= $displayend ?> of <?= $totalcount ?>.</strong></td>
                <td width="20%" valign="top" align="right" nowrap><? if ($start > 0) { ?><a style="color: #0000cd;" href="<?= $PHP_SELF ?>?limit=<?= $limit ?>&sort=<?= $sort ?>&start=<?= $start - $limit?>&tn=<?= $tn ?>&details=<?= $details ?>">Previous <?= $limit ?></a> - <? } ?><? if ($nextset > 0) { ?><a style="color: #0000cd;" href="<?= $PHP_SELF ?>?limit=<?= $limit ?>&sort=<?= $sort ?>&start=<?= $start + $limit?>&tn=<?= $tn ?>&details=<?= $details ?>">Next <?= $nextset ?></a><? } ?></td>
        </tr>
</table>


<table border="0" width="95%" cellpadding="2" cellspacing="0">
        <tr bgcolor="#dcdcdc">
                <td align="center" class="cell"><input type="checkbox" onclick="check_all('chk','reports')"></td>
                <td align="center" class="cell"><strong>Report ID</strong></td>
                <td align="center" class="cell"><strong>Reported Photo</strong></td>
                <td align="center" class="cell"><strong>Report Date/Time</strong></td>
                <td align="center" class="cell"><strong>Reporter ID</strong></td>
                <td align="center" class="cell"><strong>Reporter IP</strong></td>
                <td align="center" class="cell"><strong>Uploader ID</strong></td>
        </tr>
<? while ($line = mysql_fetch_array($result2)) { ?>
        <tr id="<?=$line[id]?>">
                <td align="center" class="cell"><input type="checkbox" name="chk[]" value="<?=$line[id]?>"></td>
				<td align="center" class="cell"><?=$line[id]?></td>
                <td align="center" class="cell"><a href="view.php?filename=<?= $line[imagename] ?>"><img src="<?= $line[filepath].$line[tn_filename] ?>" border="0"></a></td>
                <td align="center" class="cell"><?= date("d/m/Y h:i:s A", $line[timestamp]) ?>&nbsp;</td>
				<td align="center" class="cell"><a title="Click to edit or suspend user" href="edituser.php?uid=<?= $line[reporterid] ?>"><?=$line[reporterid]?></a></td>
				<td align="center" class="cell"><?=$line[ip]?></td>
				<td align="center" class="cell"><a title="Click to edit or suspend user" href="edituser.php?uid=<?= $line[uploaderid] ?>"><?=$line[uploaderid]?></a></td>
        </tr>
<? } ?>
</table>
</div>
<?

    mysql_free_result($result2);
        mysql_close($link);
		?>
<br>
<table border="0" width="95%" cellpadding="2" cellspacing="0">
        <tr bgcolor="#dcdcdc">
                <td align="center" class="cell"><input type="button" name="delete" value="Delete Report" onClick="return deletereport();"></td>
        </tr>
</table>    
</form>
</div>
</div>
<br>
<br>
<? require_once("footer.php"); ?>