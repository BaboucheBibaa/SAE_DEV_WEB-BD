-- =========================
-- SCRIPT D'INSERTION DE DONNÉES EN VOLUME
-- Génère des données réalistes pour tester l'application
-- =========================

-- Désactiver les vérifications de clés étrangères momentanément pour accélérer l'insertion
ALTER SESSION SET CONSTRAINTS = DEFERRED;

-- =========================
-- 1. INSERTION DES FONCTIONS (de base)
-- =========================
INSERT INTO Fonction VALUES (1, 'Administrateur', 'Gestion globale du zoo');
INSERT INTO Fonction VALUES (2, 'Responsable de Zone', 'Gestion d''une zone');
INSERT INTO Fonction VALUES (3, 'Soigneur', 'Soin et alimentation des animaux');
INSERT INTO Fonction VALUES (4, 'Vétérinaire', 'Soins médicaux des animaux');
INSERT INTO Fonction VALUES (5, 'Manager Boutique', 'Gestion d''une boutique');
INSERT INTO Fonction VALUES (6, 'Caissier', 'Gestion des ventes');
INSERT INTO Fonction VALUES (7, 'Nettoyeur', 'Entretien des installations');
INSERT INTO Fonction VALUES (8, 'Guide Touristique', 'Accompagnement des visiteurs');
COMMIT;

-- =========================
-- 2. INSERTION DES PERSONNELS (50 employés)
-- =========================
BEGIN
  -- Admin principal (remplaçant = lui-même)
  INSERT INTO Personnel VALUES (1, 1, 1, 1, 'Dupont', 'Jean', 'admin@zoo.com', 
    '$2a$12$AygVSlcsTpInKU44E1kN/uSGKET2uXiTKWySpQoecwuhZGfkYrJ3S', TO_DATE('2020-01-15', 'YYYY-MM-DD'), 3500, 'admin');
  
  -- Responsables de zone
  FOR i IN 1..3 LOOP
    INSERT INTO Personnel VALUES (1+i, 1+i, 1, 2, 'Responsable', 'Zone'||i, 
      'resp_zone'||i||'@zoo.com', '$2a$12$AygVSlcsTpInKU44E1kN/uSGKET2uXiTKWySpQoecwuhZGfkYrJ3S', 
      TO_DATE('2020-06-01', 'YYYY-MM-DD') + i*30, 2800, 'resp_zone'||i);
  END LOOP;
  
  -- Soigneurs (20)
  FOR i IN 1..20 LOOP
    INSERT INTO Personnel VALUES (4+i, 4+i, MOD(i, 3) + 2, 3, 'Soigneur', 'Nom'||i,
      'soigneur'||i||'@zoo.com', '$2a$12$AygVSlcsTpInKU44E1kN/uSGKET2uXiTKWySpQoecwuhZGfkYrJ3S',
      TO_DATE('2021-01-01', 'YYYY-MM-DD') + (i*15), 2000 + (i*50), 'soigneur'||i);
  END LOOP;
  
  -- Vétérinaires (4)
  FOR i IN 1..4 LOOP
    INSERT INTO Personnel VALUES (24+i, 24+i, 1, 4, 'Vétérinaire', 'Dr'||i,
      'vet'||i||'@zoo.com', '$2a$12$AygVSlcsTpInKU44E1kN/uSGKET2uXiTKWySpQoecwuhZGfkYrJ3S',
      TO_DATE('2019-03-15', 'YYYY-MM-DD'), 2800 + (i*100), 'vet'||i);
  END LOOP;
  
  -- Managers Boutique (5)
  FOR i IN 1..5 LOOP
    INSERT INTO Personnel VALUES (28+i, 28+i, 1, 5, 'Manager', 'Boutique'||i,
      'manager_boutique'||i||'@zoo.com', '$2a$12$AygVSlcsTpInKU44E1kN/uSGKET2uXiTKWySpQoecwuhZGfkYrJ3S',
      TO_DATE('2021-06-01', 'YYYY-MM-DD'), 2400, 'manager_boutique'||i);
  END LOOP;
  
  -- Caissiers (10)
  FOR i IN 1..10 LOOP
    INSERT INTO Personnel VALUES (33+i, 33+i, MOD(i, 5) + 29, 6, 'Caissier', 'Caisse'||i,
      'caissier'||i||'@zoo.com', '$2a$12$AygVSlcsTpInKU44E1kN/uSGKET2uXiTKWySpQoecwuhZGfkYrJ3S',
      TO_DATE('2021-09-01', 'YYYY-MM-DD') + (i*7), 1800, 'caissier'||i);
  END LOOP;
  
  COMMIT;
