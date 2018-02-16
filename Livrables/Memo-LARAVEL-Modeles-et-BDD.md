# Mémo LARAVEL - Modèles et BDD
## *Campus Numérique 2018 - Véronique ROUAULT*
#

# Les Modèles

`Un modèle permet d'interagir avec les tables de la BDD`

## Créer un modèle & sa migration
Ligne de commande pour créer un modèle et sa migration
```php
php artisan make:model Nom_modele -m
```
* Le fichier modèle créé sera dans :
```php
App/Nom_modele.php
```

* Le fichier de migration créé sera :
```php
Database/Migrations/create_nomTable_table
```
Pour créer une table de migration directement dans le dossier Database/Migrations/
```php
php artisan make:migration create_nomTable --create=nomTable
```

## Renseigner la fonction "UP" avec les champs que l'on veut créer dans la table
```php
class CreateBoissonTable extends Migration
{
    public function up()
    {
        Schema::create('boissons', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->integer('price');
            $table->timestamps();
        });
    }
}
```

Dans le modèle et dans la classe, indiquer les champs que l'on autorise à modifier 
```php
class Boisson extends Model
{
    //Préciser les champs que l'on a le droit de modifier 
    protected $fillable = ['name', 'price'];
}
```
Pour créer la table dans la BDD : 
```php
php artisan migrate
```
Pour annuler la dernière migration faite. (`Attention` : à utiliser prudemment car la table et les données seront perdues).
```php
php artisan migrate:rollback
```
# Les relations  

## Relation 1:n   --->  hasMany()

Une boisson a plusieurs ventes
  
Dans le model Boisson, ajouter :

```php
public function ventes()
{
return $this->hasMany('App\Vente');
}
```      
Dans le model Vente, ajouter
```php
public function boisson ()
{
return $this->belongsTo('App\boisson');
}
```

La méthode `boisson` (au singulier) permet de trouver la boisson qui appartient à la vente `(belongsTo)`.
C'est la réciproque de la méthode précédente.  


Dans le fichier de migration vente :
```php
public function up()
    {
    Schema::create('ventes', function (Blueprint $table) {
        $table->increments('id');
        $table->integer('nbSucre'); 
        $table->integer('boisson_id')->unsigned();
        $table->foreign('boisson_id')->references('id')->on('boissons');            
        $table->timestamps();
    });
```
Dans le fichier controller vente, ajouter dans l'entête les liens réciproques des 2 modèles
```php
    use App\Vente;
    use App\Boisson; 
```
        
et modifier le code
```php
//ajouter une commande
public function store(Request $request)
{
    $ventes = new Vente();
    //récupère dans le model Boisson un tableau avec la liste des boissons. [0]:position 0 du tableau
    $boisson = Boisson::whereNom(request('inputBoisson'))->get()[0];
    $ventes->boisson_id = $boisson->id;
    $ventes->nbSucre = request('inputNbSucre');
    $ventes->save();

    return redirect('commandes');
}
```
    
*Dans le fichier vente.blade :
```php
@foreach($ventes as $vente)
        <tr>
            <td>{{$vente->id}} </td>
            <td>{{$vente->boisson->nom}} </td>  //utilise la table boisson
            <td>{{$vente->boisson->prix}} </td>
            <td>{{$vente->nbSucre}}</td>
            <td>{{$vente->boisson_id}}</td>
            <td>{{$vente->created_at}}</td>
        </tr>
@endforeach
```
Dans le fichier route 
```php
    Route::post('commandes/create','CommandeController@store');
```
----
## Relation n:n  ---> belongsToMany() 

Une boisson peut avoir plusieurs ingrédients et un ingrédient peut appartenir à plusieurs boissons  

Dans le model Boisson :
```php
public function ingredients()
{
    return $this->belongsToMany('App\Ingredient')->withPivot('nbDose','id');
}  
```         
Dans le model Ingredient :
```php
public function boissons()
    {
        return $this->belongsToMany('App\boisson')->withPivot('nbDose','id');
    }  
``` 
___   
## Afficher toutes les recettes et toutes les boissons

Dans le fichier recettecontroller
```php
public function showRecipes() 
{
    //Récupèrer les ingrédients d'une boisson
    $boissons= Boisson::all()->load('ingredients');

    //Retourner la vue avec les données 
    return view('back_office/recettes', ["boissons"=> $boissons]);
}
```
Dans le fichier recette.blade
```php
@foreach ($boissons as $boisson)
    @foreach($boisson->ingredients as $ingredient)
<tr>
    <td>{{$boisson->nom}}</td>
    <td>{{$ingredient->nomIngredient}}</td>
    <td>{{$ingredient->pivot->nbDose}}</td>
</tr> 
    @endforeach 
@endforeach 
```
Dans le fichier route
```php
    Route::get('/recettes','recipesController@showRecipes');    
```
## Afficher le tableau des Ingrédients de chaque boisson (Sur la même page)  

