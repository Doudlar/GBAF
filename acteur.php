<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="utf-8"/>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<script src='js/commentaire.js' defer></script>
		<link rel="stylesheet" type="text/css" href="style.css" />
		<title>Site de la GBAF, pour une meilleure collaboration au sein du système bancaire</title>
	</head>
	<?php
	//Vérification que l'utilisateur est bien connecté sinon renvoi à la page de connexion	
	session_start();
	if(isset ($_SESSION['username'])) {
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
				//Vérification de l'id acteur récupérée via l'URL sinon message d'erreur
				$req = $bdd->prepare('SELECT COUNT(id_acteur) as nbacteur FROM acteur WHERE id_acteur=?');
				$req->execute(array($_GET['id_acteur']));
				$donnees=$req->fetch();
				if (isset($_GET['id_acteur']) and $donnees["nbacteur"]>0) {
					
					?>
					<article id='presentation_acteur'>
						<?php		
							//Récupération des infos de l'acteur en BDD pour affichage dans la page
							$req = $bdd->prepare('SELECT id_acteur,acteur,description,logo,site FROM acteur WHERE id_acteur=?');
							$req->execute(array($_GET['id_acteur']));

							$donnees=$req->fetch();			
							$description =preg_replace('#\.#i','.<br/>',$donnees['description']);
							$description =preg_replace('#\-#i','<br/>-',$description);
							echo "<img src='".$donnees['logo']."' />
								<div id='acteur'><h2>".$donnees['acteur']."</h2><p><a href='".$donnees['site']."' target=blank>Visitez leur site</a></p>
								<p>".$description."</p>
								</div>";
							$req->closeCursor();
							?>
					</article>

					<div id='cadre_commentaire'>
					<div id='commentaires'>
						<?php
							//Vérification de l'initialisation de la variable commentaire pour insertion du commentaire dans la base sinon aucune action + vérification de l'unicité du commentaire sinon affichage d'un message d'erreur
							$commentaire=0;
							if (isset($_POST['commentaire'])) {
							 	$req = $bdd->prepare('SELECT id_user,id_acteur,post FROM post WHERE id_user=:user and id_acteur=:acteur');
								$req->execute(array(
								'user' => $_SESSION['id_user'],
								'acteur' => $_GET['id_acteur']));
								$donnees=$req->fetch();
								if ($donnees['id_user']==false) {			 	
								 	$req->closeCursor();
								 	$req = $bdd->prepare('INSERT INTO post (id_user,id_acteur,date_add,post) VALUES (:user,:acteur,CURRENT_TIMESTAMP,:post)');
									$req->execute(array(
									'user' => $_SESSION['id_user'],
									'post' => $_POST['commentaire'],
									'acteur' => $_GET['id_acteur']));
									$req->closeCursor();
								}
								else {
									$commentaire=1;
								}
							}
							//Récupération du nombre de commentaires en BDD et affichage sur la page
							$req = $bdd->prepare('SELECT count(id_acteur) as nbcommentaires FROM post WHERE id_acteur=?');
							$req->execute(array($_GET['id_acteur']));
							$donnees=$req->fetch();
							echo "<p>". $donnees['nbcommentaires'] . " commentaires</p>";
							$req->closeCursor();
							//Bouton pour ajouter un commentaire qui affiche les champs de saisie au clic (voir script js)
							echo "<div id='com_et_like'><div id='nouveau_commentaire'><a href='#texte_com' id='lien_commentaire'>Nouveau commentaire</a></div>";

							//Vérification de l'initialisation de la variable like pour MAJ/insertion du vote dans la base sinon aucune action
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
							$req->closeCursor();
							

							//Récupération en BDD du total des votes pour l'acteur pour affichage et mise en forme
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
							//Récupération en BDD du vote actuellement enregistré pour l'utilisateur pour mise en forme
							$req = $bdd->prepare('SELECT id_user,id_acteur,vote FROM vote WHERE id_user=:user and id_acteur=:acteur');
							$req->execute(array(
									'user' => $_SESSION['id_user'],
									'acteur' => $_GET['id_acteur']));
							$donnees=$req->fetch();
							$like=$donnees['vote'];
							$req->closeCursor();
							//Affichage des likes et boutons pour liker/disliker
							echo "<form method='post' action='acteur.php?id_acteur=". $_GET['id_acteur'] ."'><button type ='submit' name='like' value='1'";if($like==1){echo "id='vote'";} echo"><img src='ressources/thumbs-up.png'</img></button></form><form method='post' action='acteur.php?id_acteur=". $_GET['id_acteur'] ."'><button type ='submit' name='like' value='0'";if($like=='-1'){echo "id='vote'";} echo"><img src='ressources/thumbs-down.png'</img></button></form></div></div></div>";
							
							//Formulaire de saisie d'un nouveau commentaire affiché quand on clique sur le bouton nouveau commentaire
							echo "<form method='post' action='acteur.php?id_acteur=". $_GET['id_acteur'] ."' id='ajout_com'>
							<textarea name='commentaire' id='commentaire' rows='3' cols='100' id='texte_com'>Saisissez votre commentaire ici</textarea>
							<p><input type='submit' value='Envoyer' /></p>
							</form>";
							if ($commentaire==1) {
								echo "<p class=erreur>Vous ne pouvez pas écrire plus d'un commentaire par acteur</p>";
							}

							$req->closeCursor();
							
							//Récupération en BDD des commentaires pour l'acteur et affichage dans la page
							$req = $bdd->prepare('SELECT p.id_post,p.post,a.nom,a.prenom,DATE_FORMAT(p.date_add, \'%d/%m/%Y\') as date_comm FROM post p LEFT JOIN account a on p.id_user=a.id_user WHERE p.id_acteur=? ORDER BY p.id_post DESC');
							$req->execute(array($_GET['id_acteur']));

							while ($donnees=$req->fetch())
							{	
								echo "<div class='detail_commentaire'><p>".$donnees['nom']." ".$donnees['prenom']."</p><p>".$donnees['date_comm']."</p><p>".$donnees['post']."</p></div>
								";
							}
						echo "</div>";
					 	
			}
				else 
				{
					echo "<p class='erreur'>Erreur, acteur introuvable, merci de vérifier votre URL</p>";
				}	
			include("footer.php");?>
				</body>
			</html>
			