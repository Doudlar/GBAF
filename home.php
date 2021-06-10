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
				<p><label for='username'>Nom d'utilisateur</label><input type="text" name="username" id='username' /></p>
    			<p><label for='password'>Mot de passe: </label><input type="password" name="password" id='password' /></p>
				<input type="submit" value="Valider" class="valider" />
			</form>
		</section>
		<section id='inscription'><h2>S'inscrire</h2>
			<form method="post" action="inscription.php">
				<p><label for='username2'>Nom d'utilisateur</label><input type="text" name="username" id='username2' /></p>
				<p><label for='nom'>Nom</label><input type="text" name="nom" id='nom' /></p>
				<p><label for='prenom'>Prénom</label><input type="text" name="prenom" id='prenom' /></p>
    			<p><label for='mdp'>Mot de passe: </label><input type="password" name="mdp" id='mdp'/></p>
    			<p><label for='mdp2'>Confirmation du mot de passe: </label><input type='password' name='mdp2' id='mdp2'/></p>
    			<p><label for='question'>Question secrète</label><select name='question' id='question'>
					<option value='1'>Quelle est votre ville de naissance?</option>
					<option value='2'>Quel est le nom de votre premier animal de compagnie?</option>
					<option value='3'>Quelle est votre couleur préférée?</option>

				</select></p>
    			<p><label for='reponse'>Réponse à la question secrète</label><input type="text" name="reponse" id='reponse'/></p>
				<input type="submit" value="Valider" class="valider" />
			</form>
		</section>

		<?php include("footer.php");?>
		</div>
	</body>
</html>