# Vendredi - Test case

Vendredi est un projet Laravel 5.3.

## Installation

### Prérequis

Avoir installé: `php7.0`, `php7.0-pdo-pgsql`, postgres.

Il faut avoir une base de données postgres et un utilisateur avec tous les droits dessus.

### Première installation

Pour installer les dépendances et générer les fichiers de config: 

    composer install

Remplir les informations de connexion à la base de données dans le fichier `.env`.
   
Préparer la structure de la base de données:

    php artisan migrate
    # remplir les données de base (model School et Education)
    php artisan migrate:seed
    
Pour gérer les recherches qui ne tiennent pas compte des accents/de la casse, on a besoin d'activer l'extension `unaccent` dans postgres (`heroku pg:psql` pour se connecter à postgres sur heroku)

    create extension unaccent;
    
Pour créer un utilisateur avec des droits d'admin dans l'interface:

    vendredi:create-admin {email} {password}
    
### Jouer les tests

Pour jouer les tests, il faut avoir une base de test vide à disposition. La section de `config/database` qui gère la connexion utilise les variale d'environnement suivantes:

    'host' => env('DB_HOST_TEST', 'localhost'),
    'port' => env('DB_PORT_TEST', '5432'),
    'database' => env('DB_DATABASE_TEST', 'vendredi_test'),
    'username' => env('DB_USERNAME_TEST', env('DB_USERNAME', 'forge')),
    'password' => env('DB_PASSWORD_TEST', env('DB_PASSWORD', '')),
    
Une fois la BDD postgres créée, ne pas oublier de jouer une fois

    create extension unaccent;
    
Puis lancer `phpunit` depuis la racine du projet.

## Developpement et structure du code 

Les fichiers publics sont stockés sur Amazon S3.

