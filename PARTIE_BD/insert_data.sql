-- =========================
-- SCRIPT D'INSERTION DE DONNÉES EN VOLUME - ZOO'LAND
-- Utilise les séquences définies dans create_sequences.sql
-- Respecte toutes les contraintes de clés étrangères
-- =========================

-- Activation du mode COMMIT implicite
SET AUTOCOMMIT OFF;

-- =========================
-- 1. INSERTION DES FONCTIONS
-- =========================
INSERT INTO Fonction VALUES (seq_fonction.NEXTVAL, 'Administrateur', 'Gestion globale du zoo');
INSERT INTO Fonction VALUES (seq_fonction.NEXTVAL, 'Responsable de Zone', 'Gestion d''une zone');
INSERT INTO Fonction VALUES (seq_fonction.NEXTVAL, 'Soigneur', 'Soin et alimentation des animaux');
INSERT INTO Fonction VALUES (seq_fonction.NEXTVAL, 'Vétérinaire', 'Soins médicaux des animaux');
INSERT INTO Fonction VALUES (seq_fonction.NEXTVAL, 'Manager Boutique', 'Gestion d''une boutique');
INSERT INTO Fonction VALUES (seq_fonction.NEXTVAL, 'Caissier', 'Gestion des ventes');
INSERT INTO Fonction VALUES (seq_fonction.NEXTVAL, 'Nettoyeur', 'Entretien des installations');
INSERT INTO Fonction VALUES (seq_fonction.NEXTVAL, 'Guide Touristique', 'Accompagnement des visiteurs');
COMMIT;

-- =========================
-- 2. INSERTION DES PERSONNELS
-- =========================
-- Admin principal
INSERT INTO Personnel VALUES (seq_personnel.NEXTVAL, 100, 100, 10, 'Dupont', 'Jean', 'admin@zoo.com', 
  '$2a$12$AygVSlcsTpInKU44E1kN/uSGKET2uXiTKWySpQoecwuhZGfkYrJ3S', TO_DATE('2020-01-15', 'YYYY-MM-DD'), 3500, 'admin');

-- Responsables de zone (3)
INSERT INTO Personnel VALUES (seq_personnel.NEXTVAL, 101, 100, 11, 'Dupont', 'Marie', 'resp_zone1@zoo.com',
  '$2a$12$AygVSlcsTpInKU44E1kN/uSGKET2uXiTKWySpQoecwuhZGfkYrJ3S', TO_DATE('2020-06-01', 'YYYY-MM-DD'), 2800, 'resp_zone1');
INSERT INTO Personnel VALUES (seq_personnel.NEXTVAL, 102, 100, 11, 'Martin', 'Paul', 'resp_zone2@zoo.com',
  '$2a$12$AygVSlcsTpInKU44E1kN/uSGKET2uXiTKWySpQoecwuhZGfkYrJ3S', TO_DATE('2020-06-15', 'YYYY-MM-DD'), 2800, 'resp_zone2');
INSERT INTO Personnel VALUES (seq_personnel.NEXTVAL, 103, 100, 11, 'Durand', 'Sophie', 'resp_zone3@zoo.com',
  '$2a$12$AygVSlcsTpInKU44E1kN/uSGKET2uXiTKWySpQoecwuhZGfkYrJ3S', TO_DATE('2020-07-01', 'YYYY-MM-DD'), 2800, 'resp_zone3');

-- Soigneurs (20)
DECLARE
  v_id NUMBER := 104;
BEGIN
  FOR i IN 1..20 LOOP
    INSERT INTO Personnel VALUES (seq_personnel.NEXTVAL, v_id, 101 + MOD(i, 3), 12, 'Soigneur', 'Pers'||i,
      'soigneur'||i||'@zoo.com', '$2a$12$AygVSlcsTpInKU44E1kN/uSGKET2uXiTKWySpQoecwuhZGfkYrJ3S',
      TO_DATE('2021-01-01', 'YYYY-MM-DD') + (i*15), 2000 + (i*50), 'soigneur'||i);
    v_id := v_id + 1;
  END LOOP;
  COMMIT;
END;
/

-- Vétérinaires (4)
DECLARE
  v_id NUMBER := 124;
BEGIN
  FOR i IN 1..4 LOOP
    INSERT INTO Personnel VALUES (seq_personnel.NEXTVAL, v_id, 100, 13, 'Vétérinaire', 'Dr'||i,
      'vet'||i||'@zoo.com', '$2a$12$AygVSlcsTpInKU44E1kN/uSGKET2uXiTKWySpQoecwuhZGfkYrJ3S',
      TO_DATE('2019-03-15', 'YYYY-MM-DD'), 2800 + (i*100), 'vet'||i);
    v_id := v_id + 1;
  END LOOP;
  COMMIT;
