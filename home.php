<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8"/>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" type="text/css" href="style.css" />
		<title>Site de la GBAF, pour une meilleure collaboration au sein du système bancaire</title>
	</head>
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
?>
<body>
		<div id='background'>
		<header id='header_home'>
			<a href='accueil.php'><img src='ressources/LOGO_GBAF_ROUGE.png' titre='logo GBAF' alt="Logo de la GBAF" id="logo"/></a>
		</header>
		<section id='connexion' class='home'><h2>SE CONNECTER</h2>
<?php 
	/*Fonction permettant d'afficher le formulaire*/
	function formulaire() {
		echo "<form method='post' action='home.php'>
		<p><label for='username'>Nom d'utilisateur:</label><input type='text' name='username' id='username' /></p>
	    	<p><label for='password'>Mot de passe: </label><input type='password' name='password' id='password' /></p>
		<p class='valider'><input type='submit' value='Valider'/></p></form>";
	}
	/*Contrôle des variables username et password sinon affichage du formulaire simple*/
	if (isset($_POST["username"]) and isset($_POST["password"])) {
		$username=$_POST["username"];
		$mdp=$_POST["password"];
		$req = $bdd->prepare('SELECT COUNT(username) as nbuser, password,id_user, username FROM account WHERE username=?');
		$req->execute(array($username));
		$donnees=$req->fetch();
		/*Contrôle de l'existence de l'utilisateur, sinon message d'erreur*/
		if ($donnees["nbuser"]==0)
		{
			formulaire();
			echo "<p class=erreur>Compte inconnu</p>";
		}
		else
		{	
		/*Contrôle de la validité du mot de passe sinon message d'erreur*/
			if (password_verify($_POST['password'], $donnees['password'])==false)
			{
				formulaire();
				echo "<p class=erreur>Mot de passe incorrect</p>";
			}
			else
			{
				/*Activation de la session et des cookies*/
				session_start(); 
				setcookie('username', $_POST["username"], time() + 365*24*3600);
				$_SESSION["id_user"]=$donnees['id_user'];
				$_SESSION["username"]=$donnees['username'];
				header('location:accueil.php');
			}
		}
	}
	else {
		formulaire();
	}
?>
	
		
		</section>
		<!-- Section avec lien vers réinitialisation du mot de passe ou vers l'inscription -->
		<section >
			<p class='home'>Vous avez oublié votre mot de passe? Réinitialisez le en suivant <a href='reset.php' id='reset'>ce lien</a>.</p>
			<p class='home'>C'est votre première visite? Inscrivez vous en suivant <a href='register.php' id='register'>ce lien</a>.</p>
		</section>

		<?php include("footer.php");?>
		</div>
	</body>
</html>