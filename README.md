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
│   ├── c-profilAnimal.php         ← Fiche détaillée d'un animal + historique soins/nourriture
│   ├── c-enclos.php               ← Affichage du profil d'un enclos
│   ├── c-respBoutique.php         ← Dashboard responsable boutique
│   ├── c-respSoigneurs.php        ← Dashboard responsable de zone
│   └── c-search.php               ← Moteur de recherche global et avancée
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
│   ├── m-Boutique.php             ← Modèle boutiques + recupParManager()
│   ├── m-Zone.php                 ← Modèle zones
│   ├── m-Enclos.php               ← Lecture des enclos par coordonnées/zone
│   ├── m-Espece.php               ← Lecture des espèces
│   ├── m-Fonction.php             ← Lecture des fonctions/rôles
│   ├── m-HistoriqueSoins.php      ← Historique soins + doses nourriture (recupNourritureParAnimal, recupSoinsParAnimal)
│   └── m-Compatibilite.php        ← Compatibilités entre espèces
│
├── views/
│   ├── v-includes.php             ← Layout principal (header / footer + include view)
│   ├── v-home.php                 ← Page d'accueil
│   ├── test-moteur-recherche.php  ← Page de résultats de recherche
│   ├── connexion/
│   │   └── v-login.php            ← Formulaire de connexion
│   ├── profil/
│   │   └── v-profil.php           ← Page profil utilisateur
│   ├── animal/
│   │   └── v-profilAnimal.php     ← Fiche animal + soins + doses nourriture
│   ├── enclos/
│   │   └── v-profil.php           ← Profil d'un enclos avec localisation et animaux
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
│   │   └── v-dashboard.php        ← Dashboard responsable de zone (employés, enclos, animaux)
│   └── resp_boutique/
│       └── v-dashboard.php        ← Dashboard responsable boutique (infos boutique, équipe)
│
└── utilities/
    └── Utils.php                  ← Fonctions utilitaires (hash mdp, génération mdp, conversion dates)
