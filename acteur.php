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
								<?php 
									
								?>
							<div id='commentaires'>
								<?php
									$req = $bdd->prepare('SELECT count(id_acteur) as nbcommentaires FROM post WHERE id_acteur=?');
									$req->execute(array($_GET['id_acteur']));
									$donnees=$req->fetch();
									echo "<p>". $donnees['nbcommentaires'] . " commentaires</p>";
									$req->closeCursor();
									echo "<div id='com_et_like'><div id='nouveau_commentaire'><a href='#texte_com'>Nouveau commentaire</a><form method='post' action='commentaire.php' id='ajout_com'></form></div>";
									
									if (isset($_POST['like'])) {
											$req = $bdd->prepare('SELECT id_user,id_acteur,vote FROM vote WHERE id_user=:user and id_acteur=:acteur');
											$req->execute(array(
											'user' => $_SESSION['id_user'],
											'acteur' => $_GET['id_acteur']));
											$donnees=$req->fetch();
											$like_user=$donnees['vote'];
										if ($_POST['like'] == '1') {
											
											
										switch ($like_user) {
										 	case null:
										 	$req->closeCursor();
										 	$req = $bdd->prepare('INSERT INTO vote (id_acteur,id_user,vote) VALUES (:acteur,:user,1)');
											$req->execute(array(
											'user' => $_SESSION['id_user'],
											'acteur' => $_GET['id_acteur']));
											break;
										 	case -1:
										 	$req->closeCursor();
										 	$req = $bdd->prepare('UPDATE vote SET vote =1 WHERE id_acteur=:acteur AND id_user=:user');
											$req->execute(array(
											'user' => $_SESSION['id_user'],
											'acteur' => $_GET['id_acteur']));
											break;
										 	case 1:
										 	$req->closeCursor();
											$req = $bdd->prepare('DELETE FROM vote WHERE id_acteur=:acteur AND id_user=:user');
											$req->execute(array(
											'user' => $_SESSION['id_user'],
											'acteur' => $_GET['id_acteur']));
											break;
										}
									}
									elseif ($_POST['like'] == '0') {
										switch ($like_user) {
										 	case null:
										 	$req->closeCursor();
										 	$req = $bdd->prepare('INSERT INTO vote (id_acteur,id_user,vote) VALUES (:acteur,:user,"-1")');
											$req->execute(array(
											'user' => $_SESSION['id_user'],
											'acteur' => $_GET['id_acteur']));
											break;
										 	case 1:
										 	$req->closeCursor();
										 	$req = $bdd->prepare('UPDATE vote SET vote ="-1" WHERE id_acteur=:acteur AND id_user=:user');
											$req->execute(array(
											'user' => $_SESSION['id_user'],
											'acteur' => $_GET['id_acteur']));
											break;
										 	case -1:
										 	$req->closeCursor();
											$req = $bdd->prepare('DELETE FROM vote WHERE id_acteur=:acteur AND id_user=:user');
											$req->execute(array(
											'user' => $_SESSION['id_user'],
											'acteur' => $_GET['id_acteur']));
											break;
										}
									}

								}
								else {
									echo "like n'est pas défini";
								}
									$req->closeCursor();
									$req = $bdd->prepare('SELECT id_user,id_acteur,vote FROM vote WHERE id_user=:user and id_acteur=:acteur');
									$req->execute(array(
											'user' => $_SESSION['id_user'],
											'acteur' => $_GET['id_acteur']));
									$donnees=$req->fetch();
									$like=$donnees['vote'];
									$req->closeCursor();

									$req = $bdd->prepare('SELECT sum(vote) as nbvote FROM vote WHERE id_acteur=?');
									$req->execute(array($_GET['id_acteur']));
									$donnees=$req->fetch();
									
									if ($donnees['nbvote'] <0) {
										
										echo"<div id ='like'><p id='negatif'>".$donnees['nbvote']."</p>";
									}
									else {
										echo "<div id ='like'><p id='positif'>".$donnees['nbvote']."</p>";
									}
									$req->closeCursor();
									echo "<form method='post' action='acteur.php?id_acteur=". $_GET['id_acteur'] ."'><button type ='submit' name='like' value='1'";if($like==1){echo "id='vote'";} echo"><img src='ressources/thumbs-up.png'</img></button></form><form method='post' action='acteur.php?id_acteur=". $_GET['id_acteur'] ."'><button type ='submit' name='like' value='0'";if($like=='-1'){echo "id='vote'";} echo"><img src='ressources/thumbs-down.png'</img></button></form></div></div></div>";
									/*echo "<a href='acteur.php?id_acteur=". $_GET['id_acteur'] ."&like=1'><img src='ressources/thumbs-up.png' /></a><a href='acteur.php?id_acteur=". $_GET['id_acteur'] ."&like=0'><img src='ressources/thumbs-down.png' /></a></div></div></div>";*/
									
									$req = $bdd->prepare('SELECT username,nom,prenom FROM account WHERE username=?');
									$req->execute(array($username));
									$donnees=$req->fetch();
									/*echo "<form method='post' action='commentaire.php' id='ajout_com'>
									<textarea name='commentaire' id='commentaire' rows='3' cols='100' id='texte_com'>Saisissez votre commentaire ici</textarea>
									<p><input type='submit' value='Envoyer' /></p>
									</form>";*/

									$req->closeCursor();

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