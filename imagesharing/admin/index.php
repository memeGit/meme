<? require_once("header.php"); if ($auth_gid)  {       if ($auth_gid!="1" && $auth_gid!="2")      {      header("Location: logout.php"); exit;       }           }else  {   header("Location: login.php");   }

        // get date ranges

        $link = mysql_connect($db_server, $db_user, $db_password) or die("Could not connect");

        mysql_select_db($db_name) or die("Could not select database");

        $query = "SELECT timestamp as ts from imagehits order by timestamp desc";
        $result = mysql_query($query) or die("Query failed");
    while ($line = mysql_fetch_array($result)) {
                $dates[]=$line[ts];                
    }
    mysql_free_result($result);
        if($dates)
        {
        foreach($dates as $tmp)
        {
                $rsdate[]=date("d/m/Y",$tmp);
                
        }
        }
        if(empty($rsdate))
        {
         $rsdate[]=date("d/m/Y");
        }
        $dates=array_unique($rsdate);
        
        $date = $_REQUEST['date'];        
        
        // get bandwidth

        if ($date == "") {

                $day = date("d");
                $month = date("m");
                $year = date("Y");

        }

        if ($date == "all") {

                $report = "All Dates";

                $query1 = "select sum(kb) as ttl from imagehits";

                $query2 = "select count(*) as ct from imagehits";

        } else {
                
                
                if($day=="" || $month==""||$year=="")
                {
                $rs=explode("/",$date);
                $day=$rs[0];
                $month=$rs[1];
                $year=$rs[2];
                }
                $report = $day."/".$month."/".$year;
                
                $start=mktime(0,0,0,date($month),date($day),date($year));                
                $end=($start+24*60*60)-1;                
                

                $query1 = "select sum(kb) as ttl from imagehits where timestamp >= $start and timestamp <= $end";
                
                $query2 = "select count(*) as ct from imagehits where timestamp >= $start and timestamp <= $end";

        }

    $result = mysql_query($query1) or die("Query failed.");

        $bandwidth = 0;

    while ($line = mysql_fetch_array($result)) {

                $bandwidth = $line[ttl];

    }

    mysql_free_result($result);



    $result = mysql_query($query2) or die("Query failed.");

        $images = 0;

    while ($line = mysql_fetch_array($result)) {

                $images = $line[ct];

    }
	
	    $query_tm = "SELECT * from users";
        $result_tm = mysql_query($query_tm) or die("query_ti failed");
		$totalmembers = mysql_num_rows($result_tm); 

        $query_ti = "SELECT * from images";
        $result_ti = mysql_query($query_ti) or die("query_ti failed");
		$totalimages = mysql_num_rows($result_ti); 
	
        $query_gi = "SELECT * from images where userid=0";
        $result_gi = mysql_query($query_gi) or die("query_gi failed");
		$guestimages = mysql_num_rows($result_gi); 
		
		$query_mi = "SELECT * from images where userid>0";
        $result_mi = mysql_query($query_mi) or die("query_mi failed");
		$memberimages = mysql_num_rows($result_mi); 
		
		
        mysql_close($link);

?>
<div style="width:760px;">
<center>
<h2> <font color="#FF0000">Statistics<br />        </font></h2></center>

<br />

<hr>

<br />

<form name="stats" action="<?= $_SERVER['PHP_SELF'] ?>" method="post" style="margin-bottom: 0px;">

<div align="center"><a href="<?= $_SERVER['PHP_SELF'] ?>?date=<?= date("d/m/Y",time()) ?>" class="submenu">Today</a> - <a href="<?= $_SERVER['PHP_SELF'] ?>?date=<?=date("d/m/Y",mktime(0, 0, 0, date("m"), date("d")-1,  date("Y"))) ?>" class="submenu">Yesterday</a>
 - Date: <select name="date" size="1">
                        <option value="" selected></option>
                        <? foreach ($dates as $dt1) { ?>
                        <option value="<?= $dt1?>"><?=$dt1?></option>
                        <? } ?>
                        </select>&nbsp;
                <input type="submit" name="go" value="Go" style="font-size: smaller;"> - <a href="<?= $_SERVER['PHP_SELF'] ?>?date=all" class="submenu">Forever</a>

</form>

<br />

<br />

<h2>Daily report for <?= $report ?></h2>

<table border="0" align="Center" cellpadding="4" cellspacing="0">

        <tr>

                <td align="right"><strong class="fontcolor">Total Image Views:</strong></td>

                <td align="left">&nbsp;<?= number_format($images) ?></td>

        </tr>
        <?
$bandwidthgb =  ($bandwidth / 1073741824) ;
$bandwidthmb =  ($bandwidth / 1048576) ;
$bandwidthkb =  ($bandwidth / 1024) ;
?>
        <tr>        
             <td align="right"><strong class="fontcolor">Bandwidth Used GB:</strong></td>
                <td align="left">&nbsp;<?= number_format($bandwidthgb) ?> GB</td>

        </tr><br /><br />
        <tr>
                <td align="right"><strong class="fontcolor">Bandwidth Used MB:</strong></td>
                <td align="left">&nbsp;<?= number_format($bandwidthmb) ?> MB</td>
        
        </tr>

</table> 

<br /><br />
<h2>Universal Stats</h2>
<br />
<strong class="fontcolor">Total Members :</strong> <?= $totalmembers ?><br />
<strong class="fontcolor">Total images :</strong> <?= $totalimages ?><br />
<strong class="fontcolor">Guests images :</strong> <?= $guestimages ?><br />
<strong class="fontcolor">Members images :</strong> <?= $memberimages ?><br />

</div>
</div>
</div>
<? require_once("footer.php"); ?>