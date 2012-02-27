<?require_once ("../inc/ftp.class.php");
require_once("header.php");


if($auth_gid!=="1" && $auth_gid!=="2") {

	header("Location: logout.php");	exit;

	}


$filename = $_REQUEST['filename'];
$delete = $_REQUEST['delete'];


        $link = mysql_connect($db_server, $db_user, $db_password) or die("Could not connect.");

        mysql_select_db($db_name) or die("Could not select database.");

        $query = "SELECT i.filename as filename, i.tn_filename as tn_filename, i.filepath as filepath, i.added as add_dt, i.ip as ip, i.filesize as filesize, sum(ih.kb) as bandwidth, count( ih.filename ) as ctr,i.ftpid as ftpid from images i left outer join imagehits ih on i.filename = ih.filename where i.filename = '$filename' group by filename";
        
    $result = mysql_query($query) or die("Query failed.");

    while ($line = mysql_fetch_array($result)) {



                // check for delete

                if (isset($delete)) {

                        if ($delete == "Delete") {

                                // remove image
                                //GET FTP INFO
				if($line[ftpid]>0)
				{
					$query2 = "select * from ftp where ftpid=".$line[ftpid]." limit 1";

					$result2 = mysql_query($query2) or die("Query failed.");

					while ($row = mysql_fetch_array($result2)) 
				    {

					        $ftpid=$row['ftpid'];

					        $path=$row['name'];        

					        $url=$row['dir'];        

					        $host=$row['host'];        

					        $user=$row['user'];        

					        $pass=$row['ftppass'];        
				    }
					if($ftpid>0)
					{
						$ftp =& new FTP();
						if ($ftp->connect($host)) {
							if ($ftp->login($user,$pass)) {
								$ftp->chdir($path);
								$ftp->delete($line[filename]);
								$ftp->delete($line[tn_filename]);
                                $ftp->close();
								
							}
						}
					}

				}
				else
				{
	                // remove image                
	                $file=$server_dir . $line[filename];

	                if ( file_exists ( $file))

	                unlink($file);

	                // remove image thumbnail

	                if ($line[tn_filename] != "") {

	                    $file=$server_dir . $line[tn_filename];

	                 if ( file_exists ( $file))

	                    unlink($file);

	                }
					

				}
	                // remove image from database

	                $query2 = "delete from images where filename = '" . $line[filename] . "'";

	                mysql_query($query2) or die("Could not delete.");

	                $query2 = "delete from imagehits where filename = '" . $line[filename] . "'";

	                mysql_query($query2) or die("Could not delete.");

                        mysql_close($link);
						
						

                        header("Location: images.php?limit=" . $_REQUEST['limit'] . "&sort=" . $_REQUEST['sort'] . "&start=" . $_REQUEST['start'] . "&tn=" . $_REQUEST['tn'] . "&details=" . $_REQUEST['details']);

                        exit;

                } } 

?>

<center>
<h4> <font face="Comic Sans MS" size="4" color="#FF0000">View Image<br />        </font></h4></center><br />

<br />

<table width="80%" align="center" border="0" cellspacing="0" cellpadding="4">

        <tr>
<?
					$band=$line[bandwidth];
					$bandwidthmb =  ($band / 1048576) ;        
					//$bandwidthmb =  ($band / 1024) ;
					$filesizekb =  ($line[filesize] / 1024) ;
?>
                <td align="right"><strong>File Name: &nbsp;</strong></td>

                <td align="left"><?= $line[filename] ?></td>

                <td align="right"><strong>File Size: &nbsp;</strong></td>

                <td align="left"><?= number_format($filesizekb) ?> KB</td>

        </tr>

        <tr>

                <td align="right"><strong>Date/Time Added: &nbsp;</strong></td>

                <td align="left"><?= date("d/m/Y h:i:s A", $line[add_dt]) ?></td>

                <td align="right"><strong>Views: &nbsp;</strong></td>

                <td align="left"><a title="Click to see details about image views" href="referers.php?limit=<?= $_REQUEST['limit'] ?>&sort=<?= $_REQUEST['sort'] ?>&start=<?= $_REQUEST['start'] ?>&tn=<?= $_REQUEST['tn'] ?>&details=<?= $_REQUEST['details'] ?>&filename=<?= $line[filename] ?>"><?= number_format($line[ctr]) ?></a></td>

        </tr>

        <tr>

                <td align="right"><strong>Bandwidth Used: &nbsp;</strong></td>

                <td align="left"><?= number_format($bandwidthmb) ?> MB</td>

        </tr>

        <tr>

                <td align="right"><strong>Uploader IP: &nbsp;</strong></td>

                <td align="left"><?= $line[ip] ?></td>

                <td>&nbsp;</td>

                <td>&nbsp;</td>

        </tr>

</table>

<br />

<div align="center">
<img src="<?= $line[filepath].$line[tn_filename] ?>" alt="<?=$line[tn_filename]?>" border="0"><br />
<br />

<form name="delete" action="<?= $_SERVER['PHP_SELF'] ?>" method="post" style="margin-bottom: 0px;">

<input type="hidden" name="tn" value="<?= $_REQUEST['tn'] ?>">

<input type="hidden" name="limit" value="<?= $_REQUEST['limit'] ?>">

<input type="hidden" name="sort" value="<?= $_REQUEST['sort'] ?>">

<input type="hidden" name="start" value="<?= $_REQUEST['start'] ?>">

<input type="hidden" name="details" value="<?= $_REQUEST['details'] ?>">

<input type="hidden" name="filename" value="<?= $_REQUEST['filename'] ?>">

<input type="submit" name="delete" value="Delete" style="width: 50px;" onClick="return verifyAction('Are you sure you want to delete this image?');">

</form>

</div>

<?
    }
    mysql_free_result($result);
        mysql_close($link);
?>
</div>
<br />
<? require_once("footer.php"); ?>
