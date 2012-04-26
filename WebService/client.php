<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="ru" >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">




<?php # HelloClient.php
# Copyright (c) 2005 by Dr. Herong Yang
#
   $client = new SoapClient(null, array(
      'location' => "http://localhost/Livescore/WebService/server.php",
      'uri'      => "urn://www.livescore.com/req",
      'trace'    => 1 ));

   
   $result = $client->getContent();

   foreach ($result as $row) {
   		echo $row['country_name'];
   }
        // echo("\nReturning value of __soapCall() call: ".$return);

  // echo("\nDumping request headers:\n" 
   //   .$client->__getLastRequestHeaders());

   //echo("\nDumping request:\n".$client->__getLastRequest());

   //echo("\nDumping response headers:\n"
   //   .$client->__getLastResponseHeaders());

 //  echo("\nDumping response:\n".$client->__getLastResponse());
?>