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

			// add current executor to order executors list

			$order_id = $_GET['id'];
			$cookies_password = $_COOKIE["ExchangeService"];

			$conn = new PDO('mysql:host=localhost;dbname=exchange', DB_USERNAME, DB_PASSWORD);
	    	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);		
			$query_for_getting_order_executors = $conn->prepare('SELECT executors_id FROM orders WHERE id = :order_id');		
			$query_for_getting_order_executors->bindValue(':order_id', $order_id);
			$query_for_getting_order_executors->execute();
			
			$order_executors = $query_for_getting_order_executors->fetchAll();					
			$order_executors_id = $order_executors[0]['executors_id'];
			$order_executors_id = explode(",", $order_executors_id);						


			$query_for_getting_current_executor_data = $conn->prepare('SELECT id FROM executor WHERE password = :cookies_password');
			$query_for_getting_current_executor_data->bindValue(':cookies_password', $cookies_password);
			$query_for_getting_current_executor_data->execute();

			$current_executor_id = $query_for_getting_current_executor_data->fetchAll();
			$current_executor_id = $current_executor_id[0]['id'];			

			
			if (isset($current_executor_id)) {				
			
				$first_answer_to_order = true;
				$order_executors_id_length = count($order_executors_id);

				for ($i = 0; $i < $order_executors_id_length; $i++) { 
					if ($order_executors_id[$i] === $current_executor_id) {
						$first_answer_to_order = false;
						break;
					}
				}

				if ($first_answer_to_order == true) {

					if (empty($order_executors_id[0])) {
						$order_executors_id[0] = $current_executor_id;
					} else {
						$order_executors_id[] = $current_executor_id;						
					}
					$order_executors_id = implode(",", $order_executors_id);

					$query_for_add_current_executor = $conn->prepare('UPDATE orders SET executors_id = :order_executors_id WHERE id = :order_id');
					$query_for_add_current_executor->bindValue(':order_executors_id', $order_executors_id);
					$query_for_add_current_executor->bindValue(':order_id', $order_id);
					$query_for_add_current_executor->execute();
					header("Location: order_page_executor.php?id=" . $order_id);
				} else {
					header("Location: find_work_executor.php"); 
				}

			} else {
				header("Location: find_work_executor.php"); 
			}

		} else {
			header("Location: find_work_executor.php"); 
		}

	}


?>


