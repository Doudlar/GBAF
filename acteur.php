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
					//Vérification que l'utilisateur est bien connecté sinon renvoi à la page de connexion	
				if(isset ($_SESSION["username"]))
					{
						$req = $bdd->prepare('SELECT COUNT(id_acteur) as nbacteur FROM acteur WHERE id_acteur=?');
						$req->execute(array($_GET['id_acteur']));
						$donnees=$req->fetch();
						//Vérification de l'id acteur récupérée via l'URL
						if (isset($_GET['id_acteur']) and $donnees["nbacteur"]>0)
						{
							include("header.php");?>
		
							<article id='presentation_acteur'>
								<?php		
								
								$req = $bdd->prepare('SELECT id_acteur,acteur,description,logo FROM acteur WHERE id_acteur=?');
									$req->execute(array($_GET['id_acteur']));

									$donnees=$req->fetch();			
									echo "<img src='".$donnees['logo']."' />
										<div id='acteur'><h2>".$donnees['acteur']."</h2><p><a href='https://www.chambredesentrepreneurs.com/'' target=blank>https://www.chambredesentrepreneurs.com</a></p>
										<p>".$donnees['description']."</p>
										</div>";
									$req->closeCursor();
									?>
							</article>

							<div id='cadre_commentaire'>
							<div id='commentaires'>
								<?php
									$req = $bdd->prepare('SELECT count(id_acteur) as nbcommentaires FROM post WHERE id_acteur=?');
									$req->execute(array($_GET['id_acteur']));
									$donnees=$req->fetch();
									echo "<p>". $donnees['nbcommentaires'] . " commentaires</p>";
									$req->closeCursor();



									echo "<div id='com_et_like'><div id='nouveau_commentaire'><a href='commentaire.php'>Nouveau commentaire</a></div>
										<div id ='like'><a href='like.php'><?php echo '5 ' ?><img src='ressources/rating.png' /></a></div></div>
										</div>";

									$req = $bdd->prepare('SELECT p.id_post,p.post,a.nom,a.prenom,DATE_FORMAT(p.date_add, \'%d/%m/%Y\') as date_comm FROM post p LEFT JOIN account a on p.id_user=a.id_user WHERE p.id_acteur=? ORDER BY p.id_post DESC');
									$req->execute(array($_GET['id_acteur']));

									while ($donnees=$req->fetch())
									{	
										echo "<div class='detail_commentaire'><p>".$donnees['nom']." ".$donnees['prenom']."</p><p>".$donnees['date_comm']."</p><p>".$donnees['post']."</p></div>
										</div>";
									}
							 	include("footer.php");?>
						</body>
					</html>
						<?php
					}
						else 
						{
							echo "Erreur, acteur introuvable, merci de vérifier votre URL";
						}	
					}
					else 
					{
						header('location:home.php');
					} ?>