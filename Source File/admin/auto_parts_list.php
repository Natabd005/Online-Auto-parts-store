<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>Auto Parts Items List</title>
<style type="text/css">
table{
	font-family: Arial, Helvetica, sans-serif;
	font-size:12px;
	align:center;
	vertical-align:middle;
	border-collapse:collapse;
	margin-top:10px;
	position: absolute;
	margin-left:80px;
}
th{
	border:1px solid white;
}
td{
	border:1px solid white;
}


.edit{
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



table, th, td {
   border: 1px solid black;
}
th{
	text-align:center;
}
#createnew{
	vertical-align:middle;
	border-collapse:collapse;
	position: absolute;
	margin-left:45%;
	
}
}

</style>
</head>

<body>

	<div style="overflow:hidden">
		<button class="edit" id="createnew" onclick="add();" style="margin-left:400px">Create New Item</button>
	</div>

	<div style="overflow:hidden">
		<button class="edit" id="createnew" onclick="logoff();">Log Off</button>
	</div>
	
	<br/><br/>
	
	<div id="display">
	
	<table>
		<tr>
			<th>Image</th>
			<th>PartId</th>
			<th>PartName</th>
			<th>Manufacturer</th>
			<th>Date</th>
			<th>Price</th>
			<th>list Price</th>
			<th>Category</th>
			<th></th>
		</tr>
		
		<?php
				
		
				include "loginCheck.php";
				convientCheck();
				
				$sql = getSql();
				$db = new database;
				
				$autoparts = $db->select($sql);
				
				foreach($autoparts as $autopart){
                    echoautopart($autopart);
				}
				
				function getSql(){
					$sql = "select autopart.partId,partName,price,listPrice,manufacturer,date(updateTime) as updateTime,pictureUrl,categoryId from autopart join autopartcategory on autopart.partId = autopartcategory.partId order by updateTime desc";
					return $sql;
				}
				
				function getCategoryName($id){
					$category = array();
					$category[1] = "Motor Oil";
					$category[2] = "Wash & Wax";
					$category[3] = "Batteries";
					$category[4] = "Lights";
					$category[5] = "Tires & Wheels";
					return $category[$id];
				}
				
				function echoautopart($autopart){
					echo '<tr>
			<td><img src="'.$autopart["pictureUrl"].'" alt="'.$autopart["partName"].'" height="160" width="160"></td>
			<td>&nbsp&nbsp'.$autopart["partId"].'&nbsp&nbsp</td>
			<td>&nbsp&nbsp'.$autopart["partName"].'&nbsp&nbsp</td>
			<td>&nbsp&nbsp'.$autopart["manufacturer"].'&nbsp&nbsp</td>
			<td>&nbsp&nbsp'.$autopart["updateTime"].'&nbsp&nbsp</td>
			<td>&nbsp&nbsp$'.$autopart["price"].'&nbsp&nbsp</td>
			<td>&nbsp&nbsp$'.$autopart["listPrice"].'&nbsp&nbsp</td>
			<td>
				&nbsp&nbsp'.getCategoryName($autopart["categoryId"]).'&nbsp&nbsp
			</td>
			
			<td><button class="edit" onclick="edit('.$autopart["partId"].')">Edit</button><br/><br/><button onclick="del('.$autopart["partId"].')" class="edit">Delete</button></td>
			</tr>';
				}
		?>
		
		
		
		</table>
	</div>
</body>

<script>
	function add(){
		window.location.href="new.html";
	}
	
	function edit(id){
		window.location.href="edit.php?partId="+id;
	}
	
	function del(id){
		if(confirm("Are you sure to delete this item?")){
			window.location.href="delete.php?partId="+id;
		}
		
	}
	
	function logoff(){

		window.location.href="/admin/logoff.php";
	}
	
	function createCookie(name,value,days) {
		if (days) {
			var date = new Date();
			date.setTime(date.getTime()+(days*24*60*60*1000));
			var expires = "; expires="+date.toGMTString();
		}
		else var expires = "";
		document.cookie = name+"="+value+expires+"; path=/";
	}
</script>
</html>