END;
/

-- Managers Boutique (5)
DECLARE
  v_id NUMBER := 128;
BEGIN
  FOR i IN 1..5 LOOP
    INSERT INTO Personnel VALUES (seq_personnel.NEXTVAL, v_id, 100, 14, 'Manager', 'Boutique'||i,
      'manager_boutique'||i||'@zoo.com', '$2a$12$AygVSlcsTpInKU44E1kN/uSGKET2uXiTKWySpQoecwuhZGfkYrJ3S',
      TO_DATE('2021-06-01', 'YYYY-MM-DD'), 2400, 'manager_boutique'||i);
    v_id := v_id + 1;
  END LOOP;
  COMMIT;
END;
/

-- Caissiers (10)
DECLARE
  v_id NUMBER := 133;
BEGIN
  FOR i IN 1..10 LOOP
    INSERT INTO Personnel VALUES (seq_personnel.NEXTVAL, v_id, 128 + MOD(i, 5), 15, 'Caissier', 'Caisse'||i,
      'caissier'||i||'@zoo.com', '$2a$12$AygVSlcsTpInKU44E1kN/uSGKET2uXiTKWySpQoecwuhZGfkYrJ3S',
      TO_DATE('2021-09-01', 'YYYY-MM-DD') + (i*7), 1800, 'caissier'||i);
    v_id := v_id + 1;
  END LOOP;
  COMMIT;
END;
/

-- =========================
-- 3. INSERTION DES ZONES
-- =========================
INSERT INTO Zone VALUES (seq_zone.NEXTVAL, 'Zone Africaine', 101);
INSERT INTO Zone VALUES (seq_zone.NEXTVAL, 'Zone Asiatique', 102);
INSERT INTO Zone VALUES (seq_zone.NEXTVAL, 'Zone Amazonienne', 103);
INSERT INTO Zone VALUES (seq_zone.NEXTVAL, 'Zone Arctique', 101);
INSERT INTO Zone VALUES (seq_zone.NEXTVAL, 'Zone Marine', 102);
INSERT INTO Zone VALUES (seq_zone.NEXTVAL, 'Zone Australienne', 103);
COMMIT;

-- =========================
-- 4. INSERTION DES ENCLOS
-- =========================
BEGIN
  -- Zone Africaine (10 enclos)
  INSERT INTO Enclos VALUES (10.5, 20.5, 10, 'Savane');
  INSERT INTO Enclos VALUES (10.5, 21.5, 10, 'Savane');
  INSERT INTO Enclos VALUES (10.5, 22.5, 10, 'Savane');
  INSERT INTO Enclos VALUES (11.5, 20.5, 10, 'Forêt');
  INSERT INTO Enclos VALUES (11.5, 21.5, 10, 'Forêt');
  INSERT INTO Enclos VALUES (11.5, 22.5, 10, 'Montagne');
  INSERT INTO Enclos VALUES (12.5, 20.5, 10, 'Plaine');
  INSERT INTO Enclos VALUES (12.5, 21.5, 10, 'Plaine');
  INSERT INTO Enclos VALUES (13.5, 20.5, 10, 'Bassin');
  INSERT INTO Enclos VALUES (13.5, 21.5, 10, 'Bassin');
  
  -- Zone Asiatique (8 enclos)
  INSERT INTO Enclos VALUES (20.5, 30.5, 11, 'Jungle');
  INSERT INTO Enclos VALUES (20.5, 31.5, 11, 'Jungle');
  INSERT INTO Enclos VALUES (20.5, 32.5, 11, 'Jungle');
  INSERT INTO Enclos VALUES (21.5, 30.5, 11, 'Montagne');
  INSERT INTO Enclos VALUES (21.5, 31.5, 11, 'Montagne');
  INSERT INTO Enclos VALUES (21.5, 32.5, 11, 'Forêt');
  INSERT INTO Enclos VALUES (22.5, 30.5, 11, 'Plaine');
  INSERT INTO Enclos VALUES (22.5, 31.5, 11, 'Plaine');
  
  -- Zone Amazonienne (8 enclos)
  INSERT INTO Enclos VALUES (30.5, 40.5, 12, 'Jungle');
  INSERT INTO Enclos VALUES (30.5, 41.5, 12, 'Jungle');
  INSERT INTO Enclos VALUES (30.5, 42.5, 12, 'Jungle');
  INSERT INTO Enclos VALUES (31.5, 40.5, 12, 'Aquatique');
  INSERT INTO Enclos VALUES (31.5, 41.5, 12, 'Aquatique');
  INSERT INTO Enclos VALUES (31.5, 42.5, 12, 'Aquatique');
  INSERT INTO Enclos VALUES (32.5, 40.5, 12, 'Forêt');
  INSERT INTO Enclos VALUES (32.5, 41.5, 12, 'Forêt');
  
  -- Zone Arctique (8 enclos)
  INSERT INTO Enclos VALUES (40.5, 50.5, 13, 'Glace');
  INSERT INTO Enclos VALUES (40.5, 51.5, 13, 'Glace');
  INSERT INTO Enclos VALUES (40.5, 52.5, 13, 'Glace');
  INSERT INTO Enclos VALUES (41.5, 50.5, 13, 'Eau Froide');
  INSERT INTO Enclos VALUES (41.5, 51.5, 13, 'Eau Froide');
  INSERT INTO Enclos VALUES (41.5, 52.5, 13, 'Eau Froide');
  INSERT INTO Enclos VALUES (42.5, 50.5, 13, 'Toundra');
  INSERT INTO Enclos VALUES (42.5, 51.5, 13, 'Toundra');
  
  -- Zone Marine (4 enclos)
  INSERT INTO Enclos VALUES (50.5, 60.5, 14, 'Bassin');
  INSERT INTO Enclos VALUES (50.5, 61.5, 14, 'Bassin');
  INSERT INTO Enclos VALUES (51.5, 60.5, 14, 'Bassin');
  INSERT INTO Enclos VALUES (51.5, 61.5, 14, 'Bassin');
  
  COMMIT;
