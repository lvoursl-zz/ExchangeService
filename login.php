<html>
	<body>
		<div align="center">
			<a href="index.php">�� �������</a>
			<hr>
			<p>�������</p>
			<form method="post">
				���:
				<br>
				<input type="text" name="name">
				<br>
				������:
				<br>
				<input type="text" name="password">
				<br>
				<button name="submit" type="submit" value="submitted">�����</button>
				<?php
				 	if($_POST['submit']) {
			    		echo $_POST['submit'];
			  		}	 
			  		
				?>
			</form>
		</div>
	</body>
</html>

