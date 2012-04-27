<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="ru" >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="style.css" type="text/css" />




<?php # HelloClient.php
# Copyright (c) 2005 by Dr. Herong Yang
#
   	$client = new SoapClient(null, array(
      'location' => "http://localhost/Livescore/WebService/server.php",
      'uri'      => "urn://www.livescore.com/req",
      'trace'    => 1 ));

   
   	$result = $client->getContent();
   	
   	$date = $result['date_array'];
   	$match = $result['match_array'];
   	
   	print_r($match);
   	
	echo "<center><table border='1'>";
	foreach ($date as $row) {
   		echo "<tr id='tr_header'><td colspan='4'><u>".$row['country_name']."</u> - ".$row['championship_name']."<div align='right'>".$row['date']."</div></td></tr>";
   		
   		foreach ($match as $row_match) {
   			echo "<tr><td width='5px'>";
   		echo $row_match['hour']."</td>";
   		echo "<td align='right' width='100px'><div align='right'>".$row_match['team_owner_name']."</div>
				<td width='20px'>
				<div align='center'><a href='index.php?id_game=".$row_match['id_game']."'> ".$row_match['team_owner_score']." - ".$row_match['team_guest_score']." </a> </div></td>
				<td width='100px'><div align='left'>".$row_match['team_guest_name']."</div></td></td>
				</tr>";
   		}
   	}
   	echo "</table></center>";
        // echo("\nReturning value of __soapCall() call: ".$return);

  // echo("\nDumping request headers:\n" 
   //   .$client->__getLastRequestHeaders());

   //echo("\nDumping request:\n".$client->__getLastRequest());

   //echo("\nDumping response headers:\n"
   //   .$client->__getLastResponseHeaders());

 //  echo("\nDumping response:\n".$client->__getLastResponse());
?>