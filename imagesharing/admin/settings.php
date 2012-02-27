<? require_once("header.php"); 

if($auth_gid!="1")
{
	header("Location: logout.php");	exit;
}

        $link = mysql_connect($db_server, $db_user, $db_password) or die("Could not connect");

        mysql_select_db($db_name) or die("Could not select database");

	if($_POST['submit']){
	$config = $_POST['config'];
                while(list($k,$v)=each($config))
                {
$k=check_input($k);
$v=check_input($v);				
					$sql="UPDATE config SET svalue='".$v."' where soption='".$k."'";										
					mysql_query($sql)or die("Query failed");
                }
	}
        
        $query = "SELECT * from config";
    $result = mysql_query($query) or die("Query failed");
        while ($row = mysql_fetch_assoc($result)) { 
                                
                        $config[$row['soption']]=$row['svalue'];
                        
        }
        

?>
<div style="width:760px;">
<center>
<h4> <font face="Comic Sans MS" size="4" color="#FF0000">Site Settings<br />        </font></h4></center>
<br />

<hr />

<br />

<div style="height:470px;" align="center">

<form name="config" action="<?= $_SERVER['PHP_SELF'] ?>" method="post" style="margin-top: 0px; margin-bottom: 0px;">

<div class="config-width">
        <div class="config1">Site Name :</div>
        <div class="config2">
                <input type="text" name="config[SiteName]" size="50"value="<?=$config[SiteName]?>" >&nbsp; <a title="Site name to use on the header and emails." href="###">What's this?</a></div>
</div>
<div class="config-width">
        <div class="config1">Meta Description :</div>
        <div class="config2"><input type="text"size="50" name="config[MetaDesc]" value="<?=$config[MetaDesc]?>" >&nbsp; <a title="Meta description tag." href="###">What's this?</a></div> 
</div>

<div class="config-width">
        <div class="config1">Meta Keywords :</div>
        <div class="config2"><input type="text"size="50" name="config[MetaWords]" value="<?=$config[MetaWords]?>" >&nbsp; <a title="Meta keywords tag separated by commas." href="###">What's this?</a></div> 
</div>

<div class="config-width">
        <div class="config1">Site Url :</div>
        <div class="config2"><input type="text"size="50" name="config[SiteUrl]" value="<?=$config[SiteUrl]?>" >&nbsp; <a title="Link to the site WITHOUT the ending slash /" href="###">What's this?</a></div>
</div>
<div class="config-width">
        <div class="config1">Site Root :</div>
        <div class="config2"><input type="text"size="50" name="config[SiteRoot]" value="<?=$config[SiteRoot]?>" >&nbsp; <a title="Local path to the script folder WITHOUT the ending slash /" href="###">What's this?</a></div>
</div>
<div class="config-width">
        <div class="config1">Allowed Extensions :</div>
        <div class="config2"><input type="text"size="30" name="config[Extension]" value="<?=$config[Extension]?>" >&nbsp; <a title="Filetypes that users can upload. Currently gif,jpg,jpeg,png only supported." href="###">What's this?</a></div>
</div>
<div class="config-width">
        <div class="config1">Max File Size [Guest] :</div>
<div class="config2"><input type="text"size="30" name="config[FileSizeGuest]" value="<?=$config[FileSizeGuest]?>" >&nbsp; <a title="Max file size that guest can upload in MB" href="###">What's this?</a></div>
</div>
<div class="config-width">
        <div class="config1">Max File Size [Member] :</div>
<div class="config2"><input type="text"size="30" name="config[FileSizeMember]" value="<?=$config[FileSizeMember]?>" >&nbsp; <a title="Max file size that member can upload in MB" href="###">What's this?</a></div>
</div>
<div class="config-width">
        <div class="config1">Bandwidth [Guest]:</div>
        <div class="config2"><input type="text"size="30" name="config[BandwidthGuest]" value="<?=$config[BandwidthGuest]?>" >&nbsp; <a title="Max bandwidth that single photo uploaded by guest can use in GB" href="###">What's this?</a></div>
</div>
<div class="config-width">
        <div class="config1">Bandwidth [Member]:</div>
        <div class="config2"><input type="text"size="30" name="config[BandwidthMember]" value="<?=$config[BandwidthMember]?>" >&nbsp; <a title="Max bandwidth that single photo uploaded by member can use in GB" href="###">What's this?</a></div>
</div>
<div class="config-width">
        <div class="config1">Thumbnail Max Width :</div>
        <div class="config2"><input type="text" size="30"name="config[ThumbWidth]" value="<?=$config[ThumbWidth]?>" >&nbsp; <a title="Maximum width for thumbnail in pixels. 150 recommended." href="###">What's this?</a></div>
</div>
<div class="config-width">
        <div class="config1">Thumbnail Max Height :</div>
        <div class="config2"><input type="text" size="30" name="config[ThumbHeight]" value="<?=$config[ThumbHeight]?>" >&nbsp; <a title="Maximum height for thumbnail in pixels. 150 recommended." href="###">What's this?</a></div>
</div>

