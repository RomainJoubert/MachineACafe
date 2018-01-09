
<?php
include "fonctions.php";

	$messageAttente ="Sélectionnez votre boisson";
	$date = date("l d F Y H:i"); //je déclare une variable qui prend comme valeur la fonction date avec comme paramètre le jour, la date, le mois, l'année et l'heure
	// $boissons = array("Expresso", "Latte", "Chocolat", "Thé"); //je déclare une variable qui prend comme valeurn un tableau avec comme paramètre la liste des boissons
	$argentInsere = 0;//je déclare une variable qui prend comme valeur 0
	// $messageAttente = "Sélectionnez votre boisson"; // Déclaration d'un variable $messageAttente qui prend pour valeur la chaine de caractères du message d'attente
	// $liste = "";//je déclare une variable
	// foreach($boissons as $uneBoisson){
				// $liste = $liste . "<button>$uneBoisson</button>";
			// } // je crée une boucle qui affiche chaque élément du tableau et qui l'affiche en bouton
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
	<?= $date; ?> <!-- Je crée une div dans laquelle s'affiche une chaine de caractère pour que s'affiche "Nous sommes" + le résultat de la variable $date -->
	
</div>

<!-- <div class = "boissons">
<h3>Liste des boissons</h3>
	<?= $liste ?> Je crée une div dans laquelle s'affiche les boutons de la variable $liste
<br>En attente...
</div>
 -->
<div class = "montantInsere">
	<p>Montant inséré <?= $argentInsere?>.00€</p> <!--Je crée une div qui affiche la chaine de caractère "Montant inséré" + la valeur de la variable $argentInsere -->
</div>	

 		<!-- <form method="post" action="machineCafe.php">
		<p>Choisissez votre boisson :</p>
		<input type="text" name="boisson" placeholder="Saisissez votre boisson">
		<p></p>
		<input type="text" name="sucre" placeholder="Quantité de sucre désiré">
		<input type="submit" value="valider"> -->
		
		<div class="blocInfos">
			<form method="post" action="machineCafe.php">
				<select name="choixBoisson">
					<option name="choix">Choisissez votre boisson</option>
				
					<?= menuDeroulant();?>			
				</select>

				<input type="number" min="0" max="5" name="choixSucre" placeholder="Combien de sucres ?"/>
				<input type="submit" value="Valider"/>
			</form>
			<p>
			<?php
			if (isset($_POST["choixBoisson"]) AND isset($_POST["choixSucre"]))
			{
			echo preparerBoisson($_POST['choixBoisson'], $_POST["choixSucre"]);
			} else {
				echo $messageAttente;
				}

			// Teste si la variable existe
			// if (isset($_POST["choixBoisson"]) AND isset($_POST["choixSucre"])) {
			// 	echo "Vous avez choisi '" . $_POST["choixBoisson"] . "', dont la recette est :<br>";
 		// 		echo prepareBoisson($_POST["choixBoisson"], $_POST["choixSucre"]);
			// } else {
			// 	echo $messageAttente;
			// }
			//Je récupère tout le contenur de la table boisson

			
			
				
			// $reponse = $bdd->query('SELECT *FROM boisson');

			//J'affiche chaque entrée une par une
			// while ($donnees = $reponse->fetch())
			// {
			// 	echo $donnees['NomBoisson']." dont le prix est : ".$donnees["Prix"]." centimes."."<br>";
			// }

			// $reponse->closeCursor();
			?>
			</p>

		</div>

		<div class="blocInfos">
			Solde = 
			<?= $argentInsere ?> <!-- Insertion de l'argent inséré en php -->
			.00 €
		</div>
		
	   	<div id="pieces">
	       	<img id="btnCinqCts" class="piece" alt="0.05" src="images/5_cts.png">
	        <img id="btnDixCts" class="piece" alt="0.10" src="images/10_cts.png">
	        <img id="btnVingtCts" class="piece" alt="0.20" src="images/20_cts.png">
	        <img id="btnCinquanteCts" class="piece" alt="0.50" src="images/50_cts.png">
	        <img id="btnUnEuro" class="piece" alt="1.00" src="images/1_euros.png">
	        <img id="btnDeuxEuros" class="piece" alt="2.00" src="images/2_euros.png">
	    </div>
		    <div id="afficheurMonnaie">
		        <div id="monnayeur">Crédit : 0.00 €</div>
			</div>
			<div id="btnResetCoin"><button>Reset Coin</button></div>
	</div>
</body>
</html>
