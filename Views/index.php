<?php
session_start();
require_once '../Controllers/MainController.php';
require_once '../Controllers/MessagesController.php';
$mainController = new MainController();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="ru" >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<!-- CSS -->
<link rel="stylesheet" href="../Css/ui-darkness/jquery-ui-1.8.18.custom.css" type="text/css" />
<link rel="stylesheet" href="../Css/style.css" type="text/css" />
<link rel="stylesheet" href="../Css/modal.css" type="text/css" />
<link rel="stylesheet" href="../Css/autocomplete.css" type="text/css" />


<!--[if lte IE 6]><link rel="stylesheet" type="text/css" href="css/style-ie.css" media="screen, projection, tv" /><![endif]-->
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />

<title>Админ часть</title>
</head>

<body>
<div id="main">
	<!-- Header -->
	<div id="header">
		<div id="header-in">
			
		<!-- Your website name  -->
		<!--<h1></h1> -->
		<!-- Your website name end -->
		
			<!-- Your slogan -->
			<!--<h2>Your slogan, your sevices, your offer&hellip;</h2>-->
			<!-- Your slogan end -->

		<!-- Search form -->

		<!-- Search end -->		
		</div>
	</div>
	<!-- Header end -->
	

<!-- Menu -->
	<div id="menu-box" class="cleaning-box">
	<a href="#skip-menu" class="hidden"></a>
		<ul id="menu">
			<li class="first"><a href="index.php">Главная</a></li>
			<li><a href="index.php?messages=inbox">Личные сообщения(<b style="color: #6495ED"><?=$mainController->getUnreadAmount()?></b>)</a></li>
			<li><a href="index.php?action=logout">Выход(<?=$mainController->getUserLoginBySessionId()?>)</a></li>
			<!-- <li><a href="#">Portfolio</a></li>-->
			<!-- <li><a href="#">Price list</a></li>-->
			<!-- <li><a href="#">Contact</a></li>-->
		</ul>
	</div>
<!-- Menu end -->

<hr class="noscreen" />
<div id="skip-menu"></div>

<div id="content">
	
<!-- Content box with white background and gray border -->
<div id="content-box">
<!-- Left column -->
<div id="content-box-in-left">
				<div id="content-box-in-left-in">
		<div id="left-menu-block">
		
		<ul id="left-menu">
<?php
try {
$mainController->getLeftMenu();
} 
catch (PDOException $e) {
	$error .= $e->getMessage();
}
echo "<span style='color:red'>".$error."</span>";
//$mainController->getLeftMenu();
/*foreach ($mainController->getContinents() as $row)  {
	echo "<div id='continents'>".$row['name']."</div><br>";
	foreach ($mainController->getCountries($row['id_continent']) as $row)  {
		echo "<li><a href='index.php?id_country=".$row['id_country']."'>
		<img src='".$mainController->getImageDir().$row['emblem']."'>&nbsp;".$row['name']."</a></li><br>";
	}
}*/
?>
</ul>
</div>
</div></div>
<hr class="noscreen" />
			
			<!-- Right column -->
			<div id="content-box-in-right">
				<div id="content-box-in-right-in">
				<?php 
				//$mainController->getChampionshipsByCountryId();
				try {
					$mainController->checkContent();
				}
				catch (PDOException $e) {
					$errorContent = $e->getMessage();
				}
				echo "<span style='color:red'>".$errorContent."</span>";
				/*	echo "<h2><img align='middle' id='flag' src='".$mainController->getImageDir()."
					".$mainController->getCountryEmblem()."'>&nbsp;".$mainController->getCountryById()."</h2><br>";
				
					foreach ($mainController->getChampionshipsById()as $row) {
						echo $row['name'];
					}*/
				?>
		</div>
			</div>
			<div class="cleaner">&nbsp;</div>
			<!-- Right column end -->
		</div>
		<!-- Content box with white background and gray border end -->
	</div>

<hr class="noscreen" />
	
	<!-- Footer -->
	<div id="footer">
		<div id="footer-in">
			<p class="footer-left">&copy; <a href="#">Онлайн результаты</a>, 2011 - 2012.</p>
		</div>
	</div>
	<!-- Footer end -->

</div>
<script type="text/javascript" src="../Scripts/jquery-1.7.1.js"></script> 
<script type="text/javascript" src="../Scripts/jquery-ui-1.8.18.min.js"></script>
<script type="text/javascript" src="../Scripts/contextmenu.js"></script> 
<script type="text/javascript" src="../Scripts/modal.js"></script> 
<script type="text/javascript" src="../Scripts/ContextMenuForChampionships.js"></script>
<script type="text/javascript" src="../Scripts/ContextMenuForTeams.js"></script>
<script type="text/javascript" src="../Scripts/ContextMenuForTeamPlayers.js"></script>
<script type="text/javascript" src="../Scripts/ContextMenuForReferees.js"></script>
<script type="text/javascript" src="../Scripts/ContextMenuForStadiums.js"></script>
<script type="text/javascript" src="../Scripts/Games.js"></script>
<script type="text/javascript" src="../Scripts/easyTooltip.js"></script>
<script type="text/javascript" src="../Scripts/OtherScripts.js"></script>
<script type="text/javascript" src="../Scripts/autocomplete.js"></script>
<script type="text/javascript" src="../Scripts/timepicker.js"></script>

</body>
</html>