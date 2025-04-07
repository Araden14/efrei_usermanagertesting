# Exercice Efrei: Tests pour un CRUD d'Utilisateurs

## Objectif du Projet

Le but de ce projet est de réaliser différents types de tests sur le fichier `UserManager.php` et sur la mini-application PHP associée.

## Types de Tests Réalisés

-   **Tests Unitaires**: Utilisant `phpunit`.
-   **Tests de Performances**: Utilisant `k6`.
-   **Tests de Bout en Bout (E2E)**: Utilisant Selenium IDE.
-   **Tests de Non-Régression**: Utilisant Selenium IDE et `phpunit`.

## Structure du Projet

```plaintext
.
├── reporting/          # Captures d'écrans, explications
├── tests/              # Tests unitaires (phpunit), tests de performances (k6) + rapport HTML
│   └── ...
├── .gitignore
├── UserManager.php     # Fichier à tester (logique métier)
├── api.php             # Fichier à tester (API endpoints)
├── composer.json       # Dépendances PHP
├── composer.lock       # Fichier de verrouillage des dépendances
├── database.sql        # Schéma de la base de données
├── index.html          # Interface utilisateur de l'application
├── script.js           # Script JavaScript de l'application
└── style.css           # Feuille de style CSS de l'application
```





