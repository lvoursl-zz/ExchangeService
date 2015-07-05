<html>
	<body>
		<div align="center">
			<a href="index.php">На главную</a>
			<hr>
			<p>Регистрация клиента</p>
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
				Еше раз пароль:
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

						    $query = $conn->prepare('SELECT * FROM client WHERE mail = :mail');						
							$query->bindValue(':mail', $mail);	
							$query->execute();
							$query_res = $query->fetchAll();							
							
							if (empty($query_res)) {

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

										    // HASH PASSWORD!!!!! 

											$query = $conn->prepare('INSERT INTO client (mail, surname, name, patronymic, password) 
																	 VALUES (:mail, :surname, :name, :patronymic, :password)');						
											
											$query->bindValue(':name', $name);
											$query->bindValue(':surname', $surname);
											$query->bindValue(':patronymic', $patronymic);
											$query->bindValue(':password', $password);	
											$query->bindValue(':mail', $mail);	
											$query->execute();

											echo "EMPTY Плейс. велком!";
										} catch(PDOException $e) {
										    echo 'ERROR: ' . $e->getMessage() . '<br>';
										    echo "Упс, кажется вы испозуете запрещенные символы в своих данных";
										}									


									} else {
										echo "Ой, а вы ввели разные пароли";
									}

								} else {
									echo "Заполните все поля и не оставляйте их пустыми";
								}

							} else {
								echo "Такой юзер у нас уже есть";
							}


						} catch(PDOException $e) {
						    echo 'ERROR: ' . $e->getMessage() . '<br>';
						    echo "Упс, проблемы с подключением к базе данных";
						}


			  		}	 

			  		
				?>
			</form>
		</div>
	</body>
</html>