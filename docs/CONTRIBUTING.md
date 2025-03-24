# 🤝 Contribuer au projet Zaoui

Bienvenue, et merci de vouloir contribuer à **Zaoui**, une application dédiée à l’univers visuel de la photographe Ina Zaoui. Ce guide vous aidera à contribuer efficacement au projet, que ce soit pour signaler un bug, proposer une fonctionnalité, améliorer le code ou enrichir la documentation.

---

## 🚀 Objectif du projet

Zaoui met en lumière les paysages capturés aux quatre coins du monde par Ina Zaoui, une photographe qui voyage à pied, à vélo, à dos d’animal ou en montgolfière. L’application est pensée pour valoriser la beauté naturelle du monde à travers une approche éthique et responsable.

---

## ⚙️ Pré-requis techniques

- PHP 8.2 minimum
- Symfony 6.4
- Composer

Clonage du projet :
```
git clone https://github.com/ton-utilisateur/zaoui.git
cd zaoui
composer install
```

---

## 🐞 Signaler un bug

1. Ouvrez une issue sur GitHub.
2. Donnez un titre clair et une description détaillée.
3. Expliquez les étapes pour reproduire le problème.
4. Précisez votre environnement (PHP, OS, navigateur si nécessaire).
5. Ajoutez des messages d’erreur ou logs si disponibles.

---

## 💡 Proposer une nouvelle fonctionnalité
### Avant de coder, ouvrez une issue pour décrire votre idée :

- Quelle est la fonctionnalité souhaitée ?
- À quel besoin répond-elle ?
- Avez-vous des suggestions pour l’interface ou l’implémentation ?

Cela permet d’éviter les doublons et d’assurer une cohérence avec la vision du projet.

---

## 🧑‍💻 Contribuer au code

### Étapes
1. Forkez ce dépôt et clonez votre version.
2. Créez une branche dédiée :
```
git checkout -b feature/nom-de-la-fonctionnalite
```
3. Respectez les conventions PSR-12.
4. Vérifiez le code avec :
```
make test
# ou manuellement :
vendor/bin/phpstan analyse
vendor/bin/phpunit
```
5. Commitez avec des messages explicites
6. Poussez et ouvrez une Pull Request (PR) vers main.

---

## ✅ Tests
Les tests se trouvent dans le dossier `/tests`.

### Lancer les tests :
```
make test
# ou individuellement :
vendor/bin/phpunit
vendor/bin/phpstan analyse
```

Merci d’ajouter des tests unitaires et/ou fonctionnels si vous apportez :
- Une nouvelle fonctionnalité
- Une correction de bug

---

## 📘 Documentation
La documentation se trouve dans le dossier /docs.

Vous pouvez y ajouter :
- Des guides d’utilisation
- Des instructions d’installation ou de déploiement
- Des explications techniques (architecture, composants utilisés, etc.)

Merci d’écrire dans un style clair et structuré, en utilisant le Markdown :
- Titres (#, ##, etc.)
- Paragraphes courts
- Listes à puces
- Blocs de code (```)
- Liens au format : [texte du lien](URL)

---

## 🔗 Ressources utiles
- [Documentation Symfony](https://symfony.com/doc/current/index.html)
- [Doctrine ORM](https://www.doctrine-project.org/)
- [Twig](https://twig.symfony.com/)
- [PHPUnit](https://phpunit.de/index.html)
- [PHP-CS-Fixer](https://github.com/PHP-CS-Fixer/PHP-CS-Fixer)
- [PHPStan](https://phpstan.org/)
- [Norme PSR-12](https://www.php-fig.org/psr/psr-12/)