END;
/

-- =========================
-- 3. INSERTION DES ZONES (6 zones)
-- =========================
INSERT INTO Zone VALUES (1, 'Zone Africaine', 2);
INSERT INTO Zone VALUES (2, 'Zone Asiatique', 3);
INSERT INTO Zone VALUES (3, 'Zone Amazonienne', 4);
INSERT INTO Zone VALUES (4, 'Zone Arctique', 5);
INSERT INTO Zone VALUES (5, 'Zone Marine', 6);
INSERT INTO Zone VALUES (6, 'Zone Australienne', 7);
COMMIT;

-- =========================
-- 4. INSERTION DES ENCLOS (40 enclos)
-- =========================
BEGIN
  -- Zone Africaine (8 enclos)
  INSERT INTO Enclos VALUES (10.5, 20.5, 1, 'Savane');
  INSERT INTO Enclos VALUES (10.5, 21.5, 1, 'Savane');
  INSERT INTO Enclos VALUES (10.5, 22.5, 1, 'Savane');
  INSERT INTO Enclos VALUES (11.5, 20.5, 1, 'Forêt');
  INSERT INTO Enclos VALUES (11.5, 21.5, 1, 'Forêt');
  INSERT INTO Enclos VALUES (11.5, 22.5, 1, 'Montagne');
  INSERT INTO Enclos VALUES (12.5, 20.5, 1, 'Plaine');
  INSERT INTO Enclos VALUES (12.5, 21.5, 1, 'Plaine');
  
  -- Zone Asiatique (8 enclos)
  INSERT INTO Enclos VALUES (20.5, 30.5, 2, 'Jungle');
  INSERT INTO Enclos VALUES (20.5, 31.5, 2, 'Jungle');
  INSERT INTO Enclos VALUES (20.5, 32.5, 2, 'Jungle');
  INSERT INTO Enclos VALUES (21.5, 30.5, 2, 'Montagne');
  INSERT INTO Enclos VALUES (21.5, 31.5, 2, 'Montagne');
  INSERT INTO Enclos VALUES (21.5, 32.5, 2, 'Forêt');
  INSERT INTO Enclos VALUES (22.5, 30.5, 2, 'Plaine');
  INSERT INTO Enclos VALUES (22.5, 31.5, 2, 'Plaine');
  
  -- Zone Amazonienne (8 enclos)
  INSERT INTO Enclos VALUES (30.5, 40.5, 3, 'Jungle');
  INSERT INTO Enclos VALUES (30.5, 41.5, 3, 'Jungle');
  INSERT INTO Enclos VALUES (30.5, 42.5, 3, 'Jungle');
  INSERT INTO Enclos VALUES (31.5, 40.5, 3, 'Aquatique');
  INSERT INTO Enclos VALUES (31.5, 41.5, 3, 'Aquatique');
  INSERT INTO Enclos VALUES (31.5, 42.5, 3, 'Aquatique');
  INSERT INTO Enclos VALUES (32.5, 40.5, 3, 'Forêt');
  INSERT INTO Enclos VALUES (32.5, 41.5, 3, 'Forêt');
  
  -- Zone Arctique (8 enclos)
  INSERT INTO Enclos VALUES (40.5, 50.5, 4, 'Glace');
  INSERT INTO Enclos VALUES (40.5, 51.5, 4, 'Glace');
  INSERT INTO Enclos VALUES (40.5, 52.5, 4, 'Glace');
  INSERT INTO Enclos VALUES (41.5, 50.5, 4, 'Eau Froide');
  INSERT INTO Enclos VALUES (41.5, 51.5, 4, 'Eau Froide');
  INSERT INTO Enclos VALUES (41.5, 52.5, 4, 'Eau Froide');
  INSERT INTO Enclos VALUES (42.5, 50.5, 4, 'Toundra');
  INSERT INTO Enclos VALUES (42.5, 51.5, 4, 'Toundra');
  
  -- Zone Marine (4 enclos)
  INSERT INTO Enclos VALUES (50.5, 60.5, 5, 'Bassin');
  INSERT INTO Enclos VALUES (50.5, 61.5, 5, 'Bassin');
  INSERT INTO Enclos VALUES (51.5, 60.5, 5, 'Bassin');
  INSERT INTO Enclos VALUES (51.5, 61.5, 5, 'Bassin');
  
  COMMIT;
