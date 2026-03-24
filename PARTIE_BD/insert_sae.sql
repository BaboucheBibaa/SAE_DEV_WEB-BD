INSERT INTO Fonction VALUES (1, 'Administrateur', 'Administration du zoo');
INSERT INTO Fonction VALUES (2, 'Responsable de Zone', 'Gestion d''une zone');
INSERT INTO Fonction VALUES (3, 'Soigneur', 'Soin et alimentation quotidienne des animaux');
INSERT INTO Fonction VALUES (4, 'Manager Boutique', 'Gestion d''une boutique');
INSERT INTO Fonction VALUES (5, 'Employé boutique', 'Employé d''une boutique');
INSERT INTO Fonction VALUES (6, 'Technicien Entretien', 'Maintenance des enclos');
INSERT INTO Fonction VALUES (7, 'Comptable', 'Gestion du budget du zoo');

INSERT INTO Personnel VALUES (1,NULL,1,1,'Delcroix','Lucas','admin@zoo.fr','$2a$12$Cxp..EXnGgLFTdfc1EnwxOmzzl2fPkyBC1gcLh/DAKzygCY4PQTKG',TO_DATE('2020-12-12', 'YYYY-MM-DD'),3600,'admin',1);
INSERT INTO Personnel VALUES (2,NULL,1,2,'Vauchel','Anthony','avauchel@zoo.fr','$2a$12$Cxp..EXnGgLFTdfc1EnwxOmzzl2fPkyBC1gcLh/DAKzygCY4PQTKG',TO_DATE('2020-12-12', 'YYYY-MM-DD'),2600,'avauchel',1);
INSERT INTO Personnel VALUES (3,4,2,3,'Dupont','Dupond','dupont@zoo.fr','$2a$12$Cxp..EXnGgLFTdfc1EnwxOmzzl2fPkyBC1gcLh/DAKzygCY4PQTKG',TO_DATE('2020-12-12', 'YYYY-MM-DD'),1900,'ddupont',1);
INSERT INTO Personnel VALUES (4,3,2,3,'Dupond','Dupont','dupond@zoo.fr','$2a$12$Cxp..EXnGgLFTdfc1EnwxOmzzl2fPkyBC1gcLh/DAKzygCY4PQTKG',TO_DATE('2020-12-12', 'YYYY-MM-DD'),1900,'ddupond',1);
INSERT INTO Personnel VALUES (5,NULL,1,4,'Babouche','Dora','bdora@zoo.fr','$2a$12$Cxp..EXnGgLFTdfc1EnwxOmzzl2fPkyBC1gcLh/DAKzygCY4PQTKG',TO_DATE('2020-12-12', 'YYYY-MM-DD'),1900,'bdora',1);
INSERT INTO Personnel VALUES (6,NULL,5,5,'Sacha','Pikachu','spikachu@zoo.fr','$2a$12$Cxp..EXnGgLFTdfc1EnwxOmzzl2fPkyBC1gcLh/DAKzygCY4PQTKG',TO_DATE('2020-12-12', 'YYYY-MM-DD'),1900,'spikachu',1);
INSERT INTO Personnel VALUES (7,NULL,5,5,'Omar','Fred','ofred@zoo.fr','$2a$12$Cxp..EXnGgLFTdfc1EnwxOmzzl2fPkyBC1gcLh/DAKzygCY4PQTKG',TO_DATE('2020-12-12', 'YYYY-MM-DD'),1900,'ofred',1);
INSERT INTO Personnel VALUES (8,NULL,1,6,'Master','Poulet','mpoulet@zoo.fr','$2a$12$Cxp..EXnGgLFTdfc1EnwxOmzzl2fPkyBC1gcLh/DAKzygCY4PQTKG',TO_DATE('2020-12-12', 'YYYY-MM-DD'),1900,'mpoulet',1);
INSERT INTO Personnel VALUES (9,NULL,1,6,'Maitre','Chicken','mchicken@zoo.fr','$2a$12$Cxp..EXnGgLFTdfc1EnwxOmzzl2fPkyBC1gcLh/DAKzygCY4PQTKG',TO_DATE('2020-12-12', 'YYYY-MM-DD'),1900,'mchicken',1);
INSERT INTO Personnel VALUES (10,NULL,1,2,'Maitre','Crampteur','mcrampteur@zoo.fr','$2a$12$Cxp..EXnGgLFTdfc1EnwxOmzzl2fPkyBC1gcLh/DAKzygCY4PQTKG',TO_DATE('2020-12-12', 'YYYY-MM-DD'),2400,'mcrampteur',1);
INSERT INTO Personnel VALUES (11,NULL,1,2,'Trotin','Gabriel','gtrotin@zoo.fr','$2a$12$Cxp..EXnGgLFTdfc1EnwxOmzzl2fPkyBC1gcLh/DAKzygCY4PQTKG',TO_DATE('2020-12-12', 'YYYY-MM-DD'),1900,'gtrotin',1);
INSERT INTO Personnel VALUES (12,NULL,1,2,'Pessi','Tronc','ptronc@zoo.fr','$2a$12$Cxp..EXnGgLFTdfc1EnwxOmzzl2fPkyBC1gcLh/DAKzygCY4PQTKG',TO_DATE('2020-12-12', 'YYYY-MM-DD'),1900,'ptronc',1);
INSERT INTO Personnel VALUES (13,NULL,1,5,'Pessi','Miabraz','pmiabraz@zoo.fr','$2a$12$Cxp..EXnGgLFTdfc1EnwxOmzzl2fPkyBC1gcLh/DAKzygCY4PQTKG',TO_DATE('2020-12-12', 'YYYY-MM-DD'),1900,'pmiabraz',1);
INSERT INTO Personnel VALUES (14,NULL,1,5,'Pessi','Xseven','pmiabraz@zoo.fr','$2a$12$Cxp..EXnGgLFTdfc1EnwxOmzzl2fPkyBC1gcLh/DAKzygCY4PQTKG',TO_DATE('2020-12-12', 'YYYY-MM-DD'),1900,'pxseven',1);
INSERT INTO Personnel VALUES (15,NULL,1,5,'Skew','Bounce','sbounce@zoo.fr','$2a$12$Cxp..EXnGgLFTdfc1EnwxOmzzl2fPkyBC1gcLh/DAKzygCY4PQTKG',TO_DATE('2020-12-12', 'YYYY-MM-DD'),1900,'sbounce',1);
INSERT INTO Personnel VALUES (16,NULL,1,5,'Erwann','Batoko','ebatoko@zoo.fr','$2a$12$Cxp..EXnGgLFTdfc1EnwxOmzzl2fPkyBC1gcLh/DAKzygCY4PQTKG',TO_DATE('2020-12-12', 'YYYY-MM-DD'),1900,'ebatoko',1);