END;
/

-- =========================
-- 5. INSERTION DES ESPÈCES
-- =========================
BEGIN
  -- Afrique
  INSERT INTO Espece VALUES (seq_espece.NEXTVAL, 'Lion', 'Panthera leo', 1);
  INSERT INTO Espece VALUES (seq_espece.NEXTVAL, 'Éléphant', 'Loxodonta africana', 1);
  INSERT INTO Espece VALUES (seq_espece.NEXTVAL, 'Girafe', 'Giraffa camelopardalis', 1);
  INSERT INTO Espece VALUES (seq_espece.NEXTVAL, 'Zèbre', 'Equus quagga', 0);
  INSERT INTO Espece VALUES (seq_espece.NEXTVAL, 'Hippopotame', 'Hippopotamus amphibius', 1);
  
  -- Asie
  INSERT INTO Espece VALUES (seq_espece.NEXTVAL, 'Tigre du Bengale', 'Panthera tigris tigris', 1);
  INSERT INTO Espece VALUES (seq_espece.NEXTVAL, 'Éléphant d''Asie', 'Elephas maximus', 1);
  INSERT INTO Espece VALUES (seq_espece.NEXTVAL, 'Panda Géant', 'Ailuropoda melanoleuca', 1);
  INSERT INTO Espece VALUES (seq_espece.NEXTVAL, 'Rhinocéros', 'Rhinoceros unicornis', 1);
  INSERT INTO Espece VALUES (seq_espece.NEXTVAL, 'Singe Doré', 'Rhinopithecus roxellana', 1);
  
  -- Amazonie
  INSERT INTO Espece VALUES (seq_espece.NEXTVAL, 'Jaguar', 'Panthera onca', 1);
  INSERT INTO Espece VALUES (seq_espece.NEXTVAL, 'Anaconda', 'Eunectes murinus', 0);
  INSERT INTO Espece VALUES (seq_espece.NEXTVAL, 'Piranha', 'Pygocentrus nattereri', 0);
  INSERT INTO Espece VALUES (seq_espece.NEXTVAL, 'Ara Bleu', 'Ara ararauna', 1);
  INSERT INTO Espece VALUES (seq_espece.NEXTVAL, 'Caïman', 'Caiman yacare', 0);
  
  -- Arctique
  INSERT INTO Espece VALUES (seq_espece.NEXTVAL, 'Ours Blanc', 'Ursus maritimus', 1);
  INSERT INTO Espece VALUES (seq_espece.NEXTVAL, 'Phoque', 'Phoca vitulina', 0);
  INSERT INTO Espece VALUES (seq_espece.NEXTVAL, 'Baleine Béluga', 'Delphinapterus leucas', 1);
  INSERT INTO Espece VALUES (seq_espece.NEXTVAL, 'Morse', 'Odobenus rosmarus', 1);
  INSERT INTO Espece VALUES (seq_espece.NEXTVAL, 'Renard Arctique', 'Vulpes lagopus', 0);
  
  -- Marin
  INSERT INTO Espece VALUES (seq_espece.NEXTVAL, 'Requin Blanc', 'Carcharodon carcharias', 1);
  INSERT INTO Espece VALUES (seq_espece.NEXTVAL, 'Dauphin', 'Tursiops truncatus', 0);
  INSERT INTO Espece VALUES (seq_espece.NEXTVAL, 'Tortue Marine', 'Chelonia mydas', 1);
  INSERT INTO Espece VALUES (seq_espece.NEXTVAL, 'Raie Manta', 'Manta birostris', 1);
  INSERT INTO Espece VALUES (seq_espece.NEXTVAL, 'Otarie', 'Zalophus californianus', 0);
  
  -- Australie
  INSERT INTO Espece VALUES (seq_espece.NEXTVAL, 'Kangourou', 'Macropus rufus', 0);
  INSERT INTO Espece VALUES (seq_espece.NEXTVAL, 'Koala', 'Phascolarctos cinereus', 1);
  INSERT INTO Espece VALUES (seq_espece.NEXTVAL, 'Crocodile d''eau de mer', 'Crocodylus porosus', 1);
  INSERT INTO Espece VALUES (seq_espece.NEXTVAL, 'Ornithorynque', 'Ornithorhynchus anatinus', 0);
  INSERT INTO Espece VALUES (seq_espece.NEXTVAL, 'Échidné', 'Tachyglossus aculeatus', 0);
  
  COMMIT;
