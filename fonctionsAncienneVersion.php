 <!-- Création d'un tableau associatif avec les recettes -->
 $boissonsTab = array(
   "Café Long" => array(
     "Café" => 2,
     "Eau"  => 2
   ),
   "Expresso" => array(
     "Café" => 1,
     "Eau"  => 1
   ),
   "Thé" => array(
     "Thé" => 1,
     "Eau" => 1
   )
 );

 <!-- Déclaration des fonctions */ -->

 <!-- Recette du café Long en fonction du nombre de sucres */ -->
 function cafeLong ($nbSucres) {
  
   $recetteCafeLong = array();

  array_push ($recetteCafeLong," Café x 2 doses");
     array_push ($recetteCafeLong," Eau x 2 doses");

   $recetteCafeLong = ajouterSucre($recetteCafeLong, $nbSucres);
  
   return join(",", $recetteCafeLong);

 }

 <!-- Recette de l'expresso en fonction du nombre de sucres */ -->
 function expresso ($nbSucres) { 
   $recetteExpresso = array();

   array_push ($recetteExpresso," Café x 1 dose");
   array_push ($recetteExpresso," Eau x 1 dose");

   $recetteExpresso = ajouterSucre($recetteExpresso, $nbSucres);
  
   return join(",", $recetteExpresso);

 }

 <!-- Recette du thé en fonction du nombre de sucres */ -->
 function the ($nbSucres) {
  
   $recetteThe = array();

   array_push ($recetteThe, " Thé x 1 dose");
   array_push ($recetteThe, " Eau x 2 doses");
  
   $recetteThe = ajouterSucre($recetteThe, $nbSucres);
  
   return join(",", $recetteThe);

 }

  <!-- Préparation d'une boisson avec son nom et les fonctions ci-dessus  -->

 function prepareBoisson($boisson, $nbSucres) {
  if ($boisson === "Café Long") {
    $recetteCommande = cafeLong($nbSucres);
  } else if ($boisson === "Expresso") {
    $recetteCommande = expresso($nbSucres);
  } else if ($boisson === "Thé") {
    $recetteCommande = the($nbSucres);
  } else {
    $recetteCommande = "Choisissez votre boisson SVP";
  }
  
  return $recetteCommande;
} 

 <!-- Affiche chacune des boissons avec leur recette  -->
 <!-- echo var_dump($boissonsTab); -->


 