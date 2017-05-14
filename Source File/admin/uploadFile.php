<?php
  
  
	
	function upload(){
		$dir = "../upload/";
		$dbdir = "/upload/";
		 if ($_FILES["file"]["error"] > 0)
		{
			return "null";
		}
		else
		{
			while (file_exists($dir . $_FILES["file"]["name"]))
			{
				$r = rand(10,10000000);
				$_FILES["file"]["name"] = $r.".jpg";
			}
			move_uploaded_file($_FILES["file"]["tmp_name"],
			$dir . $_FILES["file"]["name"]);
			return $dbdir . $_FILES["file"]["name"];
		}
		return "null";
	}
  

?>