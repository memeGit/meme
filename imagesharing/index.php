<? require "header.php";?>

 <div id="showform">
    <div id="wrapper">    
        
        <p>
                <font color="#CC0000"><b><?=$config[SiteName]?></b></font> is a great free photo hosting for your daily online surfing. You will have several types of links to the photo that you have stored with us including a direct link which makes it suitable to publish the photo anywhere while the links can be also used in websites, blogs and any content management system. You don't even have to register to be able to upload but registration gives you the benifit of tracking your photos and know how many views did it get and where those views are coming from and the best thing is that it's all
        <font color="#CC0000"><b>FREE</b></font>!
                </p>        
        
<div class="featured"><br />

<? 
$queryx = "select i.filename as filename, i.tn_filename as tn_filename, i.filepath as filepath, i.added as add_dt, i.ip as ip, i.filesize as filesize, sum(ih.kb) as bandwidth, count( ih.filename ) as ctr from images i left outer join imagehits ih on i.filename = ih.filename where i.prv='0' group by filename order by rand() limit 1";
				$resultx = mysql_query($queryx) or die("Query failedx."); while ($line = mysql_fetch_array($resultx)) { ?>
			<a href="view.php?filename=<?=$line[filename]?>">
				<img src="<?=$line[filepath].$line[tn_filename]?>" alt="<?=$line[filename]?>" title="<?=$line[filename]?>" class="featured" border="0" />
			</a>
			
			<?}?>
</div>

<div id="right"> 

<? if ($uploads == 0) {

echo "<center><b><br><br><br>Uploads are temporarily disabled by the site admin</center></b>";
}

else if ($uploads == 1 && !$auth_id) {

echo "<center><b><br><br><br>You have to <a href=\"register.php\" title=\"Register\">Register</a> before you will be able to upload photos.</center></b>";
}

