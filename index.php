<?php
	if (!empty($_COOKIE["ExchangeService"])) {
		/// check hash in cookies with hash in DataBase	

		try {
			
			$db_username = "root";
		   	$db_password = "";		  			   
		   	$cookie_password = $_COOKIE["ExchangeService"];

		    $conn = new PDO('mysql:host=localhost;dbname=exchange', $db_username, $db_password);
		    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);	

			$query_for_check_client_password = $conn->prepare('SELECT * FROM client WHERE client.password = :password');	
		    $query_for_check_client_password->bindValue(':password', $cookie_password);	
			$query_for_check_client_password->execute();
			$query_data_for_client_password = $query_for_check_client_password->fetchAll();	


			$query_for_check_executor_password = $conn->prepare('SELECT * FROM executor WHERE executor.password = :password');
		    $query_for_check_executor_password->bindValue(':password', $cookie_password);	
			$query_for_check_executor_password->execute();
			$query_data_for_executor_password = $query_for_check_executor_password->fetchAll();	



			if (!empty($query_data_for_client_password)) {
				header("Location: home_page_client.php");	
			} elseif (!empty($query_for_check_executor_password)) {
				header("Location: home_page_executor.php");	
			} else {
				header("Location: index.php");	
			}

		} catch(PDOException $e) {
		    //echo 'ERROR: ' . $e->getMessage() . '<br>';
		    //$error_message = "ой-ой, проблемы с подключением к базе данных";
		    header("Location: index.php");
		}
	}	

?>

<html>
	<body>
		<div align="center">
			<p>Зарегистрируйтесь как</p>
			<form>
	  			<a href="register_client.php">Заказчик</a>
			</form>
			<form>
	  			<a href="register_executor.php">Исполнитель</a>
			</form>
			<hr>
			<a href="login.php">Или войдите в свою учетную запись</a>
		</div>
	</body>
</html>
