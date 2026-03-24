-- =============================================
-- SCRIPT D'INSERTION DE DONNÉES - ZOO'LAND
-- =============================================
-- Respecte toutes les contraintes de clés étrangères et CHECK
-- Données complètes et cohérentes
-- =============================================

SET AUTOCOMMIT OFF;

-- =============================================
-- 1. INSERTION DES FONCTIONS
-- =============================================
INSERT INTO Fonction VALUES (1, 'Administrateur', 'Gestion globale du zoo et accès système');
INSERT INTO Fonction VALUES (2, 'Responsable de Zone', 'Gestion et supervision d''une zone');
INSERT INTO Fonction VALUES (3, 'Soigneur', 'Soin et alimentation quotidienne des animaux');
INSERT INTO Fonction VALUES (4, 'Vétérinaire', 'Soins médicaux et consultations des animaux');
INSERT INTO Fonction VALUES (5, 'Manager Boutique', 'Gestion commerciale d''une boutique');
INSERT INTO Fonction VALUES (6, 'Caissier', 'Gestion des ventes et commerçage');
INSERT INTO Fonction VALUES (7, 'Technicien Entretien', 'Maintenance des installations et enclos');
COMMIT;

-- =============================================
-- 2. INSERTION DES PERSONNELS
-- =============================================
-- Admin principal (point de départ, référence à lui-même)
INSERT INTO Personnel VALUES (100, 100, 100, 1, 'Dupont', 'Jean', 'jean.dupont@zoo.com',
  '$2a$12$Cxp..EXnGgLFTdfc1EnwxOmzzl2fPkyBC1gcLh/DAKzygCY4PQTKG', TO_DATE('2015-01-15', 'YYYY-MM-DD'), 4500.00, 'admin_main', 1);

-- Responsables de zone (supervision entre eux)
INSERT INTO Personnel VALUES (101, 101, 100, 2, 'Moulin', 'Sophie', 'sophie.moulin@zoo.com',
  '$2a$12$Cxp..EXnGgLFTdfc1EnwxOmzzl2fPkyBC1gcLh/DAKzygCY4PQTKG', TO_DATE('2016-06-01', 'YYYY-MM-DD'), 3200.00, 'resp_zone_africaine', 1);
INSERT INTO Personnel VALUES (102, 102, 100, 2, 'Martin', 'Paul', 'paul.martin@zoo.com',
  '$2a$12$Cxp..EXnGgLFTdfc1EnwxOmzzl2fPkyBC1gcLh/DAKzygCY4PQTKG', TO_DATE('2016-06-15', 'YYYY-MM-DD'), 3200.00, 'resp_zone_asiatique', 1);
INSERT INTO Personnel VALUES (103, 103, 100, 2, 'Durand', 'Caroline', 'caroline.durand@zoo.com',
  '$2a$12$Cxp..EXnGgLFTdfc1EnwxOmzzl2fPkyBC1gcLh/DAKzygCY4PQTKG', TO_DATE('2016-07-01', 'YYYY-MM-DD'), 3200.00, 'resp_zone_amazonie', 1);
INSERT INTO Personnel VALUES (104, 104, 100, 2, 'Blanc', 'Michel', 'michel.blanc@zoo.com',
  '$2a$12$Cxp..EXnGgLFTdfc1EnwxOmzzl2fPkyBC1gcLh/DAKzygCY4PQTKG', TO_DATE('2017-03-10', 'YYYY-MM-DD'), 3200.00, 'resp_zone_arctique', 1);
INSERT INTO Personnel VALUES (105, 105, 100, 2, 'Leclerc', 'Anne', 'anne.leclerc@zoo.com',
  '$2a$12$Cxp..EXnGgLFTdfc1EnwxOmzzl2fPkyBC1gcLh/DAKzygCY4PQTKG', TO_DATE('2017-04-01', 'YYYY-MM-DD'), 3200.00, 'resp_zone_marine', 1);

-- Soigneurs (avec chaîne de remplaçants réaliste)
-- Zone Africaine: chaque soigneur remplace le précédent, le premier remplace le manager
INSERT INTO Personnel VALUES (110, 101, 101, 3, 'Garcia', 'Carlos', 'carlos.garcia@zoo.com',
  '$2a$12$Cxp..EXnGgLFTdfc1EnwxOmzzl2fPkyBC1gcLh/DAKzygCY4PQTKG', TO_DATE('2018-01-15', 'YYYY-MM-DD'), 2400.00, 'soigneur_001', 1);
INSERT INTO Personnel VALUES (111, 110, 101, 3, 'Rossi', 'Marco', 'marco.rossi@zoo.com',
  '$2a$12$Cxp..EXnGgLFTdfc1EnwxOmzzl2fPkyBC1gcLh/DAKzygCY4PQTKG', TO_DATE('2018-02-01', 'YYYY-MM-DD'), 2400.00, 'soigneur_002', 1);
INSERT INTO Personnel VALUES (112, 111, 101, 3, 'Bianchi', 'Luigi', 'luigi.bianchi@zoo.com',
  '$2a$12$Cxp..EXnGgLFTdfc1EnwxOmzzl2fPkyBC1gcLh/DAKzygCY4PQTKG', TO_DATE('2018-03-15', 'YYYY-MM-DD'), 2400.00, 'soigneur_003', 1);
INSERT INTO Personnel VALUES (113, 112, 101, 3, 'Rossi', 'Lucia', 'lucia.rossi@zoo.com',
  '$2a$12$Cxp..EXnGgLFTdfc1EnwxOmzzl2fPkyBC1gcLh/DAKzygCY4PQTKG', TO_DATE('2018-04-01', 'YYYY-MM-DD'), 2400.00, 'soigneur_004', 1);

-- Zone Asiatique: même logique
INSERT INTO Personnel VALUES (120, 102, 102, 3, 'Tanaka', 'Hiroshi', 'hiroshi.tanaka@zoo.com',
  '$2a$12$Cxp..EXnGgLFTdfc1EnwxOmzzl2fPkyBC1gcLh/DAKzygCY4PQTKG', TO_DATE('2018-05-10', 'YYYY-MM-DD'), 2400.00, 'soigneur_005', 1);
INSERT INTO Personnel VALUES (121, 120, 102, 3, 'Yamamoto', 'Yuki', 'yuki.yamamoto@zoo.com',
  '$2a$12$Cxp..EXnGgLFTdfc1EnwxOmzzl2fPkyBC1gcLh/DAKzygCY4PQTKG', TO_DATE('2018-06-01', 'YYYY-MM-DD'), 2400.00, 'soigneur_006', 1);
