<?php

	require_once 'functions.php';

	if (is_client_cookies_correct() === false) {
		header("Location: index.php");
	} else {
		
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

		} catch(PDOException $e) {
		    $error_message = "Проблемы с подключением к базе данных";
		}

	}


?>

<html>
	<body>
		<div align="center">
			<p>Мои заказы</p>
			<hr>
			<a href="create_order.php">Создать заказ</a>
			<a href="home_page_client.php">Моя страница</a>
			Мои заказы
			<a href="logout.php">Выход</a>
			<br>
			<?php
				if (count($client_orders) == 0)  {
					echo "В данный момент у вас нет заказов";
				} else {
					//echo "zazaza $client_orders[0]['name']";
					echo $client_orders[0]['description'];
				}

			?>
		</div>
	</body>
</html>