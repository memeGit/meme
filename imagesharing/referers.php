<? require_once("header.php");
if($auth_id == '0')
{
	header("Location: logout.php");
	exit;
}
  $filename = check_input($_REQUEST['filename']);
        $link = mysql_connect($db_server, $db_user, $db_password) or die("Could not connect.");

        mysql_select_db($db_name) or die("Could not select database.");

        $query = "SELECT i.filename as filename, i.tn_filename as tn_filename, i.filepath as filepath, i.added as add_dt, i.ip as ip, i.filesize as filesize, sum(ih.kb) as bandwidth, count( ih.filename ) as ctr from images i left outer join imagehits ih on i.filename = ih.filename where i.filename = '$filename' group by filename";

    $result = mysql_query($query) or die("Query failed.");

    while ($line = mysql_fetch_array($result)) {
$bandwidthmb =  (($line[filesize]*$line[ctr]) / 1048576) ;
$bandwidthkb =  (($line[filesize]*$line[ctr]) / 1024) ;
$filesizekb =  ($line[filesize] / 1024) ;

?>
<div id="wrapper">
        <center>
        <h4> <font face="Comic Sans MS" size="4" color="#FF0000">Referers<br /></font></h4></center>
        <br />
                <table width="100%" align="center" border="0" cellspacing="0" cellpadding="4">
                        <tr>
                <td align="right"><strong class="fontcolor">File Name:</strong></td>
                <td align="left">&nbsp; <?= $line[filename] ?></td>
                <td align="right"><strong class="fontcolor">File Size:</strong></td>
                <td align="left">&nbsp; <?= number_format($filesizekb) ?> KB</td>
                        </tr>
                        <tr>
                <td align="right"><strong class="fontcolor">Date/Time Added:</strong></td>
                <td align="left">&nbsp; <?= date("d/m/Y h:i:s A", $line[add_dt]) ?></td>
                <td align="right"><strong class="fontcolor">Views:</strong></td>
                <td align="left">&nbsp; <?= number_format($line[ctr]) ?></td>
                        </tr>
                        <tr>
                <td align="right"><strong class="fontcolor">Bandwidth Used:</strong></td>
                <td align="left">&nbsp;<?= number_format($bandwidthmb) ?> MB</td>
                        </tr>
                        <tr>
                <td align="right"><strong class="fontcolor">Bandwidth Used:</strong></td>
                <td align="left">&nbsp; <?= number_format($bandwidthkb) ?> KB</td>                
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                        </tr>
                </table>
        <br />
        <div align="center" style="width:760px;">
                <br />
                <form name="referers" action="myimages.php" method="post" style="margin-bottom: 0px;">
                <input type="hidden" name="tn" value="<?= $_REQUEST['tn'] ?>">
                <input type="hidden" name="limit" value="<?= $_REQUEST['limit'] ?>">
                <input type="hidden" name="sort" value="<?= $_REQUEST['sort'] ?>">
                <input type="hidden" name="start" value="<?= $_REQUEST['start'] ?>">
                <input type="hidden" name="details" value="<?= $_REQUEST['details'] ?>">
                <input type="hidden" name="filename" value="<?= $_REQUEST['filename'] ?>">
                <input type="submit" name="return" value="Return to image list">
                </form>
                <br />
                <table border="0" width="100%" align="center" cellpadding="2" cellspacing="0">
                        <tr bgcolor="#dcdcdc" height="20">
                <td align="center" class="fontcolor"><strong>Date/Time Viewed</strong></td>
                <td align="center" class="fontcolor"><strong>Referer</strong></td>
                        </tr>
        <?
        $query2 = "SELECT timestamp as ts, referer, ip from imagehits where filename = '$filename' order by timestamp desc limit 50";
                $result2 = mysql_query($query2) or die("Query failed.");
                while ($line2 = mysql_fetch_array($result2)) {
        ?>
        <tr>
            <td align="left" class="cell"><?= date("d/m/Y h:i:s A", $line2[ts]) ?>&nbsp;</td>
            <td align="left" class="cell"><a href="<?= $line2[referer] ?>" target="_blank"><?= strlen($line2[referer]) > 50 ? substr($line2[referer], 0, 50) . "..." : $line2[referer] ?></a>&nbsp;</td>
                </tr>
        <?
       }
        ?>
                </table>
        </div>
        <?
    }
    mysql_free_result($result);
    mysql_free_result($result2);
    mysql_close($link);
        ?>

<br />
<br />
                                                    <br /><br /><br /><center><?=$config[footer]?></center><br /><br />

</div>
<br />
<? require_once("footer.php"); ?>
