<?php	

	if(isset($_COOKIE["ExchangeService"])) {
  		setcookie('ExchangeService', '', time() - 7000000);
  		header("Location: index.php");
	} else {
		header("Location: index.php");
	}
	
?>