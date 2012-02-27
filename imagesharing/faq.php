<? require "header.php"; 
require_once("inc/limits.php"); 
?>


<center>	<h4> <font face="Comic Sans MS" size="4" color="#FF0000">		Frequently Asked Questions.<br />	</font></h4></center>	


<div id="wrapper">
<div  style="width:760px;">
We have compiled this list of questions that our visitors often ask.<br />
<br />
<hr />
<br />
<span style="font-weight: bold;">1. What are the file restrictions for free image hosting?</span><br />
<br />
Files must be under <?= $max_file_size_member_mb ?> MB for members and under <?= $max_file_size_guest_mb ?> MB for guests, they must be of a <?= $valid_mime_types_display ?> and they must not be pictures with adult content or illegal activities.<br />
<br />
<hr />
<br />
<span style="font-weight: bold;">2. Do you allow direct linking to uploaded images?</span><br />
<br />
Yes. When you upload an image, you will be given an actual URL to the actual image file. You may link to the image from any site on the Internet.<br />
<br />
<hr />
<br />
<span style="font-weight: bold;">3. Is there a bandwidth limit for uploaded images?</span><br />
<br />
Yes, there is a limit of <?= $config['BandwidthGuest']?> GB per image for guests and <?= $config['BandwidthMember']?> GB per image for members. Our service is not designed to handle hosting for large (i.e.: high traffic) web sites.<br />
<br />
<hr />
<br />
<span style="font-weight: bold;">4. What types of images can I upload?</span><br />
<br />
You may not upload pictures that contain nudity, sexual content, etc. You also may not upload images that contain illegal content or depict illegal activities. Examples of illegal content would be child pornography, bestiality, etc. If you are not sure about your image, please ask us first. We will remove illegal images or images that contain adult content.<br />
<br />
<hr />
<br />
<span style="font-weight: bold;">5. Is nudity and/or sexual content allowed?</span><br />
<br />
No. Please see the answer to #4.<br />
<br />
<hr />
<br />
<span style="font-weight: bold;">6. Will pictures I upload remain private?</span><br />
<br />
Photos will be public on the gallery unless you set them to "Private" on upload.<br />
<br />
<hr />
<br />
<span style="font-weight: bold;">7. Will my e-mail address remain private?</span><br />
<br />
Yes. We will not share your address with anyone and we will not send e-mail to you other than the one e-mail containing your links to your uploaded image.<br />
</div>
<br />

<?if (($ads == "1" && !$auth_id) || ($ads == "2") ) { ?> <center> <?=$config[footer]?> </center> <br /><br /> <?}?>

</div>
<? require "footer.php"; ?>