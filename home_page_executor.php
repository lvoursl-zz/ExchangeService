<?php

	require_once 'functions.php';

	if (is_executor_cookies_correct() === false) {
		header("Location: index.php");
	} else {
		
	}

?>

<html>
	<body>
		<div align="center">
			<h2>Страница исполнителя</h2>
			<p>Страница исполнителя</p>
			<hr>
			<a href="find_work_executor.php">Найти заказ</a>
			<a href="executor_completed_orders.php">Мои выполненные заказы</a>
			Моя страница		
			<a href="logout.php">Выход</a>
			<hr>
		</div>
	</body>
</html>