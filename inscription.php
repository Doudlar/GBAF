<?php 
// Vérification de la validité des informations
try
{
	$bdd = new PDO('mysql:host=localhost;dbname=gbaf;charset=utf8', 'root', '',array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
	
}
catch (Exception $e)
{
        die('Erreur : ' . $e->getMessage());
}
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
	if ($donnees["nbusername"]>0)
	{
		echo "Nom d'utilisateur déjà utilisé, merci d'en choisir un différent";
	}
	else
	{	
		if ($mdp<>$mdp2)
		{
			echo "Les mots de passe ne sont pas identiques";
		}
		else
		{
			$req->closeCursor();
				// Hachage du mot de passe
			$pass_hache = password_hash($_POST['mdp'], PASSWORD_DEFAULT);

			// Insertion
			$req = $bdd->prepare('INSERT INTO account(username,nom,prenom, password,question,reponse) VALUES(:username,:nom,:prenom, :mdp, :question, :reponse)');
			$req->execute(array(
			    'username' => $username,
			    'nom' => $nom,
			    'prenom' => $prenom,
			    'mdp' => $pass_hache,
			    'question' => $question,
			    'reponse' => $reponse));
			echo "Votre compte a bien été créé, vous pouvez désormais vous connecter à <a href='home.php'>l'espace membre</a>";
		}
	}
}
else
{
	echo "Merci de renseigner tous les champs";
}
 
?>      