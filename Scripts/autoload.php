<?php

function __autoload($class_name) {
	$models = '../Models/';
	$controllers = '../Controllers/';
	$ajax = '../Ajax/';
	if (file_exists($models.$class_name.'.php')){
		include $models.$class_name.'.php';
	}
	else
	if (file_exists($controllers.$class_name.'.php')) {
		include $controllers.$class_name.'.php';
	}
	else
	if (file_exists($ajax.$class_name.'.php')) {
		include $ajax.$class_name.'.php'; 
	}
}

?>