INSERT INTO Contrat_Travail VALUES(1,1,1,TO_DATE('2020-12-12', 'YYYY-MM-DD'),TO_DATE('2028-12-12','YYYY-MM-DD'));
INSERT INTO Contrat_Travail VALUES(2,2,2,TO_DATE('2020-12-12', 'YYYY-MM-DD'),TO_DATE('2024-12-12','YYYY-MM-DD'));
INSERT INTO Contrat_Travail VALUES(3,3,3,TO_DATE('2020-12-12', 'YYYY-MM-DD'),TO_DATE('2023-12-12','YYYY-MM-DD'));
INSERT INTO Contrat_Travail VALUES(4,4,3,TO_DATE('2020-12-12', 'YYYY-MM-DD'),TO_DATE('2022-12-12','YYYY-MM-DD'));
INSERT INTO Contrat_Travail VALUES(5,5,4,TO_DATE('2020-12-12', 'YYYY-MM-DD'),TO_DATE('2025-12-12','YYYY-MM-DD'));
INSERT INTO Contrat_Travail VALUES(6,6,5,TO_DATE('2020-12-12', 'YYYY-MM-DD'),TO_DATE('2025-12-12','YYYY-MM-DD'));
INSERT INTO Contrat_Travail VALUES(7,7,5,TO_DATE('2020-12-12', 'YYYY-MM-DD'),TO_DATE('2026-12-12','YYYY-MM-DD'));
INSERT INTO Contrat_Travail VALUES(8,8,6,TO_DATE('2020-12-12', 'YYYY-MM-DD'),TO_DATE('2027-12-12','YYYY-MM-DD'));
INSERT INTO Contrat_Travail VALUES(9,9,6,TO_DATE('2020-12-12', 'YYYY-MM-DD'),TO_DATE('2021-12-12','YYYY-MM-DD'));
INSERT INTO Contrat_Travail VALUES(10,10,2,TO_DATE('2020-12-12', 'YYYY-MM-DD'),TO_DATE('2021-12-12','YYYY-MM-DD'));
INSERT INTO Contrat_Travail VALUES(11,11,2,TO_DATE('2020-12-12', 'YYYY-MM-DD'),TO_DATE('2021-12-12','YYYY-MM-DD'));
INSERT INTO Contrat_Travail VALUES(12,12,2,TO_DATE('2020-12-12', 'YYYY-MM-DD'),TO_DATE('2021-12-12','YYYY-MM-DD'));
INSERT INTO Contrat_Travail VALUES(13,13,5,TO_DATE('2020-12-12', 'YYYY-MM-DD'),TO_DATE('2021-12-12','YYYY-MM-DD'));
INSERT INTO Contrat_Travail VALUES(14,14,5,TO_DATE('2020-12-12', 'YYYY-MM-DD'),TO_DATE('2021-12-12','YYYY-MM-DD'));
INSERT INTO Contrat_Travail VALUES(15,15,5,TO_DATE('2020-12-12', 'YYYY-MM-DD'),TO_DATE('2021-12-12','YYYY-MM-DD'));
INSERT INTO Contrat_Travail VALUES(16,16,5,TO_DATE('2020-12-12', 'YYYY-MM-DD'),TO_DATE('2021-12-12','YYYY-MM-DD'));

