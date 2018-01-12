<?php
/* Déclaration des variables */
$date = date("l d F Y"); // Déclaration d'une variable $date qui prend pour valeur la fonction date avec les paramètres le jour (nom + numéro) le mois et l'année
$heure = date("H"); // Déclaration d'une variable $heure qui prend pour valeur la fonction date avec le paramètre Heure
$minutes  = date("i"); // Déclaration d'une variable $minutes qui prend pour valeur la fonction date avec le paramètre minutes
// $boissons = array("Thé Menthe","Chocolat","Café","Expresso"); // Déclaration d'une variable $boissons qui prend pour valeur la fonction tableau comprenant les paramètres des 4 boissons
$argentInsere = 0; // Déclaration de la variable $argentInsere qui prend pour valeur 0

function baseDeDonnees(){
	try
{
	$bdd = new PDO('mysql:host=localhost;dbname=machineacafe;charset=UTF8','romain','Campus1979!', array(PDO::ATTR_ERRMODE =>PDO::ERRMODE_EXCEPTION));
}
catch (Exception $e)
{
	die('Erreur : ' . $e->getMessage());
} return $bdd;
}

function menuDeroulant(){
	$bdd = baseDeDonnees();
	$drink = "";
	$drinkName = $bdd->query('SELECT * FROM boisson');
					while ($drinkTab = $drinkName->fetch())
					{
						$drink .= "<option>" . $drinkTab["NomBoisson"] . "</option>";
					}
					return $drink;
					$drinkName->closeCursor();
}

// Fonction qui permet d'éviter de répéter le code
// Affichage selon le nombre de sucres
// function ajouterSucre($recetteTab, $nbSucres) {
//   if ($nbSucres == 1) {
//     array_push($recetteTab, " Sucre x " . $nbSucres);
//   } else if ($nbSucres > 1) {
//     array_push($recetteTab, " Sucres x " . $nbSucres);
//   } else if ($nbSucres == 0) {
//     array_push($recetteTab, " Sans sucre");
//   }

//   return $recetteTab;
// }

function preparerBoisson($choixBoisson,$nbSucres){
	$bdd = baseDeDonnees();
	$i = 0;
			//je déclare une varialbe pour que la boisson ne s'affiche qu'une fois
			//si la connexion est ok, récupère la liste des boissons
				$boissonsTab = $bdd->prepare("SELECT Quantite, NomIngredients, NomBoisson FROM `boisson_has_ingredients` INNER JOIN boisson ON boisson.CodeBoisson = boisson_has_ingredients.Boisson_CodeBoisson 
						INNER JOIN ingredients ON ingredients.CodeIngredients = boisson_has_ingredients.Ingredients_CodeIngredients 
						WHERE NomBoisson = ?" );
				$boissonsTab->execute(array($choixBoisson));

				//affiche les boissons une par une
				while ($groot = $boissonsTab->fetch()){
					if($i==0){
					 $i=1;
						echo "Vous avez choisi " .$groot["NomBoisson"]."<br>";
					}			
						echo $groot["Quantite"] ." x dose(s) de " .  $groot["NomIngredients"] . "<br>"; 
				}
					if($nbSucres>0){
						echo "Avec ".$nbSucres ." x dose(s) de sucre";
					}
				$boissonsTab->closeCursor();	
} 	



// Affiche la recette d'UNE SEULE boisson
// function prepare($recette) {
// 	$liste = "";
// 	foreach($recette as $ingredient => $quantite)
// 	{
//     $liste .= $ingredient . " x " . $quantite . "<br/>";	
//   }
//   return $liste;
// }

// function prepareBoisson($boisson, $nbSucres) {
//   global $boissonsTab;

//   if ($boisson === "Café Long") {
//     $recette = $boissonsTab["Café Long"];
//   } else if ($boisson === "Expresso") {
//     $recette = $boissonsTab["Expresso"];
//   } else if ($boisson === "Thé") {
//     $recette = $boissonsTab["Thé"];
//   }

//   if ($nbSucres > 0) {
//     $recette["Sucre"] = $nbSucres;
//   }
  
//   return prepare($recette);
// } 

?>