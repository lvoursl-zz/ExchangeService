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
			<p>Мои заказы</p>
			<hr>
			<a href="create_order.php">Создать заказ</a>
			<a href="home_page_client.php">Моя страница</a>
			Мои заказы
			<a href="logout.php">Выход</a>
		</div>
	</body>
</html>