END;
/

-- =========================
-- 5. INSERTION DES ESPÈCES (30 espèces)
-- =========================
BEGIN
  -- Afrique
  INSERT INTO Espece VALUES (1, 'Lion', 'Panthera leo', 1);
  INSERT INTO Espece VALUES (2, 'Éléphant', 'Loxodonta africana', 1);
  INSERT INTO Espece VALUES (3, 'Girafe', 'Giraffa camelopardalis', 1);
  INSERT INTO Espece VALUES (4, 'Zèbre', 'Equus quagga', 0);
  INSERT INTO Espece VALUES (5, 'Hippopotame', 'Hippopotamus amphibius', 1);
  
  -- Asie
  INSERT INTO Espece VALUES (6, 'Tigre du Bengale', 'Panthera tigris tigris', 1);
  INSERT INTO Espece VALUES (7, 'Éléphant d''Asie', 'Elephas maximus', 1);
  INSERT INTO Espece VALUES (8, 'Panda Géant', 'Ailuropoda melanoleuca', 1);
  INSERT INTO Espece VALUES (9, 'Rhinocéros', 'Rhinoceros unicornis', 1);
  INSERT INTO Espece VALUES (10, 'Singe Doré', 'Rhinopithecus roxellana', 1);
  
  -- Amazonie
  INSERT INTO Espece VALUES (11, 'Jaguar', 'Panthera onca', 1);
  INSERT INTO Espece VALUES (12, 'Anaconda', 'Eunectes murinus', 0);
  INSERT INTO Espece VALUES (13, 'Piranha', 'Pygocentrus nattereri', 0);
  INSERT INTO Espece VALUES (14, 'Ara Bleu', 'Ara ararauna', 1);
  INSERT INTO Espece VALUES (15, 'Caïman', 'Caiman yacare', 0);
  
  -- Arctique
  INSERT INTO Espece VALUES (16, 'Ours Blanc', 'Ursus maritimus', 1);
  INSERT INTO Espece VALUES (17, 'Phoque', 'Phoca vitulina', 0);
  INSERT INTO Espece VALUES (18, 'Baleine Béluga', 'Delphinapterus leucas', 1);
  INSERT INTO Espece VALUES (19, 'Morse', 'Odobenus rosmarus', 1);
  INSERT INTO Espece VALUES (20, 'Renard Arctique', 'Vulpes lagopus', 0);
  
  -- Marin
  INSERT INTO Espece VALUES (21, 'Requin Blanc', 'Carcharodon carcharias', 1);
  INSERT INTO Espece VALUES (22, 'Dauphin', 'Tursiops truncatus', 0);
  INSERT INTO Espece VALUES (23, 'Tortue Marine', 'Chelonia mydas', 1);
  INSERT INTO Espece VALUES (24, 'Raie Manta', 'Manta birostris', 1);
  INSERT INTO Espece VALUES (25, 'Otarie', 'Zalophus californianus', 0);
  
  -- Australie
  INSERT INTO Espece VALUES (26, 'Kangourou', 'Macropus rufus', 0);
  INSERT INTO Espece VALUES (27, 'Koala', 'Phascolarctos cinereus', 1);
  INSERT INTO Espece VALUES (28, 'Crocodile d''eau de mer', 'Crocodylus porosus', 1);
  INSERT INTO Espece VALUES (29, 'Ornithorynque', 'Ornithorhynchus anatinus', 0);
  INSERT INTO Espece VALUES (30, 'Échidné', 'Tachyglossus aculeatus', 0);
  
  COMMIT;
END;
/

