<html>
	<body>
		<div align="center">
			<a href="index.php">На главную</a>
			<hr>
			<p>Регистрация заказчика</p>
			<form method="post">
				Адрес электронной почты:
				<br>
				<input type="text" name="mail">
				<br>
				Фамилия:
				<br>
				<input type="text" name="surname">
				<br>
				Имя:
				<br>
				<input type="text" name="name">
				<br>
				Отчество:
				<br>
				<input type="text" name="patronymic">
				<br>
				Пароль:
				<br>
				<input type="text" name="password">
				<br>
				Пароль еще раз:
				<br>
				<input type="text" name="password_for_check">
				<br><br>
				<button name="submit" type="submit" value="submitted">Зарегистрироваться</button>
				<br>
	
				<?php
				 	
				 	if($_POST) {
	
		  			   //echo '<br>' . htmlspecialchars(print_r($_POST, true)) . '<br>';
		  					   
		  			    try {
						    $username = "root";
		  			   		$password = "";		  			   
		  			   		$mail = $_POST["mail"];

						    $conn = new PDO('mysql:host=localhost;dbname=exchange', $username, $password);
						    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);						    

						    $query_for_check_registration = $conn->prepare('SELECT client.mail, executor.mail
						    												FROM client, executor WHERE client.mail = :mail 
						    												OR executor.mail = :mail');						
							$query_for_check_registration->bindValue(':mail', $mail);	
							$query_for_check_registration->execute();
							$query_res_for_registration = $query_for_check_registration->fetchAll();	
				
							if (empty($query_res_for_registration)) {

								$isInputEmpty = false;
								foreach ($_POST as $key => $value) {
									//echo "POST parameter '$key' has '$value'" . '<br>';
									if (empty($value)) {
										$isInputEmpty = true;										
										break;
									} 
								}

								if ($isInputEmpty == false) {

									if ($_POST["password"] == $_POST["password_for_check"]) {									

										try {

											$surname = $_POST["surname"];
										    $name = $_POST["name"];						   
										    $patronymic = $_POST["patronymic"];
										    $password = $_POST["password"];
										    
										    $password = password_hash($password, PASSWORD_DEFAULT);

											$query = $conn->prepare('INSERT INTO client (mail, surname, name, patronymic, password) 
																	 VALUES (:mail, :surname, :name, :patronymic, :password)');						
											
											$query->bindValue(':name', $name);
											$query->bindValue(':surname', $surname);
											$query->bindValue(':patronymic', $patronymic);
											$query->bindValue(':password', $password);	
											$query->bindValue(':mail', $mail);	
											$query->execute();
											//echo password_verify($p, $password);
											echo "Все классно! добро пожаловать!";
											echo '<br><a href="login.php">Теперь вы можете войти в свою учетную запись</a>';
										} catch(PDOException $e) {
										    echo 'ERROR: ' . $e->getMessage() . '<br>';
										    echo "Кажется вы используете в своих данных запрещенные символы";
										}									


									} else {
										echo "Ваши пароли не совпадают, попробуйте снова";
									}

								} else {
									echo "Упс, кажется вы заполнили не все требуемые поля";
								}

							} else {
								echo "Пользователь с такой почтой у нас уже есть";
							}


						} catch(PDOException $e) {
						    echo 'ERROR: ' . $e->getMessage() . '<br>';
						    echo "ой-ой, проблемы с подключением к базе данных";
						}


			  		}	 

			  		
				?>
			</form>
		</div>
	</body>
</html>