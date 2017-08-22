# Vendredi - Test case

Vendredi est un projet Laravel 5.3.

## Installation

### Prérequis

Avoir installé: `php7.0`.


### Première installation

Pour préparer les bases de données SQLite :
 
    touch database/database.sqlite
    touch database/database.testing.sqlite

Pour installer les dépendances et générer les fichiers de config: 

    composer install
    cp .env.example .env
    php artisan key:generate
   
Préparer la structure de la base de données:

    php artisan migrate
    # remplir les données de base (model School et Education)
    php artisan db:seed
  
    
Pour créer un utilisateur avec des droits d'admin dans l'interface:

    vendredi:create-admin {email} {password}
    
### Lancer le serveur de dev (port 8000 par défaut) 

    php artisan serve
    
### Jouer les tests

Lancer `phpunit` depuis la racine du projet.


### Assets pipeline

Laravel utilise `Elixir` comme asset pipeline par défaut. La config de base permet de construire automatiquement un fichier app.css à partir de tous les fichiers de /resources/assets/sass/ et un fichier app.js en intégrant ses dépendances.

Pour installer et utiliser Elixir : 

    npm install --global gulp-cli
    npm install  # install from package.json

Pour lancer la build auto (dev)

    gulp watch

Pour lancer la build prod

    gulp --production

Plus de détails : https://laravel.com/docs/5.3/elixir
  
### Customiser un modèle

#### Défault

Backpack va par défaut charger les entités et essayer de déduire en fonction du type de champs qui lui revient le type de colonne/champ à appliquer dans son UI - c'est pour ça qu'on peut laisser les controller des entités simples quasiment vide.

Pour les champs plus complexe par contre, type relation 1-n ou n-n, il faut lui préciser les éléments qu'on veut voir apparaitre. Cette customisation se fait dans la fonction `setUp` du `CompanyCrudController`.

Les options suivantes sont disponibles (voir [listes des champs possibles](https://laravel-backpack.readme.io/docs/crud-fields)):

    
    // ------ CRUD FIELDS
    $this->crud->addField($options, 'update/create/both');
    $this->crud->addFields($array_of_arrays, 'update/create/both');
    $this->crud->removeField('name', 'update/create/both');
    $this->crud->removeFields($array_of_names, 'update/create/both');

    // ------ CRUD COLUMNS
    $this->crud->addColumn(); // add a single column, at the end of the stack
    $this->crud->addColumns(); // add multiple columns, at the end of the stack
    $this->crud->removeColumn('column_name'); // remove a column from the stack
    $this->crud->removeColumns(['column_name_1', 'column_name_2']); // remove an array of columns from the stack
    $this->crud->setColumnDetails('column_name', ['attribute' => 'value']); // adjusts the properties of the passed in column (by name)
    $this->crud->setColumnsDetails(['column_1', 'column_2'], ['attribute' => 'value']);

    // ------ CRUD BUTTONS
    // possible positions: 'beginning' and 'end'; defaults to 'beginning' for the 'line' stack, 'end' for the others;
    $this->crud->addButton($stack, $name, $type, $content, $position); // add a button; possible types are: view, model_function
    $this->crud->addButtonFromModelFunction($stack, $name, $model_function_name, $position); // add a button whose HTML is returned by a method in the CRUD model
    $this->crud->addButtonFromView($stack, $name, $view, $position); // add a button whose HTML is in a view placed at resources\views\vendor\backpack\crud\buttons
    $this->crud->removeButton($name);
    $this->crud->removeButtonFromStack($name, $stack);

    // ------ CRUD ACCESS
    $this->crud->allowAccess(['list', 'create', 'update', 'reorder', 'delete']);
    $this->crud->denyAccess(['list', 'create', 'update', 'reorder', 'delete']);

    // ------ CRUD REORDER
    $this->crud->enableReorder('label_name', MAX_TREE_LEVEL);
    // NOTE: you also need to do allow access to the right users: $this->crud->allowAccess('reorder');

    // ------ CRUD DETAILS ROW
    // $this->crud->enableDetailsRow();
    // NOTE: you also need to do allow access to the right users: $this->crud->allowAccess('details_row');
    // NOTE: you also need to do overwrite the showDetailsRow($id) method in your EntityCrudController to show whatever you'd like in the details row OR overwrite the views/backpack/crud/details_row.blade.php

    // ------ REVISIONS
    // You also need to use \Venturecraft\Revisionable\RevisionableTrait;
    // Please check out: https://laravel-backpack.readme.io/docs/crud#revisions
    $this->crud->allowAccess('revisions');

    // ------ AJAX TABLE VIEW
    // Please note the drawbacks of this though:
    // - 1-n and n-n columns are not searchable
    // - date and datetime columns won't be sortable anymore
    $this->crud->enableAjaxTable();

    // ------ DATATABLE EXPORT BUTTONS
    // Show export to PDF, CSV, XLS and Print buttons on the table view.
    // Does not work well with AJAX datatables.
    $this->crud->enableExportButtons();

    // ------ ADVANCED QUERIES
    $this->crud->addClause('active');
    $this->crud->addClause('type', 'car');
    $this->crud->addClause('where', 'name', '==', 'car');
    $this->crud->addClause('whereName', 'car');
    $this->crud->addClause('whereHas', 'posts', function($query) {
        $query->activePosts();
    });
    $this->crud->with(); // eager load relationships
    $this->crud->orderBy();
    $this->crud->groupBy();
    $this->crud->limit();
    
> **Attention aux champs n-n**
> 
> Avec un champ n-n (par exemple `values` pour notre `company`)' il est necessaire de marquer ce champ comme `$guarded` dans l'entité qui va enregistrer la relation pour que backpack n'essaie pas de le mass-assign en plus de l'enregistrer dans la table pivot. Par exemple dans `Company`:
>
>     $guarded = [ 'id', 'values' ];

