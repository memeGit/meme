<? require_once("header.php"); 

if ($auth_gid)
  {
    
   if ($auth_gid!="1" && $auth_gid!="2")
      {

      header("Location: logout.php"); exit;
       }
        
   }
else
  {
   header("Location: login.php");
   }


if ($btn == "delete") {
		$deleteList = $_REQUEST['chk'];
		foreach ($deleteList as $fn) {			
			$query = "delete from users where userid = '$fn'";				
    		$result = mysql_query($query) or die("Query failed.");
    		
		}
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
                $sort = "added";
        }
        $tn = $_REQUEST['tn'];
        if ($tn == "") {
                $tn = 0;
        }
        $details = $_REQUEST['details'];
        if ($details == "") {
                $details = 1;
        }

        $totalcount = 0;
        $query = "SELECT count(filename) as ct from images";
    $result = mysql_query($query) or die("Query failed.");
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
                $query = "select i.filename as filename, i.tn_filename as tn_filename, i.filepath as filepath, i.added as add_dt, i.ip as ip, i.filesize as filesize, count( ih.filename ) as ctr, sum(ih.kb) as bandwidth from images i left outer join imagehits ih on i.filename = ih.filename group by filename order by " . $sort . " desc limit " . $start . "," . $limit;
        } else {
                $query = "select i.filename as filename, i.tn_filename as tn_filename, i.filepath as filepath from images i left outer join imagehits ih on i.filename = ih.filename group by filename order by " . $sort . " desc limit " . $start . "," . $limit;
        }
    $result = mysql_query($query) or die(mysql_error());
?>
<div style="width:770px;">
<center>
<h4> <font face="Comic Sans MS" size="4" color="#FF0000">Image Management<br>        </font></h4></center>
<br>
<hr>
<br>
<form name="images" id="images" action="<?= $_SERVER['PHP_SELF'] ?>" method="post" style="margin-bottom: 0px;" >
<div align="center" style="color: #000080;">Images per page: <input type="text" name="limit" value="<?= $limit ?>" size="3" maxlength="4">&nbsp;&nbsp;&nbsp;&nbsp;Sort by: <select name="sort" size="1"><option value="added" <?= ($sort == "add_dt" ? "selected" : "") ?>>Date/Time Added</option><option value="filename" <?= ($sort == "filename" ? "selected" : "") ?>>Image Name</option><option value="userid" <?= ($sort == "userid" ? "selected" : "") ?>>User Name</option><option value="ip" <?= ($sort == "ip" ? "selected" : "") ?>>IP Address</option><option value="filesize" <?= ($sort == "filesize" ? "selected" : "") ?>>File Size</option><option value="ctr" <?= ($sort == "ctr" ? "selected" : "") ?>>Views</option><option value="bandwidth" <?= ($sort == "bandwidth" ? "selected" : "") ?>>Bandwidth</option></select>&nbsp;&nbsp;&nbsp;&nbsp;View Thumbnails: <select name="tn" size="1"><option value="1" <?= ($tn == "1" ? "selected" : "") ?>>Yes</option><option value="0" <?= ($tn == "0" ? "selected" : "") ?>>No</option></select>&nbsp;&nbsp;&nbsp;&nbsp;View Details: <select name="details" size="1"><option value="1" <?= ($details == "1" ? "selected" : "") ?>>Yes</option><option value="0" <?= ($details == "0" ? "selected" : "") ?>>No</option></select>&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" name="btn" value="View"></div>
<br>
<br>
<div id="error"style="display:none;"><div class="msg" id="sucmsgid"></div></div>
<div id="displayimage">
<table border="0" width="95%" cellpadding="2" cellspacing="0">
        <tr>

                <td width="60%" valign="top" align="center" nowrap><strong>Displaying images <?= $displaystart ?> to <?= $displayend ?> of <?= $totalcount ?>.</strong></td>
                <td width="20%" valign="top" align="right" nowrap><? if ($start > 0) { ?><a style="color: #0000cd;" href="<?= $PHP_SELF ?>?limit=<?= $limit ?>&sort=<?= $sort ?>&start=<?= $start - $limit?>&tn=<?= $tn ?>&details=<?= $details ?>">Previous <?= $limit ?></a> - <? } ?><? if ($nextset > 0) { ?><a style="color: #0000cd;" href="<?= $PHP_SELF ?>?limit=<?= $limit ?>&sort=<?= $sort ?>&start=<?= $start + $limit?>&tn=<?= $tn ?>&details=<?= $details ?>">Next <?= $nextset ?></a><? } ?></td>
        </tr>
