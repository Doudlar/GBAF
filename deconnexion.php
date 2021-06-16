<?php
/* Test de la connexion à la BDD*/
try
{
	$bdd = new PDO('mysql:host=localhost;dbname=gbaf;charset=utf8', 'root', '',array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
	
}
catch (Exception $e)
{
        die('Erreur : ' . $e->getMessage());
}
/*Fermeture de la session et renvoi vers la page de connexion*/
session_start();
if (isset($_SESSION["username"])) {
	
	unset($_SESSION['id_user']);
 	unset($_SESSION['username']);
 	unset($_COOKIE['username']);
 	session_destroy();
}

header('location:home.php');
?>