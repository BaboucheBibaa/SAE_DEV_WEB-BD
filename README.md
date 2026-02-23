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

## TODO Liste

### Page Profil (Améliorations)

- [ ] **[BONUS]** Ajouter la possibilité de mettre une absence entre tel et tel jour + motif
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
