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

INSERT INTO Contrat_Travail VALUES(1,1,1,TO_DATE('2020-12-12', 'YYYY-MM-DD'),TO_DATE('2028-12-12','YYYY-MM-DD'));
INSERT INTO Contrat_Travail VALUES(2,2,2,TO_DATE('2020-12-12', 'YYYY-MM-DD'),TO_DATE('2024-12-12','YYYY-MM-DD'));
INSERT INTO Contrat_Travail VALUES(3,3,3,TO_DATE('2020-12-12', 'YYYY-MM-DD'),TO_DATE('2023-12-12','YYYY-MM-DD'));
INSERT INTO Contrat_Travail VALUES(4,4,3,TO_DATE('2020-12-12', 'YYYY-MM-DD'),TO_DATE('2022-12-12','YYYY-MM-DD'));
INSERT INTO Contrat_Travail VALUES(5,5,4,TO_DATE('2020-12-12', 'YYYY-MM-DD'),TO_DATE('2025-12-12','YYYY-MM-DD'));
INSERT INTO Contrat_Travail VALUES(6,6,5,TO_DATE('2020-12-12', 'YYYY-MM-DD'),TO_DATE('2025-12-12','YYYY-MM-DD'));
INSERT INTO Contrat_Travail VALUES(7,7,5,TO_DATE('2020-12-12', 'YYYY-MM-DD'),TO_DATE('2026-12-12','YYYY-MM-DD'));
INSERT INTO Contrat_Travail VALUES(8,8,6,TO_DATE('2020-12-12', 'YYYY-MM-DD'),TO_DATE('2027-12-12','YYYY-MM-DD'));
INSERT INTO Contrat_Travail VALUES(9,9,6,TO_DATE('2020-12-12', 'YYYY-MM-DD'),TO_DATE('2021-12-12','YYYY-MM-DD'));

INSERT INTO Zone VALUES (1,"Zone du Haut",2);
INSERT INTO Zone VALUES (2, "Zone de la Jungle",10);
INSERT INTO Zone VALUES (3, "Zone du milieu",11);
INSERT INTO Zone VALUES (4, "Zone du Bas",12);