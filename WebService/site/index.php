<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<title>Free CSS template by ChocoTemplates.com</title>
	<link rel="stylesheet" href="css/style.css" type="text/css" media="all" />
	<!--[if lte IE 6]><link rel="stylesheet" href="css/ie6.css" type="text/css" media="all" /><![endif]-->
</head>
<body>
	<!-- Header -->
	<div id="header">
		<div class="shell">
			<!-- Logo -->
			<h1 id="logo" class="notext"><a href="#">Sport Zone Sport Portal</a></h1>
			<!-- End Logo -->
		</div>
	</div>
	<!-- End Header -->
	
	<!-- Navigation -->
	<div id="navigation">
		<div class="shell">
			<div class="cl">&nbsp;</div>
			<ul>
			    <li><a href="#">news &amp; events</a></li>
			    <li><a href="#">photo gallery</a></li>
			    <li><a href="#">video gallery</a></li>
			    <li><a href="#">community</a></li>
			    <li><a href="#">schedules</a></li>
			</ul>
			<div class="cl">&nbsp;</div>
		</div>
	</div>
	<!-- End Navigation -->
	
	<!-- Heading -->
	<div id="heading">
		<div class="shell">
			<div id="heading-cnt">
				
				<!-- Sub nav -->
				<div id="side-nav">
					<ul>
					    <li class="active"><div class="link"><a href="#">home</a></div></li>
					    <li><div class="link"><a href="#">ranking</a></div></li>
					    <li><div class="link"><a href="results.php">results</a></div></li>
					    <li><div class="link"><a href="#">schedules</a></div></li>
					    <li><div class="link"><a href="#">photo gallery</a></div></li>
					</ul>
				</div>
				<!-- End Sub nav -->
				
				<!-- Widget -->
				<div id="heading-box">
					<div id="heading-box-cnt">
						<div class="cl">&nbsp;</div>
						
						<!-- Main Slide Item -->
						<div class="featured-main">
						
						<?php 
   	$client = new SoapClient(null, array(
      'location' => "http://localhost/Livescore/WebService/server.php",
      'uri'      => "urn://www.livescore.com/req",
      'trace'    => 1 ));

   	$result = $client->getNearestMatches();
   	
   	$date = $result['date_array'];
   	$match = $result['match_array'];
   	
	echo "<center><table border='1'>";
	foreach ($date as $row) {
   		echo "<tr id='tr_header'><td colspan='4'><u>".$row['country_name']."</u> - ".$row['championship_name']."<div align='right'>".$row['date']."</div></td></tr>";
   		
   		foreach ($match as $row_match) {
   			echo "<tr><td width='5px'>";
   		echo $row_match['hour']."</td>";
   		echo "<td align='right' width='100px'><div align='right'>".$row_match['team_owner_name']."</div>
				<td width='20px'>
				<div align='center'><a onclick='openWindow(".$row_match['id_game'].");'> ".$row_match['team_owner_score']." - ".$row_match['team_guest_score']." </a> </div></td>
				<td width='100px'><div align='left'>".$row_match['team_guest_name']."</div></td></td>
				</tr>";
   		}
   	}
   	echo "</table></center>";
