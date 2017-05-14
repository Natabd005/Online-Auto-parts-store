<?php
	include 'php/database.php';
	$email = $_GET["email"];
	$sql = 'select email from user where email="'.$email.'";';
	
	
	$db = new database;
	$data = $db->select($sql);
	$res = array();
	$res["suc"] = false;
	if(count($data)==0){
		$res["suc"] = true;
	}
	echo json_encode($res);
	
?>