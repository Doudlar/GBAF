<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8"/>
		<link rel="stylesheet" type="text/css" href="style.css" />
	</head>
	<body>
		<header>
			<a href='accueil.php'><img src='ressources/LOGO_GBAF_ROUGE.png' titre='logo GBAF' alt="Logo de la GBAF" id="logo"/></a>
			<div id='user'><a href='compte.php'><img src='ressources/user.png' titre ='avatar' alt='avatar'/></a><a href='compte.php'><p>
				<?php 	
					try
						{
							$bdd = new PDO('mysql:host=localhost;dbname=gbaf;charset=utf8', 'root', '',array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
							
						}
					catch (Exception $e)
						{
						        die('Erreur : ' . $e->getMessage());
						}
					$username=$_SESSION["username"];
					$req = $bdd->prepare('SELECT username,nom,prenom FROM account WHERE username=?');
					$req->execute(array($username));
					$donnees=$req->fetch();
					echo $donnees['prenom'] . ' ' . $donnees['nom'] ?></p></a><div id='deconnexion'><a href='deconnexion.php'><img src='ressources/logout.svg' id='logout' titre ='deconnexion' alt='deconnexion'/></a></div></div>

		</header>
	</body>
</html>