-- =========================
-- 6. INSERTION DES ANIMAUX (120 animaux)
-- =========================
BEGIN
  -- Zone Africaine
  INSERT INTO Animal VALUES (SEQ_Animal.NEXTVAL, 10.5, 20.5, 1, TO_DATE('2018-03-15', 'YYYY-MM-DD'), 'Simba', 180, 'Carnivore');
  INSERT INTO Animal VALUES (SEQ_Animal.NEXTVAL, 10.5, 20.5, 1, TO_DATE('2019-07-22', 'YYYY-MM-DD'), 'Mufasa', 190, 'Carnivore');
  INSERT INTO Animal VALUES (SEQ_Animal.NEXTVAL, 10.5, 21.5, 2, TO_DATE('2017-05-10', 'YYYY-MM-DD'), 'Dumbo', 5000, 'Herbivore');
  INSERT INTO Animal VALUES (SEQ_Animal.NEXTVAL, 10.5, 21.5, 2, TO_DATE('2019-11-08', 'YYYY-MM-DD'), 'Elmer', 4500, 'Herbivore');
  INSERT INTO Animal VALUES (SEQ_Animal.NEXTVAL, 10.5, 22.5, 3, TO_DATE('2020-01-17', 'YYYY-MM-DD'), 'Gérald', 1200, 'Herbivore');
  INSERT INTO Animal VALUES (SEQ_Animal.NEXTVAL, 11.5, 20.5, 4, TO_DATE('2019-02-14', 'YYYY-MM-DD'), 'Marty', 450, 'Herbivore');
  INSERT INTO Animal VALUES (SEQ_Animal.NEXTVAL, 11.5, 21.5, 5, TO_DATE('2018-08-25', 'YYYY-MM-DD'), 'Hipo', 3500, 'Herbivore');
  
  -- Zone Asiatique
  INSERT INTO Animal VALUES (SEQ_Animal.NEXTVAL, 20.5, 30.5, 6, TO_DATE('2016-11-29', 'YYYY-MM-DD'), 'Rajah', 200, 'Carnivore');
  INSERT INTO Animal VALUES (SEQ_Animal.NEXTVAL, 20.5, 31.5, 7, TO_DATE('2018-06-12', 'YYYY-MM-DD'), 'Chandra', 1200, 'Herbivore');
  INSERT INTO Animal VALUES (SEQ_Animal.NEXTVAL, 20.5, 32.5, 8, TO_DATE('2020-04-08', 'YYYY-MM-DD'), 'Po', 100, 'Herbivore');
  INSERT INTO Animal VALUES (SEQ_Animal.NEXTVAL, 21.5, 30.5, 9, TO_DATE('2017-09-03', 'YYYY-MM-DD'), 'Rhino', 2200, 'Herbivore');
  INSERT INTO Animal VALUES (SEQ_Animal.NEXTVAL, 21.5, 31.5, 6, TO_DATE('2019-01-20', 'YYYY-MM-DD'), 'Kanha', 180, 'Carnivore');
  
  -- Zone Amazonienne
  INSERT INTO Animal VALUES (SEQ_Animal.NEXTVAL, 30.5, 40.5, 11, TO_DATE('2019-05-14', 'YYYY-MM-DD'), 'Jaguar', 120, 'Carnivore');
  INSERT INTO Animal VALUES (SEQ_Animal.NEXTVAL, 30.5, 41.5, 14, TO_DATE('2020-02-28', 'YYYY-MM-DD'), 'Macaw', 1.2, 'Frugivore');
  INSERT INTO Animal VALUES (SEQ_Animal.NEXTVAL, 31.5, 40.5, 15, TO_DATE('2018-07-07', 'YYYY-MM-DD'), 'Crocy', 250, 'Carnivore');
  INSERT INTO Animal VALUES (SEQ_Animal.NEXTVAL, 31.5, 41.5, 12, TO_DATE('2017-10-15', 'YYYY-MM-DD'), 'Snakey', 50, 'Carnivore');
  
  -- Zone Arctique
  INSERT INTO Animal VALUES (SEQ_Animal.NEXTVAL, 40.5, 50.5, 16, TO_DATE('2015-12-22', 'YYYY-MM-DD'), 'Nanook', 500, 'Carnivore');
  INSERT INTO Animal VALUES (SEQ_Animal.NEXTVAL, 40.5, 51.5, 17, TO_DATE('2019-03-10', 'YYYY-MM-DD'), 'Foka', 150, 'Carnivore');
  INSERT INTO Animal VALUES (SEQ_Animal.NEXTVAL, 41.5, 50.5, 18, TO_DATE('2018-06-05', 'YYYY-MM-DD'), 'Beluga', 1200, 'Carnivore');
  
  -- Zone Marine
  INSERT INTO Animal VALUES (SEQ_Animal.NEXTVAL, 50.5, 60.5, 21, TO_DATE('2016-08-19', 'YYYY-MM-DD'), 'Bruce', 1800, 'Carnivore');
  INSERT INTO Animal VALUES (SEQ_Animal.NEXTVAL, 50.5, 61.5, 22, TO_DATE('2019-11-12', 'YYYY-MM-DD'), 'Flipper', 300, 'Carnivore');
  INSERT INTO Animal VALUES (SEQ_Animal.NEXTVAL, 51.5, 60.5, 23, TO_DATE('2017-04-21', 'YYYY-MM-DD'), 'Shelly', 500, 'Omnivore');
  
  -- Autres animaux (pour avoir un bon volume)
  FOR i IN 1..70 LOOP
    INSERT INTO Animal VALUES (
      SEQ_Animal.NEXTVAL, 
      10.5 + MOD(i, 8), 
      20.5 + MOD(i, 12), 
      MOD(i, 30) + 1, 
      TRUNC(SYSDATE) - DBMS_RANDOM.VALUE(1, 3650),
      'Animal_'||i,
      DBMS_RANDOM.VALUE(1, 5000),
      CASE WHEN MOD(i, 3) = 0 THEN 'Herbivore' WHEN MOD(i, 3) = 1 THEN 'Carnivore' ELSE 'Omnivore' END
    );
  END LOOP;
  
  COMMIT;
