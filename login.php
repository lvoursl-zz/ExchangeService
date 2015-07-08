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
				    			$username = "root";
			  			   		$password = "";		  			   
			  			   		$mail = $_POST["mail"];

							    $conn = new PDO('mysql:host=localhost;dbname=exchange', $username, $password);
							    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);						    

							    $query_for_check_registration = $conn->prepare('SELECT *
							    												FROM client, executor WHERE client.mail = :mail 
							    												OR executor.mail = :mail');	


							} catch(PDOException $e) {
							    echo 'ERROR: ' . $e->getMessage() . '<br>';
							    echo "ой-ой, проблемы с подключением к базе данных";
							}
			    		}
			  		}	 
			  		
				?>
			</form>
		</div>
	</body>
</html>

