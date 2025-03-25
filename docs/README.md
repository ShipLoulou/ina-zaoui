# Ina Zaoui • Projet 15

<img src="../public/images/home.jpeg" alt="CritiPixel" width="200" />

Refactorisez le code d'un site pour l'optimiser • Développeur d'application PHP Symfony

---

## 📚 Sommaire

- [Présentation](#présentation)
- [Pré-requis](#pré-requis)
- [Installation](#installation)
  - [Méthode automatique](#méthode-automatique)
  - [Méthode manuelle](#méthode-manuelle)
- [Démarrage](#démarrage)
- [Tests](#tests)
  - [Exécution des tests](#exécution-des-tests)
  - [Coverage](#coverage)
- [Fonctionnalités](#fonctionnalités)
- [Stack technique](#stack-technique)
- [Qualité du code](#qualité-du-code)
- [Auteur](#auteur)
- [Licence](#licence)

---

## 🖼️ Présentation

Ce projet Symfony met en valeur le portfolio de la photographe **Ina Zaoui**, à travers une interface éco-conçue, responsive et optimisée.  
Il s'agit du **Projet 15** de la formation *Développeur d'application PHP/Symfony* chez OpenClassrooms.

---

## ✅ Pré-requis

- PHP >= 8.2
- Composer
- Symfony CLI
- Xdebug (pour la couverture de test)
- MySQL
- Make (pour les commandes automatiques)

---

## ⚙️ Installation

- Cloner le repo git
```
git clone https://github.com/ShipLoulou/ina-zaoui.git
cd ina-zaoui
```
- Créer un fichier .env.local à la racine avec votre configuration de base de données : 
`DATABASE_URL="mysql://user:password@127.0.0.1:3306/ina_zaoui"`
- Télécharger le [fichier](https://www.swisstransfer.com/d/6a9da88e-d768-4d92-b4a2-48b8f41d3737) qui contient les images du projet et les mettres dans le dossier `public/uploads`

### 🔁 Méthode automatique
- Entrer la commande suivante pour initialiser le projet
```
make init
```

### 🛠️ Méthode manuelle
```
composer install
php bin/console doctrine:database:create
php bin/console doctrine:schema:update --force
php bin/console doctrine:fixtures:load --no-interaction --group=app
```
Pour initialiser la base de données de test :
```
php bin/console doctrine:database:create --env=test
php bin/console doctrine:schema:update --force --env=test
php bin/console doctrine:fixtures:load --no-interaction --env=test --group=test
```


## ▶️ Démarrage

Pour lancer le projet :
```
make start
```
Par défaut, le site est accessible sur : http://localhost:8000

## Usage 

### 🧪 Tests

Assurez-vous d'avoir bien initialisé la base de données de test au préalable :
```
make test
```

### 📊 Coverage

Générer un rapport de couverture :
```
make coverage
```
Le rapport se trouve dans : `tests/report/index.html`
Vous pouvez l'ouvrir dans votre navigateur.

## 👤 Auteur
Lounis ZAOUANI
Développeur PHP/Symfony

## 📄 Licence
Ce projet a été réalisé dans le cadre de la formation OpenClassrooms.
Usage personnel ou pédagogique uniquement.
Aucune utilisation commerciale n'est autorisée sans autorisation préalable.