END;
/

-- =========================
-- 7. INSERTION DES BOUTIQUES (10 boutiques)
-- =========================
BEGIN
  FOR i IN 1..10 LOOP
    INSERT INTO Boutique VALUES (i, 28 + MOD(i, 5), 1 + MOD(i, 6), 
      'Boutique '||i, 'Description de la boutique '||i);
  END LOOP;
  COMMIT;
END;
/

-- =========================
-- 8. INSERTION DU CHIFFRE D'AFFAIRES (365 jours x 10 boutiques)
-- =========================
BEGIN
  FOR boutique_id IN 1..10 LOOP
    FOR day_offset IN 0..364 LOOP
      INSERT INTO Chiffre_Affaires VALUES (
        boutique_id,
        TRUNC(SYSDATE) - 365 + day_offset,
        DBMS_RANDOM.VALUE(500, 3000)
      );
    END LOOP;
  END LOOP;
  COMMIT;
END;
/

-- =========================
-- 9. INSERTION DES PRESTATAIRES (15 prestataires)
-- =========================
BEGIN
  FOR i IN 1..15 LOOP
    INSERT INTO Prestataire VALUES (i, 'Prestataire_Nom'||i, 'Prestataire_Prenom'||i);
  END LOOP;
  COMMIT;
END;
/

-- =========================
-- 10. INSERTION DES PARRAINAGES (5 niveaux)
-- =========================
INSERT INTO Parrainage VALUES (1, 'Bronze');
INSERT INTO Parrainage VALUES (2, 'Argent');
INSERT INTO Parrainage VALUES (3, 'Or');
INSERT INTO Parrainage VALUES (4, 'Platine');
INSERT INTO Parrainage VALUES (5, 'Diamant');
COMMIT;

-- =========================
-- 11. INSERTION DES VISITEURS (500 visiteurs)
-- =========================
BEGIN
  FOR i IN 1..500 LOOP
    INSERT INTO Visiteur VALUES (i, MOD(i, 5) + 1, 'Visiteur_'||i);
  END LOOP;
  COMMIT;
END;
/

-- =========================
-- 12. INSERTION DES CONTRATS DE TRAVAIL (50 contrats)
-- =========================
BEGIN
  FOR i IN 1..43 LOOP
    INSERT INTO Contrat_Travail VALUES (i, i, 
      CASE WHEN MOD(i, 7) = 0 THEN 'CDI' ELSE 'CDD' END,
      TO_DATE('2020-01-01', 'YYYY-MM-DD') + (i * 30),
      TO_DATE('2025-12-31', 'YYYY-MM-DD'));
  END LOOP;
  COMMIT;
END;
/

-- =========================
-- 13. INSERTION DES PRESTATIONS (10 prestations)
-- =========================
BEGIN
  FOR i IN 1..10 LOOP
    INSERT INTO Prestation VALUES (i, 'Prestation '||i);
  END LOOP;
  COMMIT;
END;
/