Le schema structure de la base de données est accessible sur [draw.io](https://drive.google.com/file/d/0B2VQCIUBXfhxc1otWTJSWUlxMGc/view?usp=sharing).

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

### Heroku & deploiement

Installer la toolbelt Heroku : https://devcenter.heroku.com/articles/heroku-cli#download-and-install

Pour ajouter la remote git : 

    git remote add heroku-dev https://git.heroku.com/vendredi-dev.git

Pour pusher en dev : 
    
    git push heroku-dev master

Migration :

    heroku run php artisan migrate

Autres commandes :
 
    heroku run your-command
    # ex pour un shell: heroku run /bin/bash
    
### Commandes laravel

Il y a plusieurs commandes customs:

- `vendredi:create-admin {email} {password}`: crée un administrateur
- `vendredi:unpublish-old-missions {--a|age=90}`: dépublie les missions plus vielles que le nombre de jours indiqués dans `-a` (défault à 90 jours).

Sur Heroku en prod, une cron (à travers Heroku Scheduler) tourne tous les jours vers minuit pour jouer la commande de dépublication.

### Modèles

Certains modèles ont un statut publié ou non. On retient un certain nombre d'informations (date de dernière publication, etc), les méthodes nécessaires au changement de statut sont dans le `IsPublishedTrait`.

> **Attention**: pour passer d'un statut publié à non publié ou vice verse, toujours utiliser le pseudo attribut `$entity->is_published = true|false` qui se charge de bien mettre à jour ces champs. 
    
### HTTPS

Le site (vendredi.cc et www.vendredi.cc) est équipé d'un certificat fourni par [LetsEncrypt](https://letsencrypt.org). Ce certificat est valide pour une durée de 3 mois, et doit actuellement être renouvelé à la main (en attendant un plugin heroku qui permet de le faire automatiquement...).
 
 Un exemple des étapes qu'on peut suivre pour le renouveler dans [cet article](https://medium.com/@bantic/free-tls-with-letsencrypt-and-heroku-in-5-minutes-807361cca5d3#.2arhby3co).

## Admin: Backpack

Pour générer l'interface d'administration, on utilise Laravel Backpack et son module CRUD ([github](https://github.com/Laravel-Backpack/CRUD) et [doc](https://laravel-backpack.readme.io/docs/crud-example)).

### Créer un nouveau modèle

Pour créer un modèle, par exemple `company`, on utilise la commande suivante: 

    php artisan backpack:crud company
    
Ce qui va nous générer:

- un controller `AssociationCrudController` dans `app/Http/Controllers/Admin`, qui est là où on customise les champs d'édition et colonnes d'affichage de l'entité
- un modèle `Company` dans `app/Models`, à supprimer: on place nos modèles à nous directement dans `app`. Il faut modifier notre modèle comme ceci:

      // app/Company.php
      use Backpack\CRUD\CrudTrait;
      ...
        
      class Company extends Model
      {
          // necessaire pour le bon fonctionnement de backpack
          use CrudTrait;
        
          // necessaire de spécifier soit une liste de $fillable, soit au moins un $guarded
          // car backpack utilise du mass-assignment pour créer des entités
          protected $guarded = [ 'id' ];
          ...
- une requête `CompanyRequest` dans `app/Http/Requests`, qu'on peut customiser pour ajouter des règles de validation au formulaire d'édition de l'entité
 
Il reste à rajouter une route dans le namespace admin:
 
    Route::group(['prefix' => 'admin', 'middleware' => ['web', 'auth'], 'namespace' => 'Admin'], function () {
        ...
        CRUD::resource( 'company', 'CompanyCrudController' );
        
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

#### Méthodes customs

Les CrudController héritent du `App\Http\Controllers\Admin\BaseCrudController`, qui étend le controller de base de backpack pour rajouter des méthodes fréquemment utilisées. Aller voir les commentaires de ces méthodes pour leur détail, quelques exemple (à activer dans la config de routing):

- `import`: importe un fichier CSV
- `publish`: gère la publication/dépublication d'une entité

On y a également étendu les méthodes de base pour les connecter avec la synchro AirTable.

L'API du CrudPanel a également été étendue dans `App\CRUD\CrudPanel` - là aussi, aller y voir pour savoir ce qu'elles font. 

### Synchro AirTable

Limitations de l'API AirTable: 5 appels max par seconde, sinon ban des requètes pendant 30s.

#### CRUD

Pour activer la synchro AirTable d'une entité dans l'admin, rajouter

    $this->crud->setAirTableSync( $airTableConnectorName ); // ex: AirTable::JOB. 'null': défault, pas de synchro
    
La synchro se fait actuellement automatiquement à l'insertion, l'update, la suppression et le changement du statut de publication d'une entité.

> **Attention**: si la synchro AirTable échoue pour une raison ou pour une autre, l'enregistrement dans l'admin ne se fait pas.

#### Code

La logique de synchronisation se trouve dans `App\Connectors`. Pour ajouter une table, créer un nouveau connecteur qui hérite de `App\Connectors\AirTable\Connector` avec les méthodes qui vont bien, puis l'enregistrer dans `App\Connectors\AirTable`.

On se base sur les vendredi ID pour faire la correspondance entre les entrées en base d'admin et celle dans AirTable.

#### Config

La config se fait dans `app/config/airtable.php`. On a les variable d'environnement suivantes:

- AIRTABLE_ENABLED: `true` ou `false` pour activer ou non la synchro 
- AIRTABLE_URL: l'url de base vers la base AirTable (ex: `https://api.airtable.com/v0/appNlM2erBvNi134`)
- AIRTABLE_APIKEY
- AIRTABLE_COMPANY_TABLE, AIRTABLE_JOB_TABLE, AIRTABLE_ASSOCIATION_TABLE, AIRTABLE_MISSION_TABLE: nom de la table correspondante 

On peut régler ces variables d'environnement depuis l'interface heroku sans avoir à toucher au code.

### Import

Les imports sont gérés dans les classe `App\Importers` - c'est là qu'on définit les noms et l'ordre des colonnes attendus.
 
Pour activer l'import pour une admin, dans un CrudController ajouter:

    $this->crud->enbaleImporter( App\Importers\Importer::JOB );

### Elements customs

On peut facilement rajouter des éléments à backpack dans `resources/views/vendor/backpack/crud`. En général, regarder les éléments qui s'y trouvent qui devraient être simples ou bien commentés.

#### Bouton

- **import**: ajoute un bouton qui permet d'uploader un fichier. Pointe vers route + `/import`

#### Colonne

- **html**: montre les champs HTML sous forme rendue (n'escape pas les tags)
- **date-format**: permet un format custom de la date, avec la première lettre en majuscule
- **image-s3**: montre le nom du fichier sur S3 ainsi qu'une preview de l'image
- **text-suffix**: ajoute un suffixe à la valeur affichée, en gardant le tri sur la valeur d'orgine
- **checkbox-toggle**: une checkbox en forme de bouton switch, qui va taper sur l'url précisée dans `url` en `POST`

Avec un override dans `list.blade.html`, on peut ajouter des attributs HTML à l'élement `<th>` d'une colonne avec le champ `html_attributes` - par exemple:

    'html_attirbute' => 'style="min-width: 30em"'

#### Champ

- **tinymce**: éditeur HTML, ajout du champ `options` pour overrider la configuration par défaut de tinyMCE
- **image-s3**: permet d'uploader et resizer une image. Basé sur le champ `image`, on a en plus une preview de l'image depuis S3.
- **text-fixed**: affiche une preview du texte qu'on est en train de taper dans l'admin, tronquée au bout de `max_length` caractères
- **textarea-fixed**: idem mais avec un champ `textarea`, plus grand
- **url**: override le champ naturel pour préfixer un champ vide par `http://`
- **select2**: override champ d'origine pour rajouter des options customs à l'instantiation des widgets `select2`.  
- **select2_multiple**: override champ d'origine pour rajouter des options customs à l'instantiation des widgets `select2`. Par exemple: `'options' => [ 'maximumSelectionLength' => 2 ]` pour limiter le nombre d'items selectionnable à deux.   

#### Filtre

- **select2_ajax**: override le champ de base pour rajouter la possibilité d'avoir des paramètres custom dans l'URL qui charge les données en ajax. Utile pour par exemple retourner les jobs qui correspondent à une seule entreprise.
