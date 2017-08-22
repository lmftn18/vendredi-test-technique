# Test technique Vendredi


## Mise en place

Pour démarrer le test technique tu dois :

- te créer un compte GitHub
- forker ce repository sur ton propre compte
- cloner ce repository en local
- suivre les indications d'installation du ficher [install.md](./install.md)
- créé ta propre branche (nom-prenom) sur laquelle tu vas travailler


Une fois la base de code prête et fonctionnelle, tu peux commencer le test.


## Test technique (maximum 2h)

Ci-dessous te sont présentées 2 user story que tu dois implémenter.  
- Tu peux les traiter dans l'ordre que tu veux
- Le code back-end est testé avec PHP Unit, tu dois réaliser au moins un test même s'il est très simple
- N'hésite pas à ajouter des commentaires dans le code pour expliquer ta démarche

### 1. Front-end


Quand je suis sur la page [Devenir Partenaire](https://www.vendredi.cc/devenir-partenaire)

Onglet de droite *Pour les associations* (div#partenaire-pour-les-assos) : 

- Changer le texte du bouton "En savoir plus" pour "Nous écrire"

- Au clic sur ce bouton "Nous écrire"

    - Ouverture d'un court formulaire en "pop-up" -> (L'ouverture / fermeture du modal reprend les animations in/out du modal "Ils ont vécu un Vendredi" que l'on découvre en cliquant sur le bouton "Decouvrir" depuis la page www.vendredi.cc)

    - Titre du formulaire : "Nous contacter"

    - Possibilité de refermer le modal (croix en haut à droite)

    - Champs : 
        - Nom & prénom 
        - Adresse Mail 
        - Votre demande
        - Bouton "Envoyer" (Code hex du bouton -> #4FC1B5)

    - Au clic sur *Envoyer* : L'information est envoyée en base de données et accessible depuis [l'admin](vendredi.cc)
    
Pour le design de la modal tu peux t'inspirer de cet écran : https://scene.zeplin.io/project/585d2e5a44917ee1154df7b2/screen/593e8ea6fae05195c983faa7


### 2. Back-end

Depuis vendredi.cc/admin,

Onglet Accueil (dans la liste déroulante à gauche)

En dessous de "Tableau de bord"

- Création d'un nouvel onglet "Formulaire association"

- Depuis cet onglet,
    - Un tableau qui récapitule les données envoyées depuis le front :
    - Nom & Prénom | Adresse mail | Votre demande
    - Quatrième colonne "Actions" tout à droite qui permet de modifier ou de supprimer les informations envoyées

Attention, tu n'as pas accès à l'admin de notre site public mais celui-ci est le même que sur la base de code mis à disposition


## Fin du test

A la fin du test tu dois : 

- pusher ta branche sur GitHub
- créer une pull request https://github.com/vendredicc/vendredi-test-technique/compare