</table>
<? if ($details) { ?>
<table border="0" width="95%" cellpadding="2" cellspacing="0">
        <tr bgcolor="#dcdcdc">
                <td align="left" class="cell"><input type="checkbox" onclick="check_all('chk','images')"></td>
                <td align="left" class="cell"><strong>Image Name</strong></td>
                <? if ($tn) { ?><td align="left" class="cell"><strong>Thumbnail</strong></td><? } ?>
                <td align="left" class="cell"><strong>Date/Time Added</strong></td>
                <td align="left" class="cell"><strong>IP Address</strong></td>
                <td align="right" class="cell"><strong>File Size KB</strong></td>
                <td align="right" class="cell"><strong>Views</strong></td>
                <td align="right" class="cell"><strong>Bandwidth MB</strong></td>
        </tr>
<? while ($line = mysql_fetch_array($result)) { ?>
        <tr id="<?= $line[filename] ?>">
                <td align="left" class="cell"><input type="checkbox" name="chk[]" value="<?= $line[filename] ?>"></td>
                <td align="left" class="cell"><a style="color:#0000cd;" href="view.php?limit=<?= $limit ?>&sort=<?= $sort ?>&start=<?= $start ?>&tn=<?= $tn ?>&filename=<?= $line[filename] ?>"><?= $line[filename] ?></a>&nbsp;</td>
                <? if ($tn) { ?><td align="left" class="cell"><img src="<?=$line[filepath].$line[tn_filename] ?>" border="0"></td><? } ?>
                <td align="left" class="cell"><?= date("d/m/Y h:i:s A", $line[add_dt]) ?>&nbsp;</td>
				
				<?	
				
					$band=$line[bandwidth];
					$bandwidthmb =  ($band / 1048576) ;        
					//$bandwidthmb =  ($band / 1024) ;
					$filesizekb =  ($line[filesize] / 1024) ;
				?>
				
                <td align="left" class="cell"><?= $line[ip] ?>&nbsp;</td>
                <td align="right" class="cell"><?= number_format($filesizekb) ?>&nbsp;</td>
                <td align="right" class="cell"><a href="referers.php?limit=<?= $limit ?>&sort=<?= $sort ?>&start=<?= $start ?>&tn=<?= $tn ?>&details=<?= $details ?>&filename=<?= $line[filename] ?>"><?= number_format($line[ctr]) ?></a>&nbsp;</td>
                <td align="right" class="cell"><?= number_format($bandwidthmb) ?>&nbsp;</td>
        </tr>
<? } ?>
</table>
</div>
<? } else { ?>
<table border="0" width="90%" cellpadding="2" cellspacing="0">
        <tr>
<?
                $ctr = 0;
                while ($line = mysql_fetch_array($result)) {
                        $ctr++;
?>
                        <td valign="bottom" align="center"><a href="view.php?limit=<?= $limit ?>&sort=<?= $sort ?>&start=<?= $start ?>&tn=<?= $tn ?>&details=<?= $details ?>&filename=<?= $line[filename] ?>"><img src="<?= $line[filepath].$line[tn_filename] ?>" border="0"></a><br><input type="checkbox" name="deleteFN[]" value="<?= $line[filename] ?>"></td>
<?
                        if ($ctr % 4 == 0) {
?>
                                </tr>
                                <tr>
<?
                        }
                }
?>
        </tr>
</table>			</div>

<? } ?>
<?
    mysql_free_result($result);
        mysql_close($link);
?>
<br>
<table border="0" width="95%" cellpadding="2" cellspacing="0">
        <tr bgcolor="#dcdcdc">
                <td align="center" class="cell"><input type="button" name="delete" value="Delete" onClick="return deleteimage();"></td>
        </tr>
</table>    
</form>
</div>
</div>
<br>
<br>
<? require_once("footer.php"); ?>