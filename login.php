<html>
	<body>
		<div align="center">
			<a href="index.php">На главную</a>
			<hr>
			<p>Войдите</p>
			<form method="post">
				Имя:
				<br>
				<input type="text" name="name">
				<br>
				Пароль:
				<br>
				<input type="text" name="password">
				<br>
				<button name="submit" type="submit" value="submitted">Войти</button>
				<?php
				 	if($_POST['submit']) {
			    		echo $_POST['submit'];
			  		}	 
			  		
				?>
			</form>
		</div>
	</body>
</html>

