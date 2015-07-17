<?php

	require_once 'functions.php';

	if (is_executor_cookies_correct() === true) {
		header("Location: home_page_executor.php");	
	} elseif (is_client_cookies_correct() === true) {
		header("Location: home_page_client.php");
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
