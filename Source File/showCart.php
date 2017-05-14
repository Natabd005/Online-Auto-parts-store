<?php
	session_start();
	$books = array();
	if(isset($_SESSION["car"])){
		$books = $_SESSION["car"];
	}
	$total = 0;
	$totalPrice = 0;
	foreach($books as $book){
		
		$total += $book["num"];
		$totalPrice +=($book["num"]*$book["price"]);
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<title> Shopping Cart </title>
		<link rel="stylesheet" type="text/css" href="css/foot.css"></style>
		<link rel="stylesheet" type="text/css" href="css/header.css"></style>
		<link rel="stylesheet" type="text/css" href="css/shoppingCart.css"></style>
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
		
		

	<br/><br/>
		<h2>&nbsp;Shopping Cart</h2><br/>
		<div style="min-height:270px">
		<table>

		  <tr>
			<th id="spec" class="des" colspan="2">ITEM DESCRIPTION</th>
			<th>STATUS</th>
			<th>QTY</th>
			<th>PRICE</th>
		  </tr>
			
			<?php
				foreach($books as $book){
					echoTr($book);
				}
				
				function echoTr($book){
					echo '<tr id="'.$book["partId"].'">';
					echo '<td class="des" style="width:39px"> <img src="'.$book["pictureUrl"].'" alt="picture" height=80px/> </td>';
					echo '<td class="des" style="width:250px"><p><span>'.$book["partName"].'</span><br/> by '.$book["manufacturer"].'<br/>partId:'.$book["partId"].'<br/></br> <button onclick="del('.$book["partId"].','.$book["num"].')"> REMOVE </button></p></td>';
					echo '<td>In Stock</td>';
					echo '<td>';
					echo '<input type="text" class="'.$book["partId"].'" name="qty" value="'.$book["num"].'" style="width:35px; text-align: center">';
					echo '<td>$'.$book["price"].'</td>';
					echo '</tr>';
		
				}
			?>
			
		</table> 
		</div>

		<br/>

		<p id="total">SUBTOTAL: $<span><?php echo $totalPrice ?></span> </p>

		<button id="checkout" onclick="checkout();"> CHECKOUT </button>

		<br/><br/><br/><br/><br/><br/>
		
		<div id="foot" align="center" style="position:absolute">
			Copyright @Monkeys' Auto Parts
		</div>
	
	</body>
	<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
	<script type="text/javascript" src="js/common.js"></script>
	<script type="text/javascript" src="js/header.js"></script>
	<script>
	
		var total = <?php echo $total?>;
	
		$("document").ready(function(){
			$("input").on("input",onChange);
			$("input").blur(onBlur);
		});
		
		
		function del(isbn,n){
			n = 0-n;
			var is = "#" + isbn;
			$.ajax({
				method:"GET",
				data:{id:isbn,num:n,opt:"del"},
				dataType:"json",
				url:"shoppingCar.php",
				success:function(data){
					$(is).remove();
					updateTotal(eval(data));
				}
			});
		}
		
		function onChange(){
			var isbn = $(this).attr("class");
			update(isbn);
		}
		
		function onBlur(){
			
			var n = $(this).val();
			n = Math.floor(n);
			$(this).val(n);
			if(isNaN(n)||n==""){
				$(this).val(0);
			}
			
			
		}
		
		function update(isbn){
			var is ="#" + isbn + " input";
			var n = $(is).val();
			if(isNaN(n)){
				return;
			}
			n = Math.floor(n);
			$.ajax({
				method:"GET",
				data:{id:isbn,num:n,opt:"set"},
				dataType:"json",
				url:"shoppingCar.php",
				success:function(data){

					var data = eval(data);
					updateTotal(eval(data));
					var r = data["num"];
					r = new Number(r);

					$(is).val(r);
				}
			});
		}
		
		function updateTotal(data){
			
			total = data["total"];

			var totalPrice = data["totalPrice"];

			$("#total span").text(totalPrice);
		}
		
		function checkout(){
			if(total==0){
				alert("your shopping cart is empty");
				return;
			}
			window.location = "placeOrder.php";
		}
	</script>
	
</html>



