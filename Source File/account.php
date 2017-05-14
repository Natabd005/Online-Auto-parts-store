

<!DOCTYPE html>
<html>
	<head>
		<title> My Account </title>
		<link rel="stylesheet" type="text/css" href="css/foot.css"></style>
		<link rel="stylesheet" type="text/css" href="css/header.css"></style>
		<link rel="stylesheet" type="text/css" href="css/account.css"></style>
	</head>

	<body>
		<div id="banner">
			<div id="logo">
				<a id="home" target="mainFrame" href="index.php">Monkeys' Auto Part</a>
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
			
			include "php/loginStatus.php";
			$ls = new loginStatus;
			if(!$ls->check()){
				header("Location:/login.html");
			}
			
			$email = $_COOKIE["email"];
			$sql = "select orderId, date(Date) as Date, totalPrice from orders where email = '".$email."' order by orderId desc;";
			$db = new database;
			$orders = $db->select($sql);
			$length = count($orders);
		?>
		<div id="main" style="overflow:hidden;min-height:540px">

			<div id="right">

				<h3 style="margin-bottom:10px">PURCHASE HISTORY</h3>

				<hr/><br/><br/>
				<?php
					if($length==0){
						echo '<p>Your order history is empty</p>';
						//exit();
					}else{
						foreach($orders as $order){
						echoOrder($order);
					}
					}
					
					
					function echoOrder($order){
						echo '<div class="record">
					<div class="orderNo">
						<h3>Order Number: '.$order["orderId"].'</h3>
					</div>

					<div class="content">
						<table>
							<tr>
								<td>Placed:</td>
								<td style="text-align:right">'.$order["Date"].'</td>
								<td rowspan="2"><button onclick="orderDetails('.$order["orderId"].');"> VIEW ORDER DETAILS </button></td>
							</tr>

							<tr>
								<td>Order Total:</td>
								<td style="text-align:right">$ '.$order["totalPrice"].'</td>
							</tr>
						</table>
					</div><br/>
				</div>';
					}
				?>
				
				
				

				<br/>

			</div>

		</div>

		<br/><br/>
	<div id="foot" align="center" style="position:absolute">
			Copyright @Monkeys' Auto Part
		</div>
	</body>
	<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
	<script type="text/javascript" src="js/header.js"></script>
	<script type="text/javascript" src="js/common.js"></script>
	
	<script>
		function orderDetails(orderId){
			window.location.href = "/orderDetail.php?orderId="+orderId;
		}
	</script>
	
</html>