END;
/

-- =========================
-- 6. INSERTION DES ANIMAUX (150 animaux)
-- =========================
BEGIN
  -- Animaux nommés
  INSERT INTO Animal VALUES (seq_animal.NEXTVAL, 10.5, 20.5, 100, TO_DATE('2018-03-15', 'YYYY-MM-DD'), 'Simba', 180, 'Carnivore');
  INSERT INTO Animal VALUES (seq_animal.NEXTVAL, 10.5, 20.5, 100, TO_DATE('2019-07-22', 'YYYY-MM-DD'), 'Mufasa', 190, 'Carnivore');
  INSERT INTO Animal VALUES (seq_animal.NEXTVAL, 10.5, 21.5, 101, TO_DATE('2017-05-10', 'YYYY-MM-DD'), 'Dumbo', 5000, 'Herbivore');
  INSERT INTO Animal VALUES (seq_animal.NEXTVAL, 10.5, 21.5, 101, TO_DATE('2019-11-08', 'YYYY-MM-DD'), 'Elmer', 4500, 'Herbivore');
  INSERT INTO Animal VALUES (seq_animal.NEXTVAL, 10.5, 22.5, 102, TO_DATE('2020-01-17', 'YYYY-MM-DD'), 'Gérald', 1200, 'Herbivore');
  INSERT INTO Animal VALUES (seq_animal.NEXTVAL, 11.5, 20.5, 103, TO_DATE('2019-02-14', 'YYYY-MM-DD'), 'Marty', 450, 'Herbivore');
  INSERT INTO Animal VALUES (seq_animal.NEXTVAL, 11.5, 21.5, 104, TO_DATE('2018-08-25', 'YYYY-MM-DD'), 'Hipo', 3500, 'Herbivore');
  INSERT INTO Animal VALUES (seq_animal.NEXTVAL, 20.5, 30.5, 105, TO_DATE('2016-11-29', 'YYYY-MM-DD'), 'Rajah', 200, 'Carnivore');
  INSERT INTO Animal VALUES (seq_animal.NEXTVAL, 20.5, 31.5, 106, TO_DATE('2018-06-12', 'YYYY-MM-DD'), 'Chandra', 1200, 'Herbivore');
  INSERT INTO Animal VALUES (seq_animal.NEXTVAL, 20.5, 32.5, 107, TO_DATE('2020-04-08', 'YYYY-MM-DD'), 'Po', 100, 'Herbivore');
  INSERT INTO Animal VALUES (seq_animal.NEXTVAL, 21.5, 30.5, 108, TO_DATE('2017-09-03', 'YYYY-MM-DD'), 'Rhino', 2200, 'Herbivore');
  INSERT INTO Animal VALUES (seq_animal.NEXTVAL, 21.5, 31.5, 105, TO_DATE('2019-01-20', 'YYYY-MM-DD'), 'Kanha', 180, 'Carnivore');
  INSERT INTO Animal VALUES (seq_animal.NEXTVAL, 30.5, 40.5, 110, TO_DATE('2019-05-14', 'YYYY-MM-DD'), 'Jaguar', 120, 'Carnivore');
  INSERT INTO Animal VALUES (seq_animal.NEXTVAL, 30.5, 41.5, 113, TO_DATE('2020-02-28', 'YYYY-MM-DD'), 'Macaw', 1.2, 'Frugivore');
  INSERT INTO Animal VALUES (seq_animal.NEXTVAL, 31.5, 40.5, 114, TO_DATE('2018-07-07', 'YYYY-MM-DD'), 'Crocy', 250, 'Carnivore');
  INSERT INTO Animal VALUES (seq_animal.NEXTVAL, 31.5, 41.5, 111, TO_DATE('2017-10-15', 'YYYY-MM-DD'), 'Snakey', 50, 'Carnivore');
  INSERT INTO Animal VALUES (seq_animal.NEXTVAL, 40.5, 50.5, 115, TO_DATE('2015-12-22', 'YYYY-MM-DD'), 'Nanook', 500, 'Carnivore');
  INSERT INTO Animal VALUES (seq_animal.NEXTVAL, 40.5, 51.5, 116, TO_DATE('2019-03-10', 'YYYY-MM-DD'), 'Foka', 150, 'Carnivore');
  INSERT INTO Animal VALUES (seq_animal.NEXTVAL, 41.5, 50.5, 117, TO_DATE('2018-06-05', 'YYYY-MM-DD'), 'Beluga', 1200, 'Carnivore');
  INSERT INTO Animal VALUES (seq_animal.NEXTVAL, 50.5, 60.5, 120, TO_DATE('2016-08-19', 'YYYY-MM-DD'), 'Bruce', 1800, 'Carnivore');
  INSERT INTO Animal VALUES (seq_animal.NEXTVAL, 50.5, 61.5, 121, TO_DATE('2019-11-12', 'YYYY-MM-DD'), 'Flipper', 300, 'Carnivore');
  INSERT INTO Animal VALUES (seq_animal.NEXTVAL, 51.5, 60.5, 122, TO_DATE('2017-04-21', 'YYYY-MM-DD'), 'Shelly', 500, 'Omnivore');
  
  COMMIT;
