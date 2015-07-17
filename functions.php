<?php


function is_client_cookies_correct() {
	if (!empty($_COOKIE["ExchangeService"])) {
		
		// check hash in cookies with hash in DataBase	

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
			return true;
		} else {
			// incorrect hash in cookies			
			return false;
		}

	} else {
		// cookies is empty
		return false;
	}
}


function is_executor_cookies_correct() {
	if (!empty($_COOKIE["ExchangeService"])) {
		
		$db_username = "root";
	   	$db_password = "";		  			   
	   	$cookie_password = $_COOKIE["ExchangeService"];

	    $conn = new PDO('mysql:host=localhost;dbname=exchange', $db_username, $db_password);
	    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);						    

	    $query_for_check_password = $conn->prepare('SELECT * FROM executor WHERE executor.password = :password');						
		$query_for_check_password->bindValue(':password', $cookie_password);	
		$query_for_check_password->execute();
		$query_res_for_password = $query_for_check_password->fetchAll();	


		if (!empty($query_res_for_password)) {			
			return true;
		} else {			
			// incorrect hash in cookies
			return false;
		}

	} else {	
		// cookies is empty	
		return false;
	}
}


function is_array_have_empty_values($array) {
	foreach ($array as $key => $value) {
		if (empty($value)) {
			return true;
		} 
	}

	return false;
}



?>