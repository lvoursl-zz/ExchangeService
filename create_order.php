<?php

	require_once 'functions.php';

	if (is_client_cookies_correct() === false) {
		header("Location: index.php");
	} else {
		$error_message = "";
		
		if ($_POST) {
			if (is_array_have_empty_values($_POST) === false) {
				
				try {

					$cookies_password = $_COOKIE["ExchangeService"];
					$conn = new PDO('mysql:host=localhost;dbname=exchange', DB_USERNAME, DB_PASSWORD);
			    	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);			    	
			    	
			    	$query_for_getting_client_id = $conn->prepare('SELECT client.id FROM client WHERE client.password = :password');						
					$query_for_getting_client_id->bindValue(':password', $cookies_password);	
					$query_for_getting_client_id->execute();
					$query_result_for_getting_client_id = $query_for_getting_client_id->fetchAll();

					$client_id = $query_result_for_getting_client_id[0][0];
			    	$order_name = $_POST["order_name"];
					$order_description = $_POST["order_description"];	
					$order_section = $_POST["order_section"];
					$order_tags = $_POST["order_tags"];
					$order_status = "created";
					
					$query_for_insert_order = $conn->prepare('INSERT INTO orders (client_id, section, name, description, tags, status) 
													 VALUES (:client_id, :section, :name, :description, :tags, :status)');						
							
					$query_for_insert_order->bindValue(':client_id', $client_id);
					$query_for_insert_order->bindValue(':section', $order_section);
					$query_for_insert_order->bindValue(':name', $order_name);
					$query_for_insert_order->bindValue(':description', $order_description);	
					$query_for_insert_order->bindValue(':tags', $order_tags);	
					$query_for_insert_order->bindValue(':status', $order_status);	
					$query_for_insert_order->execute();

					$error_message = "Ваш заказ успешно добавлен!";
				
				} catch(PDOException $e) {
				    $error_message = "Кажется вы используете в своих данных запрещенные символы";
				}	
				
			} else {
				$error_message = "Заполните все поля заказа";
			}
		}
	}

?>


<html>
	<body>
		<div align="center">
			<p>Создание заказа</p>
			<hr>
			Создать заказ
			<a href="home_page_client.php">Моя страница</a>
			<a href="client_orders.php">Мои заказы</a>
			<a href=""></a>
			<a href="logout.php">Выход</a>
			<hr>
			<?php echo $error_message; ?>
			<form method="post">
				Название:
				<br>
				<textarea cols="35" rows="2" name="order_name"></textarea>
				<br>
				Описание:
				<br>
				<textarea cols="40" rows="10" name="order_description"></textarea>
				<br>
				Раздел:
				<br>
			    <select name="order_section">
			    <option disabled>Выберите раздел</option>
			    <option value="1">Раздел0</option>
			    <option value="2">Раздел1</option>
			    <option value="3">Раздел2</option>
			    <option value="4">Раздел3</option>
			   	</select>
				<br>
				Теги:
				<br>
				<input type="text" name="order_tags">
				<br>
				<br>
				<button name="submit" type="submit" value="submitted">Создать заказ</button>
				<br>
					
			</form>
		</div>
	</body>
</html>