<?php 
require_once("header.php"); 
require_once ("../inc/ftp.class.php");

if($auth_gid!="1")
{
	header("Location: logout.php");	exit;
}

	$days = check_input($_POST['days']);

	$button = $_POST['button'];



	if ($days != "") {

		$link = mysql_connect($db_server, $db_user, $db_password) or die("Could not connect");

		mysql_select_db($db_name) or die("Could not select database");



		// find images added before date selected with zero hits

		$result = mysql_query("SELECT i.filename as filename, i.filepath as filepath, i.tn_filename as tn_filename, i.ftpid as ftpid FROM images i LEFT OUTER JOIN imagehits ih ON i.filename = ih.filename WHERE FROM_UNIXTIME(i.added, '%Y-%m-%d') <= date_add(now(),  interval -" . $days . " day) GROUP BY i.filename HAVING count( ih.filename ) = 0") or die("Query failed");
		
		$ct1 = mysql_num_rows($result);


		if ($button=="Delete Images" && $_POST['del1']=="del1") {

			while ($line = mysql_fetch_array($result)) 
			{
				if($line[ftpid]>0)
				{
					$query = "select * from ftp where ftpid=".$line[ftpid]." limit 1";
					$result2 = mysql_query($query) or die("Query failed.");
					while ($row = mysql_fetch_array($result2)) 
					{
						$ftpid=$row['ftpid'];
						$path=$row['name'];        
						$url=$row['dir'];        
						$host=$row['host'];        
						$user=$row['user'];        
						$pass=$row['ftppass'];        
					}

					$ftp =& new FTP();
					if ($ftp->connect($host)) 
					{
						if ($ftp->login($user,$pass)) 
						{
							$ftp->chdir($path);
							$ftp->delete($line[filename]);
							$ftp->delete($line[tn_filename]);
						}
						$ftp->close();			
					}
				}
				else
				{
					// remove image
					unlink($server_dir . $line['filename']);
					// remove image thumbnail
					if ($line['tn_filename'] != "") {
						unlink($server_dir . $line['tn_filename']);
	    			}
				}
				// remove image from database

				$queryX = "delete from images where filename = '" . $line['filename'] . "'";

				mysql_query($queryX) or die("Could not delete.");

	                $queryX = "delete from imagehits where filename = '" . $line[filename] . "'";

	                mysql_query($queryX) or die("Could not delete.");			}

		}



		mysql_free_result($result);



		// find images added before date selected with last hit before date selected

		$result = mysql_query("SELECT ih.filename as filename, i.filepath as filepath, i.tn_filename as tn_filename FROM imagehits ih LEFT OUTER JOIN images i ON i.filename = ih.filename where ih.filename not like 'tn_%' and i.filepath is not null and i.tn_filename is not null group by ih.filename having max(FROM_UNIXTIME(ih.timestamp, '%Y-%m-%d')) < date_add(now(),  interval -" . $days . " day)") or die("Query failed");

		$ct2 = mysql_num_rows($result);



		if ($button == "Delete Images" && $_POST['del2']=="del2") {

			while ($line = mysql_fetch_array($result)) {

				// remove image
				if(file_exists($server_dir . $line['filename']))		
				{
				unlink($server_dir . $line['filename']);
				}
				// remove image from database

				$queryX = "delete from images where filename = '" . $line['filename'] . "'";

				mysql_query($queryX) or die("Could not delete.");
				
				$query2 = "delete from imagehits where filename = '" . $line[filename] . "'";

	            mysql_query($query2) or die("Could not delete.");

				// remove image thumbnail

				if ($line['tn_filename'] != "") {
						if(file_exists($server_dir . $line['tn_filename']))		
				{
					unlink($server_dir . $line['tn_filename']);
					}

    			}

			}

		}



		mysql_free_result($result);



		mysql_close($link);

	}

?>
<div style="width:760px;">
<center>
<h4> <font face="Comic Sans MS" size="4" color="#FF0000">Photo Cleaner<br />	</font></h4></center>
<br />

<hr>

<br />

<? if ($days == "" || $button == "Cancel") { ?>

Many images will be uploaded and then never accessed again. Deleting images that have not been viewed can reduce the amount of disk space used.<br />

<br />

<form name="delete" action="cleaner.php" method="post" style="margin-top: 0px; margin-bottom: 0px;">

Images not viewed in the last <input type="text" name="days" size="3" maxlength="3" /> days will be deleted.<br />

<br />

Pressing 'Continue' will show a total count of images that can be deleted. You must confirm the deletion on the next page.<br />

<br />

<input type="submit" name="button" value="Continue"><br />

</form>

<? } else if ($button != "Delete Images") { ?>

<form name="delete" action="cleaner.php" method="post" style="margin-top: 0px; margin-bottom: 0px;">

There are <?= $ct1 ?> images older then <?= $days ?> days with zero hits. <input type="checkbox" name="del1" value="del1"><br />

<br />

There are <?= $ct2 ?> images older then <?= $days ?> days where the last hit was before <?= $days ?> ago. <input type="checkbox" name="del2" value="del2"><br />

<br />

<input type="hidden" name="days" value="<?= $days ?>">

<input type="submit" name="button" value="Delete Images" onClick="return verifyAction('Are you sure you want to delete these images?');">&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" name="button" value="Cancel"><br />

</form>

<? } else { ?>

The images have been removed from the system. This includes file removal and database removal.<br />

<br />

Image statistics for these images have been left in the database.<br />

<? } ?>
</div>
</div>
<br />

<? require_once("footer.php"); ?>