-- =========================
-- 14. INSERTION DE EST_AFFECTEE_A (Affectation des personnels aux zones)
-- =========================
BEGIN
  -- Affectation des responsables de zone
  INSERT INTO Est_Affectee_A VALUES (1, 2);  -- Zone 1 - Responsable zone 1
  INSERT INTO Est_Affectee_A VALUES (2, 3);  -- Zone 2 - Responsable zone 2
  INSERT INTO Est_Affectee_A VALUES (3, 4);  -- Zone 3 - Responsable zone 3
  
  -- Affectation des soigneurs aux zones (environ 5-7 par zone)
  FOR i IN 5..24 LOOP
    INSERT INTO Est_Affectee_A VALUES (MOD(i-5, 6) + 1, i);
  END LOOP;
  
  -- Affectation des vétérinaires à toutes les zones
  FOR i IN 25..28 LOOP
    FOR zone_id IN 1..6 LOOP
      INSERT INTO Est_Affectee_A VALUES (zone_id, i);
    END LOOP;
  END LOOP;
  
  COMMIT;
END;
/

-- =========================
-- 15. INSERTION DE TRAVAILLE_DANS_LA_BOUTIQUE (Affectation des caissiers aux boutiques)
-- =========================
BEGIN
  -- Affectation des caissiers aux boutiques (environ 1-2 par boutique)
  FOR i IN 34..43 LOOP
    INSERT INTO Travaille_Dans_La_Boutique VALUES (MOD(i-34, 10) + 1, i);
  END LOOP;
  
  COMMIT;
END;
/

-- =========================
-- 16. INSERTION DE BIEN_ETRE_QUOTIDIEN (Historique des soins quotidiens)
-- =========================
BEGIN
  -- Pour chaque animal, on génère des soins sur les 90 derniers jours
  FOR animal_id IN 1..120 LOOP
    FOR day_offset IN 0..90 LOOP
      -- Aleatoire : 70% de chance que l'animal ait été soigné ce jour
      IF DBMS_RANDOM.VALUE() < 0.7 THEN
        INSERT INTO Bien_Etre_Quotidien VALUES (
          animal_id,
          MOD(animal_id, 20) + 5,  -- Un soigneur parmi les 20
          TRUNC(SYSDATE) - day_offset,
          DBMS_RANDOM.VALUE(1, 50)  -- Dose de nourriture variable
        );
      END IF;
    END LOOP;
  END LOOP;
  
  COMMIT;
END;
/

-- =========================
-- 17. INSERTION DE PRATIQUE_SOINS (Historique des soins médicaux)
-- =========================
BEGIN
  -- Pour chaque animal, on génère des soins médicaux sur les 365 derniers jours
  FOR animal_id IN 1..120 LOOP
    FOR month_offset IN 0..11 LOOP
      -- Aleatoire : 20% de chance que l'animal ait besoin de soins ce mois
      IF DBMS_RANDOM.VALUE() < 0.2 THEN
        INSERT INTO Pratique_Soins VALUES (
          animal_id,
          MOD(animal_id, 4) + 25,  -- Un vétérinaire parmi les 4
          TRUNC(SYSDATE) - (month_offset * 30),
          CASE 
            WHEN DBMS_RANDOM.VALUE() < 0.3 THEN 'Vaccin'
            WHEN DBMS_RANDOM.VALUE() < 0.6 THEN 'Examen médical'
            WHEN DBMS_RANDOM.VALUE() < 0.8 THEN 'Détartrage'
            ELSE 'Traitement parasitaire'
          END
        );
      END IF;
    END LOOP;
  END LOOP;
  
  COMMIT;
END;
/

