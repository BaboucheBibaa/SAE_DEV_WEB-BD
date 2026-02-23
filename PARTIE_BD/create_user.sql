-- =========================
-- SCRIPT DE CRÉATION DE L'UTILISATEUR SAE_USER
-- À exécuter en tant que SYSTEM ou SYSDBA
-- =========================

-- Se connecter à la PDB (Pluggable Database)
ALTER SESSION SET CONTAINER = FREEPDB1;

-- Supprimer l'utilisateur s'il existe déjà (avec CASCADE pour supprimer tous ses objets)
BEGIN
    EXECUTE IMMEDIATE 'DROP USER SAE_USER CASCADE';
EXCEPTION
    WHEN OTHERS THEN
        IF SQLCODE != -1918 THEN -- Ignorer si l'utilisateur n'existe pas
            RAISE;
        END IF;
END;
/

-- Créer l'utilisateur SAE_USER (local à la PDB)
CREATE USER SAE_USER IDENTIFIED BY sae2026;

-- Accorder les privilèges de base
GRANT CONNECT TO SAE_USER;
GRANT RESOURCE TO SAE_USER;

-- Accorder les privilèges de création d'objets
GRANT CREATE SESSION TO SAE_USER;
GRANT CREATE TABLE TO SAE_USER;
GRANT CREATE VIEW TO SAE_USER;
GRANT CREATE SEQUENCE TO SAE_USER;
GRANT CREATE TRIGGER TO SAE_USER;
GRANT CREATE PROCEDURE TO SAE_USER;

-- Accorder un quota illimité sur le tablespace par défaut
GRANT UNLIMITED TABLESPACE TO SAE_USER;

-- Afficher un message de confirmation
SELECT 'Utilisateur SAE_USER créé avec succès!' AS Message FROM DUAL;
