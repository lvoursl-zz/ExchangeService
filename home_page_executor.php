<?php

	require_once 'functions.php';

	if (is_executor_cookies_correct() === false) {
		header("Location: index.php");
	} else {
		
	}

?>

<html>
	<body>
		<div align="center">
			<p>Страница исполнителя</p>
			<hr>
			<a href="logout.php">Выход</a>
		</div>
	</body>
</html>