END;
/

-- Animaux générés en masse (130 animaux supplémentaires)
BEGIN
  FOR i IN 1..130 LOOP
    DECLARE
      lat NUMBER;
      lng NUMBER;
      zone_id NUMBER;
      espece_id NUMBER;
    BEGIN
      zone_id := MOD(i - 1, 6) + 1;
      espece_id := MOD(i - 1, 30) + 100;
      
      -- Assigner des coordonnées valides selon la zone
      CASE zone_id
        WHEN 1 THEN lat := 10.5 + MOD(i, 3); lng := 20.5 + MOD(i, 2);
        WHEN 2 THEN lat := 20.5 + MOD(i, 2); lng := 30.5 + MOD(i, 3);
        WHEN 3 THEN lat := 30.5 + MOD(i, 2); lng := 40.5 + MOD(i, 3);
        WHEN 4 THEN lat := 40.5 + MOD(i, 2); lng := 50.5 + MOD(i, 3);
        WHEN 5 THEN lat := 50.5; lng := 60.5 + MOD(i, 2);
        ELSE lat := 13.5; lng := 20.5 + MOD(i, 2);
      END CASE;
      
      INSERT INTO Animal VALUES (
        seq_animal.NEXTVAL,
        lat,
        lng,
        espece_id,
        TRUNC(SYSDATE) - ROUND(DBMS_RANDOM.VALUE(1, 3650)),
        'Animal_Generique_'||i,
        ROUND(DBMS_RANDOM.VALUE(5, 5000), 2),
        CASE WHEN MOD(i, 3) = 0 THEN 'Herbivore' WHEN MOD(i, 3) = 1 THEN 'Carnivore' ELSE 'Omnivore' END
      );
    EXCEPTION WHEN OTHERS THEN
      NULL;
    END;
  END LOOP;
  COMMIT;
END;
/

-- =========================
-- 7. INSERTION DES BOUTIQUES
-- =========================
BEGIN
  FOR i IN 1..10 LOOP
    INSERT INTO Boutique VALUES (seq_boutique.NEXTVAL, 128 + MOD(i-1, 5), 10 + MOD(i-1, 6),
      'Boutique '||i, 'Boutique touristique '||i);
  END LOOP;
  COMMIT;
END;
/

-- =========================
-- 8. INSERTION DES PRESTATAIRES
-- =========================
BEGIN
  FOR i IN 1..15 LOOP
    INSERT INTO Prestataire VALUES (seq_prestataire.NEXTVAL, 'Entreprise'||i, 'Contact'||i);
  END LOOP;
  COMMIT;
END;
/

-- =========================
-- 9. INSERTION DES PARRAINAGES
-- =========================
INSERT INTO Parrainage VALUES (seq_parrainage.NEXTVAL, 'Bronze');
INSERT INTO Parrainage VALUES (seq_parrainage.NEXTVAL, 'Argent');
INSERT INTO Parrainage VALUES (seq_parrainage.NEXTVAL, 'Or');
INSERT INTO Parrainage VALUES (seq_parrainage.NEXTVAL, 'Platine');
INSERT INTO Parrainage VALUES (seq_parrainage.NEXTVAL, 'Diamant');
COMMIT;

