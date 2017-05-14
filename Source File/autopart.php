<!DOCTYPE HTML>
<?php
		header("Content-Type: text/html;charset=utf-8");
		if(!isset($_GET["partId"])){
			header('Location:/error.html');
		}
		include "php/database.php";
		$partId = $_GET["partId"];
		$sql = "select * from autopart where partId = '".$partId."';";
		$db = new database;
		$autoparts = $db->select($sql);
		if(count($autoparts)==0){
			header('Location:/error.html');
		}
		$sql2 = "select * from autopartcategory join category on autopartcategory.categoryId = category.id where partId = '".$partId."';";
		$category = $db->select($sql2)[0];
		
		$autopart = $autoparts[0];
		
	?>
<html>
	<head>
		<meta http-equiv='Content-Type' content='text/html'; charset='utf-8' />
		<title> <?php echo $autopart["partName"]?> </title>
		<link rel="stylesheet" type="text/css" href="css/header.css"></style>
		<link rel="stylesheet" type="text/css" href="css/foot.css"></style>
		<link rel="stylesheet" type="text/css" href="css/header.css"></style>
		<link rel="stylesheet" type="text/css" href="css/each_part.css"></style>
		
	</head>
	
	
	<body>
		<div id="banner">
			<div id="logo">
				<a id="home" target="mainFrame" href="index.php">Monkeys' Auto Parts</a>
			</div>

			<div id="search_field">
				<form id="search_form" action="index.php" method="GET">
					<select id="select" name="category">
						<option value="0">All Auto Parts</option>
						<option value="1">Motor Oil</option>
						<option value="2">Wash & Wax</option>
						<option value="3">Batteries</option>
						<option value="4">Lights</option>
						<option value="5">Tires & Wheels</option>
					</select><input name="keyword" id="text" type="text" /><input id="go" type="submit" value="search" />
				</form>
			</div>

			<div id="account_info"> 
				<a class="myButton" id="signin" target="mainFrame" href="login.html">Sign In</a>
				<a class="myButton" id="logout" style="display:none" onclick="logout()" >Log Out</a>
				<a class="myButton" id="account" target="mainFrame" href="account.php">My Account</a> 
				<a class="myButton" id="cart" target="mainFrame" href="showCart.php">Cart</a>
				<a class="myButton" id="contact" target="mainFrame" href="contact.html"> Contact </a>
			</div>
		</div>

		<div id="menu">
			<a id="computer" class="link" target="mainFrame" href="index.php?category=1">Motor Oil</a>
			<a class="link" target="mainFrame"  href="index.php?category=2">Wash & Wax</a>
			<a class="link" target="mainFrame"  href="index.php?category=3">Batteries</a>
			<a class="link" target="mainFrame"  href="index.php?category=4">Lights</a>
			<a class="link" target="mainFrame"  href="index.php?category=5">Tires & Wheels</a>
			
		</div>
		
		<div id="main" style="overflow:false">
		<div id="content1">
		<div class="books_picture">
		<?php
			echo '<img id="photo" src="'.$autopart["pictureUrl"].'" alt="'.$autopart["partName"].'"/>'
		?>
			
		</div>

		<div class="text1">
		
			<p id="bookname"><span id="title"><?php 
			echo $autopart["partName"]
			?></span><br/>
			by <?php echo $autopart["manufacturer"]?> (manufacturer)<br/>
			</p> 

			<p id="price">List Price: $<?php echo $autopart["listPrice"];?> <br/>
			Our Price: $<?php echo $autopart["price"];?></p>

			<ul id="availability">
				<h3 id="proDetail">Product Detail:</h3>
				<li>PartId: <?php echo $autopart["partId"];?></li>
				<li>Category: <?php echo $category["name"];?></li>
				<li>Availability: <?php echo $autopart["inStock"];?> in stock</li>
			</ul>

			<form>
				QTY:&nbsp;&nbsp;
				<input id="qty" type="text" name="qty" value="1">

				
			</form>
			<button id="toCart" onclick="addToCar();">Add to Cart</button>

		</div>

		</div>

		<br/><br/><br/>

		<div class="text2">
			<h3>Auto Parts Description</h3>
			<p id="description">
			
			<?php
			$desc = $autopart["description"];

			echo $desc;
			?>
			
			
			
			</p>
		</div>

	</div>
		
		<br/>
		<div id="foot" align="center" style="position:absolute">
			Copyright @Monkeys' Auto Parts
		</div>
	</body>
	
	<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
	<script type="text/javascript" src="js/common.js"></script>
	<script type="text/javascript" src="js/header.js"></script>
	
	<script>
		var partId = <?php echo $autopart["partId"]?>;
		var inStock = <?php echo $autopart["inStock"]?>;
		function addToCar(){
			var n = $("#qty").val();
			if(isNaN(n)){
				alert("the quality should a digit number");
				return;
			}
			n = Math.floor(n);
			if(n>inStock){
				alert("no enough items to add in shopping cart");
				return;
			}
			if(n<=0){
				alert("the number should larger than 0");
				return;
			}
			$.ajax({
				method:"GET",
				data:{id:partId,num:n},
				dataType:"json",
				url:"shoppingCar.php",
				success:function(data){
					alert("Successfully add this item to shopping cart");
				}
			});
		}
	</script>
</html>