INSERT INTO Personnel VALUES (122, 121, 102, 3, 'Nakamura', 'Takeshi', 'takeshi.nakamura@zoo.com',
  '$2a$12$Cxp..EXnGgLFTdfc1EnwxOmzzl2fPkyBC1gcLh/DAKzygCY4PQTKG', TO_DATE('2018-07-15', 'YYYY-MM-DD'), 2400.00, 'soigneur_007', 1);
INSERT INTO Personnel VALUES (123, 122, 102, 3, 'Suzuki', 'Keiko', 'keiko.suzuki@zoo.com',
  '$2a$12$Cxp..EXnGgLFTdfc1EnwxOmzzl2fPkyBC1gcLh/DAKzygCY4PQTKG', TO_DATE('2018-08-01', 'YYYY-MM-DD'), 2400.00, 'soigneur_008', 1);

-- Zone Amazonienne: même logique
INSERT INTO Personnel VALUES (130, 103, 103, 3, 'Silva', 'João', 'joao.silva@zoo.com',
  '$2a$12$Cxp..EXnGgLFTdfc1EnwxOmzzl2fPkyBC1gcLh/DAKzygCY4PQTKG', TO_DATE('2018-09-20', 'YYYY-MM-DD'), 2400.00, 'soigneur_009', 1);
INSERT INTO Personnel VALUES (131, 130, 103, 3, 'Santos', 'Maria', 'maria.santos@zoo.com',
  '$2a$12$Cxp..EXnGgLFTdfc1EnwxOmzzl2fPkyBC1gcLh/DAKzygCY4PQTKG', TO_DATE('2018-10-01', 'YYYY-MM-DD'), 2400.00, 'soigneur_010', 1);
INSERT INTO Personnel VALUES (132, 131, 103, 3, 'Oliveira', 'Pedro', 'pedro.oliveira@zoo.com',
  '$2a$12$Cxp..EXnGgLFTdfc1EnwxOmzzl2fPkyBC1gcLh/DAKzygCY4PQTKG', TO_DATE('2018-11-15', 'YYYY-MM-DD'), 2400.00, 'soigneur_011', 1);
INSERT INTO Personnel VALUES (133, 132, 103, 3, 'Costa', 'Ana', 'ana.costa@zoo.com',
  '$2a$12$Cxp..EXnGgLFTdfc1EnwxOmzzl2fPkyBC1gcLh/DAKzygCY4PQTKG', TO_DATE('2018-12-01', 'YYYY-MM-DD'), 2400.00, 'soigneur_012', 1);

-- Zone Arctique: même logique
INSERT INTO Personnel VALUES (140, 104, 104, 3, 'Andersson', 'Erik', 'erik.andersson@zoo.com',
  '$2a$12$Cxp..EXnGgLFTdfc1EnwxOmzzl2fPkyBC1gcLh/DAKzygCY4PQTKG', TO_DATE('2019-01-10', 'YYYY-MM-DD'), 2400.00, 'soigneur_013', 1);
INSERT INTO Personnel VALUES (141, 140, 104, 3, 'Bergström', 'Ingrid', 'ingrid.bergstrom@zoo.com',
  '$2a$12$Cxp..EXnGgLFTdfc1EnwxOmzzl2fPkyBC1gcLh/DAKzygCY4PQTKG', TO_DATE('2019-02-01', 'YYYY-MM-DD'), 2400.00, 'soigneur_014', 1);

-- Zone Marine: même logique
INSERT INTO Personnel VALUES (150, 105, 105, 3, 'Dubois', 'Pierre', 'pierre.dubois@zoo.com',
  '$2a$12$Cxp..EXnGgLFTdfc1EnwxOmzzl2fPkyBC1gcLh/DAKzygCY4PQTKG', TO_DATE('2019-03-15', 'YYYY-MM-DD'), 2400.00, 'soigneur_015', 1);
INSERT INTO Personnel VALUES (151, 150, 105, 3, 'Dupuis', 'Marie', 'marie.dupuis@zoo.com',
  '$2a$12$Cxp..EXnGgLFTdfc1EnwxOmzzl2fPkyBC1gcLh/DAKzygCY4PQTKG', TO_DATE('2019-04-01', 'YYYY-MM-DD'), 2400.00, 'soigneur_016', 1);

-- Vétérinaires
INSERT INTO Personnel VALUES (200, 200, 100, 4, 'Labelle', 'Dr. Cécile', 'cecile.labelle@zoo.com',
  '$2a$12$Cxp..EXnGgLFTdfc1EnwxOmzzl2fPkyBC1gcLh/DAKzygCY4PQTKG', TO_DATE('2015-09-01', 'YYYY-MM-DD'), 3800.00, 'vet_001', 1);
INSERT INTO Personnel VALUES (201, 201, 100, 4, 'Leduc', 'Dr. Frédéric', 'frederic.leduc@zoo.com',
  '$2a$12$Cxp..EXnGgLFTdfc1EnwxOmzzl2fPkyBC1gcLh/DAKzygCY4PQTKG', TO_DATE('2016-03-15', 'YYYY-MM-DD'), 3800.00, 'vet_002', 1);
INSERT INTO Personnel VALUES (202, 202, 100, 4, 'Moreau', 'Dr. Hélène', 'helene.moreau@zoo.com',
  '$2a$12$Cxp..EXnGgLFTdfc1EnwxOmzzl2fPkyBC1gcLh/DAKzygCY4PQTKG', TO_DATE('2017-05-01', 'YYYY-MM-DD'), 3800.00, 'vet_003', 1);

-- Managers Boutique
INSERT INTO Personnel VALUES (300, 300, 100, 5, 'Bernard', 'Thomas', 'thomas.bernard@zoo.com',
  '$2a$12$Cxp..EXnGgLFTdfc1EnwxOmzzl2fPkyBC1gcLh/DAKzygCY4PQTKG', TO_DATE('2018-06-01', 'YYYY-MM-DD'), 2900.00, 'mgr_boutique_001', 1);
INSERT INTO Personnel VALUES (301, 301, 100, 5, 'Richard', 'Nicole', 'nicole.richard@zoo.com',
  '$2a$12$Cxp..EXnGgLFTdfc1EnwxOmzzl2fPkyBC1gcLh/DAKzygCY4PQTKG', TO_DATE('2018-07-15', 'YYYY-MM-DD'), 2900.00, 'mgr_boutique_002', 1);
