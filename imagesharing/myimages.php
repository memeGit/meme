<?require_once("header.php"); 
if($auth_id == '0')
{
	header("Location: logout.php");
	exit;
}
        $limit = check_input($_REQUEST['limit']);
        if ($limit == "") {
                $limit = 10;
        }
        $start = check_input($_REQUEST['start']);
        if ($start == "") {
                $start = 0;
        }
        $sort = check_input($_REQUEST['sort']);
        if ($sort == "") {
                $sort = "added";
        }
        $tn = check_input($_REQUEST['tn']);
        if ($tn == "") {
                $tn = 0;
        }
        $details = check_input($_REQUEST['details']);
        if ($details == "") {
                $details = 1;
        }

        $totalcount = 0;
        $query = "SELECT count(filename) as ct from images where userid=$auth_id";        
    $result = mysql_query($query) or die("Query failed 1.");
        while ($line = mysql_fetch_array($result)) {
                        $totalcount = $line[ct];
        }
        mysql_free_result($result);

        $displaystart = $start + 1;
        $displayend = ($start + $limit > $totalcount ? $totalcount : $start + $limit);
        if ($displayend == $totalcount) {
                $nextset = 0;
        } else {
                $nextset = ($totalcount - $displayend > $limit ? $limit: ($totalcount - $displayend));
        }

        if ($details) {
                $query = "select i.idx as idx, i.filename as filename, i.tn_filename as tn_filename, i.filepath as filepath, i.prv as prv, i.added as add_dt, i.ip as ip, i.filesize as filesize, sum(ih.kb) as bandwidth, count( ih.filename ) as ctr from images i left outer join imagehits ih on i.filename = ih.filename where i.userid=$auth_id group by filename order by " . $sort . " desc limit " . $start . "," . $limit;
        } else {
                $query = "select i.idx as idx, i.filename as filename, i.tn_filename as tn_filename, i.filepath as filepath, i.prv as prv from images i left outer join imagehits ih on i.filename = ih.filename  where i.userid=$auth_id group by filename order by " . $sort . " desc limit " . $start . "," . $limit;
        }
        
    $result = mysql_query($query) or die("Query failed 2.");
        
