<? require "header.php"; ?>
<div id="wrapper">
<br />
<center>	<h4> <font face="Comic Sans MS" size="4" color="#FF0000">Terms Of Service.<br />	</font></h4>	</center>
<br />
<br />

<div  style="width:760px;">
<?= $site_name ?> reserves the right to remove images from our server if they are found to be illegal, introduce security issues, use too much bandwidth, or for any other reason as we see fit. This service is provided free of charge and is not expected to be used to host images for large-scale web sites. Files consuming too much bandwidth on a regular basis will be removed.<br />
<br />
We do not allow uploading of adult content. This would include pictures containing nudity and sexual situations. We also do not allow pictures that depict illegal activities or subjects. Those who upload illegal files will be blocked (by IP address) from using our service. Legal authorities may be contacted if the subject of the file is found to be illegal.<br />
<br />
<?= $site_name ?> retains no copyright to photos on this site. All uploaded files are copyright by their respective owners.<br />
<br />
Images uploaded to <?= $site_name ?> are public on the gallery by default unless you chose to make them private. When you upload a file, you will be given link to view the file and they will be available to the public via the gallery if you choose to make them public.<br />
<br />
<?= $site_name ?> may modify this policy at any time and without warning or prior notice.<br />

<br />

<?if (($ads == "1" && !$auth_id) || ($ads == "2") ) { ?> <center> <?=$config[footer]?> </center> <br /><br /> <?}?>

</div></div>
<br style="clear:both;" />
<? require "footer.php"; ?>