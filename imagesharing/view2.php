<? require "header.php"; 
     $file = check_input($_GET['filename']);
     $view = check_input($_GET['view']);
        if ($file == "") {
                header("Location: " . $server_url);
                exit;
        }
        $t1=mktime(0,0,0,date("m"),date("d"),date("y"));
        $t2=($t1+24*60*50)-1;
        
        $currentip = $_SERVER['REMOTE_ADDR'];
        
        $query1 = "select * from images where filename='$file'";        
        $result1 = mysql_query($query1) or die("Query failed1.");
				if(mysql_num_rows($result1) ==0) { ?>
		<div id="error"><div class="msg" id="sucmsgid"> <?
	echo "We don't have a photo with that name!"; ?>
	</div></div>
		<META HTTP-EQUIV="refresh" CONTENT="3;URL=gallery.php">
	<?
	}

		while ($row = mysql_fetch_array($result1))
		{
		$uploaderid=$row['userid'];
		$filesize1=$row['filesize'];
        $file_path=$row['filepath'];
		$date_added=date("jS F Y", $row[added]);

       }
	   
	   
	   if($filesize1=="" or $file_path=="")
	   {
			$err = "Image Not found";

			$query2 = "select filesize,filepath,filename,tn_filename from images order by rand() limit 1";        
			$result2 = mysql_query($query2) or die("Query failed2.");

			
	        while ($line1 = mysql_fetch_array($result2)) {         
	        $filesize1=$line1[filesize];
	        $file_path=$line1[filepath];
			}
	   }
        
        $query3 = "select count(*) as total from imagehits where filename='$file'";        
        $result3 = mysql_query($query3) or die("Query failed3.");
        while ($line2 = mysql_fetch_array($result3)) {         
        $view1=$line2[total];
        }
        
        
	$referer = $_SERVER['HTTP_REFERER'];
 /*       if($view1>0)
        $kb=$view1*$filesize1;
        else
        $kb=$filesize1;
		$timestamp=time();
        $sql="insert into imagehits set referer='".$referer."', kb=$kb, filename='".$file."',ip='".$currentip."',timestamp='".$timestamp."'";
        mysql_query($sql) or die("Query failed3.");
*/

		$timestamp=time();
        $sql="insert into imagehits set referer='".$referer."', kb=$filesize1, filename='".$file."',ip='".$currentip."',timestamp='".$timestamp."'";
        mysql_query($sql) or die("Query failed3.");