-- =========================
-- 10. INSERTION DES VISITEURS
-- =========================
BEGIN
  FOR i IN 1..500 LOOP
    INSERT INTO Visiteur VALUES (seq_visiteur.NEXTVAL, 10 + MOD(i, 5), 'Visiteur_'||i);
  END LOOP;
  COMMIT;
END;
/

-- =========================
-- 11. INSERTION DES PRESTATIONS
-- =========================
BEGIN
  FOR i IN 1..10 LOOP
    INSERT INTO Prestation VALUES (seq_prestation.NEXTVAL, 'Prestation '||i);
  END LOOP;
  COMMIT;
END;
/

-- =========================
-- 12. INSERTION DES CONTRATS DE TRAVAIL
-- =========================
BEGIN
  FOR i IN 100..142 LOOP
    BEGIN
      INSERT INTO Contrat_Travail VALUES (seq_contrat.NEXTVAL, i,
        CASE WHEN MOD(i, 7) = 0 THEN 'CDI' ELSE 'CDD' END,
        TO_DATE('2020-01-01', 'YYYY-MM-DD') + ((i-100)*10),
        TO_DATE('2026-12-31', 'YYYY-MM-DD'));
    EXCEPTION WHEN OTHERS THEN NULL; END;
  END LOOP;
  COMMIT;
END;
/

-- =========================
-- 13. INSERTION DE EST_AFFECTEE_A
-- =========================
BEGIN
  -- Affectation des responsables de zone
  INSERT INTO Est_Affectee_A VALUES (10, 101);
  INSERT INTO Est_Affectee_A VALUES (11, 102);
  INSERT INTO Est_Affectee_A VALUES (12, 103);
  INSERT INTO Est_Affectee_A VALUES (13, 101);
  INSERT INTO Est_Affectee_A VALUES (14, 102);
  INSERT INTO Est_Affectee_A VALUES (15, 103);
  
  -- Affectation des soigneurs aux zones
  FOR i IN 104..123 LOOP
    BEGIN
      INSERT INTO Est_Affectee_A VALUES (10 + MOD(i-104, 6), i);
    EXCEPTION WHEN OTHERS THEN NULL; END;
  END LOOP;
  
  -- Affectation des vétérinaires aux zones
  FOR i IN 124..127 LOOP
    FOR zone IN 10..15 LOOP
      BEGIN
        INSERT INTO Est_Affectee_A VALUES (zone, i);
      EXCEPTION WHEN OTHERS THEN NULL; END;
    END LOOP;
  END LOOP;
  
  COMMIT;
END;
/

-- =========================
-- 14. INSERTION DE TRAVAILLE_DANS_LA_BOUTIQUE
-- =========================
BEGIN
  FOR i IN 133..142 LOOP
    BEGIN
      INSERT INTO Travaille_Dans_La_Boutique VALUES (10 + MOD(i-133, 10), i);
    EXCEPTION WHEN OTHERS THEN NULL; END;
  END LOOP;
  COMMIT;
END;
/

-- =========================
-- 15. INSERTION DE EST_PARRAINE
-- =========================
BEGIN
  -- Tous les animaux sont parrainés
  FOR i IN 1000..1149 LOOP
    BEGIN
      INSERT INTO Est_Parraine VALUES (i, 10 + MOD(i, 5));
    EXCEPTION WHEN OTHERS THEN NULL; END;
  END LOOP;
  COMMIT;
END;
/

-- =========================
-- 16. INSERTION DE A_ACCES_A
-- =========================
BEGIN
  -- Bronze : accès basique
  INSERT INTO A_Acces_A VALUES (10, 10);
  INSERT INTO A_Acces_A VALUES (10, 11);
  
  -- Argent : accès étendu
  INSERT INTO A_Acces_A VALUES (11, 10);
  INSERT INTO A_Acces_A VALUES (11, 11);
  INSERT INTO A_Acces_A VALUES (11, 12);
  
  -- Or : accès complet
  INSERT INTO A_Acces_A VALUES (12, 10);
  INSERT INTO A_Acces_A VALUES (12, 11);
  INSERT INTO A_Acces_A VALUES (12, 12);
  INSERT INTO A_Acces_A VALUES (12, 13);
  
  -- Platine : VIP access
  INSERT INTO A_Acces_A VALUES (13, 10);
  INSERT INTO A_Acces_A VALUES (13, 11);
  INSERT INTO A_Acces_A VALUES (13, 12);
  INSERT INTO A_Acces_A VALUES (13, 13);
  INSERT INTO A_Acces_A VALUES (13, 14);
  
  -- Diamant : accès complet
  INSERT INTO A_Acces_A VALUES (14, 10);
  INSERT INTO A_Acces_A VALUES (14, 11);
  INSERT INTO A_Acces_A VALUES (14, 12);
  INSERT INTO A_Acces_A VALUES (14, 13);
  INSERT INTO A_Acces_A VALUES (14, 14);
  
  COMMIT;
