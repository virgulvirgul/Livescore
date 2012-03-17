<?php 
require_once '../Controllers/UsersController.php';
$usersController = new UsersController();
$usersController->checkUserPassword();
?>

<html>
<head>
<link rel="stylesheet" type="text/css" href="../Css/login_form_style.css">
</head>
<body>
<div style="text-align: center;display: <?=$usersController->getHidden();?>" >
<form class="loginform" action="login.php" method="POST"><br>
<p class="center_text_">Вход для администраторов</p>
<p class="error"><?=$usersController->getMsg();?></p>
        <input class="loginfield" name="login" type="text" value="Логин..." 
        	onfocus="if (this.value == 'Логин...') {this.value = '';}"
             onblur="if (this.value == '') {this.value = 'Логин...';}" /><br><br>
        <input class="loginfield" name="password" type="password" value="Пароль..." 
        	onfocus="if (this.value == 'Пароль...') {this.value = '';}"
             onblur="if (this.value == '') {this.value = 'Пароль...';}" /> <br><br>
        <input class="loginbutton" type="submit" value="Войти" /><br>
</form>
</div>
</body>
</html>