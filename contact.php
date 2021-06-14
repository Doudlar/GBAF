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
		<?php 
				session_start(); 
				// Vérification de la validité des informations
				try
					{
						$bdd = new PDO('mysql:host=localhost;dbname=gbaf;charset=utf8', 'root', '',array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
						
					}
				catch (Exception $e)
					{
				        die('Erreur : ' . $e->getMessage());
					}
		include("header.php");?>
		<section id='contact'><h2>Nous contacter</h2>
			<form method="post" action="contact.php">
				<p><label for='email'>Adresse email</label><input type="email" name="email" id='email' /></p>
    			<p><label for='nom'>Nom</label><input type="text" name="nom" id='nom' /></p>
				<p><label for='prenom'>Prénom</label><input type="text" name="prenom" id='prenom' /></p>
				<p><label for='message'></label><textarea name="message" id="message" rows="10"cols="30">Saisissez votre message ici</textarea></p>
				<p><input type="submit" value="Envoyer" /></p>
			</form>
		</section>

		<?php include("footer.php");?>
		</div>
	</body>
</html>