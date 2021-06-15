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
		include("header.php");	
		try
			{
				$bdd = new PDO('mysql:host=localhost;dbname=gbaf;charset=utf8', 'root', '',array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
				
			}
		catch (Exception $e)
			{
			        die('Erreur : ' . $e->getMessage());
			}
		$username=$_SESSION["username"];
		$req = $bdd->prepare('SELECT username,nom,prenom,question,reponse FROM account WHERE username=?');
		$req->execute(array($username));
		$donnees=$req->fetch();
		
		echo "<section id='compte'><h2>Informations du compte</h2>
			<form method='post' action='compte.php'>
				<p><label for='username'>Nom d'utilisateur:</label><input type='text' name='username' id='username' value='". htmlspecialchars($donnees['username']) ."' /></p>
				<p><label for='nom'>Nom:</label><input type='text' name='nom' id='nom' value='". htmlspecialchars($donnees['nom']) ."'/></p>
				<p><label for='prenom'>Prénom:</label><input type='text' name='prenom' id='prenom' value='". htmlspecialchars($donnees['prenom']) ."'/></p>
				<p><label for='current_password'>Mot de passe actuel: </label><input type='password' name='current_password' id='current_password'/></p>
    			<p><label for='password'>Nouveau mot de passe: </label><input type='password' name='password' id='password'/></p>
    			<p><label for='password2'>Confirmation du mot de passe: </label><input type='password' name='password2' id='password2'/></p>
    			<p><label for='question'>Question secrète:</label><select name='question' id='question' value='". htmlspecialchars($donnees['question']) ."'></p>
					<option value='1' "; if ($donnees["question"]=='1'){echo "selected";} echo">Quelle est votre ville de naissance?</option>
					<option value='2' "; if ($donnees["question"]=='2'){echo "selected";} echo">Quel est le nom de votre premier animal de compagnie?</option>
					<option value='3' "; if ($donnees["question"]=='3'){echo "selected";} echo">Quelle est votre couleur préférée?</option>

				</select></p>
    			<p><label for='reponse'>Réponse à la question secrète:</label><input type='text' name='reponse' id='reponse' value='". htmlspecialchars($donnees['reponse']) ."'/></p>
				<p class='valider'><input type='submit' value='Valider'    /></p>
			</form>";
		include("footer.php");
		?>
		</div>
	</body>
</html>