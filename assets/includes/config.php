<?php
	
	// General
	$nombreProyecto = "RaspyTV";

	// Configuración BD
	define("DB_HOST", "localhost");
	define("DB_USER", "root");
	define("DB_PASS", "tv");
	define("DB_DATABASE", "raspytv");
	
	$conexionSQL = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_DATABASE);
	
	if (mysqli_connect_errno()) {
		echo "Imposible conectarse a la base de datos: " . mysqli_connect_error();  
		exit;
	}

?>
