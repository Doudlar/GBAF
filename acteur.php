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
		
		<article id='presentation_acteur'>
			<img src="ressources/cde.png" />
			<div id="acteur"><h2>CDE</h2><p><a href="https://www.chambredesentrepreneurs.com/" target=blank>https://www.chambredesentrepreneurs.com</a></p>
				<p>La CDE (Chambre Des Entrepreneurs) accompagne les entreprises dans leurs démarches de formation.<br/> 
					Son président est élu pour 3 ans par ses pairs, chefs d’entreprises et présidents des CDE. </p>
			</div>
		</article>

		<div id='cadre_commentaire'>
		<div id='commentaires'>
			<p> X Commentaires</p><div id='nouveau_commentaire'><p><a href="commentaire.php">Nouveau commentaire</a></p></div>
			<div id ="like"><a href="like.php"><?php echo "5" ?><img src='ressources/rating.png' /></a></div>
		</div>
			<?php echo "<div class='detail_commentaire'><p>Edouard</p><p>27/05/2021</p><p>Texte du commentaire</p></div>" ?>
		</div>

		<?php include("footer.php");?>

		</div>
	</body>
</html>