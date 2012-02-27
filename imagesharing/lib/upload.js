var cp = new cpaint();
cp.set_transfer_mode('get');
cp.set_response_type('xml');
cp.set_debug(0);

function uploaderror(msg)
{
	alert(msg);
}
function showfile()
{
    var countfld=1;
    countfld=document.getElementById("countfld").value+countfld;
    fld=countfld.length;
    if(fld>14)
    {
    alert("Sorry, i can upload  max 15 files at once.");    
    return false;
    }
    else
    {
        document.getElementById("f"+fld).style.display="block";
        document.getElementById("countfld").value=countfld;
    }
    
   var file=document.getElementById("f"+fld).value;
   if(file=="")
   {
        msg="Please fill this field.";
        alert(msg);        
        document.getElementById("f"+fld).focus();
        return false;
    }    
}
function showfileux()
{
    var countfld=1;
    countfld=document.getElementById("countfldu").value+countfld;
    fld=countfld.length;
    if(fld>14)
    {
    alert("Sorry, i can upload  max 15 files at once.");    
    return false;
    }
    else
    {
        document.getElementById("u"+fld).style.display="block";
        document.getElementById("countfldu").value=countfld;
    }    
}

function showfileu()
{
    var countfld=1;
    countfld=document.getElementById("countfldu").value+countfld;
    fld=countfld.length;
	fldx=fld-1;
	fldxx=fld.value;
	if(fldxx=="")
{
msg="Email Address cannot be left empty.";
alert(msg);
document.getElementById("u"+fldxx).select();
  document.getElementById("u"+fldxx).focus();
   return false;
}
    if(fld>14)
    {
    alert("Sorry, i can upload  max 15 files at once.");    
    return false;
    }
    else
    {
        document.getElementById("u"+fld).style.display="block";
        document.getElementById("countfldu").value=countfld;
    }    
}

function uploadfile(id)
{
    if(document.getElementById(id).value==1)
    {
    document.getElementById("showurl").style.display="none";
    document.getElementById("showfl").style.display="block";        
    return true;
    }
    if(document.getElementById(id).value==2)
    {
    document.getElementById("showfl").style.display="none";
    document.getElementById("showurl").style.display="block";    
    return true;
    }
    document.getElementById("countfldu").value="0";
    document.getElementById("countfld").value="0";
    

}

function show_loading()
{
        document.getElementById('loading').style.display = "block";
        document.getElementById('newupload').submit;
        document.getElementById('submit').disabled = true;
       // return true;
}
function show_loading1()
{
        document.getElementById('loading1').style.display = "block";
        document.getElementById('newupload1').submit;
        document.getElementById('submit').disabled = true;
}

function upload(msg,newID,messages,FileName,FileFile,FileUrl,FileUrlLink,FiletnUrl,page_url,server_url,site_name,HotLink)
{
var html='<div id="wrapper"><div style="width:760px;"><center><FONT FACE="Comic Sans MS" SIZE="4" COLOR="#FF0000">Photo Links</FONT></h4><br></center><span class="body"><form name="uploadresults" action="uploademail.php" method="post">';
if(newID)
{    
    html=html+'<input type="hidden" name="idx[]" value="'+newID+'">';
}

if(msg)
    {
        var getmsg = msg.split("|");
        for(i=0;i<getmsg.length;i++)
            {
                if(getmsg[i] && getmsg[i]!="on")
                html=html+'<span style="font-weight: bold; color: red;">'+getmsg[i]+'</span><br>';
            }
            
    }    
html=html+'<br><center>';    
if(messages)
    {
        
        var getmessages = messages.split("|");
        for(i=0;i<getmessages.length;i++)
            {
                if(getmessages[i] && getmessages[i]!="on")                
                html=html+'<span style="font-weight: bold; color: red;">'+getmessages[i]+'</span>';
            }
            html=html+'</center>';    
    }    


if(FileName)
    {
        var getFileName = FileName.split("|");
        var getFileFile = FileFile.split("|");
        var getFileUrl = FileUrl.split("|");
        var getFileUrlLink = FileUrlLink.split("|");
        var getFiletnUrl = FiletnUrl.split("|");
        var getHotLink = HotLink.split("|");
                for(i=0;i<getFileName.length;i++)
                        {
                                if(getFileName[i] && getFileName[i]!="on")        {
								
html=html+'<center><br><img src="'+getFiletnUrl[i]+'" alt="No thumbnail found for this image." /><br><br>';
html=html+'<strong>Link for viewing the photo <br><div align="center"><textarea name="url1[]" cols="80" rows="1" READONLY onfocus="javascript: this.select()">'+server_url+'/view.php?filename='+getFileUrlLink[i]+'</textarea></div><br>';

if(getHotLink=="1"){
html=html+'<strong>Link directly to your photo<br><div align="center"><textarea name="url2[]" cols="80" rows="1" READONLY onfocus="javascript: this.select()">'+getFileUrl[i]+'</textarea></div><br>';
}

html=html+'<strong>Link directly to photo thumbnail<br><div align="center"><textarea name="url3[]" cols="80" rows="1" READONLY onfocus="javascript: this.select()">'+getFiletnUrl[i]+'</textarea></div><br>';
html=html+'<strong>Code to post the photo in a forum:</strong><br><div align="center"><textarea name="url4[]" cols="80" rows="2" READONLY onfocus="javascript: this.select()">[URL='+page_url+'/view.php?filename='+getFileUrlLink[i]+'][img]'+getFileUrl[i]+'[/img][/URL]</textarea></div><br>';
html=html+'<strong>Code to post the thumbnail in a forum:</strong><br><div align="center"><textarea name="url5[]" cols="80" rows="2" READONLY onfocus="javascript: this.select()">[URL='+page_url+'/view.php?filename='+getFileUrlLink[i]+'][img]'+getFiletnUrl[i]+'[/img][/URL]</textarea></div><br>';
html=html+'<strong>Code to post photo in your website:</strong><br><div align="center"><textarea name="url6[]" cols="80" rows="2" READONLY onfocus="javascript: this.select()"><a href="'+server_url+'/view.php?filename='+getFileUrlLink[i]+'" target="_blank"><img src="'+getFiletnUrl[i]+'" alt="FREE photo hosting by '+site_name+'"></a></textarea></div><br></center><hr />';
                                }
								
                        }                
                        html=html+'<br>Instead of writting down or copying these links, you can just enter your e-mail address and we will send them to you. Your e-mail address will remain private and we will not sell or share it with anyone. And you will not receive mail from us other than one message containing the above links.<br><br><div align="center"><strong>Your E-mail Address:</strong> <input type="text" name="email" size="25" maxlength="50" /><br><br><input type="submit" name="submit" value="Send me my links" /></div><br></form></span></div></div><br>';
        }  

    
    document.getElementById("showform").style.display="none";
    document.getElementById("showoutput").style.display="block";
    document.getElementById("showoutput").innerHTML=html;        
    return false;

}