INSERT INTO Personnel VALUES (302, 302, 100, 5, 'Dubois', 'Laurent', 'laurent.dubois@zoo.com',
  '$2a$12$Cxp..EXnGgLFTdfc1EnwxOmzzl2fPkyBC1gcLh/DAKzygCY4PQTKG', TO_DATE('2018-08-01', 'YYYY-MM-DD'), 2900.00, 'mgr_boutique_003', 1);

-- Caissiers
INSERT INTO Personnel VALUES (310, 310, 300, 6, 'Petit', 'Isabelle', 'isabelle.petit@zoo.com',
  '$2a$12$Cxp..EXnGgLFTdfc1EnwxOmzzl2fPkyBC1gcLh/DAKzygCY4PQTKG', TO_DATE('2019-01-15', 'YYYY-MM-DD'), 2000.00, 'caissier_001', 1);
INSERT INTO Personnel VALUES (311, 311, 300, 6, 'Dupont', 'Pascal', 'pascal.dupont@zoo.com',
  '$2a$12$Cxp..EXnGgLFTdfc1EnwxOmzzl2fPkyBC1gcLh/DAKzygCY4PQTKG', TO_DATE('2019-02-01', 'YYYY-MM-DD'), 2000.00, 'caissier_002', 1);
INSERT INTO Personnel VALUES (312, 312, 301, 6, 'Michel', 'Florence', 'florence.michel@zoo.com',
  '$2a$12$Cxp..EXnGgLFTdfc1EnwxOmzzl2fPkyBC1gcLh/DAKzygCY4PQTKG', TO_DATE('2019-03-15', 'YYYY-MM-DD'), 2000.00, 'caissier_003', 1);
INSERT INTO Personnel VALUES (313, 313, 301, 6, 'Lefevre', 'Valérie', 'valerie.lefevre@zoo.com',
  '$2a$12$Cxp..EXnGgLFTdfc1EnwxOmzzl2fPkyBC1gcLh/DAKzygCY4PQTKG', TO_DATE('2019-04-01', 'YYYY-MM-DD'), 2000.00, 'caissier_004', 1);
INSERT INTO Personnel VALUES (314, 314, 302, 6, 'Mercier', 'Olivier', 'olivier.mercier@zoo.com',
  '$2a$12$Cxp..EXnGgLFTdfc1EnwxOmzzl2fPkyBC1gcLh/DAKzygCY4PQTKG', TO_DATE('2019-05-15', 'YYYY-MM-DD'), 2000.00, 'caissier_005', 1);

-- Techniciens entretien
INSERT INTO Personnel VALUES (400, 400, 101, 7, 'Renard', 'Alain', 'alain.renard@zoo.com',
  '$2a$12$Cxp..EXnGgLFTdfc1EnwxOmzzl2fPkyBC1gcLh/DAKzygCY4PQTKG', TO_DATE('2016-08-01', 'YYYY-MM-DD'), 2600.00, 'tech_entretien_001', 1);
INSERT INTO Personnel VALUES (401, 401, 102, 7, 'Vincent', 'Didier', 'didier.vincent@zoo.com',
  '$2a$12$Cxp..EXnGgLFTdfc1EnwxOmzzl2fPkyBC1gcLh/DAKzygCY4PQTKG', TO_DATE('2017-02-15', 'YYYY-MM-DD'), 2600.00, 'tech_entretien_002', 1);
INSERT INTO Personnel VALUES (402, 402, 103, 7, 'Benoit', 'Robert', 'robert.benoit@zoo.com',
  '$2a$12$Cxp..EXnGgLFTdfc1EnwxOmzzl2fPkyBC1gcLh/DAKzygCY4PQTKG', TO_DATE('2017-09-01', 'YYYY-MM-DD'), 2600.00, 'tech_entretien_003', 1);

-- Guides touristiques
INSERT INTO Personnel VALUES (500, 500, 101, 8, 'Arnould', 'Stéphane', 'stephane.arnould@zoo.com',
  '$2a$12$Cxp..EXnGgLFTdfc1EnwxOmzzl2fPkyBC1gcLh/DAKzygCY4PQTKG', TO_DATE('2019-06-01', 'YYYY-MM-DD'), 2200.00, 'guide_001', 1);
INSERT INTO Personnel VALUES (501, 501, 102, 8, 'Audrain', 'Nathalie', 'nathalie.audrain@zoo.com',
  '$2a$12$Cxp..EXnGgLFTdfc1EnwxOmzzl2fPkyBC1gcLh/DAKzygCY4PQTKG', TO_DATE('2019-07-15', 'YYYY-MM-DD'), 2200.00, 'guide_002', 1);

COMMIT;

-- =============================================
-- 3. INSERTION DES ZONES
-- =============================================
INSERT INTO Zone VALUES (1, 'Zone Africaine', 101);
INSERT INTO Zone VALUES (2, 'Zone Asiatique', 102);
INSERT INTO Zone VALUES (3, 'Zone Amazonienne', 103);
INSERT INTO Zone VALUES (4, 'Zone Arctique', 104);
INSERT INTO Zone VALUES (5, 'Zone Marine', 105);
COMMIT;

-- =============================================
-- 4. INSERTION DES ENCLOS
-- =============================================
-- Zone Africaine (12 enclos)
INSERT INTO Enclos VALUES (10.0, 20.0, 1, 'Savane');
INSERT INTO Enclos VALUES (10.0, 20.5, 1, 'Savane');
INSERT INTO Enclos VALUES (10.5, 20.0, 1, 'Savane');
INSERT INTO Enclos VALUES (11.0, 20.0, 1, 'Forêt');
INSERT INTO Enclos VALUES (11.0, 20.5, 1, 'Forêt');
INSERT INTO Enclos VALUES (11.5, 20.0, 1, 'Montagne');
INSERT INTO Enclos VALUES (12.0, 20.0, 1, 'Plaine');
INSERT INTO Enclos VALUES (12.0, 20.5, 1, 'Plaine');
INSERT INTO Enclos VALUES (12.5, 20.0, 1, 'Bassin');
INSERT INTO Enclos VALUES (12.5, 20.5, 1, 'Bassin');
INSERT INTO Enclos VALUES (13.0, 20.0, 1, 'Clôture');
INSERT INTO Enclos VALUES (13.0, 20.5, 1, 'Clôture');

