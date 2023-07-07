# PetMatch

Ce projet est un gestionnaire d'adoption d'animaux développé en PHP utilisant le modèle MVC (Modèle-Vue-Contrôleur). Il permet aux utilisateurs de consulter les animaux disponibles pour adoption, de déposer une demande d'adoption, de proposer un animal à mettre en adoption, de gérer leur profil et de modifier ou supprimer leurs dépôts de formulaire.

## Contexte

Ce projet vise à faciliter le processus d'adoption d'animaux en offrant une plateforme en ligne où les utilisateurs peuvent interagir avec les animaux disponibles et effectuer différentes actions liées à l'adoption. Il permet aux utilisateurs de trouver des informations détaillées sur chaque animal, de déposer des demandes d'adoption, de proposer des animaux à mettre en adoption et de gérer leur profil d'adoption.

## Fonctionnalités

* Affichage des animaux disponibles pour adoption. `path: /repertoire` ![Page répertoire](https://raw.githubusercontent.com/s-kenza/PetMatchImages/main/Repertoire.PNG)

* Dépôt d'une demande d'adoption pour un animal spécifique. `path: /repertoire/{nom}` ![Page de détail d'un animal](https://raw.githubusercontent.com/s-kenza/PetMatchImages/main/Repertoire-nom.PNG)

* Formulaire de proposition d'adoption pour les utilisateurs souhaitant mettre un animal en adoption. `path: /adoption` ![Page formulaire d'adoption](https://raw.githubusercontent.com/s-kenza/PetMatchImages/main/Formulaire.PNG)

* Ajout automatique du nouvel animal enregistré via un formulaire sur le répertoire. `path: /repertoire`

* Connexion et déconnexion des utilisateurs. `path: /login` || `path: /register` ![Page connexion](https://raw.githubusercontent.com/s-kenza/PetMatchImages/main/Connexion.PNG) ![Page inscription](https://raw.githubusercontent.com/s-kenza/PetMatchImages/main/Inscription.PNG)

* Profil utilisateur avec historique des dépôts de formulaire et des demandes d'adoption. `path: /account` ![Page profil](https://raw.githubusercontent.com/s-kenza/PetMatchImages/main/Profil.PNG)

* Suppression des dépôts de formulaire et des demandes d'adoption dans le profil utilisateur. `path: /account`

* Modification des informations des dépôts de formulaire dans le profil utilisateur. `path: /account`

## Règles du site / Limites à tester sur l'IHM

* Lors d'une demande d'adoption d'un animal (`/repertoire/{nom}`) ou d'un dépôt de formulaire (`/adoption`), on vérifie si l'utilisateur est connecté pour lui permettre de faire ces actions, sinon on le redirige automatiquement vers la page 'Inscription/Connexion'.
* On ne peut pas avoir plus de 3 demandes d'adoption le même jour. (Affichage d'un message d'erreur lors d'une 4ème demande d'adoption pour le même jour)
* Les mots de passe sont hachés en base de données pour garantir la sécurité des connexions.
* Si un utilisateur fait une demande d'adoption pour un animal (`/repertoire/{nom}`), un autre user ne pourra pas faire une demande pour ce même animal lui indiquant un message l'empêchant de continuer.
* Si un utilisateur sur son profil (`/account`), sous l'historique des formulaires d'adoption, souhaite en supprimer un mais que cet animal a été entre temps demandé pour être adopté, il ne pourra plus le supprimer.
* Lors d'une reconnexion, l'utilisateur retrouvera sur son profil (`/account`) l'historique de toutes ces actions.
* Lors de l'inscription (`/register`), si le login existe déjà, on affiche un message d'erreur.
* Lors de la connexion (`/login`), si le login ou le mot de passe ne correspond pas, on affiche un message d'erreur.

## Démarrage

### Composer

Pour récupérer les dépendances déclarées dans `composer.json` et générer l'autoloader PSR-4, exécuter la commande suivante :

```bash
composer install
```

### DB Configuration

Configurez la base de données MySQL en important le fichier SQL fourni dans `petmatch.sql` ou en exécutant le script.

La configuration de la base de données doit être inscrite dans un fichier `.env.local`, sur le modèle du fichier `.env`.


### Démarrer l'application

Commande :

```bash
composer start
```

## Difficultés rencontrées

### Gestion des routes avec méthode POST

L'une des difficultés auxquelles j'ai été confronté était liée à la gestion des routes avec la méthode POST. Initialement, j'ai essayé de changer simplement le nom dans la définition de la Route, mais cela ne fonctionnait pas comme prévu. J'ai donc dû trouver une solution alternative en utilisant la méthode addRoute pour chaque fonction qui utilisait la méthode POST. Cela m'a permis de définir des routes distinctes et de résoudre ce problème.

### Conservation des données entre les pages

Au début, j'ai eu du mal à trouver un moyen de conserver certaines données en mémoire afin de les faire passer d'une page à une autre. Une des fonctionnalités du projet était de permettre à l'utilisateur de rester connecté, peu importe sur quelle page il se dirigeait, tant qu'il n'appuyait pas sur le bouton de déconnexion. Pour résoudre ce problème, j'ai utilisé les sessions PHP pour stocker les données pertinentes, telles que l'ID de l'utilisateur ou l'ID de l'animal sélectionné, afin de les récupérer sur différentes pages.


## Conclusion

Ce gestionnaire d'adoption d'animaux offre une solution conviviale pour faciliter le processus d'adoption et de proposition d'adoption d'animaux. Il permet aux utilisateurs de trouver rapidement des animaux disponibles, de déposer des demandes d'adoption et de proposer des animaux à mettre en adoption. Avec des fonctionnalités de profil utilisateur complètes, les utilisateurs peuvent gérer leurs demandes d'adoption et leurs dépôts de formulaire en toute simplicité.

En surmontant les difficultés citées précédemment, j'ai pu améliorer mes compétences en développement PHP de manière significative. Au début de ce projet, mes connaissances dans ce langage étaient proches de zéro, mais grâce à cette expérience, j'ai pu acquérir une solide compréhension des concepts fondamentaux de cette technologie et de son utilisation dans le développement d'applications web.

J'ai appris à utiliser le framework MVC (Modèle-Vue-Contrôleur) pour structurer mon code de manière organisée et maintenable. J'ai également acquis une compréhension approfondie de la gestion des routes, ce qui m'a permis de créer des routes personnalisées pour différentes fonctionnalités de l'application, notamment les demandes d'adoption, les dépôts de formulaires et les actions liées au profil de l'utilisateur.

La conservation des données entre les pages a été une autre compétence clé que j'ai développée. En utilisant les sessions PHP, j'ai appris à stocker et à récupérer des informations utilisateur importantes, telles que l'ID de l'utilisateur et l'ID de l'animal sélectionné, afin de les utiliser de manière cohérente tout au long de l'application.

Dans l'ensemble, ce projet m'a permis de progresser considérablement dans le développement PHP et d'acquérir une base solide pour continuer à développer des applications web plus avancées à l'avenir.
