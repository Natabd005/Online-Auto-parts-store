<?php
	var_dump($_COOKIE);
	if(isset($_COOKIE["admin"])){
		setcookie("admin",null);
		
	}
	if(isset($_COOKIE["admin_password"])){
		setcookie("admin_password",null);
	}
	header("location:/admin/login.html");
?>