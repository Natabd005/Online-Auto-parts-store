<?php
	include 'php/loginStatus.php';
	$lgs = new LoginStatus;
	$res =  $lgs->check();
	echo $res;
?>