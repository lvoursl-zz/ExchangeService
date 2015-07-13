<?php

	if (!is_null($_COOKIE["ExchangeService"])) {
		// check cookies with hash in DataBase
			
		$db_username = "root";
	   	$db_password = "";		  			   
	   	$cookie_password = $_COOKIE["ExchangeService"];

	    $conn = new PDO('mysql:host=localhost;dbname=exchange', $db_username, $db_password);
	    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);						    

	    $query_for_check_password = $conn->prepare('SELECT * FROM client WHERE client.password = :password');						
		$query_for_check_password->bindValue(':password', $cookie_password);	
		$query_for_check_password->execute();
		$query_res_for_password = $query_for_check_password->fetchAll();	


		if (!empty($query_res_for_password)) {
			echo "HOMEPAGE Welcome";
		} else {
			header("Location: index.php");	
		}

	} else {
		header("Location: index.php");
	}
?>
