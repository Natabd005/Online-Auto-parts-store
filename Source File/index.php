<!DOCTYPE html>

<html>

	<head>
		<title> Home Page </title>
		
		<link rel="stylesheet" type="text/css" href="css/foot.css"></style>
		<link rel="stylesheet" type="text/css" href="css/header.css"></style>
		<link rel="stylesheet" type="text/css" href="css/home.css"></style>
		
		
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
		
		<?php
			include "php/database.php";
			if(isset($_GET["category"])&&$_GET["category"]!=0){
				$categoryId = $_GET["category"];
				if(isset($_GET["keyword"])){
					$keyword = $_GET["keyword"];
					$sql = "select autopart.partId,partName,price,listPrice,manufacturer,date(updateTime) as updateTime,pictureUrl from autopart join autopartcategory on autopart.partId = autopartcategory.partId where categoryId ='".$categoryId."' and partName like '%".$keyword."%';";
				}else{
					$sql = "select autopart.partId,partName,price,listPrice,manufacturer,date(updateTime) as updateTime,pictureUrl from autopart join autopartcategory on autopart.partId = autopartcategory.partId where categoryId ='".$categoryId."' order by updateTime;";
				}
				
			}else{
				if(isset($_GET["keyword"])){
					$keyword = $_GET["keyword"];
					$sql = "select partId,partName,price,listPrice,manufacturer,date(updateTime) as updateTime,pictureUrl from autopart where partName like '%".$keyword."%' order by updateTime desc";
				}else{
					$sql = "select partId,partName,price,listPrice,manufacturer,date(updateTime) as updateTime,pictureUrl from autopart order by updateTime desc";
				}
				
			}
			
			$db = new database;
			$autoparts = $db->select($sql);
		?>
		
		<div id="home" style="overflow:false;margin:0 auto;width:1000px; min-height:580px">
		<table id="item_list">
			<?php
				$sum = count($autoparts);
				$rows = floor($sum/5);
				for($i = 0; $i<=$rows;$i++){
					echoTR($autoparts,$i,$rows==$i,$i>=3);
				}
				function echoTr($autoparts,$i,$last,$hide){
					$remain = 5;
					if($last){
						$sum = count($autoparts);
						$remain = $sum%5;
					}
					if($hide){
						echo '<tr class="items_row" style="display:none">';
					}else{
						echo '<tr class="items_row">';
					}
					
					for($j=0;$j<$remain;$j++){
						$autopart = $autoparts[$i*5+$j];
						
						
						echo '<td class="itemcontainer">';
						echo '<div id="item1">';
						echo '<div class="picpart">';
						echo '<a href="/autopart.php?partId='.$autopart["partId"].'"><img src="'.$autopart["pictureUrl"].'" alt="'.$autopart["partName"].'" height="160" width="160"></a>';
						echo '</div>
								<div class="infopart">
								<div id="Diary of a Wimpy Kid: Old School">
									<a href="/autopart.php?partId='.$autopart["partId"].'" title="'.$autopart["partName"].'">
									<span class="midsize">'.$autopart["partName"].'</span>
									</div>

									<div class="author-date">
									'.$autopart["manufacturer"].'<br/>
									<span class="letterspace"></span><span class="smallsize date_color">'.$autopart["updateTime"].'</span>
									</div>
									</a>
								<div id="price1">
								<span class="sale_price">$'.$autopart["price"].'</span>
								<span class="original_price">$'.$autopart["listPrice"].'</span>
								
								
								</div>
									<div>
										<button type="button" onclick="addToCar('.$autopart["partId"].',1);">add to cart</button>
									</div>
								</div>
								</div>
								</td>';
								
								
					}
					echo '</tr>';
					
				}
			?>
			
		</table>
		<br/>
		<div style="float:right">
			<button class="control" onclick="pre();">previous page</button>
			<button class="control" onclick="next();">next page</button>
		</div>
		</div>
		<br/>
		<br/>
		<div id="foot" align="center" style="position:absolute">
			Copyright @Monkeys' Auto Parts
		</div>
	</body>
	<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
	<script type="text/javascript" src="js/header.js"></script>
	<script type="text/javascript" src="js/common.js"></script>
	 <script src="js/jquery.fly.min.js"></script>
	
	<script>
		var current = 0;
		var total = 0;
		var maxIndex = 0;
		$("document").ready(function(){
			total = $("tr").length -1;
			maxIndex = Math.floor(total/3);
			if(maxIndex==0){
				$(".control").hide();
			}
		});
		function pre(){
			if(current>0){
				current--;
				$("tr").hide();
				$($("tr")[current*3]).show();
				$($("tr")[current*3+1]).show();
				$($("tr")[current*3+2]).show();
			}
		}
		
		function next(){
			if(current<maxIndex){
				current++;
				$("tr").hide();
				$($("tr")[current*3]).show();
				$($("tr")[current*3+1]).show();
				$($("tr")[current*3+2]).show();
			}
		}
		var img;
		function addToCar(partId,n){
			
			$.ajax({
				method:"GET",
				data:{id:partId,num:n},
				dataType:"json",
				url:"shoppingCar.php",
				success:function(data){
					alert("Successfully add this item to shopping car");
					
				}
			});
		}
		
		function fly(left,top){
			
			var offset = $("#account_info").offset();
			
			var flyer = $('<img style="display:block;width:50px;height:50px"class="flyer-img" src="/upload/1.jpg" style="">');
			flyer.fly({
				start:{
					left:left,
					top:top
				},
				end:{
					left:offset.left+200,
					top:offset.top,
				},
				onEnd:function(){
					this.destory();
				}
			});
		}
			
	</script>
	
	
</html>