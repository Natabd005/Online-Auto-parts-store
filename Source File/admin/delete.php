<?php
	include "loginCheck.php";
	include "../php/input.php";
	convientCheck();
	
	if(!isset($_GET["partId"])){
		header("location:auto_parts_list.php");
	}
	$partId = test_input($_GET["partId"]);
	
	function getSql($partId){
		$sql = "delete from autopart where partId='".$partId."';";
		return $sql;
	}
	$sql = getSql($partId);
	$db = new database;
	$db->modify($sql);
	header("location:auto_parts_list.php");

?>