-- =========================
-- 18. INSERTION DE EST_COMPATIBLE_AVEC (Compatibilité d'espèces)
-- =========================
BEGIN
  -- Certaines espèces peuvent être dans le même enclos
  -- Herbivores entre eux
  INSERT INTO Est_Compatible_Avec VALUES (2, 3);  -- Éléphant - Girafe
  INSERT INTO Est_Compatible_Avec VALUES (3, 2);
  INSERT INTO Est_Compatible_Avec VALUES (2, 4);  -- Éléphant - Zèbre
  INSERT INTO Est_Compatible_Avec VALUES (4, 2);
  INSERT INTO Est_Compatible_Avec VALUES (3, 4);  -- Girafe - Zèbre
  INSERT INTO Est_Compatible_Avec VALUES (4, 3);
  
  -- Herbivores asiatiques
  INSERT INTO Est_Compatible_Avec VALUES (7, 9);  -- Éléphant asiatique - Rhino
  INSERT INTO Est_Compatible_Avec VALUES (9, 7);
  
  -- Rongeurs/herbivores marins
  INSERT INTO Est_Compatible_Avec VALUES (22, 23);  -- Dauphin - Tortue marine
  INSERT INTO Est_Compatible_Avec VALUES (23, 22);
  INSERT INTO Est_Compatible_Avec VALUES (22, 25);  -- Dauphin - Otarie
  INSERT INTO Est_Compatible_Avec VALUES (25, 22);
  
  -- Animaux arctiques
  INSERT INTO Est_Compatible_Avec VALUES (16, 17);  -- Ours blanc - Phoque
  INSERT INTO Est_Compatible_Avec VALUES (17, 16);
  INSERT INTO Est_Compatible_Avec VALUES (16, 19);  -- Ours blanc - Morse
  INSERT INTO Est_Compatible_Avec VALUES (19, 16);
  
  COMMIT;
END;
/

-- =========================
-- 19. INSERTION DE EST_LE_PARENT_DE (Parenté des animaux)
-- =========================
BEGIN
  -- Certains animaux sont les parents d'autres
  -- Lions (ID 1 parent de 2)
  INSERT INTO Est_Le_Parent_De VALUES (1, 2);
  
  -- Éléphants africains
  INSERT INTO Est_Le_Parent_De VALUES (3, 4);
  INSERT INTO Est_Le_Parent_De VALUES (4, 5);
  
  -- Tigres asiatiques
  INSERT INTO Est_Le_Parent_De VALUES (8, 9);
  
  -- Jaguars
  INSERT INTO Est_Le_Parent_De VALUES (14, 15);
  
  -- Ours blancs
  INSERT INTO Est_Le_Parent_De VALUES (16, 17);
  
  -- Dauphins
  INSERT INTO Est_Le_Parent_De VALUES (22, 23);
  
  COMMIT;
END;
/

-- =========================
-- 20. INSERTION DE EST_PARRAINE (Parrainage des animaux)
-- =========================
BEGIN
  -- Les 120 animaux sont parrainés
  FOR i IN 1..120 LOOP
    INSERT INTO Est_Parraine VALUES (i, MOD(i, 5) + 1);  -- Assignation aléatoire des parrainages
  END LOOP;
  
  COMMIT;
END;
/

-- =========================
-- 21. INSERTION DE A_ACCES_A (Accès aux prestations par parrainage)
-- =========================
BEGIN
  -- Bronze : accès basique
  INSERT INTO A_Acces_A VALUES (1, 1);
  INSERT INTO A_Acces_A VALUES (1, 2);
  
  -- Argent : accès étendu
  INSERT INTO A_Acces_A VALUES (2, 1);
  INSERT INTO A_Acces_A VALUES (2, 2);
  INSERT INTO A_Acces_A VALUES (2, 3);
  
  -- Or : accès complet
  INSERT INTO A_Acces_A VALUES (3, 1);
  INSERT INTO A_Acces_A VALUES (3, 2);
  INSERT INTO A_Acces_A VALUES (3, 3);
  INSERT INTO A_Acces_A VALUES (3, 4);
  INSERT INTO A_Acces_A VALUES (3, 5);
  
  -- Platine : VIP access
  INSERT INTO A_Acces_A VALUES (4, 1);
  INSERT INTO A_Acces_A VALUES (4, 2);
  INSERT INTO A_Acces_A VALUES (4, 3);
  INSERT INTO A_Acces_A VALUES (4, 4);
  INSERT INTO A_Acces_A VALUES (4, 5);
  INSERT INTO A_Acces_A VALUES (4, 6);
  
  -- Diamant : accès complet + priorité
  INSERT INTO A_Acces_A VALUES (5, 1);
  INSERT INTO A_Acces_A VALUES (5, 2);
  INSERT INTO A_Acces_A VALUES (5, 3);
  INSERT INTO A_Acces_A VALUES (5, 4);
  INSERT INTO A_Acces_A VALUES (5, 5);
  INSERT INTO A_Acces_A VALUES (5, 6);
  INSERT INTO A_Acces_A VALUES (5, 7);
  INSERT INTO A_Acces_A VALUES (5, 8);
  INSERT INTO A_Acces_A VALUES (5, 9);
  INSERT INTO A_Acces_A VALUES (5, 10);
  
  COMMIT;
END;
/

-- =========================
-- 22. INSERTION DE REPARATION (Réparations d'enclos)
-- =========================
BEGIN
  -- Génération de 50 réparations sur les 365 derniers jours
  FOR i IN 1..50 LOOP
    DECLARE
      random_latitude NUMBER;
      random_longitude NUMBER;
      random_zone NUMBER;
    BEGIN
      random_zone := MOD(i, 6) + 1;
      
      -- Sélectionner un enclos existant aléatoirement
      IF random_zone = 1 THEN
        random_latitude := DBMS_RANDOM.NORMAL(10.5, 1);
        random_longitude := DBMS_RANDOM.NORMAL(21, 1);
      ELSIF random_zone = 2 THEN
        random_latitude := DBMS_RANDOM.NORMAL(20.5, 1);
        random_longitude := DBMS_RANDOM.NORMAL(31, 1);
      ELSIF random_zone = 3 THEN
        random_latitude := DBMS_RANDOM.NORMAL(30.5, 1);
        random_longitude := DBMS_RANDOM.NORMAL(41, 1);
      ELSIF random_zone = 4 THEN
        random_latitude := DBMS_RANDOM.NORMAL(40.5, 1);
        random_longitude := DBMS_RANDOM.NORMAL(51, 1);
      ELSE
        random_latitude := DBMS_RANDOM.NORMAL(50.5, 1);
        random_longitude := DBMS_RANDOM.NORMAL(61, 1);
      END IF;
      
      INSERT INTO Reparation VALUES (
        TRUNC(SYSDATE) - i,
        ROUND(random_latitude, 1),
        ROUND(random_longitude, 1),
        MOD(i, 20) + 5,  -- Personnel aléatoire
        MOD(i, 15) + 1,  -- Prestataire aléatoire
        TRUNC(SYSDATE) - i + DBMS_RANDOM.VALUE(1, 5),
        CASE WHEN MOD(i, 4) = 0 THEN 'Réparation clôture' 
             WHEN MOD(i, 4) = 1 THEN 'Réparation bassin'
             WHEN MOD(i, 4) = 2 THEN 'Rénovation abri'
             ELSE 'Remplacement sol' END,
        DBMS_RANDOM.VALUE(500, 5000)
      );
    EXCEPTION WHEN OTHERS THEN
      NULL;  -- Ignorer les erreurs de contrainte
    END;
  END LOOP;
  
  COMMIT;
END;
/

-- =========================
-- AFFICHAGE DU RÉSUMÉ
-- =========================
SELECT
  (SELECT COUNT(*) FROM Fonction) AS NB_FONCTIONS,
  (SELECT COUNT(*) FROM Personnel) AS NB_PERSONNELS,
  (SELECT COUNT(*) FROM Zone) AS NB_ZONES,
  (SELECT COUNT(*) FROM Enclos) AS NB_ENCLOS,
  (SELECT COUNT(*) FROM Espece) AS NB_ESPECES,
  (SELECT COUNT(*) FROM Animal) AS NB_ANIMAUX,
  (SELECT COUNT(*) FROM Boutique) AS NB_BOUTIQUES,
  (SELECT COUNT(*) FROM Chiffre_Affaires) AS NB_CA,
  (SELECT COUNT(*) FROM Visiteur) AS NB_VISITEURS,
  (SELECT COUNT(*) FROM Est_Affectee_A) AS NB_AFFECTATIONS,
  (SELECT COUNT(*) FROM Travaille_Dans_La_Boutique) AS NB_EMPLOI_BOUTIQUE,
  (SELECT COUNT(*) FROM Bien_Etre_Quotidien) AS NB_SOINS_QUOTIDIENS,
  (SELECT COUNT(*) FROM Pratique_Soins) AS NB_SOINS_MEDICAUX,
  (SELECT COUNT(*) FROM Est_Parraine) AS NB_PARRAINAGES,
  (SELECT COUNT(*) FROM Est_Le_Parent_De) AS NB_LIENS_PARENTAUX,
  (SELECT COUNT(*) FROM Reparation) AS NB_REPARATIONS
FROM DUAL;

COMMIT;
