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
			<section class='home'><h2>Recuperation du mot de passe</h2>
			<?php
			/*Fonctions permettant d'afficher les 2 formulaires différents*/
			function formulaire_question() {
				echo"<form method='post' action='reset.php'>
					<p><label for='username'>Nom d'utilisateur:</label><input type='text' name='username' id='username' /></p>
	    			<p><label for='question'>Question secrète</label><select name='question' id='question'>
						<option value='1'>Quelle est votre ville de naissance?</option>
						<option value='2'>Quel est le nom de votre premier animal de compagnie?</option>
						<option value='3'>Quelle est votre couleur préférée?</option>
					</select></p>
	    			<p><label for='reponse'>Réponse à la question secrète</label><input type='text' name='reponse' id='reponse'/></p>
					<p class='valider'><input type='submit' value='Valider'/></p>
				</form>";
			}
			function formulaire_mdp() {
				echo"<form method='post' action='reset.php'>
						<p><label for='username'>Nom d'utilisateur:</label><input type='text' name='username' id='username' value='".$_POST['username']."' readonly/></p>
						<p><label for='mdp'>Mot de passe: </label><input type='password' name='mdp' id='mdp'/></p>
	    				<p><label for='mdp2'>Confirmation du mot de passe: </label><input type='password' name='mdp2' id='mdp2'/></p>
	    				<p class='valider'><input type='submit' value='Valider'/></p></form>";
			}
			/*Vérification de l'initialisation des mots de passe 1 et 2 sinon controle du formulaire question-reponse*/
			if (isset($_POST['mdp']) and isset($_POST['mdp2'])) {
				//Vérification de l'égalité des 2 mdp sinon erreur
				if($_POST['mdp']==$_POST['mdp2']) {

					$pass_hache = password_hash($_POST['mdp'], PASSWORD_DEFAULT);
					$req = $bdd->prepare('UPDATE account SET password=:password WHERE username=:username');
					$req->execute(array(
						'password' => $pass_hache,
						'username' => $_POST['username']));
					echo "<p>Mise à jour du mot de passe réussie, retournez sur <a href='home.php' id=reset>la page de connexion</a> pour vous connecter</p>";
				}
				else {
					formulaire_mdp();
					echo "<p class=erreur>Les mots de passe ne sont pas identiques !</p>";

					
				}
			}
			else {
				/*Vérification de l'initialisation du username et question/réponse sinon affichage du formulaire question-reponse*/
				if (isset($_POST['username']) and isset($_POST['question']) and isset($_POST['reponse'])) {
					$req = $bdd->prepare('SELECT username,password,question,reponse FROM account WHERE username=?');
					$req->execute(array($_POST['username']));
					$donnees=$req->fetch();
					//Vérification de la combinaison question reponse avec la BDD pour affichage du changement de mdp sinon erreur
					if ($donnees['question']==$_POST['question'] and $donnees['reponse']==$_POST['reponse'] ) {
						formulaire_mdp();

					}
					else {
						formulaire_question();
						echo "<p class=erreur>Informations incorrectes !</p>";
					}
				}
				else {
					formulaire_question();
				}
			}
			include("footer.php");?>
			</section>
		</div>
	</body>
</html>