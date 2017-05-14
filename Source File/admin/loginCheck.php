<?php
	include "../php/database.php";
	
	function convientCheck(){
		if(!checkLogin()){
			header("location:/admin/login.html");
		}
	}
	
	function checkLogin(){
		if(!isset($_COOKIE["admin"])){
			return false;
		}
		if(!isset($_COOKIE["admin_password"])){
			return false;
		}
		$admin = $_COOKIE["admin"];
		$password  = $_COOKIE["admin_password"];
		$sql ="select password from adminuser where name = '".$admin."';";
		$db = new database;
		$res = $db->select($sql);
		$length = count($res);
		if($length == 0){
			return false;
		}
		$p = md5($res[0]["password"]);
		return $p == $password;
	}
?>