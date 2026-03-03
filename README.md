# SAE_DEV_WEB-BD - Zoo'land

> Site créé pour une SAE en développement web et bases de données

---

## Architecture du Projet

Le site utilise l'architecture **MVC (Modèle-Vue-Contrôleur)** pour une meilleure organisation du code.

### Intérêts de cette architecture

- **Modularité** : Il est simple d'ajouter ou de supprimer des fonctionnalités car tout est décomposé de sorte à ce qu'aucune fonction ne soit dépendante d'une autre (ou en tout cas, le moins possible)

- **Lisibilité** : Structure claire et séparée :
  - **Modèles** : Requêtes SQL
  - **Contrôleurs** : Traitement des requêtes SQL
  - **Vues** : Affichage des données (HTML)

### Organisation du répertoire

```txt
index.php                          ← Point d'entrée unique (front controller + routeur)
│
├── config/
│   ├── database.php               ← Connexion à la base Oracle
│   └── myparams.inc.php           ← Constantes de configuration + rôles
│
├── controllers/
│   ├── c-base.php                 ← BaseController : render(), redirect(), redirectWithMessage()
│   ├── c-connexion.php            ← Connexion / Déconnexion / Page d'accueil
│   ├── c-pageAdmin.php            ← AdminController : façade vers les services (employés, zones, boutiques, animaux)
│   ├── c-profil.php               ← Profil utilisateur et changement de mot de passe
│   ├── c-profilAnimal.php         ← Fiche détaillée d'un animal
│   ├── c-respBoutique.php         ← Contrôleur responsable boutique (à implémenter)
│   └── c-respSoigneurs.php        ← Dashboard responsable de zone
│
├── services/
│   ├── ServiceEmployee.php        ← Gestion des données des employés (préparation des données, appels modèles)
│   ├── ServiceAnimal.php          ← Gestion des données des animaux
│   ├── ServiceBoutique.php        ← Gestion des données des boutiques
│   └── ServiceZone.php            ← Gestion des données des zones
│
├── models/
│   ├── m-User.php                 ← Modèle utilisateurs (SQL Oracle via OCI8)
│   ├── m-Animal.php               ← Modèle animaux
│   ├── m-Boutique.php             ← Modèle boutiques
│   ├── m-Zone.php                 ← Modèle zones
│   ├── m-Enclos.php               ← Lecture des enclos par zone
│   ├── m-Espece.php               ← Lecture des espèces
│   ├── m-Fonction.php             ← Lecture des fonctions/rôles
│   ├── m-Absence.php              ← Données bien-être quotidien
│   ├── m-HistoriqueSoins.php      ← Historique des soins
│   └── m-Compatibilite.php        ← Compatibilités entre espèces
│
├── views/
│   ├── v-includes.php             ← Layout principal (header / footer + include view)
│   ├── v-home.php                 ← Page d'accueil
│   ├── connexion/
│   │   └── v-login.php            ← Formulaire de connexion
│   ├── profil/
│   │   └── v-profil.php           ← Page profil utilisateur
│   ├── animal/
│   │   └── v-profil-animal.php    ← Fiche détaillée d'un animal
│   ├── administrateur/
│   │   ├── v-dashboard.php        ← Tableau de bord admin
│   │   ├── v-createEmployee.php   ← Formulaire création employé
│   │   ├── v-editionEmployee.php  ← Formulaire édition employé
│   │   ├── v-createAnimal.php     ← Formulaire création animal
│   │   ├── v-editionAnimal.php    ← Formulaire édition animal
│   │   ├── v-createBoutique.php   ← Formulaire création boutique
│   │   ├── v-editionBoutique.php  ← Formulaire édition boutique
│   │   ├── v-createZone.php       ← Formulaire création zone
│   │   └── v-editionZone.php      ← Formulaire édition zone
│   ├── resp_zone/
│   │   └── v-dashboard.php        ← Dashboard responsable de zone
│   └── resp_boutique/
│       └── v-dashboard.php        ← Dashboard responsable boutique (à implémenter)
│
└── utilities/
    └── Utils.php                  ← Fonctions utilitaires (hash mdp, génération mdp, conversion dates)
```

### Flux d'une requête

```txt
Navigateur → index.php (Chef d'orchestre du projet)
                 ↓
           Contrôleur (vérifie les droits, appelle le service)
                 ↓
           Service (Gestion des données retournées par le modèle)
                 ↓
           Modèle (requête SQL)
                 ↓
           Contrôleur (récupère les données, appelle render())
                 ↓
           Vue (affichage HTML via v-includes.php)
```

---

## Fonctionnalités Implémentées

### Profil Utilisateur Individuel

- ✅ Possibilité de changer de mot de passe

### Dashboard Administrateur

- ✅ Ajouter / Supprimer / Modifier un employé
- ✅ Ajouter / Supprimer / Modifier une zone
- ✅ Ajouter / Supprimer / Modifier une boutique

### Page Responsable des Soigneurs d'une zone

- ✅ Liste des employés dans la zone
- ✅ Liste des enclos
- ✅ Liste des animaux

---

## TODO List

### Page Profil (Améliorations)

- [ ] **[BONUS]** Référence sur un contrat de travail fictif (voir pour utiliser FPDF ?)

### Page Responsable de Boutique

- [ ] Page de management de la boutique
- [ ] Chiffre d'affaires journalier, mensuel et annuel
- [ ] Liste des salariés de cette boutique
- [ ] Statistiques de ventes de la boutique par employés présents tel ou tel jour
  - _Cela implique de modifier le MCD, à voir si c'est pertinent de le faire ?_

### Page métier (Soigneur / Personnel entretien)

- [ ] Contrat de travail (FPDF Optionnel)
- [ ] Affichage de la zone d'affectation
- [ ] Soigneurs:
  - [ ] liste des parrainages sur les animaux traités par un soigneur
  - [ ] historique des soins sur les animaux qu'il gère
- [ ] Entretien:
  - [ ] Liste des enclos de la zone
  - [ ] Historique des entretiens des enclos de sa zone

### Page Gestionnaire du Zoo

- [ ] Gestion des animaux au sein du zoo
  - Possibilité de déplacer un animal d'un enclos à un autre
  - Possibilité de supprimer un animal du zoo
- [ ] Gestionnaire des parrainages du zoo
  - Affichage des parrainages
  - Affichage du nom du visiteur qui parraine l'animal
