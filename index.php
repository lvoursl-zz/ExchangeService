<?
	if (!is_null($_COOKIE["ExchangeService"])) {
		// check cookies with hash in DataBase and if true - redirect

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
			<a href="login.php">Войти в свою учетную запись</a>
		</div>
	</body>
</html>