END;
/

-- =========================
-- 17. INSERTION DE EST_COMPATIBLE_AVEC
-- =========================
BEGIN
  -- Herbivores entre eux
  INSERT INTO Est_Compatible_Avec VALUES (101, 102);
  INSERT INTO Est_Compatible_Avec VALUES (102, 101);
  INSERT INTO Est_Compatible_Avec VALUES (101, 103);
  INSERT INTO Est_Compatible_Avec VALUES (103, 101);
  INSERT INTO Est_Compatible_Avec VALUES (102, 103);
  INSERT INTO Est_Compatible_Avec VALUES (103, 102);
  
  -- Herbivores asiatiques
  INSERT INTO Est_Compatible_Avec VALUES (106, 108);
  INSERT INTO Est_Compatible_Avec VALUES (108, 106);
  
  -- Animaux marins
  INSERT INTO Est_Compatible_Avec VALUES (121, 122);
  INSERT INTO Est_Compatible_Avec VALUES (122, 121);
  
  -- Animaux arctiques
  INSERT INTO Est_Compatible_Avec VALUES (115, 116);
  INSERT INTO Est_Compatible_Avec VALUES (116, 115);
  INSERT INTO Est_Compatible_Avec VALUES (115, 118);
  INSERT INTO Est_Compatible_Avec VALUES (118, 115);
  
  COMMIT;
END;
/

-- =========================
-- 18. INSERTION DE EST_LE_PARENT_DE
-- =========================
BEGIN
  -- Lions
  INSERT INTO Est_Le_Parent_De VALUES (1000, 1001);
  
  -- Éléphants
  INSERT INTO Est_Le_Parent_De VALUES (1002, 1003);
  INSERT INTO Est_Le_Parent_De VALUES (1003, 1004);
  
  -- Tigres
  INSERT INTO Est_Le_Parent_De VALUES (1007, 1008);
  
  -- Jaguars
  INSERT INTO Est_Le_Parent_De VALUES (1012, 1013);
  
  -- Ours
  INSERT INTO Est_Le_Parent_De VALUES (1016, 1017);
  
  -- Dauphins
  INSERT INTO Est_Le_Parent_De VALUES (1020, 1021);
  
  COMMIT;
END;
/

-- =========================
-- 19. INSERTION DE BIEN_ETRE_QUOTIDIEN
-- =========================
BEGIN
  FOR animal_id IN 1000..1149 LOOP
    FOR day_offset IN 0..90 LOOP
      IF DBMS_RANDOM.VALUE() < 0.7 THEN
        BEGIN
          INSERT INTO Bien_Etre_Quotidien VALUES (
            animal_id,
            104 + MOD(animal_id, 20),
            TRUNC(SYSDATE) - day_offset,
            ROUND(DBMS_RANDOM.VALUE(1, 50), 2)
          );
        EXCEPTION WHEN OTHERS THEN NULL; END;
      END IF;
    END LOOP;
  END LOOP;
  COMMIT;
END;
/

-- =========================
-- 20. INSERTION DE PRATIQUE_SOINS
-- =========================
BEGIN
  FOR animal_id IN 1000..1149 LOOP
    FOR month_offset IN 0..11 LOOP
      IF DBMS_RANDOM.VALUE() < 0.2 THEN
        BEGIN
          INSERT INTO Pratique_Soins VALUES (
            animal_id,
            124 + MOD(animal_id, 4),
            TRUNC(SYSDATE) - (month_offset * 30),
            CASE
              WHEN DBMS_RANDOM.VALUE() < 0.3 THEN 'Vaccin'
              WHEN DBMS_RANDOM.VALUE() < 0.6 THEN 'Examen médical'
              WHEN DBMS_RANDOM.VALUE() < 0.8 THEN 'Détartrage'
              ELSE 'Traitement parasitaire'
            END
          );
        EXCEPTION WHEN OTHERS THEN NULL; END;
      END IF;
    END LOOP;
  END LOOP;
  COMMIT;
END;
/

