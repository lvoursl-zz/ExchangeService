<?php
	echo "string";
	if (!is_null($_COOKIE["ExchangeService"])) {
		// check cookies with hash in DataBase and if true - redirect
		print_r($_COOKIE["ExchangeService"]);
	}	
?>