INSERT INTO Zone VALUES (1,'Zone du Haut',2);
INSERT INTO Zone VALUES (2, 'Zone de la jungle haut',10);
INSERT INTO Zone VALUES (3, 'Zone de la jungle bas',11);
INSERT INTO Zone VALUES (4, 'Zone du bazar',12);

INSERT INTO Enclos VALUES(15, 25,1,'T1');
INSERT INTO Enclos VALUES(15, 30,1,'T2');
INSERT INTO Enclos VALUES(15, 35,1,'T3');
INSERT INTO Enclos VALUES(15, 40,1,'T4');


INSERT INTO Enclos VALUES(20,25,2,'Gromp');
INSERT INTO Enclos VALUES(20,30,2,'Wraiths');
INSERT INTO Enclos VALUES(20,35,2,'Blue Buff');

INSERT INTO Enclos VALUES(25,25,3,'Corbins');
INSERT INTO Enclos VALUES(25,30,3,'Golems');
INSERT INTO Enclos VALUES(25,35,3,'Red Buff');

INSERT INTO Enclos VALUES(30,25,4,'Enclos à dinosaure');
INSERT INTO Enclos VALUES(30,30,4,'Enclos à choses étranges');
INSERT INTO Enclos VALUES(30,35,4,'Enclos à chiens');


INSERT INTO Espece VALUES (1, 'Arbre', 'Brr Brr Patapim', 0);
INSERT INTO Espece VALUES (2, 'Bois', 'Tung Tung Tung Sahur', 1);
INSERT INTO Espece VALUES (3, 'Cactus', 'Lirili Larila', 1);
INSERT INTO Espece VALUES (4, 'Avion', 'Bombardillo Crocodilo', 1);
INSERT INTO Espece VALUES (5, 'Cappucino', 'Assassino Cappucino', 0);
INSERT INTO Espece VALUES (6, 'Ballerine', 'Ballerina Cappucina', 0);
INSERT INTO Espece VALUES (7, 'Chaussure', 'Tralalelo Tralala', 1);

INSERT INTO Espece VALUES (8, 'Darkin', 'Darkinus', 1);
INSERT INTO Espece VALUES (9, 'Humain', 'Humanus', 1);
INSERT INTO Espece VALUES (10, 'Vastaya', 'Vastayus', 0);
INSERT INTO Espece VALUES (11, 'Void', 'Voideus', 1);
INSERT INTO Espece VALUES (12, 'Yordle', 'Yordlerino', 0);
INSERT INTO Espece VALUES (13, 'Shadow Wizard Money Gang', 'We Love Casting Spells', 0);

INSERT INTO Animal VALUES(1,15,25,1,TO_DATE('2018-03-15', 'YYYY-MM-DD'),'Anthony',6.7,'Carnivore',1);
INSERT INTO Animal VALUES(2,15,30,2,TO_DATE('2018-03-15', 'YYYY-MM-DD'),'Geoffrey',49.3,'Carnivore',1);
INSERT INTO Animal VALUES(3,15,35,3,TO_DATE('2018-03-15', 'YYYY-MM-DD'),'Alexandre',67.0,'Carnivore',1);
INSERT INTO Animal VALUES(4,15,40,4,TO_DATE('2018-03-15', 'YYYY-MM-DD'),'Justin',0.67,'Carnivore',1);

