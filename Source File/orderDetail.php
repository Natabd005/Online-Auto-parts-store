
<?php
			
			include "php/loginStatus.php";
			$ls = new loginStatus;
			if(!$ls->check()){
				header("Location:/login.html");
			}
			if(!isset($_GET["orderId"])){
				header("Location:/error.html");
			}

			$orderId = $_GET["orderId"];
			$sql = "select * from orderdetails join autopart on orderdetails.partId = autopart.partId where orderId = '".$orderId."';";

			$db = new database;
			$details = $db->select($sql);
			$length = count($details);
			if($length==0){
				header("Location:/error.html");
			}
			$sql2 = "select * from orders where orderId = '".$orderId."';";
			$order = $db->select($sql2);
			$price = $order[0]["totalPrice"];
			$d = $order[0]["Date"];
			$d = strtotime($d);
			
			$d = date("m-d-Y",$d);

?>
<!DOCTYPE html>
<html>
	<head>
		<title> Order Detail </title>

		<link rel="stylesheet" type="text/css" href="css/foot.css"></style>
		<link rel="stylesheet" type="text/css" href="css/header.css"></style>
		<link rel="stylesheet" type="text/css" href="css/orderDetail.css"></style>

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

		<div id="main" style="overflow:hidden">

			<div id="right">

				<h3 style="margin-bottom:10px">ORDER DETAILS</h3>

				<hr/><br/><br/>

				<div class="detail">
					<div class="dateNo">
						<h3>Ordered on <?php echo $d?>  &nbsp;&nbsp;|&nbsp;&nbsp;  Order# <?php echo $orderId?></h3>
					</div>

					<div class="content">

						<div id="summary">	
							<h4>ORDER SUMMARY</h4>

							<table>
								<tr>
									<td>Item(s) Subtotal:</td>
									<td class="price"><?php echo $price?></td>
								</tr>

								<tr>
									<td>Shipping & Handling:</td>
									<td class="price">$0.00</td>
								</tr>

								

								<tr>
									<td>Total before tax:</td>
									<td class="price">$<?php echo $price?></td>
								</tr>

								<tr>
									<td>Sales Tax:</td>
									<td class="price">$0</td>
								</tr>
								
								<tr></tr><tr></tr><tr></tr><tr></tr>

								<tr style="font-weight:bold">
									<td>Grand Total:</td>
									<td class="price">$<?php echo $price?></td>
								</tr>
							</table>
							
						</div>

						<div id="all">
							
							<h4>ITEM(S) IN THIS ORDER </h4>
							<?php
								foreach($details as $detail){
									echo '<div class="item">
								<hr style="border-color:white; width:575px; padding-left:0px; margin-right:500px; margin-top:15px"/>

								<img src="'.$detail["pictureUrl"].'" alt="'.$detail["partName"].'"/>

								<div class="des">
									<p style="font-size:18px; font-weight:bold">'.$detail["partName"].'</p>
									<p style="margin-bottom:12px">'.$detail["manufacturer"].'</p>
									<p>partId: '.$detail["partId"].'</p>
									<P>QTY: '.$detail["quanity"].'</P>
									<p>Price: $'.$detail["price"].'</p>
								</div>
							</div>';
								}
							?>
							

						</div>
					
					</div>
				</div>

			</div>

		</div>

		<br/><br/>

		<div id="foot" align="center" style="position:absolute">
			Copyright @Monkeys' Auto Parts
		</div>

	
	</body>
	
	<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
	<script type="text/javascript" src="js/header.js"></script>
	<script type="text/javascript" src="js/common.js"></script>
</html>