<div class="config-width">
        <div class="config1">Gallery Photo No. :</div>
        <div class="config2"><input type="text" name="config[GalleryPhotoNo]" value="<?=$config[GalleryPhotoNo]?>" size="30"  >&nbsp; <a title="Max number of photos that users can browse from the gallery." href="###">What's this?</a></div>
</div>
<div class="config-width">
        <div class="config1">Gallery Photo Per Page :</div>
        <div class="config2"><input type="text" name="config[GalleryPhotoPerPage]" value="<?=$config[GalleryPhotoPerPage]?>" size="30"  >&nbsp; <a title="Max number of photos that can be shown in gallery per page." href="###">What's this?</a></div>
</div>


<div class="config-width">
        <div class="config1">Accept Terms :</div>
        <div class="config2"><select name="config[AcceptTerms]"><option value="1" <?php if ($config[AcceptTerms]=="1") {echo "selected";}?> >Enabled</option><option value="0" <?if ($config[AcceptTerms]=="0") echo "selected";?>>Disabled</option></select>&nbsp; <a title="When enabled, users will be forced to accept site terms on every upload." href="###">What's this?</a></div>
</div>


<div class="config-width">
        <div class="config1">Allow Uploads :</div>
        <div class="config2"><select name="config[Uploads]"><option value="2" <?php if ($config[Uploads]=="2"){ echo "selected";}?> >Enabled For All</option><option value="1" <?php if ($config[Uploads]=="1"){ echo "selected";}?> >Disabled For Guests</option><option value="0" <?if ($config[Uploads]=="0") echo "selected";?>>Disabled For All</option></select>&nbsp; <a title="Affects All uploads for guests and members." href="###">What's this?</a></div>
</div>

<div class="config-width">
        <div class="config1">Guest Link Upload :</div>
        <div class="config2"><select name="config[GuestUpload]"><option value="1" <?php if ($config[GuestUpload]=="1") {echo "selected";}?> >Enabled</option><option value="0" <?if ($config[GuestUpload]=="0") echo "selected";?>>Disabled</option></select>&nbsp; <a title="Enable / Disable guests to upload images from links." href="###">What's this?</a></div>
</div>
<div class="config-width">
        <div class="config1">Member Link Upload :</div>
        <div class="config2"><select name="config[MemberUpload]"><option value="1" <?php if ($config[MemberUpload]=="1"){ echo "selected";}?> >Enabled</option><option value="0" <?if ($config[MemberUpload]=="0") echo "selected";?>>Disabled</option></select>&nbsp; <a title="Enable / Disable members to upload images from links." href="###">What's this?</a></div>
</div>



<div class="config-width">
        <div class="config1">Allow Registration :</div>
        <div class="config2"><select name="config[MemberRegistration]"><option value="1" <?php if ($config[MemberRegistration]=="1"){ echo "selected";}?> >Enabled</option><option value="0" <?if ($config[MemberRegistration]=="0") echo "selected";?>>Disabled</option></select>&nbsp; <a title="Enable / Disable new member registrations." href="###">What's this?</a></div>
</div>

<div class="config-width">
        <div class="config1">Validate user email :</div>
        <div class="config2"><select name="config[EmailValidation]"><option value="1" <?php if ($config[EmailValidation]=="1"){ echo "selected";}?> >Enabled</option><option value="0" <?if ($config[EmailValidation]=="0") echo "selected";?>>Disabled</option></select>&nbsp; <a title="When enabled, new members will be forced to verify their email for account activation." href="###">What's this?</a></div>
</div>

<div class="config-width">
        <div class="config1">Advertisements :</div>
        <div class="config2"><select name="config[Advertisements]"><option value="2" <?php if ($config[Advertisements]=="2"){ echo "selected";}?> >Enabled For All</option><option value="1" <?php if ($config[Advertisements]=="1"){ echo "selected";}?> >Disabled For Members</option><option value="0" <?if ($config[Advertisements]=="0") echo "selected";?>>Disabled For All</option></select>&nbsp; <a title="Enable / Disable advertisements for guests or members." href="###">What's this?</a></div>
</div>


<div class="config-width">
        <div class="config1">Image Hotlinking :</div>
        <div class="config2"><select name="config[Hotlinking]"><option value="1" <?php if ($config[Hotlinking]=="1") {echo "selected";}?> >Enabled</option><option value="0" <?if ($config[Hotlinking]=="0") echo "selected";?>>Disabled</option></select>&nbsp; <a title="When enabled, users will be able to get direct links to images with the full size." href="###">What's this?</a></div>
</div>

<div class="config-width">
        <div class="config1">&nbsp;</div>
        <div class="config2">&nbsp;</div>
</div>        
<div class="config-width">
        <div class="config1">&nbsp;</div>
        <div class="config2"><input type="submit" name="submit" value="Update" style="font-size: large;"></div>
</div>        

</form>
<br /><br /><br /><br />
</div>

<?

    mysql_free_result($result);

        mysql_close($link);

?>
</div>
</div>
<br /><br /><br />

<? require_once("footer.php"); ?>
