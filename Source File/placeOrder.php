
<?php
	
	include "php/loginStatus.php";
	
	$ls = new loginStatus;
	if(!$ls->check()){
		header("Location:login.html");
	}
	
	session_start();
	
	if(!isset($_SESSION["car"])){
		header("Location:/index.php");
	}
	
	$autoparts = $_SESSION["car"];
	
	$total = 0;
	$totalPrice = 0;
	foreach($autoparts as $autopart){
		
		$total += $autopart["num"];
		$totalPrice +=($autopart["num"]*$autopart["price"]);
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<title> Place Order </title>
		<link rel="stylesheet" type="text/css" href="css/placeOrder.css"></style>
		<link rel="stylesheet" type="text/css" href="css/foot.css"></style>
		<link rel="stylesheet" type="text/css" href="css/header.css"></style>
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
		<h2>SECURE CHECKOUT</h2>

		<div id="main" style="overflow:false">

		<div id="left">

			<div id="userInput">
				
				<h3>SHIPPING ADDRESS</h3/><br/>

				<form id="checkOutFrom" action="checkOut.php" method="POST">
					First Name: <br/><input class="ui" type="text" name="fname" id="firstname"><br><br>
					Last Name: <br/><input class="ui" type="text" name="lname" id="lastname"><br><br>
					<br/>
					Address: <br/><input class="ui" type="text" name="address" id="address"><br><br>
					State: <br/><input class="ui" type="text" name="state" id="state"><br><br>
					Postal Code: <br/><input class="ui" type="text" name="zip" id="zcode"><br><br>
				</form>

			</div>

			<br/>

			<hr/>

			<h3>SHIPPING METHOD</h3><br/>
			<P>Free 2-Day Shipping </P><br/>

			<br/>

			<hr/>

			<h3>PAYMENT</h3><br/>
			Card Number:<br/>
			<input class="ui" type="text" name="cardNo" value="0000 0000 0000 0000"><br/><br/>
			Payment Type:<br/>
			<input class="ui" type="text" name="payType" value="Visa"><br/><br/>
			Expire Month:<br/>
			<input class="ui" type="text" name="eMonth" value="XXX"><br/><br/>
			Expire Year:<br/>
			<input class="ui" type="text" name="eYear" value="2017"><br/><br/>
			Security Code:<br/>
			<input class="ui" type="text" name="sCode" value="000"><br/><br/>

			<br/>

			<hr/>

			<p id="check">Before submitting order, please check it carefully.</p><br/><br/>

			<button id="place" onclick="placeOrder();"> PLACE MY ORDER </button><br/>

		</div>

		<div id="right">
			<h3>SUMMARY</h3/><br/>

			<table>

				<tr>
					<td>Merchandise Total:</td>
					<td class="money">$<?php echo $totalPrice ?> </td>
				</tr>

				<tr>
					<td>Shipping & Handling:</td>
					<td class="money">$ 0.00</td>
				</tr>

				<tr>
					<td>Estimated Tax:</td>
					<td class="money">$ 0.00</td>
				</tr>

				<tr style="font-weight:bold; font-size:16px; height:52px">
					<td>ORDER TOTAL:</td>
					<td class="money">$<?php echo $totalPrice?> </td>
				</tr>
			</table>
		</div>

		</div>

		<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
		<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
		<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
		<br/><br/><br/><br/><br/><br/><br/><br/><br/>
		
		
		<div id="foot" align="center" style="position:absolute">
			Copyright @Monkeys' Auto Parts
		</div>
	</body>
	
	<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
	<script type="text/javascript" src="js/common.js"></script>
	<script type="text/javascript" src="js/header.js"></script>
	
	<script>
		function placeOrder(){
			if(checkInput()){
				$("#checkOutFrom").submit();
			}
		}
		
		function checkInput(){
			if(!$("#firstname").val()){
				alert("please input the first name");
				return false;
			}
			if(!$("#lastname").val()){
				alert("please input the last name");
				return false;
			}
			if(!$("#address").val()){
				alert("please input the address");
				return false;
			}
			if(!$("#state").val()){
				alert("please input the state");
				return false;
			}
			if(!$("#zcode").val()){
				alert("please input the zip code");
				return false;
			}
			return true;
		}
	</script>
</html>



