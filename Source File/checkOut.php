<?php
	session_start();
	
	if(!isset($_SESSION["car"])){
		exit();
	}
	
	$autoparts = $_SESSION["car"];
	$total = 0;
	$totalPrice = 0;
	foreach($autoparts as $autopart){
		
		$total += $autopart["num"];
		$totalPrice +=($autopart["num"]*$autopart["price"]);
	}
	
	if($total ==0){
		onError();
		return;
	}
	

	include "php/loginStatus.php";
	
	$ls = new loginStatus;
	if(!$ls->check()){
		header("location:login.html");
	}
	
	
	
	
	$email = $_COOKIE["email"];
	$order = [$email,$total,$totalPrice];
	$prefix = "(email,totalItems,totalPrice) ";
	$db = new database;
	$sql = $db->makeInsertSqlWithPrefix("orders",$order,$prefix);
	
	$id = $db->modify_Id($sql);
	
	foreach($autoparts as $autopart){
		$partId = $autopart["partId"];
		$num =$autopart["num"];
		$price =$autopart["price"];
		$param =[$id,$partId,$num,$price];
		$sql = $db->makeInsertSql("orderdetails",$param);
		$res = $db->modify($sql);
		$sql2 = "update autopart set inStock = inStock - ".$autopart["num"]." where partId='".$autopart["partId"]."';";
		$db->modify($sql2);
		if($res<=0){
			onError();
		}
	}
	
	$address = getValue("address");
	$zipcode = getValue("zip");
	$firstname = getValue("fname");
	$lastname = getValue("lname");
	$state = getValue("state");
	
	
	$params = [$id,$firstname,$lastname,$address,$state,$zipcode];
	
	$sql = $db->makeInsertSql("orderAddress",$params);
	$res = $db->modify($sql);
	
	if($res<=0){
		onError();
	}else{
		
		onSuccess($id);
	}
	
	function onSuccess($id){
		unset($_SESSION["car"]);
		header("location:place_order_success.html?orderId=".$id);
	}
	
	function onError(){
		header("location:/error.html");
	}

	
	function getValue($key){
		if(!isset($_POST[$key])){
			header("location:error.html");
		}
		$value = $_POST[$key];
		return test_input($value);
	}
	
?>