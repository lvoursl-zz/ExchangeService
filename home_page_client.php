<?php

	require_once 'functions.php';

	if (is_client_cookies_correct() === false) {
		header("Location: index.php");
	} else {
		
	}

?>


<html>
	<body>
		<div align="center">
			<p>Страница заказчика</p>
			<hr>
			<a href="create_order.php">Создать заказ</a>
			Моя страница
			<a href="client_orders.php">Мои заказы</a>
			<a href="logout.php">Выход</a>
		</div>
	</body>
</html>