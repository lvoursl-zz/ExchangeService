<?php

	require_once 'functions.php';

	if (is_client_cookies_correct() === false) {
		header("Location: index.php");
	} else {

		if (is_array_have_empty_values($_POST) === false) {

			
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
			    <select name="section">
			    <option disabled>Выберите раздел</option>
			    <option value="">Раздел0</option>
			    <option value="">Раздел1</option>
			    <option value="">Раздел2</option>
			    <option value="">Раздел3</option>
			   	</select>
				<br>
				Теги:
				<br>
				<input type="text" name="tags">
				<br>
				<br>
				<button name="submit" type="submit" value="submitted">Создать заказ</button>
				<br>
					
			</form>
		</div>
	</body>
</html>