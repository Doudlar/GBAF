
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
			<section id='inscription' class='home'><h2>S'inscrire</h2>
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
/*Fonction permettant d'afficher le formulaire*/
function formulaire() {
	echo"<form method='post' action='register.php'>
	<p><label for='username2'>Nom d'utilisateur:</label><input type='text' name='username' id='username2' /></p>
	<p><label for='nom'>Nom:</label><input type='text' name='nom' id='nom' /></p>
	<p><label for='prenom'>Prénom:</label><input type='text' name='prenom' id='prenom' /></p>
	<p><label for='mdp'>Mot de passe: </label><input type='password' name='mdp' id='mdp'/></p>
	<p><label for='mdp2'>Confirmation du mot de passe: </label><input type='password' name='mdp2' id='mdp2'/></p>
	<p><label for='question'>Question secrète:</label><select name='question' id='question'>
		<option value='1'>Quelle est votre ville de naissance?</option>
		<option value='2'>Quel est le nom de votre premier animal de compagnie?</option>
		<option value='3'>Quelle est votre couleur préférée?</option>

	</select></p>
	<p><label for='reponse'>Réponse à la question secrète:</label><input type='text' name='reponse' id='reponse'/></p>
	<p class='valider'><input type='submit' value='Valider' /></p>
	</form>";
}
/*Contrôle des variables username et password sinon affichage du formulaire simple*/
if (isset($_POST["username"]) and isset($_POST["mdp"]))
{
	$username=$_POST["username"];
	$nom=$_POST["nom"];
	$prenom=$_POST["prenom"];
	$mdp=$_POST["mdp"];
	$mdp2=$_POST["mdp2"];
	$question=$_POST["question"];
	$reponse=$_POST["reponse"];
	$req = $bdd->prepare('SELECT COUNT(username) as nbusername FROM account WHERE username=?');
	$req->execute(array($username));
	$donnees=$req->fetch();
	//Vérification de l'existence du username dans la BDD
	if ($donnees["nbusername"]>0)
	{
		formulaire();
		echo "<p class=erreur>Nom d'utilisateur déjà utilisé, merci d'en choisir un différent</p>";
	}
	else
	{	
		//Vérification de l'égalité des mdp pour insertion dans la BDD sinon erreur
		if ($mdp<>$mdp2)
		{
			formulaire();
			echo "<p class=erreur>Les mots de passe ne sont pas identiques</p>";
		}
		else
		{
			$req->closeCursor();
				// Hachage du mot de passe
			$pass_hache = password_hash($_POST['mdp'], PASSWORD_DEFAULT);

			// Insertion des données du compte
			$req = $bdd->prepare('INSERT INTO account(username,nom,prenom, password,question,reponse) VALUES(:username,:nom,:prenom, :mdp, :question, :reponse)');
			$req->execute(array(
			    'username' => $username,
			    'nom' => $nom,
			    'prenom' => $prenom,
			    'mdp' => $pass_hache,
			    'question' => $question,
			    'reponse' => $reponse));
			echo "<p class=erreur>Votre compte a bien été créé, vous pouvez désormais vous connecter à <a href='home.php' id='register'>l'espace membre</a></p>";
		}
	}
}
else
{
	formulaire();
}
 
?>     
		</section>
		<?php include("footer.php");?>
		</div>
	</body>
</html>