?>
<div id="wrapper">
<div  style="width:760;">
	<center>
		<h4> <font face="Comic Sans MS" size="4" color="#FF0000">My Photos<br /></font></h4>
	</center>
	<br />
	<hr />
	<br />

	<form name="images" id="images" action="<?= $_SERVER['PHP_SELF'] ?>" method="post" style="margin-bottom: 0px;">
	<div align="center" style="color: #000080;">
		Images per page: <input type="text" name="limit" value="<?= $limit ?>" size="3" maxlength="4">&nbsp;&nbsp;&nbsp;&nbsp;Sort by: <select name="sort" size="1"><option value="filename" <?= ($sort == "filename" ? "selected" : "") ?>>Image Name</option><option value="added" <?= ($sort == "added" ? "selected" : "") ?>>Date/Time Added</option><option value="ip" <?= ($sort == "ip" ? "selected" : "") ?>>IP Address</option><option value="filesize" <?= ($sort == "filesize" ? "selected" : "") ?>>File Size</option><option value="ctr" <?= ($sort == "ctr" ? "selected" : "") ?>>Views</option><option value="prv" <?= ($sort == "prv" ? "selected" : "") ?>>Status</option><option value="bandwidth" <?= ($sort == "bandwidth" ? "selected" : "") ?>>Bandwidth</option></select>&nbsp;&nbsp;&nbsp;&nbsp;View Thumbnails: <select name="tn" size="1"><option value="1" <?= ($tn == "1" ? "selected" : "") ?>>Yes</option><option value="0" <?= ($tn == "0" ? "selected" : "") ?>>No</option></select>&nbsp;&nbsp;&nbsp;&nbsp;View Details: <select name="details" size="1"><option value="1" <?= ($details == "1" ? "selected" : "") ?>>Yes</option><option value="0" <?= ($details == "0" ? "selected" : "") ?>>No</option></select>&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" name="btn" value="view" style="font-size: large;">
	</div>
	<br />
	<br />
	<div id="error" style="display:none;"><div class="msg" id="sucmsgid"></div></div>
	<div id="displayimage">
		<table border="0" width="100%" cellpadding="2" cellspacing="0">
			<tr>
                <td width="20%" valign="top" align="left" nowrap><br /></td>
                <td width="60%" valign="top" align="center" nowrap><span class="fontcolor"><b>Displaying images <?= $displaystart ?> to <?= $displayend ?> of <?= $totalcount ?>.</b></td>
                <td width="20%" valign="top" align="right" nowrap><? if ($start > 0) { ?><a style="color: #0000cd;" href="<?= $PHP_SELF ?>?limit=<?= $limit ?>&sort=<?= $sort ?>&start=<?= $start - $limit?>&tn=<?= $tn ?>&details=<?= $details ?>">Previous <?= $limit ?></a> - <? } ?><? if ($nextset > 0) { ?><a style="color: #0000cd;" href="<?= $PHP_SELF ?>?limit=<?= $limit ?>&sort=<?= $sort ?>&start=<?= $start + $limit?>&tn=<?= $tn ?>&details=<?= $details ?>">Next <?= $nextset ?></a><? } ?></td>
			</tr>
		</table>
	<? if ($details) { ?>
		<table border="0" width="100%" cellpadding="2" cellspacing="0">
			<tr bgcolor="#dcdcdc" height="20">
                <td align="left" class="fontcolor"><input type="checkbox" onClick="check_all('chk','images')"></td>
                <td align="left" class="fontcolor"><strong>Image Name</strong></td>
                <? if ($tn) { ?><td align="left" class="cell"><strong>Thumbnail</strong></td><? } ?>
                <td align="left" class="fontcolor"><strong>Date/Time Added</strong></td>
                <td align="right" class="fontcolor"><strong>File Size KB</strong></td>
                <td align="right" class="fontcolor"><strong>Views</strong></td>
                <td align="right" class="fontcolor"><strong>Bandwidth MB</strong></td>
                <td align="right" class="fontcolor"><strong>Status</strong></td>

				</tr>
	<? $i=0;while ($line = mysql_fetch_array($result)) { ?>
			<tr id="<?=$line[filename]?>">
                <td align="left" class="cell"><input type="checkbox" name="chk[]" value="<?= $line[filename] ?>"></td>
                <td align="left" class="cell"><a style="color:#0000cd;" href="view.php?filename=<?= $line[filename] ?>"><?= $line[filename] ?></a>&nbsp;</td>
                <? if ($tn) { ?><td align="left" class="cell">
                <img src="<?=$line[filepath].$line[tn_filename] ?>" border="0"></td><? } ?>
                <td align="left" class="cell"><?= date("d/m/Y h:i:s A", $line[add_dt]) ?>&nbsp;</td>
                <?
					$band=$line[bandwidth];
					$bandwidthmb =  ($band / 1048576) ;        
					//$bandwidthmb =  ($band / 1024) ;
					$filesizekb =  ($line[filesize] / 1024) ;
                ?>
                <td align="right" class="cell"><?= number_format($filesizekb)?>&nbsp;</td>
                <td align="right" class="cell"><a href="referers.php?limit=<?= $limit ?>&sort=<?= $sort ?>&start=<?= $start ?>&tn=<?= $tn ?>&details=<?= $details ?>&filename=<?= $line[filename] ?>"><?= number_format($line[ctr]) ?></a>&nbsp;</td>
                <td align="right" class="cell"><?= number_format($bandwidthmb) ?>&nbsp;</td>
        <td align="right" class="cell"><span id="s_<?= $line[filename] ?>"><?php if($line[prv]==1) echo "Private"; if($line[prv]==0) echo "Public";?></span>&nbsp;</td>
				</tr>
	<? $i++;} ?>
		</table>
	</div>
	<? } else { ?>
		<table border="0" width="100%" cellpadding="2" cellspacing="0">
			<tr>
				<?
					$ctr = 0;
					while ($line = mysql_fetch_array($result)) {
                        $ctr++;
				?>
                <td valign="top" align="center"><div id="<?=$line[filename]?>"><a href="view.php?filename=<?= $line[filename] ?>"><img src="<?=$line[filepath].$line[tn_filename] ?>" border="0"></a><br /><br /><input type="checkbox" name="deleteFN[]" value="<?= $line[filename] ?>"></div></td>
				<?
                    if ($ctr % 5 == 0) {
				?>
            </tr>
            <tr>
			<?}}?>
			</tr>
		</table>
			</div>

	<? }
    mysql_free_result($result);
    mysql_close($link);
	?>
<br />
	<table border="0" width="100%" cellpadding="2" cellspacing="0">
        <tr bgcolor="#dcdcdc">
                <td align="center" class="cell">
				<input type="button" name="btn" value="Delete"  onClick="return u_deleteimage();">
				        &nbsp;&nbsp;
				<input type="button" name="public" value="Set Public" onClick="return imgstatus('Public');">
        &nbsp;&nbsp;
				<input type="button" name="private" value="Set Private" onClick="return imgstatus('Private');">

				<input type="hidden" name="authid" id="authid" value="<?=$auth_id?>" >

        </td></tr>
	</table>  
	
</form>


</div>
</div>
<? require_once("footer.php"); ?>