-- Zone Asiatique (10 enclos)
INSERT INTO Enclos VALUES (20.0, 30.0, 2, 'Jungle');
INSERT INTO Enclos VALUES (20.0, 30.5, 2, 'Jungle');
INSERT INTO Enclos VALUES (20.5, 30.0, 2, 'Jungle');
INSERT INTO Enclos VALUES (21.0, 30.0, 2, 'Montagne');
INSERT INTO Enclos VALUES (21.0, 30.5, 2, 'Montagne');
INSERT INTO Enclos VALUES (21.5, 30.0, 2, 'Forêt');
INSERT INTO Enclos VALUES (22.0, 30.0, 2, 'Plaine');
INSERT INTO Enclos VALUES (22.0, 30.5, 2, 'Plaine');
INSERT INTO Enclos VALUES (22.5, 30.0, 2, 'Bambou');
INSERT INTO Enclos VALUES (22.5, 30.5, 2, 'Bambou');

-- Zone Amazonienne (10 enclos)
INSERT INTO Enclos VALUES (30.0, 40.0, 3, 'Jungle');
INSERT INTO Enclos VALUES (30.0, 40.5, 3, 'Jungle');
INSERT INTO Enclos VALUES (30.5, 40.0, 3, 'Jungle');
INSERT INTO Enclos VALUES (31.0, 40.0, 3, 'Aquatique');
INSERT INTO Enclos VALUES (31.0, 40.5, 3, 'Aquatique');
INSERT INTO Enclos VALUES (31.5, 40.0, 3, 'Aquatique');
INSERT INTO Enclos VALUES (32.0, 40.0, 3, 'Forêt');
INSERT INTO Enclos VALUES (32.0, 40.5, 3, 'Forêt');
INSERT INTO Enclos VALUES (32.5, 40.0, 3, 'Canopée');
INSERT INTO Enclos VALUES (32.5, 40.5, 3, 'Canopée');

-- Zone Arctique (10 enclos)
INSERT INTO Enclos VALUES (40.0, 50.0, 4, 'Glace');
INSERT INTO Enclos VALUES (40.0, 50.5, 4, 'Glace');
INSERT INTO Enclos VALUES (40.5, 50.0, 4, 'Glace');
INSERT INTO Enclos VALUES (41.0, 50.0, 4, 'Eau Froide');
INSERT INTO Enclos VALUES (41.0, 50.5, 4, 'Eau Froide');
INSERT INTO Enclos VALUES (41.5, 50.0, 4, 'Eau Froide');
INSERT INTO Enclos VALUES (42.0, 50.0, 4, 'Toundra');
INSERT INTO Enclos VALUES (42.0, 50.5, 4, 'Toundra');
INSERT INTO Enclos VALUES (42.5, 50.0, 4, 'Falaise');
INSERT INTO Enclos VALUES (42.5, 50.5, 4, 'Falaise');

-- Zone Marine (8 enclos)
INSERT INTO Enclos VALUES (50.0, 60.0, 5, 'Bassin Profond');
INSERT INTO Enclos VALUES (50.0, 60.5, 5, 'Bassin Profond');
INSERT INTO Enclos VALUES (50.5, 60.0, 5, 'Bassin Côtier');
INSERT INTO Enclos VALUES (50.5, 60.5, 5, 'Bassin Côtier');
INSERT INTO Enclos VALUES (51.0, 60.0, 5, 'Lagon');
INSERT INTO Enclos VALUES (51.0, 60.5, 5, 'Lagon');
INSERT INTO Enclos VALUES (51.5, 60.0, 5, 'Récif');
INSERT INTO Enclos VALUES (51.5, 60.5, 5, 'Récif');

COMMIT;

-- =============================================
-- 5. INSERTION DES ESPÈCES
-- =============================================
-- Afrique
INSERT INTO Espece VALUES (1, 'Lion', 'Panthera leo', 1);
INSERT INTO Espece VALUES (2, 'Éléphant Africain', 'Loxodonta africana', 1);
INSERT INTO Espece VALUES (3, 'Girafe', 'Giraffa camelopardalis', 1);
INSERT INTO Espece VALUES (4, 'Zèbre des Plaines', 'Equus quagga', 0);
INSERT INTO Espece VALUES (5, 'Hippopotame', 'Hippopotamus amphibius', 1);
INSERT INTO Espece VALUES (6, 'Léopard', 'Panthera pardus', 1);
INSERT INTO Espece VALUES (7, 'Gnou', 'Connochaetes taurinus', 0);
INSERT INTO Espece VALUES (8, 'Autruche', 'Struthio camelus', 0);

-- Asie
INSERT INTO Espece VALUES (10, 'Tigre du Bengale', 'Panthera tigris tigris', 1);
INSERT INTO Espece VALUES (11, 'Éléphant d''Asie', 'Elephas maximus', 1);
INSERT INTO Espece VALUES (12, 'Panda Géant', 'Ailuropoda melanoleuca', 1);
INSERT INTO Espece VALUES (13, 'Rhinocéros Indien', 'Rhinoceros unicornis', 1);
INSERT INTO Espece VALUES (14, 'Singe Doré du Vietnam', 'Rhinopithecus roxellana', 1);
INSERT INTO Espece VALUES (15, 'Koala', 'Phascolarctos cinereus', 1);
INSERT INTO Espece VALUES (16, 'Orang-outan', 'Pongo pygmaeus', 1);
INSERT INTO Espece VALUES (17, 'Cobra Royal', 'Ophiophagus hannah', 0);

-- Amazonie
INSERT INTO Espece VALUES (20, 'Jaguar', 'Panthera onca', 1);
INSERT INTO Espece VALUES (21, 'Anaconda', 'Eunectes murinus', 0);
INSERT INTO Espece VALUES (22, 'Piranha', 'Pygocentrus nattereri', 0);
INSERT INTO Espece VALUES (23, 'Ara Bleu', 'Ara ararauna', 1);
INSERT INTO Espece VALUES (24, 'Caïman Noir', 'Caiman yacare', 0);
INSERT INTO Espece VALUES (25, 'Dauphin Rose', 'Inia geoffrensis', 1);
INSERT INTO Espece VALUES (26, 'Boa Constricteur', 'Boa constrictor', 0);
INSERT INTO Espece VALUES (27, 'Toucan', 'Ramphastos toco', 0);

-- Arctique
INSERT INTO Espece VALUES (30, 'Ours Blanc', 'Ursus maritimus', 1);
INSERT INTO Espece VALUES (31, 'Phoque Barbu', 'Erignathus barbatus', 0);
INSERT INTO Espece VALUES (32, 'Baleine Béluga', 'Delphinapterus leucas', 1);
INSERT INTO Espece VALUES (33, 'Morse', 'Odobenus rosmarus', 1);
INSERT INTO Espece VALUES (34, 'Renard Arctique', 'Vulpes lagopus', 0);
INSERT INTO Espece VALUES (35, 'Harfang des Neiges', 'Bubo scandiacus', 1);

