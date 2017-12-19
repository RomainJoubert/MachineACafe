
<?php
	$date = date("l d F Y H:i"); //je déclare une variable qui prend comme valeur la fonction date avec comme paramètre le jour, la date, le mois, l'année et l'heure
	$boissons = array("Expresso", "Latte", "Chocolat", "Thé"); //je déclare une variable qui prend comme valeurn un tableau avec comme paramètre la liste des boissons
	$argentInsere = 0;//je déclare une variable qui prend comme valeur 0

	$liste = "";//je déclare une variable
	foreach($boissons as $uneBoisson){
				$liste = $liste . "<button>$uneBoisson</button>";
			} // je crée une boucle qui affiche chaque élément du tableau et qui l'affiche en bouton
?>


<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" href="style.css">
	<title>Machine à café</title>
	
</head>
<body>
	<h1>Ma machine à café</h1>

<div class = "date"> Nous sommes
	<?= $date;?> <!-- Je crée une div dans laquelle s'affiche une chaine de caractère pour que s'affiche "Nous sommes" + le résultat de la variable $date -->
	
</div>

<div class = "boissons">
<h3>Liste des boissons</h3>
	<?= $liste ?> <!-- Je crée une div dans laquelle s'affiche les boutons de la variable $liste -->
<br>En attente...
</div>

<div class = "montantInsere">
	Montant inséré <?= $argentInsere?>.00€ <!--Je crée une div qui affiche la chaine de caractère "Montant inséré" + la valeur de la variable $argentInsere -->


</div>	
</body>
</html>