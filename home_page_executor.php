<?php
	echo "string";
	if (!is_null($_COOKIE["ExchangeService"])) {
		// check cookies with hash in DataBase
		print_r($_COOKIE["ExchangeService"]);
	} else {
		header("Location: index.php");
	}
?>
