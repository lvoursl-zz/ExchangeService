<?php

	require_once 'functions.php';

	if (is_client_cookies_correct() === false) {
		header("Location: index.php");
	} else {

		$client_orders = get_client_orders();
	
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
			<hr>			
			<?php
				if (empty($client_orders))  {
					echo "В данный момент вы не создали заказов";
				} else {					
					$array_length = count($client_orders);
					//echo $client_orders[0]['description'];
					
					for ($i = 0; $i < $array_length; $i++) { 
						echo '<a href="order_page_client.php?id=' . $client_orders[$i]['id'] . '">'. $client_orders[$i]['name']  . '</a>' . '<br>'; 							
					}
				}

			?>
		</div>
	</body>
</html>