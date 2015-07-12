<?php
	$error_message = "";
	
 	if($_POST) {
		if (!empty($_POST["mail"]) && !empty($_POST["password"])) {
			try {
    			$db_username = "root";
			   	$db_password = "";		  			   
			   	$mail = $_POST["mail"];

			    $conn = new PDO('mysql:host=localhost;dbname=exchange', $db_username, $db_password);
			    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);						    

			    $query_for_check_registration = $conn->prepare('SELECT *
			    												FROM client, executor WHERE client.mail = :mail 
			    												OR executor.mail = :mail');	

			    $query_for_check_registration->bindValue(':mail', $mail);	
				$query_for_check_registration->execute();
				$query_res_for_registration = $query_for_check_registration->fetchAll();	

				$password = $_POST["password"];

				if (!empty($query_res_for_registration)) {
					$password_in_database = $query_res_for_registration[0][5];
					if (password_verify($password, $password_in_database)) {
						//$error_message = "Пароли совпали, добро пожаловать!";
						setcookie("ExchangeService", $password_in_database, time() + 3600);
						header("Location: home_page_client.php");
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
			<form method="POST" action="login.php">
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

