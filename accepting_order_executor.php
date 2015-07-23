<?php

	require_once 'functions.php';

	if (is_executor_cookies_correct() === false) {
		header("Location: index.php");
	} else {

		if ((is_array_have_empty_values($_GET)) || (count($_GET) != 1)) {
			// empty values or more than 1 variable in $_GET
			header("Location: find_work_executor.php"); 
		}

		if (intval($_GET['id'])) {

			// request for DB, setting order status4

			$order_id = $_GET['id'];
			$conn = new PDO('mysql:host=localhost;dbname=exchange', DB_USERNAME, DB_PASSWORD);
	    	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);		
			$query_for_getting_order_executors = $conn->prepare('SELECT executors_id FROM orders WHERE id = :order_id');		
			$query_for_getting_order_executors->bindValue(':order_id', $order_id);
			$query_for_getting_order_executors->execute();
			$order_executors = $query_for_getting_order_executors->fetchAll();		
			$order_executors = $order_executors[0]['executors_id'];
			$order_executors = explode(",", $order_executors);
			


			//header("Location: order_page_executor.php?id=" . $order_id);

		} else {
			header("Location: find_work_executor.php"); 
		}

	}


?>


