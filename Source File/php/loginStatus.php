<?php
	include 'database.php';
	class LoginStatus
	{
		function check()
		{
			if(!isset($_COOKIE["email"])){
				return false;
			}
			if(!isset($_COOKIE["passwd"])){
				return false;
			}
			$email = $_COOKIE["email"];
			$passwd = $_COOKIE["passwd"];
			$email = test_input($email);
			
			$sql = "select passwd from user where email='".$email."';";
			$db = new database;
			$data = $db->select($sql);
			if(count($data)==0){
				return false;
			}
			$db_passwd = $data[0]["passwd"];
			if(!md5($db_passwd) == $passwd){
				return false;
			}
			return true;
		}
		
		
	}
	function test_input($data){
			$data = trim($data);
			$data = stripslashes($data);
			$data = htmlspecialchars($data);
			return $data;
		}
?>