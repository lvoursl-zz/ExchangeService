<?php

	require_once 'functions.php';

	if (is_client_cookies_correct() === false) {
		header("Location: index.php");
	} else {

		if ((is_array_have_empty_values($_GET)) || (count($_GET) != 1)) {
			// empty values or more than 1 variable in $_GET
			header("Location: client_orders.php"); 
		}

		if (intval($_GET['id'])) {
			// we can convert id to int
			
			$client_orders = get_client_orders(); // get all client orders
			$array_length = count($client_orders);

			// find requested order(which is in $_GET) in client orders			
			$requested_order_in_clients_orders = false;
			for ($i = 0; $i < $array_length; $i++) { 
				if ($client_orders[$i]['id'] == $_GET['id']) {
					$requested_order_in_clients_orders  = true;
					$requested_order_id = $i;
					break;
				}
			}

			if ($requested_order_in_clients_orders == true) {
				// requested order is list of client orders, lets find executors for this order

				// create executors IDs array
				$executors_id = $client_orders[$requested_order_id]['executors_id'];
				$executors_id = explode(",", $executors_id);

				$conn = new PDO('mysql:host=localhost;dbname=exchange', DB_USERNAME, DB_PASSWORD);
	    		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);	

	    		$executors_id_length = count($executors_id);
	    		for ($i = 0; $i < $executors_id_length; $i++) { 
	    			$executor_id = $executors_id[$i];
	    			$query_getting_executor_data = $conn->prepare('SELECT * FROM executor WHERE id = :executor_id');
	    			$query_getting_executor_data->bindValue(':executor_id', $executor_id);
	    			$query_getting_executor_data->execute();
	    			
	    			$executor_data = $query_getting_executor_data->fetchAll();
	    			$executor_data = $executor_data[0];	    			
	    			$executors_data[] = $executor_data;
	    		}


			} else {
				header("Location: client_orders.php"); 	
			}

		} else {			
			header("Location: client_orders.php"); 			
		}
		
	
	}


?>

<html>
	<body>
		<div align="center">
			<p>Страница заказчика</p>
			<hr>
			<a href="create_order.php">Создать заказ</a>
			<a href="home_page_client.php">Моя страница</a>
			<a href="client_orders.php">Мои заказы</a>
			<a href="logout.php">Выход</a>
			<hr>
			Информация о Вашем заказе
			<br>
			<?php
				echo 'Название: ' . $client_orders[$requested_order_id]['name'] . '<br>';
				echo 'Содержание: ' . $client_orders[$requested_order_id]['description'] . '<br>';
				echo 'Теги: ' . $client_orders[$requested_order_id]['tags'] . '<br>';
				
				if (!empty($executors_data)) {
					echo "На ваш заказ откликнулись:" . '<br>';

					$executors_data_length = count($executors_data);
					
					for ($i = 0; $i < $executors_data_length; $i++) { 
						echo 'Компания:' . $executors_data[$i]['name']	. '<br>';
					}
				}

			?>
		</div>
	</body>
</html>