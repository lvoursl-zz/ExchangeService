<?php

	require_once 'functions.php';

	if (is_executor_cookies_correct() === false) {
		header("Location: index.php");
	} else {
		$error_message = "";

		if ($_GET) {		
			if ((is_array_have_empty_values($_GET) === false) && ($_GET['submit'] === 'submitted') && 
				(intval($_GET['order_section'])) && (count($_GET) == 2)) {
				
				try {
					$section = $_GET['order_section'];
					$conn = new PDO('mysql:host=localhost;dbname=exchange', DB_USERNAME, DB_PASSWORD);
			    	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);			    	
			    	
					$query_for_getting_orders = $conn->prepare('SELECT * FROM orders WHERE section = :section');		
					$query_for_getting_orders->bindValue(':section', $section);
					$query_for_getting_orders->execute();
					$orders = $query_for_getting_orders->fetchAll();

				} catch(PDOException $e) {
				    $error_message = "Упс, ошибка подключения";
				}

			} else {
				// incorrect input!
				$error_message = "Проверьте свои входные данные";
			}

		}

	}

?>


<html>
	<body>
		<div align="center">
			<p>Поиск заказов</p>
			<hr>
			Найти заказ
			<a href="executor_completed_orders.php">Мои выполненные заказы</a>
			<a href="home_page_executor.php">Моя страница</a>			
			<a href="logout.php">Выход</a>
			<hr>
			<?php echo $error_message; ?>
			Найти заказы из раздела:
			<form method="GET">
				<select name="order_section">
				    <option disabled>Выберите раздел</option>
				    <option value="1">Раздел0</option>
				    <option value="2">Раздел1</option>
				    <option value="3">Раздел2</option>
				    <option value="4">Раздел3</option>
				</select>
				<button name="submit" type="submit" value="submitted">Найти!</button>
			</form>
			
			<?php

				if (empty($orders)) {
					echo "Сейчас нет заказов по этому направлению";		
				} else {
					$array_length = count($orders);
					
					for ($i = 0; $i < $array_length; $i++) { 
						echo '<a href="order_page_executor.php?id=' . $orders[$i]['id'] . '">'. $orders[$i]['name']  . '</a>' . '<br>'; 							
					}
				}

			?>
		</div>
	</body>
</html>