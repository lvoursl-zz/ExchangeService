<html>
	<body>
		<div align="center">
			<a href="index.php">�� �������</a>
			<hr>
			<p>����������� �������</p>
			<form method="post">
				����� ����������� �����:
				<br>
				<input type="text" name="mail">
				<br>
				�������:
				<br>
				<input type="text" name="surname">
				<br>
				���:
				<br>
				<input type="text" name="name">
				<br>
				��������:
				<br>
				<input type="text" name="patronymic">
				<br>
				������:
				<br>
				<input type="text" name="password">
				<br>
				��� ��� ������:
				<br>
				<input type="text" name="password_for_check">
				<br><br>
				<button name="submit" type="submit" value="submitted">������������������</button>
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

											echo "EMPTY �����. ������!";
										} catch(PDOException $e) {
										    echo 'ERROR: ' . $e->getMessage() . '<br>';
										    echo "���, ������� �� ��������� ����������� ������� � ����� ������";
										}									


									} else {
										echo "��, � �� ����� ������ ������";
									}

								} else {
									echo "��������� ��� ���� � �� ���������� �� �������";
								}

							} else {
								echo "����� ���� � ��� ��� ����";
							}


						} catch(PDOException $e) {
						    echo 'ERROR: ' . $e->getMessage() . '<br>';
						    echo "���, �������� � ������������ � ���� ������";
						}


			  		}	 

			  		
				?>
			</form>
		</div>
	</body>
</html>