<!DOCTYPE html>

<html lang="fr">
	<head>
		<meta charset="utf-8"/>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" type="text/css" href="style.css" />
		<title>Site de la GBAF, pour une meilleure collaboration au sein du système bancaire</title>
	</head>
	
	<?php	
	/*Vérification de l'existence d'une session sinon renvoi vers la page de connexion.*/
	session_start();
	if(isset ($_SESSION["username"]))
	{
		goto a;	
	}
	else 
	{
		header('location:home.php');
	} 
	a: ?>
	<body>
		<div id='background'>
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
		
		include("header.php");
		
		/*Fonction permettant d'afficher le formulaire*/
		function formulaire($bdd)
		{
			//Récupération des infos de l'utilisateur en BDD pour affichage dans le formulaire
			$username=$_SESSION["username"];
			$req = $bdd->prepare('SELECT username,nom,prenom,password,question,reponse FROM account WHERE username=?');
			$req->execute(array($username));
			$donnees=$req->fetch();
			echo "<section id='compte'><h2>Informations du compte</h2>
				<form method='post' action='compte.php'>
				<p><label for='username'>Nom d'utilisateur:</label><input type='text' name='username' id='username' value='". htmlspecialchars($donnees['username']) ."' readonly/></p>
				<p><label for='nom'>Nom:</label><input type='text' name='nom' id='nom' value='". htmlspecialchars($donnees['nom']) ."'/></p>
				<p><label for='prenom'>Prénom:</label><input type='text' name='prenom' id='prenom' value='". htmlspecialchars($donnees['prenom']) ."'/></p>
				<p><label for='mdp_actuel'>Mot de passe actuel: </label><input type='password' name='mdp_actuel' id='mdp_actuel'/></p>
    			<p><label for='mdp'>Nouveau mot de passe: </label><input type='password' name='mdp' id='mdp'/></p>
    			<p><label for='mdp2'>Confirmation du mot de passe: </label><input type='password' name='mdp2' id='mdp2'/></p>
    			<p><label for='question'>Question secrète:</label><select name='question' id='question'>
					<option value='1' "; if ($donnees["question"]=='1'){echo "selected";} echo">Quelle est votre ville de naissance?</option>
					<option value='2' "; if ($donnees["question"]=='2'){echo "selected";} echo">Quel est le nom de votre premier animal de compagnie?</option>
					<option value='3' "; if ($donnees["question"]=='3'){echo "selected";} echo">Quelle est votre couleur préférée?</option>

				</select></p>
    			<p><label for='reponse'>Réponse à la question secrète:</label><input type='text' name='reponse' id='reponse' value='". htmlspecialchars($donnees['reponse']) ."'/></p>
				<p class='valider'><input type='submit' value='Valider'    /></p>
				</form></section>";
				$req->closeCursor();
		}

		
		/*Contrôle des variables password sinon affichage du formulaire simple*/
		$username=$_SESSION["username"];
		$req = $bdd->prepare('SELECT username,nom,prenom,password,question,reponse FROM account WHERE username=?');
		$req->execute(array($username));
		$donnees=$req->fetch();
		
		if (isset($_POST['mdp_actuel']) and isset($_POST['mdp']) and isset($_POST['mdp2']))  {
				//Vérification du mot de passe actuel saisi sinon message d'erreur
				if (password_verify($_POST['mdp_actuel'], $donnees['password'])==false) {
					formulaire($bdd);
					echo "<p class=erreur>Mot de passe incorrect !</p>";
				}
				//Vérification de la saisie du nouveau mot de passe. Si vide, MAJ des infos personnelles uniquement
				elseif ($_POST['mdp']=='') {
					$req = $bdd->prepare('UPDATE account SET nom=:nom, prenom=:prenom, question=:question, reponse=:reponse WHERE username=:username');
					$req->execute(array(
						'nom' => $_POST['nom'],
						'prenom' => $_POST['prenom'],
						'question' => $_POST['question'],
						'reponse' => $_POST['reponse'],
						'username' => $_POST['username']));
					formulaire($bdd);
					echo "<p class=erreur>Mise à jour des informations personnelles enregistrée !</p>";
				}
				//Vérification de l'égalité entre les 2 mdp sinon message d'erreur
				elseif ($_POST['mdp']<>$_POST['mdp2']) {
					formulaire($bdd);
					echo "<p class=erreur>Nouveau mot de passe incorrect !</p>";
				}
				//Si nouveau mot de passe, MAJ du mot de passe dans la BDD
				else {
					$pass_hache = password_hash($_POST['mdp'], PASSWORD_DEFAULT);
					$req = $bdd->prepare('UPDATE account SET nom=:nom, prenom=:prenom, password=:password, question=:question, reponse=:reponse WHERE username=:username');
					$req->execute(array(
						'password' => $pass_hache,
						'nom' => $_POST['nom'],
						'prenom' => $_POST['prenom'],
						'question' => $_POST['question'],
						'reponse' => $_POST['reponse'],
						'username' => $_POST['username']));
					formulaire($bdd);
					echo "<p class=erreur>Changement de mot de passe réussi !</p>";
				}
		}
		else {
			formulaire($bdd);
		}
		
		include("footer.php");
		?>
		</div>
	</body>
</html>