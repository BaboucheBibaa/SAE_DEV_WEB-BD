# TODOLIST - SAE_DEV_WEB-BD Zoo'land

> Suivi du développement et des tâches à accomplir

---

## Phase 1 ✅ - Implémentations Complétées (v1.0 → v1.2)

### Base de Données

- ✅ Ajout de **ON DELETE CASCADE** à toutes les clés étrangères pertinentes
- ✅ Intégrité référentielle complète avec suppression en cascade

### Vues Créées/Modifiées

- ✅ **c-profilAnimal.php** (modifications)
  - Affichage des doses quotidiennes de nourriture (table BIEN_ETRE_QUOTIDIEN)
  - Affichage de l'historique des soins (table PRATIQUE_SOIN)
  - Formatage des données avec personnels associés

- ✅ **c-enclos.php** (création)
  - Affichage du profil d'un enclos
  - Localisation géographique (latitude/longitude)
  - Animaux présents

### Contrôleurs Améliorés

- ✅ **c-respBoutique.php** (finalisation)
  - Dashboard responsable boutique opérationnel
  - Récupération correcte de la boutique du manager

### Modèles Enrichis

- ✅ **m-Boutique.php**
  - Nouvelle méthode `recupParManager($id_manager)`
  - Correction du bug du dashboard responsable

- ✅ **m-HistoriqueSoins.php**
  - Nouvelle méthode `recupNourritureParAnimal($id_animal)` avec JOIN PERSONNEL
  - Modification de `recupSoinsParAnimal($id_animal)` avec JOIN PERSONNEL et tri décroissant

### Fonctionnalités Additionnelles

- ✅ Moteur de recherche global et avancée !!! Généré par IA pour comprendre l'idée, modifier le fonctionnement pour avoir un moteur de recherche maison
- ✅ Recherche par catégorie avec filtres

---

## Unification des Dashboards (EN COURS)

### À Faire

- [ ] **Analyser les 3 contrôleurs existants**
  - [ ] `c-pageAdmin.php` → `profil_admin()`
  - [ ] `c-respBoutique.php` → `afficherPage()`
  - [ ] `c-respSoigneurs.php` → `afficherPage()`

- [ ] **Créer DashboardController.php**
  - [ ] Méthode `afficherPage()`
  - [ ] Vérification du rôle utilisateur
  - [ ] Appels aux différentes requêtes selon le rôle
  - [ ] Passage des données à la vue

- [ ] **Créer vues partielles**
  - [ ] `views/partials/dashboard-admin.php`
  - [ ] `views/partials/dashboard-resp-boutique.php`
  - [ ] `views/partials/dashboard-resp-soigneur.php`

- [ ] **Créer vue principale**
  - [ ] `views/v-dashboard.php` (unifiée)
  - [ ] Inclusion conditionnelle des vues partielles

- [ ] **Mettre à jour les routes**
  - [ ] Créer route `dashboard` → `DashboardController->afficherPage()`
  - [ ] Garder compatibilité avec anciennes routes (redirection)

- [ ] **Nettoyage**
  - [ ] Supprimer les anciennes vues partielles
  - [ ] Supprimer/Archiver les anciens contrôleurs (backup d'abord)
  - [ ] Mettre à jour les liens dans la navigation

---

## Améliorations Dashboard

### Dashboard Responsable Boutique

- [ ] **Chiffre d'affaires**
  - [ ] Récupérer les données de la table CHIFFRE_AFFAIRES
  - [ ] Afficher CA journalier
  - [ ] Afficher CA mensuel
  - [ ] Afficher CA annuel

### Dashboard Responsable Zone

- [ ] **État général**
  - [ ] Nombre d'animaux dans la zone
  - [ ] État des enclos
  - [ ] Santé générale des animaux

- [ ] **Statistiques**
  - [ ] Nombre de soins effectués
  - [ ] Animaux sous surveillance (Espèce menacée ou non)

- [ ] **Alertes**
  - [ ] Problèmes de compatibilité d'enclos (gérer les problèmes de compatibilité)

---

## Pages Métier (Soigneur / Personnel entretien)

### Pour tous les métiers

- [ ] **Page personnelle/Dashboard**
  - [ ] Affichage de la zone d'affectation

### Soigneurs spécifiquement

- [ ] **Gestion des soins**
  - [ ] Liste des animaux qu'il soigne
  - [ ] Historique complet des soins réalisés
  - [ ] Ajouter/modifier un soin (formulaire)

- [ ] **Parrainages**
  - [ ] Liste des parrainages sur les animaux traités
  - [ ] Informations sur les visiteurs parrains
  - [ ] Historique des parrainages

- [ ] **Alertes**
  - [ ] Animaux à soigner aujourd'hui
  - [ ] Notifications de visite parrain

### Personnel d'entretien spécifiquement

- [ ] **Gestion des enclos**
  - [ ] Liste des enclos de sa zone
  - [ ] État de chaque enclos
  - [ ] Historique des entretiens

- [ ] **Maintenance**
  - [ ] Rapport d'entretien (formulaire)

---

## Gestion Avancée

### Gestion des Animaux

- [ ] **Déplacement d'animaux**
  - [ ] Formulaire de déplacement (enclos source → destination)
  - [ ] Vérification compatibilité espèce de l'enclos destination
  - [ ] Enregistrement historique du déplacement

- [ ] **Suppression/Départ d'animaux**
  - [ ] Archivage plutôt que suppression
  - [ ] Historique des départs
  - [ ] Raison du départ (vente, décès, transfert, etc.)

- [ ] **Fiche animale améliorée**
  - [ ] Arbre généalogique (parents/enfants)
  - [ ] Timeline complète de sa vie au zoo

### Gestionnaire des Parrainages

- [ ] **Gestion Parrainages**
  - [ ] Créer un parrainage
  - [ ] Modifier les conditions
  - [ ] Archiver/Terminer un parrainage

- [ ] **Gestion Visiteurs**
  - [ ] Affichage des visiteurs parrains
  - [ ] Historique des parrainages par visiteur

---

## Améliorations Globales

### Profil Utilisateur

- [ ] **Contrat de travail (BONUS)**
  - [ ] Intégration FPDF pour génération PDF
  - [ ] Affichage du contrat signé
  - [ ] Téléchargement du contrat

- [ ] **Historique d'accès**
  - [ ] Dernière connexion
  - [ ] Historique de connexion
  - [ ] Activités récentes

### Dashboard Administrateur

- [ ] **Archivage employés**
  - [ ] Archivage (colonne `ARCHIVE` ou table d'archivage)
  - [ ] Filtres (actifs/archivés/tous)
  - [ ] Restauration d'employés (retour d'un employé au sein du zoo par ex)

- [ ] **Gestion des rôles**
  - [ ] Interface de gestion des rôles
  - [ ] Attribution des droits