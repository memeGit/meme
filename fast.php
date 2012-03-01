<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>

<head>
<script src="http://code.jquery.com/jquery-latest.js" type="text/javascript"></script>
<script src="lib/jquery.bxSlider.js" type="text/javascript"></script>
 <link href="css/bx_styles.css" rel="stylesheet" type="text/css">
</head>
<script type="text/javascript">
var cur_image_numbers = 0;
var cur_image = 0;
var show_image = 0;
document.onkeydown=nextpage;
function click_right()
{
	if( cur_image > cur_image_numbers -5 ){
	xmlhttp=new XMLHttpRequest();
	xmlhttp.open("GET","get_image.php",true);
	
	xmlhttp.onreadystatechange=function()
	{
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
			{
				document.getElementById("image-list").innerHTML +=  make_next_html(xmlhttp.responseText,cur_image_numbers);
				set_undisplay(cur_image-1);
				set_display(cur_image);
			}
	}
		xmlhttp.send(null);
	}
	if( cur_image <= cur_image_numbers-1 )
	{
		set_undisplay(cur_image);
		cur_image++;
		set_display(cur_image);
	}
	return false;
}
function click_left()
{
	if( cur_image == 0 )
	{
		set_undisplay(0);
		cur_image = cur_image_numbers-1;
		click_right();
		return false;
	}
	set_undisplay(cur_image);
	cur_image--;
	set_display(cur_image);
}
function make_next_html(image_url,image_title)
{

	var images = eval({"images":[{"idx":"2","filename":"698C360_2012_02_28_12_26_.jpg","tn_filename":"698C360_2012_02_28_12_26__tn.jpg","filepath":"http:\/\/localhost\/weibo\/imagesharing\/images\/","add_dt":"1330431087","ip":"127.0.0.1","filesize":"503422","bandwidth":null,"ctr":"0"},{"idx":"1","filename":"143_.png","tn_filename":"143__tn.jpg","filepath":"http:\/\/localhost\/weibo\/imagesharing\/images\/","add_dt":"1330355566","ip":"127.0.0.1","filesize":"67449","bandwidth":"69796","ctr":"4"}]});
	var images = eval('('+image_url+	')');
	var re_url = "";
	var i = 0;

	for( i = 0 ; i < images.images.length; i++){
	
		re_url += "<div id =\"container_"+cur_image_numbers+"\" class = \"post_container\"  style=\"display:none;\">";
		re_url += "<div class=\"_social\"> </div>";
		re_url += "<div class=\"wrapper\">";
		re_url += "<h2>"+images.images[i].filename+"</h2>";
		
		var i_ul = images.images[i].filepath+"/"+images.images[i].filename;
		
		re_url += "<img src = \""+i_ul+"\" onclick=\"click_right()\"/>";
		re_url += "</div>";
		
		
		
		re_url += "<div class=\"right-comment\">";
		re_url += "<div id=\"ad_content\">";
		re_url += "<div>";
		re_url += "<img src=\"image/IMAG0003.jpg\" width=\"300px\" height=\"250px\"/>";
		re_url += "</div>";
		re_url += "</div>";
		
		re_url += "<div>";
		re_url += "<p>This is where the comments lies<p>";
		re_url += "</div>";
		re_url += "</div>";
		
		re_url +="</div>";
	//	alert(re_url);
		cur_image_numbers++;
	}
		return re_url;
}
function set_display(id)
{
	var img = document.getElementById("container_"+id);
	if(img)
	{		
		img.style.display="";
		
	}else{
	}
	return false;
}
function set_undisplay(id)
{	
	var ids = "container_"+id;
	var img = document.getElementById(ids);
	if(img)
	{
		img.style.display="none";
		
	}else{
		
	}
	return false;
}

function nextpage(event)   
{
    event = event ? event : (window.event ? window.event : null);
    if (event.keyCode==37)
	{
		click_left();
	}else if (event.keyCode==39)
	{
		click_right();
	}
}   

</script>
<body   onload="click_right()">

<div id = "logo" >
<a href="http://prenoon.com"></a>
</div>
<?php
// TODO 返回常规模式的代码
?>


<div><a id="close" href="javascript:void(0);" style="text-decoration: none;">× 常规模式</a></div>
<div id="block-content">
<div class="page" id="image-list">
</div>
</div>
<div class="left">
<a class="bx-prev"  onclick="click_left()"></a>
</div>
<div class="right">
<a class="bx-next"   onclick="click_right()"> </a>
</div>
<div class="hint">提示：用键盘-> 和 <- 查看图片</div>
</body>


</html>
