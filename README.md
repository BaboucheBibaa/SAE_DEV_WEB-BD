# SAE_DEV_WEB-BD

Site créé pour une SAE en développement web et bases de données

Architecture du site en MVC (Modèle Vue-Controlleur)

--- DONE:

Profil utilisateur individuel avec:
    - Possibilité de changer de MDP

Dashboard administrateur avec possibilité de:
    - Ajouter un employé
    - Supprimer un employé
    - Modifier un employé


TODO Liste:

Page responsable zone et affiche:
    - Liste des enclos, nombre d'animaux
    - Historique des réparations sur tel enclos
    - Historique des animaux dans les enclos

Page responsable soigneurs d'une zone:
    - Liste des enclos, nombre d'animaux
    - Historique des animaux dans les enclos
    - Liste des animaux
    - Historique des soins et des doses de nourriture quotidiennes fournies à un animal particulier

Page profil:
    - Ajouter la possibilité de mettre une absence entre tel et tel jour + motif [BONUS]
    - Référence sur un contrat de travail fictif (voir pour utiliser FPDF ?) [BONUS]

Page responsable de boutique:
    - Page de management de la boutique
    - Chiffre d'affaires journalier et ensuite afficher le chiffre d'affaires annuel et mensuel
    - Afficher la liste des salariés de cette boutique
    - Afficher les statistiques de ventes de la boutique par employés présents tel ou tel jour
      - ça implique de modifier le MCD, à voir si c'est pertinent de le faire ?

Page Gestionnaire du zoo:
    - Gestion des animaux au sein du zoo (possibilité de déplacer un animal d'un enclos à un autre, ou de le supprimer du zoo)
    - Gestionnaire des parrainages du zoo (affichage des parrainages + nom du visiteur qui parraine l'animal)