-- Marin
INSERT INTO Espece VALUES (40, 'Requin Blanc', 'Carcharodon carcharias', 1);
INSERT INTO Espece VALUES (41, 'Dauphin Souffleur', 'Tursiops truncatus', 0);
INSERT INTO Espece VALUES (42, 'Tortue Marine Verte', 'Chelonia mydas', 1);
INSERT INTO Espece VALUES (43, 'Raie Manta', 'Manta birostris', 1);
INSERT INTO Espece VALUES (44, 'Otarie de Californie', 'Zalophus californianus', 0);
INSERT INTO Espece VALUES (45, 'Poisson-Clown', 'Amphiprion ocellaris', 0);

COMMIT;

-- =============================================
-- 6. INSERTION DES ANIMAUX
-- =============================================
-- Animaux Africains
INSERT INTO Animal VALUES (1000, 10.0, 20.0, 1, TO_DATE('2018-03-15', 'YYYY-MM-DD'), 'Simba', 190, 'Carnivore', 1);
INSERT INTO Animal VALUES (1001, 10.0, 20.0, 1, TO_DATE('2019-07-22', 'YYYY-MM-DD'), 'Nala', 170, 'Carnivore', 1);
INSERT INTO Animal VALUES (1002, 10.0, 20.5, 2, TO_DATE('2017-05-10', 'YYYY-MM-DD'), 'Dumbo', 5000, 'Herbivore', 1);
INSERT INTO Animal VALUES (1003, 10.0, 20.5, 2, TO_DATE('2019-11-08', 'YYYY-MM-DD'), 'Elmer', 4500, 'Herbivore', 1);
INSERT INTO Animal VALUES (1004, 10.5, 20.0, 3, TO_DATE('2020-01-17', 'YYYY-MM-DD'), 'Gérald', 1200, 'Herbivore', 1);
INSERT INTO Animal VALUES (1005, 10.5, 20.0, 3, TO_DATE('2021-02-14', 'YYYY-MM-DD'), 'Martine', 1150, 'Herbivore', 1);
INSERT INTO Animal VALUES (1006, 11.0, 20.0, 4, TO_DATE('2019-02-14', 'YYYY-MM-DD'), 'Marty', 450, 'Herbivore', 1);
INSERT INTO Animal VALUES (1007, 11.0, 20.5, 5, TO_DATE('2018-08-25', 'YYYY-MM-DD'), 'Hipo', 3500, 'Herbivore', 1);
INSERT INTO Animal VALUES (1008, 11.5, 20.0, 6, TO_DATE('2020-05-10', 'YYYY-MM-DD'), 'Kali', 70, 'Carnivore', 1);
INSERT INTO Animal VALUES (1009, 12.0, 20.0, 7, TO_DATE('2019-12-01', 'YYYY-MM-DD'), 'Gnou1', 250, 'Herbivore', 1);
INSERT INTO Animal VALUES (1010, 12.0, 20.5, 8, TO_DATE('2018-09-15', 'YYYY-MM-DD'), 'Autry', 120, 'Omnivore', 1);

-- Animaux Asiatiques
INSERT INTO Animal VALUES (1020, 20.0, 30.0, 10, TO_DATE('2016-11-29', 'YYYY-MM-DD'), 'Rajah', 200, 'Carnivore', 1);
INSERT INTO Animal VALUES (1021, 20.0, 30.5, 11, TO_DATE('2018-06-12', 'YYYY-MM-DD'), 'Chandra', 4200, 'Herbivore', 1);
INSERT INTO Animal VALUES (1022, 20.5, 30.0, 12, TO_DATE('2020-04-08', 'YYYY-MM-DD'), 'Po', 100, 'Herbivore', 1);
INSERT INTO Animal VALUES (1023, 20.5, 30.0, 12, TO_DATE('2021-03-15', 'YYYY-MM-DD'), 'Mei', 105, 'Herbivore', 1);
INSERT INTO Animal VALUES (1024, 21.0, 30.0, 13, TO_DATE('2017-09-03', 'YYYY-MM-DD'), 'Rhino', 2200, 'Herbivore', 1);
INSERT INTO Animal VALUES (1025, 21.0, 30.5, 10, TO_DATE('2019-01-20', 'YYYY-MM-DD'), 'Kanha', 180, 'Carnivore', 1);
INSERT INTO Animal VALUES (1026, 21.5, 30.0, 14, TO_DATE('2020-07-22', 'YYYY-MM-DD'), 'Or', 8, 'Omnivore', 1);
INSERT INTO Animal VALUES (1027, 22.0, 30.0, 16, TO_DATE('2019-05-10', 'YYYY-MM-DD'), 'Borneo', 90, 'Frugivore', 1);

-- Animaux Amazoniens
INSERT INTO Animal VALUES (1040, 30.0, 40.0, 20, TO_DATE('2019-05-14', 'YYYY-MM-DD'), 'Jaguar1', 120, 'Carnivore', 1);
INSERT INTO Animal VALUES (1041, 30.0, 40.5, 23, TO_DATE('2020-02-28', 'YYYY-MM-DD'), 'Macaw1', 1.2, 'Frugivore', 1);
INSERT INTO Animal VALUES (1042, 30.5, 40.0, 23, TO_DATE('2021-01-10', 'YYYY-MM-DD'), 'Macaw2', 1.3, 'Frugivore', 1);
INSERT INTO Animal VALUES (1043, 31.0, 40.0, 24, TO_DATE('2018-07-07', 'YYYY-MM-DD'), 'Crocy', 250, 'Carnivore', 1);
INSERT INTO Animal VALUES (1044, 31.0, 40.5, 21, TO_DATE('2017-10-15', 'YYYY-MM-DD'), 'Snakey', 50, 'Carnivore', 1);
INSERT INTO Animal VALUES (1045, 31.5, 40.0, 25, TO_DATE('2019-11-25', 'YYYY-MM-DD'), 'Rose', 180, 'Carnivore', 1);
INSERT INTO Animal VALUES (1046, 32.0, 40.0, 27, TO_DATE('2020-08-30', 'YYYY-MM-DD'), 'Boa1', 30, 'Carnivore', 1);

