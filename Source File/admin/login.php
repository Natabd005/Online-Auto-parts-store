<?php
	include "../php/database.php";
	if(!isset($_POST["name"])){
		onerror();
	}
	
	if(!isset($_POST["password"])){
		onerror();
	}
	
	$name =$_POST["name"];
	$password = $_POST["password"];
	
	$name = htmlspecialchars($name);
	$password =htmlspecialchars($password);
	$sql = "select * from adminuser where name = '".$name."' and password='".$password."';";
	$db = new database;
	$res = $db->select($sql);
	$length = count($res);
	if($length>0){
		onsuccess($name,$password);
	}else{
		onerror();
	}

	
	
	function onsuccess($name,$password){
		setcookie("admin",$name);
		setcookie("admin_password",md5($password));
		header("location:/admin/auto_parts_list.php");
	}
	
	function onerror(){
		header("location:/admin/login.html");
	}

?>