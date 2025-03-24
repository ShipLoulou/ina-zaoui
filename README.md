# Ina Zaoui • Projet 15

<img src="public/images/home.jpeg" alt="CritiPixel" width="200" />

Refactorisez le code d'un site pour l'optimiser • Développeur d'application PHP Symfony

### Pré-requis

Ce qu'il est requis pour commencer avec votre projet...

* PHP >= 8.2
* Composer
* Extension PHP Xdebug
* Symfony (binaire)

### Installation

- Cloner le repo git
```
git clone https://github.com/ShipLoulou/ina-zaoui.git
```
- Créer un fichier .env.local et renseigner votre DATABESE_URL
- Se rendre dans le dossier `/ina-zaoui`

#### Vous pouvez intialiser la projet de manière automatique ou manuel

##### Automatique
- Entrer la commande suivante pour initialiser le projet
```
make init
```

##### Manuel
- Installer les dépendences composer 
```
Composer install
```
- Installer les dépendences composer 
```
Composer install
```
- Créer la base de donnée
```
php bin/console doctrine:database:create
```
- Mettre à jour la base de donnée
```
php bin/console doctrine:schema:update --force
```
- Charger les fixtures
```
php bin/console d:f:l --no-interaction --group=app
```

Effectuer les même opération pour utiliser la base de donnée de test en rajoutant --env=test, et en remplacant --group=app par --group=test pour les fixtures


## Démarrage

Pour lancer le projet :
```
make start
```

## Usage 

### Test

Pour lancer les tests : (assurer d'avoir créer la base de donnée de test au préalable)
```
make test
```

### Coverage

Réaliser un test de couverture des tests :
```
make coverage
```
Résultat dans : `tests/report`