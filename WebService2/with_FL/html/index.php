<html>
<head>
	<title>Template</title>
<style>
td{font-family:verdana;font-size:12px;color:000000}
a{color:#DD4411; font-size:10px; text-decoration:underline}
a:visited{color:#DD4411}
a:hover{color:blue}
.m1{padding-left:20; padding-right:20;}
</style>
</head>
<body topmargin="0" leftmargin="0" bottommargin="0" rightmargin="0">
<table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%">
  <tr>
  	<td rowspan="10" width="50%" height="100%" background="images/bg1222.jpg" style="background-position:right top; background-repeat:repeat-y"></td>
    <td colspan="2"><object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" width="780" height="350">
        <param name="movie" value="0058.swf">
        <param name="quality" value="high">
        <embed src="0058.swf" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="780" height="350"></embed></object></td>
   <td rowspan="10" width="50%" height="100%" background="images/bg1223.jpg" style="background-position:left top; background-repeat:repeat-y"></td>
  </tr>
  <tr>
    <td valign="top" height="100%" background="images/back_left.gif" width="377">
    		<table border="0" cellpadding="0" cellspacing="0" width="377">
                   <tr>
                     <td valign="top" class="m1" style="background-repeat:no-repeat; padding-top:20" style="color:808080" background="images/back_left1.jpg"><img src="images/small.gif" border="0" width="5" height="7" alt="">&nbsp;&nbsp; <font style="color:BD3716; font:900">Our career</font><br><br>
                     Duis autem vel eum iriure dolor in hendrerit in vulputate 
velit esse molestie consequat, vel illum dolore eu feugiat 
nulla facilisis at vero eros et accumsan et iusto odio 
dignissim qui blandit praesent luptatum zzril delenit 
augue duis dolore te feugait nulla facilisi. 
<br>
Duis autem vel eum iriure dolor in hendrerit in vulputate 
velit esse molestie consequat, vel illum dolore eu.</td>
                   </tr>
                   <tr>
                     <td valign="top" style="padding-top:10;">
                     		<table border="0" cellpadding="0" cellspacing="0">
                                 <tr>
                                   <td valign="top" style="padding-left:10;"><img src="images/pic.jpg" border="0" alt=""></td>
                                   <td class="m1" style="color:808080">Duis autem vel eum iriure dolor in 
hendrerit in vulputate velit esse 
molestie consequat, vel illum dolore 
eu feugiat nulla facilisis at vero eros 
et accumsan et iusto odio dignissim 
qui blandit praesent luptatum zzril 
delenit augue duis dolore te feugait 
nulla facilisi. 
</td>
                                 </tr>
                               </table>
                       
                     </td>
                   </tr>
                   <tr>
                     <td style="padding-top:5" valign="top"><img src="images/midl.gif" border="0" width="377" alt=""></td>
                   </tr>
                   <tr>
                     <td class="m1" style="color:808080; padding-top:10" valign="top"> <img src="images/small.gif" border="0" width="5" height="7" alt=""><font style="color:BD3716; font:900"> Some words about us</font><br><br>

Duis autem vel eum iriure dolor in hendrerit in vulputate 
velit esse molestie consequat, vel illum dolore eu feugiat 
nulla facilisis at vero eros et accumsan et iusto odio 
dignissim qui blandit praesent luptatum zzril delenit 
augue duis dolore te feugait nulla facilisi.</td>
                   </tr>                   
                 </table>
      
    </td>
    <td background="images/back_right.gif" valign="top" height="100%" width="403">
    		<table border="0" cellpadding="0" cellspacing="0" width="403">
                  <tr>
             
             <td valign="top" align="center" style="padding-top:20; padding-left:30">
                    		<table border="1" cellpadding="0" cellspacing="0" bordercolor="C0C9B4">     
                    		<tr>
                                   <td bgcolor="00A000" height="25" width="20px"  style="color:ffffff; width:50px; text-align:center; font-size:15px; font:900">#</td>
                                   <td bgcolor="00A000" height="25" width="150" style="color:ffffff; width:400px;  text-align:center;font-size:15px; font:900">Team</td>
                                   <td bgcolor="00A000" height="25" width="150" style="color:ffffff; width:50px; text-align:center; font-size:15px; font:900">G</td>
                                   <td bgcolor="00A000" height="25" width="150" style="color:ffffff;  width:50px;text-align:center;font-size:15px; font:900">W</td>
                                   <td bgcolor="00A000" height="25" width="150" style="color:ffffff;  width:50px;text-align:center;font-size:15px; font:900">L</td>
                                   <td bgcolor="00A000" height="25" width="150" style="color:ffffff; width:50px;text-align:center;font-size:15px; font:900">D</td>
                                   <td bgcolor="00A000" height="25" width="150" style="color:ffffff;  width:50px; text-align:center;font-size:15px; font:900">Gd</td>
                                   <td bgcolor="00A000" height="25" width="150" style="color:ffffff; width:50px;text-align:center;font-size:15px; font:900">P</td>
                                   <td bgcolor="00A000" height="25" width="150" style="color:ffffff; width:100px;text-align:center;font-size:15px; font:900">Form</td>
                                 </tr><center>
<?php 


$client = new SoapClient(null, array(
		'location' => "http://localhost/Livescore/WebService/server.php",
		'uri'      => "urn://www.livescore.com/req",
		'trace'    => 1 ));


$result = $client->getStatistics(1);
$championship_table_array = $result['championship_table_array'];
$form_array = $result['form_array'];
$number = 0;
$number_form = 0;
foreach ($championship_table_array as $row) {
	$number++;
	
	if ($team_owner_name == $row['team_name'] || $team_guest_name == $row['team_name']) {
		echo "<tr>";
	}
	else echo "<tr>";
	
	echo "<td bgcolor='435576' width='1px;' height='25' style='color:ffffff; text-align:center;font-size:15px'>".$number."</td>";
	echo "<td bgcolor='435576' height='25' style='color:ffffff; text-align:center; font-size:15px'>".$row['team_name']."</td>";
	echo "<td bgcolor='435576' height='25' style='color:ffffff; text-align:center; font-size:15px'>".$row['games']."</td>
							<td bgcolor='435576' height='25' style='color:ffffff; text-align:center; font-size:15px'>".$row['win']."</td>
									<td bgcolor='435576' height='25' style='color:ffffff; text-align:center; font-size:15px'>".$row['draw']."</td>
											<td bgcolor='435576' height='25' style='color:ffffff; text-align:center; font-size:15px'>".$row['lose']."</td>
													<td bgcolor='435576' height='25' style='color:ffffff;text-align:center;font-size:15px'>".$row['goal_diff']."</td>
															<td bgcolor='435576' height='25' style='color:ffffff; text-align:center; font-size:15px'>".$row['points']."</td>";
	
	foreach ($form_array as $row_form) {
		if ($row['team_name'] == $row_form['team_name']) {
			if (strlen($row_form['form']) > 0) {
				$symb = str_split($row_form['form']);
			}
			echo "<td bgcolor='435576' height='25' style='color:ffffff; text-align:center; font-size:15px'>";
			for ($i == 0; $i < count($symb); $i++) {
				$number_form++;
				if ($symb[$i] == "W") { $img = "win";} else
				if ($symb[$i] == "L") { $img = "lose"; } else
				if ($symb[$i] == "D") { $img = "draw"; }  else $img = "win";
				
				$id_games = explode(";", $row_form['id_games']);
				//$result_teams_names = $client->getTeamsNamesAndSoreByGameId($id_games[$i]);
				//$teams_names_array = $result_teams_names['teams_names_array'];
				
				$allDate = $teams_names_array['date'];
				$year = substr($allDate, 0, 4);
				$month = substr($allDate, 5, 2);
				$day = substr($allDate, 8, 2);
				$hour = substr($allDate, 11, 2);
				$minute = substr($allDate, 14, 2);
				$date = date('d F, Y',mktime($hour,$minute,0,$month, $day, $year));

				echo "<img src='images/".$img.".png' style='height:15px;width:15px;'>&nbsp;";
				}
			$i = 0;
			$symb = null;
				echo "</td><tr>";
				
		}
		
	}
}




?>                 
                    
                               </table>
                      
                    </td>
                  </tr>
                  <tr>
                    <td style="color:ffffff; padding-left:50; padding-right:30; padding-bottom:10; padding-top:10; font-size:10px">Duis autem vel eum iriure dolor in hendrerit in vulputate 
velit esse molestie consequat, vel illum dolore eu.</td>
                  </tr>
                </table>
      
    </td>
  </tr>
  <tr>
    <td colspan="2"><img src="images/bottom.jpg" border="0" width="780" height="38" alt=""></td>
  </tr>
  <tr>
    <td colspan="2" valign="top"><img src="images/footer1.gif" border="0" width="780" height="27" alt=""></td>
  </tr>
  <tr>
    <td colspan="2" background="images/footer2.gif" height="28" valign="top" align="center" style="color:808080; padding-top:5; font-size:10px; font-family:tahoma">
    2003 (c) Copyright CompanyName, inc. All rights reserved. <a href="">Read Legal Policy</a> and <a href="">Privacy Policy.</a>
    </td>
  </tr>
</table>


</body>
</html>
