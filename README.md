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

### Profil d'un Animal

- ✅ Affichage des informations générales (espèce, date de naissance, âge)
- ✅ Affichage des caractéristiques physiques (poids, régime alimentaire)
- ✅ Localisation (latitude, longitude)
- ✅ Historique des **doses quotidiennes de nourriture** (table BIEN_ETRE_QUOTIDIEN)
- ✅ Historique des **soins médicaux** (table PRATIQUE_SOIN) avec description du soin

### Profil d'un Enclos

- ✅ Type d'enclos et zone assignée
- ✅ Localisation géographique (latitude/longitude)
- ✅ Liste des animaux présents

### Dashboard Administrateur

- ✅ Ajouter / Supprimer / Modifier un employé
- ✅ Ajouter / Supprimer / Modifier une zone
- ✅ Ajouter / Supprimer / Modifier une boutique
- ✅ Statistiques globales (employés, zones, boutiques, animaux)

### Dashboard Responsable de Zone (Soigneurs)

- ✅ Liste des employés dans la zone
- ✅ Liste des enclos
- ✅ Liste des animaux

### Dashboard Responsable de Boutique

- ✅ Informations de la boutique (nom, ID, zone, description)
- ✅ Liste des employés de la boutique

### Moteur de Recherche

- ✅ Recherche globale (animaux, employés, zones, boutiques, enclos)
- ✅ Recherche avancée avec filtres par catégorie

### Base de Données

- ✅ **ON DELETE CASCADE** ajouté à toutes les clés étrangères pertinentes
- ✅ Intégrité référentielle complète avec suppression en cascade

---

## TODO List

### Phase 1 ✅ - Implémentations Complétées

- ✅ Affichage des soins et nourriture dans le profil animal
- ✅ Création de la vue profil enclos
- ✅ Création du dashboard responsable boutique
- ✅ Correction du bug Boutique::recupParManager()
- ✅ Ajout de ON DELETE CASCADE à la base de données
- ✅ Moteur de recherche global et avancée

### Phase 2 - Unification des Dashboards (À implémenter)

- [ ] **[EN COURS]** Créer un seul Dashboard unifié (v-dashboard.php racine)
  - [ ] Créer DashboardController.php
  - [ ] Créer vues partielles pour Admin, RespBoutique, RespSoigneur
  - [ ] Intégrer la logique de détection du rôle
  - [ ] Mettre à jour les routes
  - [ ] Supprimer les anciens contrôleurs/vues

### Phase 3 - Améliorations Dashboard

- [ ] Dashboard Responsable Boutique:
  - [ ] Chiffre d'affaires journalier, mensuel et annuel
  - [ ] Statistiques de ventes par employé
  - [ ] Graphiques de tendances

- [ ] Dashboard Responsable Zone:
  - [ ] Statistiques des soins effectués

### Phase 4 - Pages Métier (Soigneur / Personnel entretien)

- [ ] Affichage de la zone d'affectation personnelle
- ✅ Soigneurs:
  - ✅ Liste des parrainages sur les animaux qu'il soigne
  - ✅ Historique complet des soins réalisés
- [ ] Personnel entretien:
  - [ ] Liste des enclos de sa zone
  - [ ] Historique des entretiens des enclos
  - [ ] Calendrier de maintenance

### Phase 5 - Gestion Avancée

- [ ] Gestion des animaux:
  - [ ] Possibilité de déplacer un animal d'un enclos à un autre
  - [ ] Historique des déplacements
  - ✅ Suppression d'un animal du zoo
- [ ] Gestionnaire des parrainages:
  - ✅ CRUD parrainages
  - ✅ Affichage des visiteurs parrains
  - [ ] Statistiques de parrainage

### Phase 6 - Améliorations Globales

- [ ] Profil Utilisateur (amélioration):
  - [ ] **[BONUS]** Contrat de travail en PDF (FPDF)
  - [ ] Historique d'accès
  
- [ ] Dashboard Admin (amélioration):
  - [ ] Archivage des employés
  - [ ] Filtre employés archivés/actifs
  - [ ] Rapports d'activité globaux
  - [ ] Gestion des rôles et droits d'accès

---

## Identifiants de Connexion

### Base de Données Oracle

```bash
sqlplus SAE_USER/sae2026@localhost:1521/FREEPDB1
```

### Comptes de Test

- **Admin**: `admin`,mot de passe: `MDP`
- **Responsable Zone**: `resp_zone1`, mot de passe: `MDP`
- **Responsable Boutique**: `manager_boutique1`, mot de passe: `MDP`