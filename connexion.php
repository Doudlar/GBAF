<?php
//Activation de la session et des cookies
session_start(); 
setcookie('username', $_POST["username"], time() + 365*24*3600);
// Vérification de la validité des informations
try
{
	$bdd = new PDO('mysql:host=localhost;dbname=gbaf;charset=utf8', 'root', '',array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
	
}
catch (Exception $e)
{
        die('Erreur : ' . $e->getMessage());
}

if (isset($_POST["username"]) and isset($_POST["password"]))
{
	$username=$_POST["username"];
	$mdp=$_POST["password"];
	$req = $bdd->prepare('SELECT COUNT(username) as nbuser, password,id_user, username FROM account WHERE username=?');
	$req->execute(array($username));
	$donnees=$req->fetch();
	if ($donnees["nbuser"]==0)
	{
		header('location:home.php');
		echo "Compte inconnu";
	}
	else
	{	
		if (password_verify($_POST['password'], $donnees['password'])==false)
		{
			echo "Mot de passe incorrect";
		}
		else
		{
			$_SESSION["id_user"]=$donnees['id_user'];
			$_SESSION["username"]=$donnees['username'];
			header('location:accueil.php');
		}
	}
}
else
{
	echo "Merci de renseigner tous les champs";
}
?>