```

### Flux d'une requête

```txt
Navigateur → index.php (Chef d'orchestre du projet / routeur)
                 ↓
        Définition de la route et des paramètres
                 ↓
        Contrôleur (vérification des droits + verrous)
                 ↓
        Appel au(x) Modèle(s) ou Service(s)
                 ↓
        Modèle (requête SQL via OCI8 Oracle)
                 ↓
        Retour des données brutes
                 ↓
        Service (formatage/préparation des données)
                 ↓
        Contrôleur (appel render() avec données)
                 ↓
        Vue (v-includes.php) → inclut la vue correspondante
                 ↓
        HTML généré et retourné au navigateur
```

---

## Fonctionnalités Implémentées

### Profil Utilisateur Individuel

- ✅ Possibilité de changer de mot de passe
- ✅ Profil utilisateur complet accessible pour tout le monde (informations filtrées : impossible pour un autre utilisateur d'avoir la page de changement de mdp d'un autre utilisateur)
- ✅ Affichage de l'historique des emplois passés au sein du zoo

### Profil d'un Animal

- ✅ Affichage des informations générales (espèce, date de naissance)
- ✅ Affichage des caractéristiques physiques (poids, régime alimentaire)
- ✅ Localisation (latitude, longitude)
- ✅ Historique des **doses quotidiennes de nourriture** (table BIEN_ETRE_QUOTIDIEN)
- ✅ Historique des **soins médicaux** (table PRATIQUE_SOIN) avec description du soin
- ✅ Affichage de la liste des parrains de l'animal

### Profil d'un Enclos

- ✅ Informations globales de l'enclos (Zone de l'enclos, type enclos)
- ✅ Localisation géographique (latitude/longitude)
- ✅ Liste des animaux présents
- ✅ Historique des réparations appliquées sur l'enclos


### Dashboard Administrateur

- ✅ Lister / Ajouter / Supprimer / Modifier un employé + formulaire de création de contrat en plus de la création de l'employé
- ✅ Archiver / Désarchiver un employé + afficher ou non les employés archivés
- ✅ Lister / Ajouter / Supprimer / Modifier une zone
- ✅ Lister / Ajouter / Supprimer / Modifier une boutique
- ✅ Lister / Ajouter / Supprimer / Modifier / Aller sur le profil d'un animal

### Dashboard Responsable de Zone (Soigneurs)

- ✅ Liste des employés dans la zone
- ✅ Liste des enclos
- ✅ Liste des animaux

### Dashboard Soigneur

- ✅ Historique des soins apportés sur les animaux qu'il gère
- ✅ Ajouter un soin sur un animal
  - ✅ Vérifier si le soigneur qui pratique le soin sur l'animal est bien le soigneur attitré (ou le remplaçant du soigneur attitré)
- ✅ Ajouter la distribution de nourriture faite pour un animal

### Dashboard Responsable de Boutique

- ✅ Informations de la boutique (nom, ID, zone, description)
- ✅ Liste des employés de la boutique

### Pages Métier (Soigneur / Personnel entretien)

- ✅ Personnel entretien:
  - ✅ Liste des enclos de sa zone
  - ✅ Historique des entretiens des enclos
- ✅ Responsable boutique
  - ✅ Page d'ajout de CA Journalier

### Moteur de Recherche

- ✅ Recherche globale (animaux, employés, zones, boutiques, enclos)

---

## Checklist de tests fonctionnels

> **Valide chaque case après avoir testé la fonctionnalité sur le site.**

- ✅ Connexion / Déconnexion
- ✅ Changement de mot de passe utilisateur
- ✅ Accès et affichage du profil utilisateur
- ✅ Accès et affichage du profil d'un animal
- ✅ Ajout d'un animal (admin)
- ✅ Modification d'un animal (admin)
- ✅ Suppression d'un animal (admin)
- ✅ Affichage de l'historique des soins d'un animal
- ✅ Ajout d'un soin (soigneur)
- ✅ Ajout d'une distribution de nourriture (soigneur)
- ✅ Accès et affichage du profil d'un enclos
- ✅ Affichage de la liste des animaux d'un enclos
- ✅ Affichage de l'historique des réparations d'un enclos
- ✅ Ajout d'une réparation (personnel entretien)
- ✅ Accès et affichage du dashboard administrateur
- ✅ Gestion des employés (ajout, modification, suppression, archivage)
  - [ ] Désarchivage non fonctionnel
- ✅ Gestion des zones (ajout, modification, suppression)
- ✅ Gestion des boutiques (ajout, modification, suppression)
- ✅ Accès et affichage du dashboard responsable de zone
  - [ ] Un responsable soigneur de zone est aussi un soigneur, ajouter ce cas-ci  
- ✅ Accès et affichage du dashboard responsable de boutique
- ✅ Ajout de chiffre d'affaires journalier (responsable boutique)
- ✅ Accès et affichage du dashboard soigneur
- ✅ Accès et affichage du dashboard personnel entretien
- ✅ Affichage de la liste des entretiens d'enclos (personnel entretien)
- ✅ Moteur de recherche global (animaux, employés, zones, boutiques, enclos)
- [ ] Moteur de recherche avec filtres spécifiques MAJEUR
- [ ] Affichage et gestion des messages flash multiples
- ✅ Vérification des droits d'accès (accès refusé si non autorisé)
- ✅ Supprimer un soin / Supprimer un parrainage / Supprimer une nourriture donnée
- [ ] Supprimer une réparation depuis le profil enclos

---

## TODO List

---

### Phase 1 - Améliorations Dashboard

- [ ] Dashboard Responsable Boutique:
  - ✅ Chiffre d'affaires journalier, mensuel et annuel
  - [ ] Statistiques
- [ ] Dashboard Administrateur:
  - [ ] Statistiques globales
- [ ] Dashboard employé boutique
- ✅ Profil espèce

### Améliorations

- [ ] Gérer l'affichage des données du comptable par une vue
- ✅ Ajout d'un fichier de gestion des logs (Connexion / Déconnexion au sein du site et Ajout / Maj / Suppression au sein de la BD)
- ✅ Popup pour les fins de contrat sur le dashboard admin
  - [ ] Gérer le fait de pouvoir avoir plusieurs popups à afficher
- [ ] Mettre le nom du prestataire et pas son identifiant dans la gestion entretien

---

## Identifiants de Connexion

### Base de Données Oracle

```bash
sqlplus SAE_USER/sae2026@localhost:1521/FREEPDB1
```

### Comptes de Test

- **Admin**: `admin`,mot de passe: `MDP`
- **Responsable Zone**: `avauchel`, mot de passe: `MDP`
- **Responsable Boutique**: `manager_boutique1`, mot de passe: `MDP`
