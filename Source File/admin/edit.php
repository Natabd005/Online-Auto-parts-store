<?php
	include "uploadFile.php";
	include "../php/input.php";
	include "loginCheck.php";
	
	convientCheck();

	$partId = getParam("partId");
	
	$sql = "select * from autopart join autopartcategory on autopart.partId = autopartcategory.partId where autopart.partId='".$partId."';";
	$db = new database;
	$autoparts = $db->select($sql);
	if(count($autoparts)==0){
		onerror();
	}

    $autopart = $autoparts[0];
	
	function getParam($name){
		if(!isset($_GET[$name])){
			onerror();
		}
		$value = $_GET[$name];
		return test_input($value);
	}
	
	function onerror(){

	}
?>














<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<style type="text/css">
#content{
text-align:center;
font-family: Arial, Helvetica, sans-serif;

}
input.edit{
				width:270px;
				height:20px;
				font-size:15px;
				padding-left:3px;
				margin-top:5px;
			}
		
#bt1,#bt2,#bt3{
	width:100px;
	height:30px;
	padding: 5px 15px;
	font-family: Arial, Helvetica, sans-serif;
	font-size:12px;
	outline: none;
	cursor: pointer;
	text-align: center;
	text-decoration: none;
	color: #ffffff;
	border: solid 1px #0076a3; border-right:0px;
	background: #0095cd;
	background: -webkit-gradient(linear, left top, left bottom, from(#00adee), to(#0078a5));
	background: -moz-linear-gradient(top,  #00adee,  #0078a5);
	border-radius: 5px 5px;
}

select {
	background: transparent;
	padding: 5px;
	font-family: Arial, Helvetica, sans-serif;
	font-size:12px;
	border: 1px solid #ccc;
	height: 34px;
	-webkit-appearance: none; /*for chrome*/
	background: url("http://ourjs.github.io/static/2015/arrow.png") no-repeat scroll right center transparent;
	padding-right: 14px;
}

</style>
</head>

<body>
			

	<div id="content">
	<form action="edit2.php" method="post"
enctype="multipart/form-data">
	<span>&nbsp&nbspImage:&nbsp&nbsp&nbsp</span><input type="file" class="edit" name="file"/><br/><br/>
	<span>&nbsp&nbsp&nbspPartId:&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</span><input class="edit" type="text" name="partId" readonly="readonly" value="<?php echo $autopart["partId"]?>"/><br/><br/>
	<span>&nbsp&nbspManufacturer:&nbsp&nbsp</span><input class="edit" type="text" name="manufacturer" value="<?php echo $autopart["manufacturer"]?>"/><br/><br/>
	<span>&nbsp&nbspPartName:&nbsp&nbsp</span><input class="edit" type="text" name="partName" value="<?php echo $autopart["partName"]?>"/><br/><br/>
	<span>&nbsp&nbsp&nbspPrice:&nbsp&nbsp&nbsp&nbsp</span><input class="edit" type="text" name="price" value="<?php echo $autopart["price"]?>"/><br/><br/>
	
	<span>ListPrice:</span><input class="edit" type="text" name="listPrice" value="<?php echo $autopart["listPrice"]?>"/><br/><br/>
	<span>&nbsp&nbsp&nbspInStock:&nbsp&nbsp&nbsp&nbsp</span><input class="edit" type="text" name="inStock" value="<?php echo $autopart["inStock"]?>"/><br/><br/>
	<span>Category:&nbsp&nbsp</span><select id="sel" name="category">
		<option value="1" select="select">Motor Oil</option>
		<option value="2">Wash & Wax</option>
		<option value="3">Batteries</option>
		<option value="4">Lights</option>
		<option value="5">Tires & Wheels</option>
	</select><br/><br/>
	<span>Description:&nbsp&nbsp</span><textarea id="desc" name="description" rows="5" cols="60"><?php echo $autopart["description"]?></textarea><br/><br/>
	
	<input id="bt3" type="submit" value="submit"/>
	</form>
	</div>
</body>

<script>
	
	var sel = <?php echo $autopart["categoryId"]?> -1;
	document.getElementById("sel").selectedIndex=sel;
</script>
</html>