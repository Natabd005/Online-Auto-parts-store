<?php
	include 'php/database.php';
	
	$email = $_POST["email"];
	$passwd = $_POST["passwd"];
	$email = test_input($email);
	$passwd = test_input($passwd);
	$passwd = md5($passwd);
	$sql = "select passwd from user where email='".$email."' and passwd='".$passwd."';";
	$db = new database;
	$result = $db->select($sql);
	if(count($result)>0){
		onSuccess($email,$passwd);
	}else{
		onError($email);
	}
	
	function onSuccess($email,$passwd){
		setcookie("email",$email);
		setcookie('passwd',md5($passwd));
		header('Location:index.php');
	}
	
	function onerror($email){
		header('Location:login.html?email='.$email);
	}
	
	function test_input($data){
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}
?>