?>
   	
						</div>
						<!-- End Main Slide Item -->
						<div class="cl">&nbsp;</div>						
					</div>
				</div>
				<!-- End Widget -->
				
			</div>			
		</div>
	</div>
	<!-- End Heading -->
	
	<!-- Main -->
	<div id="main">
		<div class="shell">		
			<div class="cl">&nbsp;</div>	
			<div id="sidebar">
				<h2>news spot</h2>
				<ul>
				    <li>
				    	<small class="date">12.05.09</small>
				    	<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
				    </li>
				    <li>
				    	<small class="date">12.05.09</small>
				    	<p>Donec venenatis varius urna vitae congue.</p>
				    </li>
				    <li>
				    	<small class="date">12.05.09</small>
				    	<p>Ullam vel neque ut lectus cursus dapibus.</p>
				    </li>
				    <li>
				    	<small class="date">12.05.09</small>
				    	<p>Praesent pellentesque arcu convallis ante dignissim quis ultrices felis iaculis.</p>
				    </li>
				    <li>
				    	<small class="date">12.05.09</small>
				    	<p>Ut eget lorem elit. Donec lorem eros, congue vel mollis non, tincidunt a nisl.</p>
				    </li>
				    <li>
				    	<small class="date">12.05.09</small>
				    	<p>Curabitur consectetur tellus a diam tincidunt pellentesque. </p>
				    </li>
				</ul>
				<a href="#" class="archives">News Archives</a>
			</div>
			<div id="content">
				<div class="cl">&nbsp;</div>
				<div class="grey-box">
					<h3><a href="#">Lorem ipsum dolor sit amet.</a></h3>
					<a href="#"><img src="css/images/main-1.jpg" alt="" /></a>
					<p>
						<span>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur elementum, odio tincidunt egestas</span>
						<a href="#" class="button">Read more</a>
					 </p>
				</div>
				<div class="grey-box">
					<h3><a href="#">Curabitur elementum, odio tincidunt </a></h3>
					<a href="#"><img src="css/images/main-2.jpg" alt="" /></a>
					<p>
						<span>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur elementum, odio tincidunt egestas</span>
						<a href="#" class="button">Read more</a>
					 </p>
				</div>
				<div class="grey-box last">
					<h3><a href="#">Etiam iaculis tortor vel arcu porta consectetur.</a></h3>
					<a href="#"><img src="css/images/main-3.jpg" alt="" /></a>
					<p>
						<span>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur elementum, odio tincidunt egestas</span>
						<a href="#" class="button">Read more</a>
					 </p>
				</div>
				<div class="cl">&nbsp;</div>
				<div class="video-box">
					<div class="cl">&nbsp;</div>
					
					<h2 class="left">video spot</h2>
					<a href="#" class="button">All videos</a>
					<div class="cl">&nbsp;</div>
					<div class="video-item-box">
					
						<a href="#" class="left"><img src="css/images/video-1.jpg" alt="" /></a>
						<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit</p>
						<a href="#" class="watch-now">Watch now</a>
					</div>
					<div class="video-item-box second">
						<a href="#" class="left"><img src="css/images/video-2.jpg" alt="" /></a>
						<p>Curabitur consectetur tellus a diam tincidunt pellentesque</p>
						<a href="#" class="watch-now">Watch now</a>
					</div>
					<div class="video-item-box">
						<a href="#" class="left"><img src="css/images/video-3.jpg" alt="" /></a>
						<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit</p>
						<a href="#" class="watch-now">Watch now</a>
					</div>
					<div class="video-item-box second">
						<a href="#" class="left"><img src="css/images/video-4.jpg" alt="" /></a>
						<p>Aliquam erat volutpat. Nam tortor justo, pretium eget iaculis et</p>
						<a href="#" class="watch-now">Watch now</a>
					</div>
					<div class="cl">&nbsp;</div>
				</div>
			</div>
			<div class="cl">&nbsp;</div>
		</div>
	</div>
	<!-- End Main -->
	
	<!-- Footer -->
	<div id="footer">
		<div class="shell">
			<div class="cl">&nbsp;</div>
			<a href="#" class="left">TERMS OF USE</a>
			<a href="#" class="left">PRIVACY POLICY</a>
			<p class="right">&copy; Sitename.com. Design by <a href="http://chocotemplates.com">ChocoTemplates.com</a></p>
			<div class="cl">&nbsp;</div>
		</div>
	</div>
	<!-- End Footer -->
</body>


<script language="JavaScript">
	var newWindow; //глобальная переменная для ссылки на окно
	function openWindow(id_game){ //открытие первого окна
		window.status = "Первое окно /*статусная строка главного окна*/";
		strfeatures = "top=200,left=150, width=550, height=550, scrollbars=yes, location=no";
		window.open("statistics.php?id_game="+id_game, "Win1", strfeatures);
	}
</script>

</html>