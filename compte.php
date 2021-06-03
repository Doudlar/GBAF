<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8"/>
		<link rel="stylesheet" type="text/css" href="style.css" />
		<title>Site de la GBAF, pour une meilleure collaboration au sein du système bancaire</title>
	</head>
	<body>
		<div id='background'>
		<?php include("header.php");?>
		<section id='compte'><h2>Informations du compte</h2>
			<form method="post" action="compte.php">
				<label for='email'>Username (adresse email)</label><input type="email" name="email" id='email' />
				<label for='nom'>Nom</label><input type="text" name="nom" id='nom' />
				<label for='prenom'>Prénom</label><input type="text" name="prenom" id='prenom' />
				<label for='current_password'>Mot de passe actuel: </label><input type="password" name="current_password" id='current_password'/>
    			<label for='password'>Nouveau mot de passe: </label><input type="password" name="password" id='password'/>
    			<label for='password2'>Confirmation du mot de passe: </label><input type="password" name="password2" id='password2'/>
    			<label for='question_secrete'>Question secrète</label><select name="question_secrete" id='question_secrete'>
					<option>Quelle est votre ville de naissance?</option>
					<option>Quel est le nom de votre premier animal de compagnie?</option>
					<option>Quelle est votre couleur préférée?</option>

				</select>
    			<label for='reponse_secrete'>Réponse à la question secrète</label><input type="text" name="reponse_secrete" id='reponse_secrete'/>
				<input type="submit" value="Valider" />
			</form>