-- =========================
-- 21. INSERTION DE CHIFFRE_AFFAIRES (365 jours x 10 boutiques)
-- =========================
BEGIN
  FOR boutique_id IN 10..19 LOOP
    FOR day_offset IN 0..364 LOOP
      BEGIN
        INSERT INTO Chiffre_Affaires VALUES (
          boutique_id,
          TRUNC(SYSDATE) - 365 + day_offset,
          ROUND(DBMS_RANDOM.VALUE(500, 3000), 2)
        );
      EXCEPTION WHEN OTHERS THEN NULL; END;
    END LOOP;
  END LOOP;
  COMMIT;
END;
/

-- =========================
-- 22. INSERTION DE REPARATION
-- =========================
BEGIN
  FOR i IN 1..50 LOOP
    DECLARE
      lat NUMBER;
      lng NUMBER;
      zone_id NUMBER;
    BEGIN
      zone_id := MOD(i, 6) + 1;
      
      -- Sélectionner un enclos valide
      CASE zone_id
        WHEN 1 THEN lat := 10.5 + MOD(i, 3); lng := 20.5 + MOD(i, 2);
        WHEN 2 THEN lat := 20.5; lng := 30.5 + MOD(i, 3);
        WHEN 3 THEN lat := 30.5; lng := 40.5 + MOD(i, 3);
        WHEN 4 THEN lat := 40.5; lng := 50.5 + MOD(i, 3);
        WHEN 5 THEN lat := 50.5; lng := 60.5 + MOD(i, 2);
        ELSE lat := 13.5; lng := 21.5;
      END CASE;
      
      INSERT INTO Reparation VALUES (
        TRUNC(SYSDATE) - i,
        lat,
        lng,
        104 + MOD(i, 20),
        10 + MOD(i, 15),
        TRUNC(SYSDATE) - i + ROUND(DBMS_RANDOM.VALUE(1, 5)),
        CASE WHEN MOD(i, 4) = 0 THEN 'Réparation clôture'
             WHEN MOD(i, 4) = 1 THEN 'Réparation bassin'
             WHEN MOD(i, 4) = 2 THEN 'Rénovation abri'
             ELSE 'Remplacement sol' END,
        ROUND(DBMS_RANDOM.VALUE(500, 5000), 2)
      );
    EXCEPTION WHEN OTHERS THEN NULL; END;
  END LOOP;
  COMMIT;
END;
/

-- =========================
-- RÉSUMÉ DU SCRIPT
-- =========================
DECLARE
  nb_func NUMBER;
  nb_pers NUMBER;
  nb_zones NUMBER;
  nb_enclos NUMBER;
  nb_especes NUMBER;
  nb_animaux NUMBER;
  nb_boutiques NUMBER;
  nb_visiteurs NUMBER;
  nb_affectations NUMBER;
  nb_emploi_boutique NUMBER;
BEGIN
  SELECT COUNT(*) INTO nb_func FROM Fonction;
  SELECT COUNT(*) INTO nb_pers FROM Personnel;
  SELECT COUNT(*) INTO nb_zones FROM Zone;
  SELECT COUNT(*) INTO nb_enclos FROM Enclos;
  SELECT COUNT(*) INTO nb_especes FROM Espece;
  SELECT COUNT(*) INTO nb_animaux FROM Animal;
  SELECT COUNT(*) INTO nb_boutiques FROM Boutique;
  SELECT COUNT(*) INTO nb_visiteurs FROM Visiteur;
  SELECT COUNT(*) INTO nb_affectations FROM Est_Affectee_A;
  SELECT COUNT(*) INTO nb_emploi_boutique FROM Travaille_Dans_La_Boutique;
  
  DBMS_OUTPUT.PUT_LINE('====== RÉSUMÉ DE L''INSERTION ======');
  DBMS_OUTPUT.PUT_LINE('Fonctions: ' || nb_func);
  DBMS_OUTPUT.PUT_LINE('Personnels: ' || nb_pers);
  DBMS_OUTPUT.PUT_LINE('Zones: ' || nb_zones);
  DBMS_OUTPUT.PUT_LINE('Enclos: ' || nb_enclos);
  DBMS_OUTPUT.PUT_LINE('Espèces: ' || nb_especes);
  DBMS_OUTPUT.PUT_LINE('Animaux: ' || nb_animaux);
  DBMS_OUTPUT.PUT_LINE('Boutiques: ' || nb_boutiques);
  DBMS_OUTPUT.PUT_LINE('Visiteurs: ' || nb_visiteurs);
  DBMS_OUTPUT.PUT_LINE('Affectations: ' || nb_affectations);
  DBMS_OUTPUT.PUT_LINE('Emplois boutique: ' || nb_emploi_boutique);
  DBMS_OUTPUT.PUT_LINE('=====================================');
END;
/

COMMIT;