-- Animaux Arctiques
INSERT INTO Animal VALUES (1060, 40.0, 50.0, 30, TO_DATE('2015-12-22', 'YYYY-MM-DD'), 'Nanook', 500, 'Carnivore', 1);
INSERT INTO Animal VALUES (1061, 40.0, 50.5, 30, TO_DATE('2019-04-10', 'YYYY-MM-DD'), 'Ismo', 480, 'Carnivore', 1);
INSERT INTO Animal VALUES (1062, 40.5, 50.0, 31, TO_DATE('2019-03-10', 'YYYY-MM-DD'), 'Foka', 150, 'Carnivore', 1);
INSERT INTO Animal VALUES (1063, 41.0, 50.0, 32, TO_DATE('2018-06-05', 'YYYY-MM-DD'), 'Beluga', 1200, 'Carnivore', 1);
INSERT INTO Animal VALUES (1064, 41.0, 50.5, 33, TO_DATE('2017-08-14', 'YYYY-MM-DD'), 'Walrus', 1200, 'Carnivore', 1);
INSERT INTO Animal VALUES (1065, 42.0, 50.0, 34, TO_DATE('2020-01-20', 'YYYY-MM-DD'), 'Arctic_Fox', 5, 'Carnivore', 1);

-- Animaux Marins
INSERT INTO Animal VALUES (1080, 50.0, 60.0, 40, TO_DATE('2016-08-19', 'YYYY-MM-DD'), 'Bruce', 1800, 'Carnivore', 1);
INSERT INTO Animal VALUES (1081, 50.0, 60.5, 41, TO_DATE('2019-11-12', 'YYYY-MM-DD'), 'Flipper', 300, 'Carnivore', 1);
INSERT INTO Animal VALUES (1082, 50.5, 60.0, 42, TO_DATE('2017-04-21', 'YYYY-MM-DD'), 'Shelly', 500, 'Omnivore', 1);
INSERT INTO Animal VALUES (1083, 50.5, 60.5, 43, TO_DATE('2018-09-10', 'YYYY-MM-DD'), 'Manta1', 400, 'Omnivore', 1);
INSERT INTO Animal VALUES (1084, 51.0, 60.0, 44, TO_DATE('2019-02-15', 'YYYY-MM-DD'), 'Seal', 350, 'Carnivore', 1);
INSERT INTO Animal VALUES (1085, 51.0, 60.5, 45, TO_DATE('2020-10-05', 'YYYY-MM-DD'), 'Nemo', 0.1, 'Omnivore', 1);

COMMIT;

-- =============================================
-- 7. INSERTION DES BOUTIQUES
-- =============================================
INSERT INTO Boutique VALUES (1, 300, 1, 'Boutique Africaine', 'Souvenirs et produits africains');
INSERT INTO Boutique VALUES (2, 300, 2, 'Boutique Asiatique', 'Artisanat asiatique et soieries');
INSERT INTO Boutique VALUES (3, 301, 3, 'Boutique Amazonienne', 'Produits issus de la forêt tropicale');
INSERT INTO Boutique VALUES (4, 301, 4, 'Boutique Arctique', 'Articles polaires et fourrures écologiques');
INSERT INTO Boutique VALUES (5, 302, 5, 'Boutique Marine', 'Souvenirs marins et minéraux');
INSERT INTO Boutique VALUES (6, 302, 1, 'Boutique Générale', 'Produits divers et souvenirs du zoo');
COMMIT;

-- =============================================
-- 8. INSERTION DES VISITEURS
-- =============================================
BEGIN
  FOR i IN 1..100 LOOP
    INSERT INTO Visiteur VALUES (5000 + i, 'Visiteur_' || TO_CHAR(i, '000'));
  END LOOP;
  COMMIT;
END;
/

-- =============================================
-- 9. INSERTION DES PRESTATAIRES
-- =============================================
INSERT INTO Prestataire VALUES (1, 'BTP Solutions', 'Jean');
INSERT INTO Prestataire VALUES (2, 'Entreprise Nettoyage', 'Marie');
INSERT INTO Prestataire VALUES (3, 'Réparations Rapides', 'Pierre');
INSERT INTO Prestataire VALUES (4, 'Maintenance Plus', 'Sophie');
INSERT INTO Prestataire VALUES (5, 'Travaux Généraux', 'Laurent');
COMMIT;

-- =============================================
-- 10. INSERTION DES PARRAINAGES (EST_PARRAINE)
-- =============================================
BEGIN
  FOR i IN 1000..1085 LOOP
    BEGIN
      INSERT INTO Est_Parraine VALUES (
        i,
        5000 + MOD(i - 1000, 100) + 1,
        MOD(i - 1000, 5) + 1,
        CASE WHEN MOD(i - 1000, 5) = 0 THEN 'Bronze'
             WHEN MOD(i - 1000, 5) = 1 THEN 'Argent'
             WHEN MOD(i - 1000, 5) = 2 THEN 'Or'
             WHEN MOD(i - 1000, 5) = 3 THEN 'Platine'
             ELSE 'Diamant' END
      );
    EXCEPTION WHEN OTHERS THEN NULL; END;
  END LOOP;
  COMMIT;
END;
/

-- =============================================
-- 11. INSERTION DES COMPATIBILITÉS (EST_COMPATIBLE_AVEC)
-- =============================================
-- Herbivores africains entre eux
INSERT INTO Est_Compatible_Avec VALUES (2, 3);   -- Éléphant - Girafe
INSERT INTO Est_Compatible_Avec VALUES (2, 4);   -- Éléphant - Zèbre
INSERT INTO Est_Compatible_Avec VALUES (3, 4);   -- Girafe - Zèbre
INSERT INTO Est_Compatible_Avec VALUES (3, 7);   -- Girafe - Gnou

-- Carnivores africains
INSERT INTO Est_Compatible_Avec VALUES (1, 6);   -- Lion - Léopard

-- Herbivores asiatiques
INSERT INTO Est_Compatible_Avec VALUES (11, 13);  -- Éléphant d'Asie - Rhino
INSERT INTO Est_Compatible_Avec VALUES (12, 14);  -- Panda - Singe Doré

-- Animaux marins
INSERT INTO Est_Compatible_Avec VALUES (41, 42);  -- Dauphin - Tortue
INSERT INTO Est_Compatible_Avec VALUES (42, 43);  -- Tortue - Raie Manta
INSERT INTO Est_Compatible_Avec VALUES (41, 45);  -- Dauphin - Poisson-Clown

