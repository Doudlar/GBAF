<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8"/>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" type="text/css" href="style.css" />
		<title>Site de la GBAF, pour une meilleure collaboration au sein du système bancaire</title>
	</head>
	<body>
		<div id='background'>
		<header id='header_home'>
			<a href='accueil.php'><img src='ressources/LOGO_GBAF_ROUGE.png' titre='logo GBAF' alt="Logo de la GBAF" id="logo"/></a>
		</header>
		<section id='connexion'><h2>Se connecter</h2>
			<form method="post" action="connexion.php">
				<p><label for='username'>Nom d'utilisateur:</label><input type="text" name="username" id='username' /></p>
    			<p><label for='password'>Mot de passe: </label><input type="password" name="password" id='password' /></p>
				<p class='valider'><input type="submit" value="Valider"/></p>
			</form>
		</section>
		<section>
			<p>C'est votre première visite? Inscrivez vous en suivant <a href='register.php' id='register'>ce lien</a></p>
		</section>

		<?php include("footer.php");?>
		</div>
	</body>
</html>