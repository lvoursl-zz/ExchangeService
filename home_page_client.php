<?php

	if (!empty($_COOKIE["ExchangeService"])) {
		
		// check hash in cookies with hash in DataBase	

		$db_username = "root";
	   	$db_password = "";		  			   
	   	$cookie_password = $_COOKIE["ExchangeService"];

	    $conn = new PDO('mysql:host=localhost;dbname=exchange', $db_username, $db_password);
	    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);						    

	    $query_for_check_password = $conn->prepare('SELECT * FROM client WHERE client.password = :password');						
		$query_for_check_password->bindValue(':password', $cookie_password);	
		$query_for_check_password->execute();
		$query_res_for_password = $query_for_check_password->fetchAll();	


		if (empty($query_res_for_password)) {
			// incorrect hash in cookies			
			header("Location: index.php");	
		}

	} else {
		// cookies is empty
		header("Location: index.php");
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