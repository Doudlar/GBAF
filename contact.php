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
		<?php include("header.php");?>
		<section id='contact'><h2>Nous contacter</h2>
			<form method="post" action="contact.php">
				<label for='email'>Adresse email</label><input type="email" name="email" id='email' />
    			<label for='nom'>Nom</label><input type="text" name="nom" id='nom' />
				<label for='prenom'>Prénom</label><input type="text" name="prenom" id='prenom' />
				<label for='message'>Votre message</label><textarea name="message" id="message" rows="10"cols="30">Saisissez votre message ici</textarea>
				<input type="submit" value="Valider" />
			</form>
		</section>

		<?php include("footer.php");?>
		</div>
	</body>
</html>