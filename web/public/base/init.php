<?php
	session_start();
	if (isset($_SESSION['LAST_REQUEST_TIME'])) {
		if (time() - $_SESSION['LAST_REQUEST_TIME'] > 3600) {
			// session timed out, last request is longer than 1hour ago
			$_SESSION = array();
			session_destroy();
		}
	}
	$_SESSION['LAST_REQUEST_TIME'] = time();

	//$orange = new PDO('mysql:host=localhost;dbname=orange', 'root', 'root', array(PDO::MYSQL_ATTR_INIT_COMMAND=>'SET NAMES UTF8') ); //connexion bdd mac en local
	try {
		$soundbuzz = new PDO('mysql:host=mysql;dbname=Soundbuzz', 'root', 'root', array(PDO::MYSQL_ATTR_INIT_COMMAND=>'SET NAMES UTF8') );  //connexion bdd ubuntu en local
	} catch (PDOException $e) {
		echo 'Connexion échouée : ' . $e->getMessage();
	}

	function enLigne(){
		if( !isset($_SESSION['utilisateur']) ){
			//Si la session utilisateur n'existe pas, cela signifie que l'on n'est pas connecté donc on retournera false
			return false;
		}
		else{ 
			return true;
		}
	} 
?>