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

			$order_id = $_GET['id'];

			$conn = new PDO('mysql:host=localhost;dbname=exchange', DB_USERNAME, DB_PASSWORD);
	    	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);		
			$query_for_getting_order = $conn->prepare('SELECT * FROM orders WHERE id = :order_id');		
			$query_for_getting_order->bindValue(':order_id', $order_id);
			$query_for_getting_order->execute();
			$order = $query_for_getting_order->fetchAll();		
			$order_executors_id = $order[0]['executors_id'];
			$order_executors_id = explode(",", $order_executors_id);

			if (!empty($order)) {
				
				//take executors list and check current executor in list
				$cookies_password = $_COOKIE["ExchangeService"];

				$query_for_getting_current_executor_data = $conn->prepare('SELECT id FROM executor WHERE password = :cookies_password');
				$query_for_getting_current_executor_data->bindValue(':cookies_password', $cookies_password);
				$query_for_getting_current_executor_data->execute();

				$current_executor_id = $query_for_getting_current_executor_data->fetchAll();
				$current_executor_id = $current_executor_id[0]['id'];

				if (isset($current_executor_id)) {
					
					$current_executor_accepted_order = false;
					$order_executors_id_length = count($order_executors_id);

					for ($i = 0; $i < $order_executors_id_length; $i++) { 
						if ($current_executor_id == $order_executors_id[$i]) {
							$current_executor_accepted_order = true;
							break;
						}
					}

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


<html>
	<body>
		<div align="center">
			<h2>Страница исполнителя</h2>
			<p>Страница заказа</p>
			<hr>
			<a href="find_work_executor.php">Найти заказ</a>
			<a href="executor_completed_orders.php">Мои выполненные заказы</a>
			<a href="home_page_executor.php">Моя страница</a>		
			<a href="logout.php">Выход</a>
			<hr>
			<?php
				echo 'Название: ' . $order[0]['name'] . '<br>';
				echo 'Содержание: ' . $order[0]['description'] . '<br>';
				echo 'Теги: ' . $order[0]['tags'] . '<br>';
				echo 'Статус: ' . $order[0]['status'] . '<br>';
				if ($current_executor_accepted_order) {
					echo 'Вы ответили на этот заказ' . '<br>';
				} else {
					echo '<a href="accepting_order_executor.php?id=' . $order_id . '">'. 'Предложить исполнение заказа'  . '</a>' . '<br>';
				}
			?>
		</div>
	</body>
</html>