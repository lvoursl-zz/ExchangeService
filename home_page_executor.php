<?php

	if (!empty($_COOKIE["ExchangeService"])) {
		
		$db_username = "root";
	   	$db_password = "";		  			   
	   	$cookie_password = $_COOKIE["ExchangeService"];

	    $conn = new PDO('mysql:host=localhost;dbname=exchange', $db_username, $db_password);
	    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);						    

	    $query_for_check_password = $conn->prepare('SELECT * FROM executor WHERE executor.password = :password');						
		$query_for_check_password->bindValue(':password', $cookie_password);	
		$query_for_check_password->execute();
		$query_res_for_password = $query_for_check_password->fetchAll();	


		if (!empty($query_res_for_password)) {
			echo "HOMEPAGE Welcome";
		} else {
			header("Location: index.php");	
		}

	} else {
		header("Location: index.php");
	}

?>

<html>
	<body>
		<div align="center">
			<p>Страница исполнителя</p>
			<hr>
			<a href="logout.php">Выход</a>
		</div>
	</body>
</html>