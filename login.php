<?php
	
	require_once 'functions.php';

	if (is_executor_cookies_correct() === true) {
		header("Location: home_page_executor.php");	
	} elseif (is_client_cookies_correct() === true) {
		header("Location: home_page_client.php");
	} 

	$error_message = "";
	
 	if($_GET) {
		if (!empty($_GET["mail"]) && !empty($_GET["password"])) {
			try {	  			   
			   	$mail = $_GET["mail"];

			    $conn = new PDO('mysql:host=localhost;dbname=exchange', DB_USERNAME, DB_PASSWORD);
			    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);						    

			    $query_for_check_client_registration = $conn->prepare('SELECT * FROM client WHERE client.mail = :mail ');	
			    $query_for_check_client_registration->bindValue(':mail', $mail);	
				$query_for_check_client_registration->execute();
				$query_data_for_client_registration = $query_for_check_client_registration->fetchAll();	


				$query_for_check_executor_registration = $conn->prepare('SELECT * FROM executor WHERE executor.mail = :mail ');	
			    $query_for_check_executor_registration->bindValue(':mail', $mail);	
				$query_for_check_executor_registration->execute();
				$query_data_for_executor_registration = $query_for_check_executor_registration->fetchAll();	
			

				if (!empty($query_data_for_client_registration)) {
					$password = $_GET["password"];
					$password_in_database = $query_data_for_client_registration[0][5];
					
					if (password_verify($password, $password_in_database)) {
						// everything is good, redirect	
						setcookie("ExchangeService", $password_in_database, time() + 3600);
						header("Location: home_page_client.php");
					} else {						
						$error_message = "Пароль неверный";
					}
					
				} elseif (!empty($query_data_for_executor_registration)) {
					$password = $_GET["password"];
					$password_in_database = $query_data_for_executor_registration[0][2];

					if (password_verify($password, $password_in_database)) {
						// everything is good, redirect						
						setcookie("ExchangeService", $password_in_database, time() + 3600);
						header("Location: home_page_executor.php");
					} else {						
						$error_message = "Пароль неверный";
					}

				} else {
					$error_message = "Такого пользователя у нас нет";
				}							

			} catch(PDOException $e) {
			    //echo 'ERROR: ' . $e->getMessage() . '<br>';
			    $error_message = "ой-ой, проблемы с подключением к базе данных";
			}
		} else {
			$error_message = "Заполните все поля";
		}
	}	
		
?>

<html>
	<body>
		<div align="center">
			<a href="index.php">На главную</a>
			<hr>
			<?php echo $error_message; ?>
			<p>Войдите</p>
			<form method="GET">
				Адрес электронной почты:
				<br>
				<input type="email" name="mail"> 
				<br>
				Пароль:
				<br>
				<input type="password" name="password">
				<br>
				<button name="submit" type="submit" value="submitted">Войти</button>				
			</form>
		</div>
	</body>
</html>