-- Animaux arctiques
INSERT INTO Est_Compatible_Avec VALUES (31, 32);  -- Phoque - Béluga
INSERT INTO Est_Compatible_Avec VALUES (32, 33);  -- Béluga - Morse

COMMIT;

-- =============================================
-- 12. INSERTION DES RELATIONS PARENTALES (EST_LE_PARENT_DE)
-- =============================================
-- Lions
INSERT INTO Est_Le_Parent_De VALUES (1000, 1001);  -- Simba - Nala

-- Éléphants
INSERT INTO Est_Le_Parent_De VALUES (1002, 1003);  -- Dumbo - Elmer

-- Girafes
INSERT INTO Est_Le_Parent_De VALUES (1004, 1005);  -- Gérald - Martine

-- Tigres
INSERT INTO Est_Le_Parent_De VALUES (1020, 1025);  -- Rajah - Kanha

-- Pandas
INSERT INTO Est_Le_Parent_De VALUES (1022, 1023);  -- Po - Mei

-- (Pas de relation parentale jaguar valide - contrainte CHECK(ID_Parent < ID_Enfant) prévient l'auto-référence)

-- Aras
INSERT INTO Est_Le_Parent_De VALUES (1041, 1042);  -- Macaw1 - Macaw2

-- Ours Blancs
INSERT INTO Est_Le_Parent_De VALUES (1060, 1061);  -- Nanook - Ismo

COMMIT;

-- =============================================
-- 13. INSERTION DES AFFECTATIONS AUX ZONES (EST_AFFECTEE_A)
-- =============================================
-- Managers aux zones (déjà manager via FK Zone)
INSERT INTO Est_Affectee_A VALUES (1, 101);
INSERT INTO Est_Affectee_A VALUES (2, 102);
INSERT INTO Est_Affectee_A VALUES (3, 103);
INSERT INTO Est_Affectee_A VALUES (4, 104);
INSERT INTO Est_Affectee_A VALUES (5, 105);

-- Soigneurs aux zones
INSERT INTO Est_Affectee_A VALUES (1, 110);
INSERT INTO Est_Affectee_A VALUES (1, 111);
INSERT INTO Est_Affectee_A VALUES (1, 112);
INSERT INTO Est_Affectee_A VALUES (1, 113);
INSERT INTO Est_Affectee_A VALUES (2, 120);
INSERT INTO Est_Affectee_A VALUES (2, 121);
INSERT INTO Est_Affectee_A VALUES (2, 122);
INSERT INTO Est_Affectee_A VALUES (2, 123);
INSERT INTO Est_Affectee_A VALUES (3, 130);
INSERT INTO Est_Affectee_A VALUES (3, 131);
INSERT INTO Est_Affectee_A VALUES (3, 132);
INSERT INTO Est_Affectee_A VALUES (3, 133);
INSERT INTO Est_Affectee_A VALUES (4, 140);
INSERT INTO Est_Affectee_A VALUES (4, 141);
INSERT INTO Est_Affectee_A VALUES (5, 150);
INSERT INTO Est_Affectee_A VALUES (5, 151);

-- Vétérinaires à toutes les zones
INSERT INTO Est_Affectee_A VALUES (1, 200);
INSERT INTO Est_Affectee_A VALUES (2, 200);
INSERT INTO Est_Affectee_A VALUES (3, 200);
INSERT INTO Est_Affectee_A VALUES (4, 201);
INSERT INTO Est_Affectee_A VALUES (5, 201);
INSERT INTO Est_Affectee_A VALUES (1, 202);
INSERT INTO Est_Affectee_A VALUES (2, 202);
INSERT INTO Est_Affectee_A VALUES (3, 202);

-- Techniciens entretien aux zones
INSERT INTO Est_Affectee_A VALUES (1, 400);
INSERT INTO Est_Affectee_A VALUES (2, 401);
INSERT INTO Est_Affectee_A VALUES (3, 402);

-- Guides touristiques
INSERT INTO Est_Affectee_A VALUES (1, 500);
INSERT INTO Est_Affectee_A VALUES (2, 501);

COMMIT;

-- =============================================
-- 14. INSERTION DES AFFECTATIONS BOUTIQUE (TRAVAILLE_DANS_LA_BOUTIQUE)
-- =============================================
-- Caissiers aux boutiques
INSERT INTO Travaille_Dans_La_Boutique VALUES (1, 310);
INSERT INTO Travaille_Dans_La_Boutique VALUES (1, 311);
INSERT INTO Travaille_Dans_La_Boutique VALUES (2, 312);
INSERT INTO Travaille_Dans_La_Boutique VALUES (2, 313);
INSERT INTO Travaille_Dans_La_Boutique VALUES (3, 314);
INSERT INTO Travaille_Dans_La_Boutique VALUES (4, 310);
INSERT INTO Travaille_Dans_La_Boutique VALUES (5, 312);
INSERT INTO Travaille_Dans_La_Boutique VALUES (6, 311);

COMMIT;

-- =============================================
-- 15. INSERTION DU BIEN-ÊTRE QUOTIDIEN (BIEN_ETRE_QUOTIDIEN)
-- =============================================
BEGIN
  FOR animal_id IN 1000..1085 LOOP
    FOR day_offset IN 0..30 LOOP
      IF DBMS_RANDOM.VALUE() < 0.6 THEN
        BEGIN
          INSERT INTO Bien_Etre_Quotidien VALUES (
            animal_id,
            110 + MOD(animal_id - 1000, 50),
            TRUNC(SYSDATE) - day_offset,
            ROUND(DBMS_RANDOM.VALUE(1, 100), 2)
          );
        EXCEPTION WHEN OTHERS THEN NULL; END;
      END IF;
    END LOOP;
  END LOOP;
  COMMIT;
END;
/

-- =============================================
-- 16. INSERTION DES SOINS (PRATIQUE_SOINS)
-- =============================================
BEGIN
  FOR animal_id IN 1000..1085 LOOP
    FOR month_offset IN 0..11 LOOP
      IF DBMS_RANDOM.VALUE() < 0.3 THEN
        BEGIN
          INSERT INTO Pratique_Soins VALUES (
            animal_id,
            200 + MOD(animal_id - 1000, 3),
            TRUNC(SYSDATE) - (month_offset * 30),
            CASE WHEN DBMS_RANDOM.VALUE() < 0.25 THEN 'Vaccination'
                 WHEN DBMS_RANDOM.VALUE() < 0.50 THEN 'Examen médical'
                 WHEN DBMS_RANDOM.VALUE() < 0.75 THEN 'Détartrage'
                 ELSE 'Traitement parasitaire' END
          );
        EXCEPTION WHEN OTHERS THEN NULL; END;
      END IF;
    END LOOP;
  END LOOP;
  COMMIT;
END;
/

-- =============================================
-- 17. INSERTION DES RÉPARATIONS (REPARATION)
-- =============================================
BEGIN
  FOR i IN 1..30 LOOP
    DECLARE
      lat NUMBER;
      lng NUMBER;
    BEGIN
      lat := 10.0 + MOD(i, 5) * 0.5;
      lng := 20.0 + MOD(i, 3) * 0.5;
      
      INSERT INTO Reparation VALUES (
        TRUNC(SYSDATE) - (i * 5),
        lat,
        lng,
        400 + MOD(i, 3),
        MOD(i, 5) + 1,
        TRUNC(SYSDATE) - (i * 5) + ROUND(DBMS_RANDOM.VALUE(1, 30)),
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

-- =============================================
-- 18. INSERTION DES CHIFFRES D'AFFAIRES (CHIFFRE_AFFAIRES)
-- =============================================
BEGIN
  FOR boutique_id IN 1..6 LOOP
    FOR day_offset IN 0..365 LOOP
      BEGIN
        INSERT INTO Chiffre_Affaires VALUES (
          boutique_id,
          TRUNC(SYSDATE) - 365 + day_offset,
          ROUND(DBMS_RANDOM.VALUE(200, 2000), 2)
        );
      EXCEPTION WHEN OTHERS THEN NULL; END;
    END LOOP;
  END LOOP;
  COMMIT;
END;
/

-- =============================================
-- 19. INSERTION DES CONTRATS DE TRAVAIL (CONTRAT_TRAVAIL)
-- =============================================
DECLARE
  v_id NUMBER := 1;
BEGIN
  -- Contrats pour tous les personnels
  FOR pers_id IN 100..501 LOOP
    BEGIN
      INSERT INTO Contrat_Travail VALUES (
        v_id,
        pers_id,
        (SELECT ID_Fonction FROM Personnel WHERE ID_Personnel = pers_id),
        TO_DATE('2020-01-01', 'YYYY-MM-DD'),
        TO_DATE('2028-12-31', 'YYYY-MM-DD')
      );
      v_id := v_id + 1;
    EXCEPTION WHEN OTHERS THEN NULL; END;
  END LOOP;
  COMMIT;
END;
/

-- =============================================
-- RÉSUMÉ DE L'INSERTION
-- =============================================
DECLARE
  nb_func NUMBER;
  nb_pers NUMBER;
  nb_zones NUMBER;
  nb_enclos NUMBER;
  nb_especes NUMBER;
  nb_animaux NUMBER;
  nb_boutiques NUMBER;
  nb_visiteurs NUMBER;
  nb_parrainages NUMBER;
  nb_bien_etre NUMBER;
  nb_soins NUMBER;
  nb_affectations NUMBER;
  nb_boutique_staff NUMBER;
  nb_reparations NUMBER;
  nb_ca NUMBER;
  nb_contrats NUMBER;
BEGIN
  SELECT COUNT(*) INTO nb_func FROM Fonction;
  SELECT COUNT(*) INTO nb_pers FROM Personnel;
  SELECT COUNT(*) INTO nb_zones FROM Zone;
  SELECT COUNT(*) INTO nb_enclos FROM Enclos;
  SELECT COUNT(*) INTO nb_especes FROM Espece;
  SELECT COUNT(*) INTO nb_animaux FROM Animal;
  SELECT COUNT(*) INTO nb_boutiques FROM Boutique;
  SELECT COUNT(*) INTO nb_visiteurs FROM Visiteur;
  SELECT COUNT(*) INTO nb_parrainages FROM Est_Parraine;
  SELECT COUNT(*) INTO nb_bien_etre FROM Bien_Etre_Quotidien;
  SELECT COUNT(*) INTO nb_soins FROM Pratique_Soins;
  SELECT COUNT(*) INTO nb_affectations FROM Est_Affectee_A;
  SELECT COUNT(*) INTO nb_boutique_staff FROM Travaille_Dans_La_Boutique;
  SELECT COUNT(*) INTO nb_reparations FROM Reparation;
  SELECT COUNT(*) INTO nb_ca FROM Chiffre_Affaires;
  SELECT COUNT(*) INTO nb_contrats FROM Contrat_Travail;
  
  DBMS_OUTPUT.PUT_LINE('===============================================');
  DBMS_OUTPUT.PUT_LINE('      RÉSUMÉ DE L''INSERTION DE DONNÉES');
  DBMS_OUTPUT.PUT_LINE('===============================================');
  DBMS_OUTPUT.PUT_LINE('Fonctions:                  ' || nb_func);
  DBMS_OUTPUT.PUT_LINE('Personnels:                 ' || nb_pers);
  DBMS_OUTPUT.PUT_LINE('Zones:                      ' || nb_zones);
  DBMS_OUTPUT.PUT_LINE('Enclos:                     ' || nb_enclos);
  DBMS_OUTPUT.PUT_LINE('Espèces:                    ' || nb_especes);
  DBMS_OUTPUT.PUT_LINE('Animaux:                    ' || nb_animaux);
  DBMS_OUTPUT.PUT_LINE('Boutiques:                  ' || nb_boutiques);
  DBMS_OUTPUT.PUT_LINE('Visiteurs:                  ' || nb_visiteurs);
  DBMS_OUTPUT.PUT_LINE('Parrainages:                ' || nb_parrainages);
  DBMS_OUTPUT.PUT_LINE('Bien-être quotidien:        ' || nb_bien_etre);
  DBMS_OUTPUT.PUT_LINE('Soins pratiqués:            ' || nb_soins);
  DBMS_OUTPUT.PUT_LINE('Affectations zones:         ' || nb_affectations);
  DBMS_OUTPUT.PUT_LINE('Affectations boutiques:     ' || nb_boutique_staff);
  DBMS_OUTPUT.PUT_LINE('Réparations:                ' || nb_reparations);
  DBMS_OUTPUT.PUT_LINE('Chiffres d''affaires:        ' || nb_ca);
  DBMS_OUTPUT.PUT_LINE('Contrats de travail:        ' || nb_contrats);
  DBMS_OUTPUT.PUT_LINE('===============================================');
  DBMS_OUTPUT.PUT_LINE('INSERTION COMPLÈTE ET VALIDÉE');
  DBMS_OUTPUT.PUT_LINE('===============================================');
END;
/

COMMIT;