else { ?>
   
    <p class="title"><input type="radio" id="url1" name="url" value="1" checked="checked" onClick="return uploadfile('url1');" />From PC&nbsp;&nbsp;
    <?if($auth_id>0 && $config[MemberUpload]=="1"){?><input type="radio" id="url2" name="url" value="2"  onClick="return uploadfile('url2');" />From Link<br />
    <?}if(!$auth_id && $config[GuestUpload]=="1"){?>
    <input type="radio" id="url2" name="url" value="2" onClick="return uploadfile('url2');" />From Link<br />
    <?}?>
    </p><br />
	
    <div id="showfl">
    <form name="newupload" id="newupload" method="post"  target="formsubmit1" action="inc/uploader.php" enctype="multipart/form-data" onSubmit="return show_loading();">
    <input type="hidden" id="countfld" value="" />    
     <div id="loading" ></div>
     <?php /* <div id="loading" name="loading"></div> */ ?>
        <iframe name="formsubmit1" width="500" height="100" id="formsubmit1"></iframe>
        <div style="display:block;" id="f0"><input type="file" class="input2" size="50" name="thefile0" /><br /></div>
        <div style="display:none;" id="f1"><input type="file" class="input2" size="50" name="thefile1" /><br /></div>
        <div style="display:none;" id="f2"><input type="file" class="input2" size="50" name="thefile2" /><br /></div>
        <div style="display:none;" id="f3"><input type="file" class="input2" size="50" name="thefile3" /><br /></div>
        <div style="display:none;" id="f4"><input type="file" class="input2" size="50" name="thefile4" /><br /></div>
        <div style="display:none;" id="f5"><input type="file" class="input2" size="50" name="thefile5" /><br /></div>
        <div style="display:none;" id="f6"><input type="file" class="input2" size="50" name="thefile6" /><br /></div>
        <div style="display:none;" id="f7"><input type="file" class="input2" size="50" name="thefile7" /><br /></div>
        <div style="display:none;" id="f8"><input type="file" class="input2" size="50" name="thefile8" /><br /></div>
        <div style="display:none;" id="f9"><input type="file" class="input2" size="50" name="thefile9" /><br /></div>
        <div style="display:none;" id="f10"><input type="file" class="input2" size="50" name="thefile10" /><br /></div>
        <div style="display:none;" id="f11"><input type="file" class="input2" size="50" name="thefile11" /><br /></div>
        <div style="display:none;" id="f12"><input type="file" class="input2" size="50" name="thefile12" /><br /></div>
        <div style="display:none;" id="f13"><input type="file" class="input2" size="50" name="thefile13" /><br /></div>
        <div style="display:none;" id="f14"><input type="file" class="input2" size="50" name="thefile14" /><br /></div>

        <br />
        <p><font color="#CC0000">Maximum File Size</font>: <span class="body"><?= $max_file_size_mb ?> MB</span></p>
    <br />
    <p><font color="#CC0000">Allowed File Types</font>: <span class="body"><?= $valid_mime_types_display ?></span></p>
        <br> <? if ($config[AcceptTerms]=="1"){  ?>
        <p><font color="#CC0000">Terms of Service</font>: <span class="body"><input type="checkbox" name="tos" value="agree"> I agree to the <a href="terms.php" class="toplinks">Terms Of Service</a></span></p>
        <br><? } ?>
        <p><font color="#CC0000">Private</font>: <span class="body"><input type="checkbox" name="prv" value="1" />   If selected, photo will not show up in the public gallery. </span></p>
    <br />
    <div class="buttons">
        <a href="javascript:void(0);"  onClick="return showfile();"><img src="i/+.jpg" alt="+" class="+" title="Add more uploading slots" /></a>&nbsp; <input id="submit1" name="submit" value="Upload" type="image" src="i/upload.jpg" title="Upload selected photos" alt="upload" />
    </div>
    </form>
    
    </div>
    <div id="showurl">
        <form name="newupload" id="newupload1" method="post" target="formsubmit" action="inc/uploaderurl.php" enctype="multipart/form-data" onSubmit="return show_loading1();">
        <input type="hidden" id="countfldu" value="" />        
         <?php /* <div id="loading1" name="loading"></div> */ ?>
         <div id="loading1"></div>
        <iframe name="formsubmit" width="500" height="100" id="formsubmit"></iframe>
        <div style="display:block;" id="u0"><b>URL :</b><input type="text" class="input2" size="50" name="thefile0" /><br /></div>
        <div style="display:none;" id="u1"><input type="text" class="input2" size="50" name="thefile1" /><br /></div>
        <div style="display:none;" id="u2"><input type="text" class="input2" size="50" name="thefile2" /><br /></div>
        <div style="display:none;" id="u3"><input type="text" class="input2" size="50" name="thefile3" /><br /></div>
        <div style="display:none;" id="u4"><input type="text" class="input2" size="50" name="thefile4" /><br /></div>
        <div style="display:none;" id="u5"><input type="text" class="input2" size="50" name="thefile5" /><br /></div>
        <div style="display:none;" id="u6"><input type="text" class="input2" size="50" name="thefile6" /><br /></div>
        <div style="display:none;" id="u7"><input type="text" class="input2" size="50" name="thefile7" /><br /></div>
        <div style="display:none;" id="u8"><input type="text" class="input2" size="50" name="thefile8" /><br /></div>
        <div style="display:none;" id="u9"><input type="text" class="input2" size="50" name="thefile9" /><br /></div>
        <div style="display:none;" id="u10"><input type="text" class="input2" size="50" name="thefile10" /><br /></div>
        <div style="display:none;" id="u11"><input type="text" class="input2" size="50" name="thefile11" /><br /></div>
        <div style="display:none;" id="u12"><input type="text" class="input2" size="50" name="thefile12" /><br /></div>
        <div style="display:none;" id="u13"><input type="text" class="input2" size="50" name="thefile13" /><br /></div>
        <div style="display:none;" id="u14"><input type="text" class="input2" size="50" name="thefile14" /><br /></div>

        <br />
        <p><font color="#CC0000">Maximum File Size</font>: <span class="body"><?= $max_file_size_mb ?> MB</span></p>
    <br />
    <p><font color="#CC0000">Allowed File Types</font>: <span class="body"><?= $valid_mime_types_display ?></span></p>
        <br> <? if ($config[AcceptTerms]=="1"){  ?>
        <p><font color="#CC0000">Terms of Service</font>: <span class="body"><input type="checkbox" name="tos" value="agree"> I agree to the <a href="terms.php" class="toplinks">Terms Of Service</a></span></p>
        <br><? } ?>
        <p><font color="#CC0000">Private</font>: <span class="body"><input type="checkbox" name="prv" value="1" /> </span></p>
    <br />
    <div class="buttons">
        <a href="javascript:void(0);"  onClick="return showfileu();"><img src="i/+.jpg" alt="+" class="+" /></a>&nbsp; <input id="submit" name="submit" value="Upload" type="image" src="i/upload.jpg" alt="upload" />
    </div>
    </form>
       </div>

<?}?>

   
    
</div>
    <p class="float"></p>
</div>

<?if (($ads == "1" && !$auth_id) || ($ads == "2") ) { ?> <center><br /><br /><br /> <?=$config[footer]?> </center> <br /><br /> <?}?>
          
  
</div>
<div id="showoutput">
</div>
<? require "footer.php"; ?>
