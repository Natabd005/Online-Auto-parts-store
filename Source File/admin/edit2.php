<?php
	include "uploadFile.php";
	include "../php/input.php";
	include "loginCheck.php";
	
	convientCheck();
	$partId = $_POST["partId"];
	$autopart = getAutoPart($partId);
	$pictureUrl = getPicture($autopart);
	
	
	$manufacturer = getParamOnDb("manufacturer",$autopart);
	$price =getParamOnDb("price",$autopart);
	$listPrice =getParamOnDb("listPrice",$autopart);
	$category = getParamOnDb("category",$autopart);
	$inStock = getParamOnDb("inStock",$autopart);
	$partName = getParamOnDb("partName",$autopart);
	$description =getParamOnDb("description",$autopart);
	$description =addslashes($description);
	
	
	$db = new database;
	
	$param = [$partId,$partName,$price,$listPrice,$pictureUrl,$description,$inStock,$manufacturer];
	$prefix = "(partId,partName,price,listPrice,pictureUrl,description,inStock,manufacturer)";
	$sql = $db->makeReplaceSqlWithPrefix("autopart",$param,$prefix);

	$res = $db->modify($sql);
	if($res<=0){
		onerror();
	}
	

	$sql = "update autopartcategory set categoryId='".$category."' where partId='".$partId."';";
	$res = $db->modify($sql);
	

	onsuccess();
	
	function getParamOnDb($name,$autopart){
		if(!isset($_POST[$name])){
			return $autopart[$name];
		}
		$value = $_POST[$name];
		return test_input($value);
	}
	
	function getPicture($autopart){
		$pictureUrl =  upload();
		if($pictureUrl!="null"){
			return $pictureUrl;
		}
		return $autopart["pictureUrl"];
	}
	
	function getAutoPart($partId){
		$sql = "select * from autopart join autopartcategory on autopart.partId = autopartcategory.partId where autopart.partId='".$partId."';";
		$db = new database;
		$autoparts = $db->select($sql);
		if(count($autoparts)==0){
			onerror();
		}
		return $autoparts[0];
	}
	
	function onerror(){
		header("location:error.html");
	}
	
	function onsuccess(){
		header("location:/admin/auto_parts_list.php");
	}
?>