?>
<div id="wrapper">

	<center>
		<h2>This photo is hosted for FREE on "<?=$config[SiteName]?>"</h2>  
		<?
				if($err!="")
				{
					echo '<br /><br /><br /><h2>The requested image does not exist!<br/>
					or it was removed for violating terms or using excessive bandwidth</h2>'; ?> 
					
					<META HTTP-EQUIV="Refresh"
      CONTENT="5; URL=gallery.php">
	  <? 
				}  else {
		?>		
	</center>
	<br /><br />
	
		<div style="float:left;width:200px;">
			<?$query4 = "select i.filename as filename, i.tn_filename as tn_filename, i.filepath as filepath, i.added as add_dt, i.ip as ip, i.filesize as filesize, sum(ih.kb) as bandwidth, count( ih.filename ) as ctr from images i left outer join imagehits ih on i.filename = ih.filename where i.prv='0' group by filename order by rand() limit 7";
				$result4 = mysql_query($query4) or die("Query failed4."); while ($line = mysql_fetch_array($result4)) { ?>
			<a href="view.php?filename=<?=$line[filename]?>">
				<img src="<?=$line[filepath].$line[tn_filename]?>" alt="<?=$line[filename]?>" title="<?=$line[filename]?>" border="0" style="max-width:200px" />
			</a>
			<br /><br />
			<?}?>
		</div>





<div style="float:left;width:530px;padding-left:15px;text-align:center;">
			<b>This photo was uploaded <?= $date_added ?> and has been viewed <?=$view1?> times since then.</b><br /><br />

			<a href="<?= $file_path.$file ?>">

					<img id="photo" src="<?= $file_path.$file ?>" alt="<?=$file?>" title="<?=$file?>" border="0" style="max-width:500px" />

					</a><br /><br /><br />
<div id="error" style="display:none;"><div class="msg" id="sucmsgid"></div><div class="error" id="msgid"></div></div>





<?if($auth_gid=="1" || $auth_gid=="2") { ?>

<form name="delete" action="<?= $_SERVER['PHP_SELF'] ?>" method="post" style="margin-top: 0px; margin-bottom: 0px;" onSubmit="return s_delete1image();">

<input type="hidden" name="d_filename" id="d_filename" value="<?=$file?>" >

<input name="delete" value="Delete" type="submit" >

</form>
 <?} else {?>
<form name="config" action="<?= $_SERVER['PHP_SELF'] ?>" method="post" style="margin-top: 0px; margin-bottom: 0px;" onSubmit="return reportimage();">
<input type="hidden" name="reporterid" id="reporterid" value="<?=$auth_id?>" >
<input type="hidden" name="uploaderid" id="uploaderid" value="<?=$uploaderid?>" >
<input type="hidden" name="timestamp" id="timestamp" value="<?=$timestamp?>" >
<input type="hidden" name="imagename" id="imagename" value="<?=$file?>" >
<input type="hidden" name="ip" id="ip" value="<?=$currentip?>" >
<input name="report" value="Report" type="submit" >

</form>
 <? } ?>
<br />
<br />
<? 
        $query5 = "select * from images where filename='$file'";        
        $result5 = mysql_query($query5) or die("Query failed5.");

while ($row = mysql_fetch_assoc($result5)) {

        $file_path=$row['filepath'];
		$file_name=$row['filename'];
		$file_tn=$row['tn_filename'];
		$file_link=$file_path.$file_name;
		$tn_link=$file_path.$file_tn;
}

?><center>
<strong>Link for viewing the photo </strong><br><div align="center"><textarea style="width: 100%;" name="url1[]" cols="" wrap="virtual" READONLY onfocus="javascript: this.select()"><?echo $server_url;?>/view.php?filename=<?echo $file_name;?></textarea></div><br>
<? if ($HotLink==1){ ?>
<strong>Link directly to your photo</strong><br><div align="center"><textarea style="width: 100%;" name="url2[]" cols="" wrap="virtual" READONLY onfocus="javascript: this.select()"><?echo $file_link;?></textarea></div><br>
<? } ?>
<strong>Link directly to photo thumbnail</strong><br><div align="center"><textarea style="width: 100%;" name="url3[]" cols="" wrap="virtual" READONLY onfocus="javascript: this.select()"><?echo $tn_link;?></textarea></div><br>

<strong>Code to post the photo in a forum:</strong><br><div align="center"><textarea style="width: 100%;" name="url4[]" cols="" wrap="virtual" READONLY onfocus="javascript: this.select()">[URL=<?echo $server_url;?>/view.php?filename=<?echo $file_name;?>][img]<?echo $file_link;?>[/img][/URL]</textarea></div><br>

<strong>Code to post the thumbnail in a forum:</strong><br><div align="center"><textarea style="width: 100%;" name="url5[]" cols="" wrap="virtual" READONLY onfocus="javascript: this.select()">[URL=<?echo $server_url;?>/view.php?filename=<?echo $file_name;?>][img]<?echo $tn_link;?>[/img][/URL]</textarea></div><br>

<strong>Code to post photo in your website:</strong><br><div align="center"><textarea style="width: 100%;" name="url6[]" cols="" wrap="virtual" READONLY onfocus="javascript: this.select()"><a href="<?echo $server_url;?>/view.php?filename=<?echo $file_name;?>" target="_blank"><img src="<?echo $file_link;?>" alt="FREE photo hosting by <?=$config[SiteName]?>"></a></textarea></div><br></center>


</div><br style="clear:both;" />
						    <br /><br /><br /><center><?=$config[footer]?></center><br /><br />
<? }?>
</div> 
<br /> 
<? require "footer.php"; ?>