<?php
	session_start();
	
	include "php/database.php";
	
	if(!isset($_GET["id"])){
		exit();
	}

	
	
	$id = $_GET["id"];
	
	$num = $_GET["num"];
	
	
	$books  = array();
	$book = array();
	if(isset($_SESSION["car"])){
		$books = $_SESSION["car"];
	}
	if(isset($books[$id])){
		$book = $books[$id];
	}else{
		$db = new database;	
		$sql = "select * from autopart where partId = '".$id."';";
		$db_books = $db->select($sql);
		if(count($db_books) ==0){
			exit();
		}
		$book = $db_books[0];
	}
	
	if(isset($_GET["opt"])){
		if($_GET["opt"]=="del"){
			del($books,$id);
		}else if($_GET["opt"] == "set"){
			$num = set($books,$book,$num);
		}
	}else{
		$num = add($books,$book,$num);
	}
	echo json_encode(finish($num));
	
	function add($books,$book,$num){
		if(!isset($book["num"])){
			$book["num"] = 0;
		}
		$num += $book["num"];
		return set($books,$book,$num);
	}
	
	function del($books,$id){
		unset($books["$id"]);
		$_SESSION["car"] = $books;
	}
	
	function set($books,$book,$num){
		if($num == 0){
			del($books,$book["partId"]);
			return;
		}
		if($book["inStock"]<$num){
			$num =$book["inStock"];
		}
		$book["num"] = $num;
		$books[$book["partId"]] = $book;
		$_SESSION["car"] = $books;
		return $num;
	}
	
	function finish($num){
		$books = $_SESSION["car"];
		$total = 0;
		$totalPrice = 0;
		foreach($books as $book){
			$total += $book["num"];
			$totalPrice +=($book["num"]*$book["price"]);
		}
		$res = array();
		$res["total"] = $total;
		$res["totalPrice"] = $totalPrice;
		$res["num"] =$num;
		return $res;
	}
	

?>