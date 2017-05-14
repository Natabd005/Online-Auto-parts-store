<?php
	include 'php/database.php';
	$insert = true;
	
	$email = $_POST["email"];
	$passwd = $_POST["passwd"];
	$fname = $_POST["fname"];
	$lname = $_POST["lname"];
	
	$email = test_input($email);
	$passwd = test_input($passwd);
	$fname = test_input($fname);
	$lname = test_input($lname);
	
	testEmail($email);
	testPasswd($passwd);
	testFirstName($fname);
	testLastName($lname);
	
	
	if($insert){
		$passwd = encodePasswd($passwd);
		$db = new database;
		$param = [$email,$passwd,$fname,$lname];
		$sql = $db->makeInsertSql("user",$param);
		$result = $db->modify($sql);
		if($result>0){
			onSuccess($email,$passwd);
		}else{
			header('Location:/error.html');
		}
		
	}else{
		header('Location:/error.html');
	}
	
	function encodePasswd($passwd){
		return md5($passwd);
	}
	
	function onSuccess($email,$passwd){
		setcookie("email",$email);
		setcookie('passwd',encodePasswd($passwd));
		header('Location:index.php');
	}
	
	function test_input($data){
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}

	
	function testEmail($email){
		$index = strpos($email,"@");
		$length = strlen($email);
		if(!($index>0&&$index<$length)){
			$insert = false;
		}
	}
	
	function testPasswd($passwd){
		if(strlen($passwd)<8){
			$insert = false;
		}
	}
	
	function testFirstName($firstName){
		if(strlen($firstName)<1){
			$insert = false;
		}
	}
	
	function testLastName($lastName){
		if(strlen($lastName)<1){
			$insert = false;
		}
	}
?>