INSERT INTO Animal VALUES(5,20,25,5,TO_DATE('2018-03-15', 'YYYY-MM-DD'),'Meg',4.93,'Carnivore',1);
INSERT INTO Animal VALUES(6,20,30,6,TO_DATE('2018-03-15', 'YYYY-MM-DD'),'Tongrod',493,'Carnivore',1);
INSERT INTO Animal VALUES(7,20,35,7,TO_DATE('2018-03-15', 'YYYY-MM-DD'),'Leo',0.493,'Carnivore',1);

INSERT INTO Animal VALUES(8,25,25,8,TO_DATE('2018-03-15', 'YYYY-MM-DD'),'Nathan',49.3,'Carnivore',1);
INSERT INTO Animal VALUES(9,25,30,9,TO_DATE('2018-03-15', 'YYYY-MM-DD'),'Ryad',49.3,'Carnivore',1);
INSERT INTO Animal VALUES(10,25,35,10,TO_DATE('2018-03-15', 'YYYY-MM-DD'),'Kecleon',49.3,'Carnivore',1);

INSERT INTO Animal VALUES(11,30,25,11,TO_DATE('2018-03-15', 'YYYY-MM-DD'),'Mysdibule',6.7,'Carnivore',1);
INSERT INTO Animal VALUES(12,30,30,12,TO_DATE('2018-03-15', 'YYYY-MM-DD'),'Yquefue',49.3,'Carnivore',1);
INSERT INTO Animal VALUES(13,30,35,13,TO_DATE('2018-03-15', 'YYYY-MM-DD'),'ANIMAL FOU',6.7,'Carnivore',1);

INSERT INTO Boutique VALUES (1, 300, 1, 'Boutique MIAM', 'Boutique pour manger');
INSERT INTO Boutique VALUES (2, 300, 1, 'Boutique des FOUS', 'Souvenirs FOUS');
INSERT INTO Boutique VALUES (3, 300, 1, 'Boutique SOIF', 'Boutique si on a soif');
INSERT INTO Boutique VALUES (4, 300, 1, 'Boutique TOILETTES', 'Boutique pour aller aux toilettes car les toilettes sont payantes');
INSERT INTO Boutique VALUES (5, 300, 1, 'Boutique NOURRITURE POUR ANIMAUX', 'Boutique pour acheter de la nourriture pour la donner aux animaux');

INSERT INTO Visiteur VALUES(1,'Babar');
INSERT INTO Visiteur VALUES(2,'Nemo');
INSERT INTO Visiteur VALUES(3,'Bambi');
INSERT INTO Visiteur VALUES(4,'Baloo');
INSERT INTO Visiteur VALUES(5,'Mario');
INSERT INTO Visiteur VALUES(6,'Winnie');
INSERT INTO Visiteur VALUES(7,'Gumball');

INSERT INTO Prestataire VALUES (1, 'BTP Solutions', 'Jean');
INSERT INTO Prestataire VALUES (2, 'Entreprise Nettoyage', 'Marie');
INSERT INTO Prestataire VALUES (3, 'Réparations Ultimes', 'Pierre');
INSERT INTO Prestataire VALUES (4, 'Maintenance Plus', 'Sophie');
INSERT INTO Prestataire VALUES (5, 'Travaux Généraux', 'Laurent');

INSERT INTO Est_Parraine VALUES (1, 1, 3, 'Parrain Bronze');
INSERT INTO Est_Parraine VALUES (2, 1, 2, 'Parrain Argent');
INSERT INTO Est_Parraine VALUES (3, 2, 1, 'Parrain Or');
INSERT INTO Est_Parraine VALUES (4, 3, 2, 'Parrain Argent');
INSERT INTO Est_Parraine VALUES (5, 4, 3, 'Parrain Bronze');
INSERT INTO Est_Parraine VALUES (6, 2, 1, 'Parrain Or');
INSERT INTO Est_Parraine VALUES (7, 5, 2, 'Parrain Argent');
INSERT INTO Est_Parraine VALUES (8, 6, 3, 'Parrain Bronze');
INSERT INTO Est_Parraine VALUES (9, 7, 1, 'Parrain Or');
INSERT INTO Est_Parraine VALUES (10, 5, 2, 'Parrain Argent');
INSERT INTO Est_Parraine VALUES (11, 3, 1, 'Parrain Or');
INSERT INTO Est_Parraine VALUES (12, 4, 3, 'Parrain Bronze');
INSERT INTO Est_Parraine VALUES (13, 6, 2, 'Parrain Argent');

