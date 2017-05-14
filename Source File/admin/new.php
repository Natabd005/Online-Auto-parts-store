<?php
	include "uploadFile.php";
	include "../php/input.php";
	include "loginCheck.php";
	
	convientCheck();
	
	$pictureUrl =  upload();

	if($pictureUrl == "null"){
		onerror();
	}
	
	
	$partId = getParam("partId");
	$manufacturer = getParam("manufacturer");
	$price =getParam("price");
	$listPrice =getParam("listPrice");
	$category = getParam("category");
	$inStock = getParam("inStock");
	$partName = getParam("partName");
	$description =getParam("description");
	
	$db = new database;
	
	$param = [$partId,$partName,$price,$listPrice,$pictureUrl,$description,$inStock,$manufacturer];
	$prefix = "(partId,partName,price,listPrice,pictureUrl,description,inStock,manufacturer)";
	$sql = $db->makeInsertSqlWithPrefix("autopart",$param,$prefix);
	$res = $db->modify($sql);
	if($res<=0){
		onerror();
	}
	
	$param = [$partId,$category];
	$sql = $db->makeInsertSql("autopartcategory",$param);
	$res = $db->modify($sql);
	if($res<=0){
		onerror();
	}
	onsuccess();
	
	function onsuccess(){
		header("location:/admin/auto_parts_list.php");
	}
	
	function getParam($name){
		if(!isset($_POST[$name])){
			onerror();
		}
		$value = $_POST[$name];
		return test_input($value);
	}
	
	function onerror(){
		header("location:error.html");
	}

?>