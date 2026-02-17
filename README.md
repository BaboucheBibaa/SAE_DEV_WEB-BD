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
  -  **Vues** : Affichage des données (HTML)

---

## Fonctionnalités Implémentées

### Profil Utilisateur Individuel

- ✅ Possibilité de changer de mot de passe

### Dashboard Administrateur

- ✅ Ajouter un employé
- ✅ Supprimer un employé
- ✅ Modifier un employé

---

## TODO Liste

### Page Responsable de Zone

- [ ] Liste des enclos, nombre d'animaux
- [ ] Historique des réparations sur tel enclos
- [ ] Historique des animaux dans les enclos

### Page Responsable Soigneurs d'une Zone

- [ ] Liste des enclos, nombre d'animaux
- [ ] Historique des animaux dans les enclos
- [ ] Liste des animaux
- [ ] Historique des soins et des doses de nourriture quotidiennes fournies à un animal particulier

### Page Profil (Améliorations)

- [ ] **[BONUS]** Ajouter la possibilité de mettre une absence entre tel et tel jour + motif
- [ ] **[BONUS]** Référence sur un contrat de travail fictif (voir pour utiliser FPDF ?)

### Page Responsable de Boutique

- [ ] Page de management de la boutique
- [ ] Chiffre d'affaires journalier, mensuel et annuel
- [ ] Liste des salariés de cette boutique
- [ ] Statistiques de ventes de la boutique par employés présents tel ou tel jour
  - _Cela implique de modifier le MCD, à voir si c'est pertinent de le faire ?_

### Page Gestionnaire du Zoo

- [ ] Gestion des animaux au sein du zoo
  - Possibilité de déplacer un animal d'un enclos à un autre
  - Possibilité de supprimer un animal du zoo
- [ ] Gestionnaire des parrainages du zoo
  - Affichage des parrainages
  - Affichage du nom du visiteur qui parraine l'animal

---

## Technologies Utilisées

- **Backend** : PHP avec Oracle Database (OCI)
- **Frontend** : HTML5, CSS3, Bootstrap 5
- **Architecture** : MVC (Modèle-Vue-Contrôleur)
- **Base de données** : Oracle Database