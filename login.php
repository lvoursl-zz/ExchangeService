<html>
	<body>
		<div align="center">
			<a href="index.php">На главную</a>
			<hr>
			<p>Войдите</p>
			<form method="post">
				Адрес электронной почты:
				<br>
				<input type="text" name="mail">
				<br>
				Пароль:
				<br>
				<input type="text" name="password">
				<br>
				<button name="submit" type="submit" value="submitted">Войти</button>
				<?php
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
									
									if (password_verify($password, $query_res_for_registration[0][5])) {
										echo "Пароли совпали, добро пожаловать!";
									} else {
										echo "Пароль неверный";
									}
									
								} else {
									echo "Такого пользователя у нас нет";
								}								

							} catch(PDOException $e) {
							    echo 'ERROR: ' . $e->getMessage() . '<br>';
							    echo "ой-ой, проблемы с подключением к базе данных";
							}
			    		} else {
			    			echo "Заполните все поля";
			    		}
			  		}	 
			  		
				?>
			</form>
		</div>
	</body>
</html>

