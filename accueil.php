<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8"/>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" type="text/css" href="style.css" />
		<title>Site de la GBAF, pour une meilleure collaboration au sein du système bancaire</title>
	</head>
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
		if(isset ($_SESSION["username"]))
		{
			goto a;	
		}
		else 
		{
			header('location:home.php');
		} 
	a: ?>;
	<body>
		<div id='background'>
		<?php include("header.php");?>
		<section id='presentation'> 
			<h1>Présentation du Groupement Banque-Assurance Français (GBAF)</h1>
			<p>Le Groupement Banque Assurance Français (GBAF) est une fédération
			représentant les 6 grands groupes français :</p>
			<ul>
				<li>BNP Paribas ;</li>
				<li>BPCE ;</li>
				<li>Crédit Agricole ;</li>
				<li>Crédit Mutuel-CIC ;</li>
				<li>Société Générale ;</li>
				<li>La Banque Postale.</li>
			</ul>
			<p>Même s’il existe une forte concurrence entre ces entités, elles vont toutes travailler
			de la même façon pour gérer près de 80 millions de comptes sur le territoire
			national.</p>
			<p>Le GBAF est le représentant de la profession bancaire et des assureurs sur tous
			les axes de la réglementation financière française. Sa mission est de promouvoir
			l'activité bancaire à l’échelle nationale. C’est aussi un interlocuteur privilégié des
			pouvoirs publics.</p>
			<div id='illustration'></div>
		</section>
		<section id='acteurs'>
			<h2>Les acteurs et partenaires de la GBAF</h2>
			<p> Les produits et services bancaires sont nombreux et très variés. Afin de
				renseigner au mieux les clients, les salariés des 340 agences des banques et
				assurances en France (agents, chargés de clientèle, conseillers financiers, etc.)
				recherchent sur Internet des informations portant sur des produits bancaires et
				des financeurs, entre autres.</p>
			<p>Aujourd’hui, il n’existe pas de base de données pour chercher ces informations de
				manière fiable et rapide ou pour donner son avis sur les partenaires et acteurs du
				secteur bancaire, tels que les associations ou les financeurs solidaires.
				Pour remédier à cela, le GBAF souhaite proposer aux salariés des grands groupes
				français un point d’entrée unique, répertoriant un grand nombre d’informations
				sur les partenaires et acteurs du groupe ainsi que sur les produits et services
				bancaires et financiers.</p>
			<p>Chaque salarié pourra ainsi poster un commentaire et donner son avis.</p>
			<div id='cadre_acteurs'>
				<?php 
					$req = $bdd->query('SELECT id_acteur,acteur,description,logo FROM acteur ORDER BY id_acteur ASC');

					while ($donnees=$req->fetch())			
						{
							echo "<article><img src='" .$donnees['logo'] ."' /><div class='texte_acteur'><h3>" . $donnees['acteur']."</h3><p>".$donnees['description']."
					Site internet:<a href='https://www.chambredesentrepreneurs.com/' target=blank>https://www.chambredesentrepreneurs.com</a></p></div><div class='lien_acteur'><a href='acteur.php?id_acteur=".$donnees['id_acteur']."''>Lire la suite</a></div></article>";
						}
					$req->closeCursor();
					?>
			</div>

		<?php include("footer.php");?>
		</div>
	</body>
</html>