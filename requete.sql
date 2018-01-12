/*Liste des boissons*/
SELECT NomBoisson FROM `boisson`

/*Liste des ingrédients en manque (dont la quantité est nulle)*/
SELECT NomIngredients  FROM `ingredients` WHERE StockIngrédients = 0

-- Liste des boissons dont le libellé contient le mot « café »
SELECT NomBoisson FROM `boisson` WHERE NomBoisson like '%Café%'

-- Liste des boissons dont le prix est entre 0.40 et 0.70 euros
SELECT NomBoisson FROM `boisson` WHERE Prix >=40 and Prix<=70

-- Liste des ventes d’aujourd’hui classées par n° décroissant
SELECT `NumeroVente`, `Date` FROM `vente` WHERE `Date` = '2018/01/04' ORDER BY `NumeroVente` DESC

-- Liste des ingrédients (nom et qte nécesssaire) d’une boisson donnée
SELECT Quantite, NomIngredients FROM `boisson_has_ingredients` INNER JOIN boisson ON boisson.CodeBoisson = boisson_has_ingredients.Boisson_CodeBoisson 
INNER JOIN ingredients ON ingredients.CodeIngredients = boisson_has_ingredients.Ingredients_CodeIngredients WHERE NomBoisson = "Expresso" 

-- Liste des boissons disponibles (pour lesquelles les ingrédients sont dispo)
SELECT NomBoisson, Quantite, StockIngrédients  FROM `boisson_has_ingredients`JOIN boisson
 ON boisson.CodeBoisson = boisson_has_ingredients.Boisson_CodeBoisson JOIN ingredients
  ON ingredients.CodeIngredients = boisson_has_ingredients.Ingredients_CodeIngredients 
  GROUP BY NomBoisson HAVING MIN(Quantite <= StockIngrédients) = 1


-- Liste des boissons vendues aujourd’hui
SELECT NomBoisson, Date FROM boisson JOIN vente ON vente.Boisson_CodeBoisson = boisson.CodeBoisson WHERE Date = CURRENT_DATE 

-- Prix de la derniere boisson vendue
SELECT Prix, NomBoisson, Date,Heure 
FROM `boisson` JOIN vente 
ON boisson.CodeBoisson = vente.Boisson_CodeBoisson
WHERE Date = (SELECT MAX(Date)
             FROM vente)  ORDER BY Heure DESC LIMIT 1

SELECT Prix, NomBoisson, Date,Heure 
FROM `boisson` JOIN vente 
ON boisson.CodeBoisson = vente.Boisson_CodeBoisson
ORDER BY Date DESC, Heure DESC LIMIT 1

-- Nombre de ventes de la boisson « CaféLong »
SELECT COUNT(NumeroVente)
FROM vente
JOIN boisson
ON boisson.CodeBoisson = vente.Boisson_CodeBoisson
WHERE NomBoisson = "Café Long" 


-- Rajouter la boisson « Café au lait »
INSERT INTO `boisson` (`CodeBoisson`, `NomBoisson`, `Prix`) VALUES ('004', 'Café au lait', '70')

-- Rajouter 100 à la quantité en stock de l’ingrédient « sucre »
UPDATE ingredients
SET StockIngrédients = StockIngrédients +100
WHERE NomIngredients = 'Sucre'

-- Augmenter de 0.10 euros le prix de toutes les boissons
UPDATE boisson
set Prix = Prix +10

-- Créer une nouvelle vente d’expresso avec 2 sucres
INSERT  INTO vente (NumeroVente,Date,Boisson_CodeBoisson, NbSucre, Heure)  VALUES(NULL, CURRENT_DATE, '002', 2, CURRENT_TIME)

-- Supprimer cette vente
DELETE FROM vente
WHERE NumeroVente = 11