Dans le fichier resultBoisson.blade
```php
@foreach ($boisson->ingredients as $ingredient)
    <tr>
        <td>{{$ingredient->pivot->id}}</td> 
        <td>{{$boisson->nom}}</td> 
        <td>{{$ingredient->pivot->ingredient_id}}</td>
        <td>{{$ingredient->nomIngredient}}</td>
        <td>{{$ingredient->pivot->nbDose}}</td> 
        <td>
            <form id= "delete{{$ingredient->pivot->id}}" method="post" action="/ingredient/{{$boisson->id}}/{{$ingredient->id}}">
                {{ csrf_field() }}
                {{method_field('DELETE')}}
                <div class="btn-group">
                    <button type="submit" form="delete{{$ingredient->pivot->id}}" class="btn btn-outline-danger"> X </button>
                </div>
            </form>
        </td>
    </tr>
@endforeach  
```
Dans le fichier controller 

*(attention : cette methode effectue plusieurs actions)*  
```php
function lien(boisson $id)
    {	/*$boisson =boisson::find($id);*/
        $boisson = $id->load('ingredients'); // load relation avec ingredients
        $allIngredients = Ingredient::all(); // récupère toutes les données ingredients
        $allIngredients= $allIngredients->diff($boisson->ingredients); //différence entre les données présentes et absentes (affiche les ingrédients qui ne sont pas déjà présents dans la recette)
        $data = [
            'boisson' => $boisson,
            'allIngredients' => $allIngredients,
        ];

        return view('back_office/resultBoisson', $data);
    }
```
## Créer une liste déroulante avec tous les ingrédients disponibles sauf ceux déjà utilisés

Dans le controller boisson
```php
    function lien(boisson $id)
	{	$boisson = $id->load('ingredients'); // load relation avec ingredients
		$allIngredients = Ingredient::all(); // récupère toutes les données ingredients
		$allIngredients= $allIngredients->diff($boisson->ingredients); //différence entre les données présentes et absentes (affiche les ingrédients qui ne sont pas déjà présents dans la recette)
		$data = [
			'boisson' => $boisson,
			'allIngredients' => $allIngredients,
		];

		return view('back_office/resultBoisson', $data);
	}
```

Dans le fichier resultBoisson
```php
    <form class="form-inline col-sm-12 push-3" method ="post" action="/recipe/create/{{$boisson->id}}">
			{{ csrf_field() }}

		<select class="form-control col-sm-3" name="ingredient">
			@foreach($allIngredients as $ingredient)
			<option value="{{$ingredient->id}}">{{$ingredient->nomIngredient}}</option>
			@endforeach
		</select>
		</br>
		<input type="text" name="nbDose" class="form-control" placeholder="quantité" required ="required">
				
		<button type="submit" class="btn btn-outline-secondary" name="valider">valider</button>
				
	</form>
```
Dans le fichier route
```php
    Route::get('/boissons/{id}', 'boissonController@lien');  
```
## Ajouter une recette depuis la boisson sélectionnée

Dans le fichier controller
```php
    public function addRecipe(Request $request, boisson $boisson)
	{	// $ingredient récupère l'id de l'ingredient via la requete
		$ingredient = Ingredient::find($request->input('ingredient'));
		$nbDose = $request ->input('nbDose');
		
		$boisson->ingredients()->attach($ingredient, ['nbDose'=> $nbDose]);

		return redirect()->back();
	}   
```

Dans le fichier .blade
```php
    <form class="form-inline col-sm-12 push-3" method ="post" action="/recipe/create/{{$boisson->id}}">
			{{ csrf_field() }}

		<select class="form-control col-sm-3" name="ingredient">
			@foreach($allIngredients as $ingredient)
			<option value="{{$ingredient->id}}">{{$ingredient->nomIngredient}}</option>
			@endforeach
		</select>
		</br>
		<input type="text" name="nbDose" class="form-control" placeholder="quantité" required ="required">
				
		<button type="submit" class="btn btn-outline-secondary" name="valider">valider</button>
				
	</form>
```
Dans le fichier route
```php
    Route::post('recipe/create/{boisson}','boissonController@addRecipe');
```
    
