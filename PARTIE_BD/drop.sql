-- =============================================
-- SCRIPT DE SUPPRESSION DE TOUTES LES TABLES
-- =============================================
-- Ordre respectant les contraintes de clés étrangères
-- (du plus dépendant au moins dépendant)
-- =============================================

-- Supprimer les tables avec dépendances (feuilles de l'arbre FK)
DROP TABLE Reparation;
DROP TABLE Travaille_Dans_La_Boutique;
DROP TABLE Est_Affectee_A;
DROP TABLE Pratique_Soins;
DROP TABLE Bien_Etre_Quotidien;
DROP TABLE Est_Le_Parent_De;
DROP TABLE Est_Compatible_Avec;
DROP TABLE Est_Parraine;
DROP TABLE Chiffre_Affaires;

-- Supprimer les tables intermédiaires
DROP TABLE Animal;
DROP TABLE Contrat_Travail;
DROP TABLE Boutique;

-- Supprimer les tables de structure
DROP TABLE Enclos;
DROP TABLE Visiteur;
DROP TABLE Zone;
DROP TABLE Personnel;

-- Supprimer les tables de base
DROP TABLE Prestataire;
DROP TABLE Espece;
DROP TABLE Fonction;

COMMIT;

