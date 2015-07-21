<?php

	define('DB_USERNAME', 'root');
	define('DB_PASSWORD', '');
	
	function is_client_cookies_correct() {
		if (!empty($_COOKIE["ExchangeService"])) {
			
			// check hash in cookies with hash in DataBase	
		  			   
		   	$cookies_password = $_COOKIE["ExchangeService"];

		    $conn = new PDO('mysql:host=localhost;dbname=exchange', DB_USERNAME, DB_PASSWORD);
		    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);						    

		    $query_for_check_password = $conn->prepare('SELECT * FROM client WHERE client.password = :password');						
			$query_for_check_password->bindValue(':password', $cookies_password);	
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
					  			   
		   	$cookies_password = $_COOKIE["ExchangeService"];

		    $conn = new PDO('mysql:host=localhost;dbname=exchange', DB_USERNAME, DB_PASSWORD);
		    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);						    

		    $query_for_check_password = $conn->prepare('SELECT * FROM executor WHERE executor.password = :password');						
			$query_for_check_password->bindValue(':password', $cookies_password);	
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


	function get_client_orders() {
		try {

			$cookies_password = $_COOKIE["ExchangeService"];
			$conn = new PDO('mysql:host=localhost;dbname=exchange', DB_USERNAME, DB_PASSWORD);
	    	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);			    	
	    	
	    	$query_for_getting_client_id = $conn->prepare('SELECT client.id FROM client WHERE client.password = :password');						
			$query_for_getting_client_id->bindValue(':password', $cookies_password);	
			$query_for_getting_client_id->execute();
			$query_result_for_getting_client_id = $query_for_getting_client_id->fetchAll();

			$client_id = $query_result_for_getting_client_id[0][0];
	    	
			$query_for_getting_client_order = $conn->prepare('SELECT * FROM orders WHERE client_id = :client_id');		
			$query_for_getting_client_order->bindValue(':client_id', $client_id);
			$query_for_getting_client_order->execute();
			$client_orders = $query_for_getting_client_order->fetchAll();

			if (empty($client_orders)) {
				return 0;
			} else {
				return $client_orders;
			}

		} catch(PDOException $e) {
		    return 0;
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