<?php
	class database
	{
		
		function getCon(){
			$con=mysqli_connect("localhost","root","root","auto_part_store_new");
			if(mysqli_connect_errno()){
				echo "Fail to connect to MYSQL".mysqli_connect_error();
			}
			return $con;
		}
		
		
		function select($sql)
		{
			$con = $this->getCon();
			$result = mysqli_query($con,$sql);
			$allResult = array();
			if(!empty($con->error)){
				echo "sql error";
				return $allResult;
			}
			
			
			while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
				$allResult[] = $row;
			}

			mysqli_close($con);
			return $allResult;
		}
		

		function modify($sql){
			$con = $this->getCon();
			$result = mysqli_query($con,$sql);
			if(!empty($con->error)){

				return -1;
			}
			$count = mysqli_affected_rows($con);

			mysqli_close($con);
			return $count;
		}

		function makeInsertSql($tableName,$array){
		    $sql = "insert into ". $tableName. " values(";
			$length = count($array);
			for($i=0;$i<$length;$i++){
				$sql = $sql."'";
				$sql = $sql.$array[$i];
				$sql = $sql."'";
				if($i<$length-1){
					$sql =$sql.",";
				}
			}
			$sql = $sql.");";
			
			return $sql;
		}
		
		function makeInsertSqlWithPrefix($tableName,$array,$prefix){
			$sql = "insert into ".$tableName.$prefix."values(";
			$length = count($array);
			for($i=0;$i<$length;$i++){
				$sql = $sql."'";
				$sql = $sql.$array[$i];
				$sql = $sql."'";
				if($i<$length-1){
					$sql =$sql.",";
				}
			}
			$sql = $sql.");";
			return $sql;
		}
		
		function modify_Id($sql){
			$con = $this->getCon();
			$result = mysqli_query($con,$sql);
			if(!empty($con->error)){

				return -1;
			}
			$id = mysqli_insert_id($con);

			mysqli_close($con);
			return $id;
		}
		
		
		function makeReplaceSqlWithPrefix($tableName,$array,$prefix){
			$sql = "Replace into ".$tableName.$prefix."values(";
			$length = count($array);
			for($i=0;$i<$length;$i++){
				$sql = $sql."'";
				$sql = $sql.$array[$i];
				$sql = $sql."'";
				if($i<$length-1){
					$sql =$sql.",";
				}
			}
			$sql = $sql.");";
			return $sql;
		}
		
		function makeReplaceSql($tableName,$array){
		    $sql = "insert into ". $tableName. " values(";
			$length = count($array);
			for($i=0;$i<$length;$i++){
				$sql = $sql."'";
				$sql = $sql.$array[$i];
				$sql = $sql."'";
				if($i<$length-1){
					$sql =$sql.",";
				}
			}
			$sql = $sql.");";
			
			return $sql;
		}
		
		
	}
	

?>