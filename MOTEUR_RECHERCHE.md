# Moteur de Recherche - Zoo'land

## Description

Un moteur de recherche complet pour votre infrastructure de gestion du zoo, permettant de chercher à travers toutes les données de la base de données : animaux, espèces, zones, employés et boutiques.

## Fichiers Créés

### 1. Service de Recherche (`services/ServiceSearch.php`)

Ce fichier contient toute la logique de recherche :

- **`recherchGlobale($searchTerm, $tables = null)`**  
  Effectue une recherche simple dans toutes les tables ou les tables spécifiées.
  
- **`recherchAvancee($searchTerm, $category, $filters = [])`**  
  Effectue une recherche avec filtres optionnels selon la catégorie sélectionnée.

- **Méthodes spécialisées :**
  - `rechercherAnimaux()` - Recherche avec filtres par espèce/zone
  - `rechercherEspeces()` - Recherche d'espèces avec compteur d'animaux
  - `rechercherZones()` - Recherche de zones et enclos
  - `rechercherEmployes()` - Recherche d'employés par fonction
  - `rechercherBoutiques()` - Recherche des produits boutique

- **`obtenirFiltres()`**  
  Récupère les listes de filtrage (espèces, zones, fonctions).

### 2. Contrôleur de Recherche (`controllers/c-search.php`)

Gère les requêtes de recherche :

- **`handleRequest()`**  
  Détecte le type de recherche et redirige vers la bonne méthode.

- **`rechercheGlobale()`**  
  Lance une recherche simple (recherche globale).

- **`rechercheAvancee()`**  
  Lance une recherche avec filtres.

- **`affichePage()`**  
  Affiche la page du moteur de recherche sans résultats.

### 3. Vue du Moteur de Recherche (`views/test-moteur-recherche.php`)

Interface utilisateur avec deux onglets :
**Onglet 1 : Recherche Globale**

- Barre de recherche simple
- Affiche les résultats organisés par catégorie (animaux, espèces, zones, employés, boutiques)
- Chaque résultat affiche les informations pertinentes
**Onglet 2 : Recherche Avancée**

- Sélection de catégorie
- Filtres dynamiques en fonction de la catégorie choisie
- Pour les animaux : filtre par espèce et zone
- Pour les employés : filtre par fonction
- Affichage détaillé des résultats

### 4. Intégration dans `index.php`

- Import du service et contrôleur
- Route pour l'action `search`

### 5. Navigation (`views/v-includes.php`)

Ajout d'un lien vers la recherche dans la barre de navigation.

## Utilisation

### Accès

Depuis l'application, cliquez sur le lien "Recherche" dans la navigation ou visitez :
```
index.php?action=search
```

### Recherche 

1. Entrez un terme (nom d'animal, espèce, zone, etc.)
2. Les résultats s'affichent groupés par catégorie
3. Les animaux affichent le poids et la date de naissance
4. Les employés affichent l'email
5. Les produits affichent le prix

### Recherche Avancée

1. Sélectionnez une catégorie (Animaux, Espèces, Zones, Employés, Boutiques)
2. Entrez votre terme de recherche
3. Sélectionnez les filtres optionnels qui apparaissent
4. Les résultats s'affichent avec tous les détails disponibles

## Fonctionnalités

✅ **Recherche insensible à la casse** - "lion", "LION", "Lion" = même résultat  
✅ **Recherche par mots-clés partiels** - "zon" trouve "zone"  
✅ **Filtres dynamiques** - Les filtres changent selon la catégorie  
✅ **Affichage enrichi** - Informations additionnelles (stock, prix, climat, etc.)  
✅ **Compteurs de résultats** - Badges pour voir le nombre de résultats par catégorie  
✅ **Interface responsive** - Adapté aux mobiles et desktops  
✅ **Intégration Bootstrap** - Style cohérent avec le reste de l'appli  

## Personnalisation

### Ajouter une nouvelle table à la recherche

1. Ajoutez une méthode `rechercherVotrTable()` dans `ServiceSearch.php`
2. Ajoutez un cas dans la méthode `recherchAvancee()`
3. Mettez à jour la vue pour afficher les résultats

### Modifier l'affichage des résultats

Modifiez la section HTML appropriée dans `test-moteur-recherche.php` pour changer le format (couleurs, icônes, informations affichées).

### Ajouter des filtres supplémentaires

Modifiez la méthode `obtenirFiltres()` pour récupérer des données additionnelles, puis mettez à jour le formulaire de recherche avancée.

## Exemples de Requêtes

- **Trouver un animal :** Entrez "Simba" en recherche globale
- **Chercher tous les lions :** Sélectionnez "Animaux", entrez "lion", filtrez par espèce "Lion"
- **Trouver un employé :** Entrez son nom en recherche globale ou avancée
- **Chercher les produits :** Entrez le nom du produit en recherche globale
- **Explorer les zones :** Sélectionnez "Zones" en recherche avancée
