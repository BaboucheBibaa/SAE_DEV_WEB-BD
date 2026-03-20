-- TABLE FONCTION
CREATE TABLE Fonction (
    ID_Fonction NUMBER,
    Nom_Fonction VARCHAR2(50),
    Description VARCHAR2(200),
    CONSTRAINT PK_Fonction PRIMARY KEY (ID_Fonction)
);

-- TABLE PERSONNEL
CREATE TABLE Personnel (
    ID_Personnel NUMBER,
    ID_Remplacant NUMBER NOT NULL, -- Référence à lui-même si aucun remplaçant attitré
    ID_Superieur NUMBER NOT NULL, -- Référence à lui-même si aucun supérieur hiérarchique
    ID_Fonction NUMBER NOT NULL,
    Nom VARCHAR2(50),
    Prenom VARCHAR2(50),
    Mail VARCHAR2(100),
    MDP VARCHAR2(100) NOT NULL, -- MDP donc not null
    Date_Entree DATE NOT NULL,
    Salaire NUMBER(10,2),
    LOGIN VARCHAR2(50) NOT NULL UNIQUE, -- Login doit être unique et not null
    estArchive NUMBER(1) DEFAULT 1, -- 1 pour actif et 0 pour archivé
    CONSTRAINT PK_Personnel PRIMARY KEY (ID_Personnel),
    CONSTRAINT FK_Remplacant FOREIGN KEY (ID_Remplacant) REFERENCES Personnel(ID_Personnel) ON DELETE SET NULL,
    CONSTRAINT FK_Superieur FOREIGN KEY (ID_Superieur) REFERENCES Personnel(ID_Personnel) ON DELETE SET NULL,
    CONSTRAINT FK_Fonction FOREIGN KEY (ID_Fonction) REFERENCES Fonction(ID_Fonction) ON DELETE CASCADE
);

-- TABLE CONTRAT_TRAVAIL
CREATE TABLE Contrat_Travail (
    ID_Contrat NUMBER,
    ID_Personnel NUMBER NOT NULL,
    ID_Fonction NUMBER NOT NULL,
    Date_Debut DATE,
    Date_Fin DATE,
    CONSTRAINT PK_Contrat_Travail PRIMARY KEY (ID_Contrat),
    CONSTRAINT FK_Contrat_Personnel FOREIGN KEY (ID_Personnel) REFERENCES Personnel(ID_Personnel) ON DELETE CASCADE,
    CONSTRAINT FK_Contrat_Fonction FOREIGN KEY (ID_Fonction) REFERENCES Fonction(ID_Fonction) ON DELETE CASCADE
);

-- TABLE ZONE
CREATE TABLE Zone (
    ID_Zone NUMBER,
    Nom_Zone VARCHAR2(100),
    ID_Manager NUMBER NOT NULL, --Chaque zone a obligatoirement un manager qui est membre du personnel
    CONSTRAINT PK_Zone PRIMARY KEY (ID_Zone),
    CONSTRAINT FK_Zone_Manager FOREIGN KEY (ID_Manager) REFERENCES Personnel(ID_Personnel) ON DELETE CASCADE
);

-- TABLE BOUTIQUE
CREATE TABLE Boutique (
    ID_Boutique NUMBER,
    ID_Manager NUMBER NOT NULL, --Chaque boutique a obligatoirement un manager qui est membre du personnel
    ID_Zone NUMBER NOT NULL,
    Nom_Boutique VARCHAR2(100),
    Description_Boutique VARCHAR2(200),
    CONSTRAINT PK_Boutique PRIMARY KEY (ID_Boutique),

    CONSTRAINT FK_Boutique_Manager FOREIGN KEY (ID_Manager) REFERENCES Personnel(ID_Personnel) ON DELETE CASCADE,
    CONSTRAINT FK_Boutique_Zone FOREIGN KEY (ID_Zone) REFERENCES Zone(ID_Zone) ON DELETE CASCADE
);

-- TABLE CHIFFRE_AFFAIRES
CREATE TABLE Chiffre_Affaires (
    ID_Boutique NUMBER,
    Date_CA_Journalier DATE,
    Montant NUMBER(10,2),
    CONSTRAINT PK_Chiffre_Affaires PRIMARY KEY (ID_Boutique, Date_CA_Journalier),
    CONSTRAINT FK_Chiffre_Affaires_Boutique FOREIGN KEY (ID_Boutique) REFERENCES Boutique(ID_Boutique) ON DELETE CASCADE
);

-- TABLE PRESTATAIRE
CREATE TABLE Prestataire (
    ID_Prestataire NUMBER,
    Nom_Prestataire VARCHAR2(50),
    Prenom_Prestataire VARCHAR2(50),
    CONSTRAINT PK_Prestataire PRIMARY KEY (ID_Prestataire)
);

-- TABLE ENCLOS
CREATE TABLE Enclos (
    Latitude NUMBER,
    Longitude NUMBER,
    ID_Zone NUMBER NOT NULL,
    Type_Enclos VARCHAR2(50),
    CONSTRAINT PK_Enclos PRIMARY KEY (Latitude, Longitude),
    CONSTRAINT FK_Enclos_Zone FOREIGN KEY (ID_Zone) REFERENCES Zone(ID_Zone) ON DELETE CASCADE
);

-- TABLE ESPECE
CREATE TABLE Espece (
    ID_Espece NUMBER,
    Nom_Espece VARCHAR2(100),
    Nom_Latin_Espece VARCHAR2(100),
    Est_Menacee NUMBER(1),
    CONSTRAINT PK_Espece PRIMARY KEY (ID_Espece)
);

-- TABLE ANIMAL
CREATE TABLE Animal (
    ID_Animal NUMBER,
    Latitude_Enclos NUMBER NOT NULL,
    Longitude_Enclos NUMBER NOT NULL,
    ID_Espece NUMBER NOT NULL,
    Date_Naissance DATE,
    Nom_Animal VARCHAR2(50),
    Poids NUMBER(6,2),
    Regime_Alimentaire VARCHAR2(50),
    estArchive NUMBER(1) DEFAULT 1, -- 1 pour actif et 0 pour archivé
    CONSTRAINT PK_Animal PRIMARY KEY (ID_Animal),
    CONSTRAINT FK_Animal_Enclos FOREIGN KEY (Latitude_Enclos, Longitude_Enclos) REFERENCES Enclos(Latitude, Longitude) ON DELETE CASCADE,
    CONSTRAINT FK_Animal_Espece FOREIGN KEY (ID_Espece) REFERENCES Espece(ID_Espece) ON DELETE CASCADE
);

-- TABLE VISITEUR
CREATE TABLE Visiteur (
    ID_Visiteur NUMBER,
    Nom_Visiteur VARCHAR2(50),
    CONSTRAINT PK_Visiteur PRIMARY KEY (ID_Visiteur)
);

-- TABLE EST_PARRAINE
CREATE TABLE Est_Parraine (
    ID_Animal NUMBER NOT NULL,
    ID_Visiteur NUMBER NOT NULL,
    NIVEAU NUMBER NOT NULL,
    LIBELLE VARCHAR2(100),
    CONSTRAINT PK_Est_Parraine PRIMARY KEY (ID_Animal, ID_Visiteur),
    CONSTRAINT FK_Est_Parraine_Animal FOREIGN KEY (ID_Animal) REFERENCES Animal(ID_Animal) ON DELETE CASCADE,
    CONSTRAINT FK_Est_Parraine_Visiteur FOREIGN KEY (ID_Visiteur) REFERENCES Visiteur(ID_Visiteur) ON DELETE CASCADE
);

-- TABLE EST_COMPATIBLE_AVEC
CREATE TABLE Est_Compatible_Avec (
    ID_Espece1 NUMBER NOT NULL,
    ID_Espece2 NUMBER NOT NULL,
    CONSTRAINT PK_Est_Compatible_Avec PRIMARY KEY (ID_Espece1, ID_Espece2),
    CONSTRAINT FK_Est_Compatible_Avec_Espece1 FOREIGN KEY (ID_Espece1) REFERENCES Espece(ID_Espece) ON DELETE CASCADE,
    CONSTRAINT FK_Est_Compatible_Avec_Espece2 FOREIGN KEY (ID_Espece2) REFERENCES Espece(ID_Espece) ON DELETE CASCADE
);

-- TABLE EST_LE_PARENT_DE
CREATE TABLE Est_Le_Parent_De (
    ID_Parent NUMBER NOT NULL,
    ID_Enfant NUMBER NOT NULL,
    CONSTRAINT PK_Est_Le_Parent_De PRIMARY KEY (ID_Parent, ID_Enfant),
    CONSTRAINT FK_Est_Le_Parent_De_Parent FOREIGN KEY (ID_Parent) REFERENCES Animal(ID_Animal) ON DELETE CASCADE,
    CONSTRAINT FK_Est_Le_Parent_De_Enfant FOREIGN KEY (ID_Enfant) REFERENCES Animal(ID_Animal) ON DELETE CASCADE
);

-- TABLE BIEN_ETRE_QUOTIDIEN
CREATE TABLE Bien_Etre_Quotidien (
    ID_Animal NUMBER,
    ID_Personnel NUMBER,
    Date_Nourrit DATE,
    Dose_Nourriture NUMBER(6,2),
    CONSTRAINT PK_Bien_Etre_Quotidien PRIMARY KEY (ID_Animal, ID_Personnel, Date_Nourrit),
    CONSTRAINT FK_Bien_Etre_Quotidien_Animal FOREIGN KEY (ID_Animal) REFERENCES Animal(ID_Animal) ON DELETE CASCADE,
    CONSTRAINT FK_Bien_Etre_Quotidien_Personnel FOREIGN KEY (ID_Personnel) REFERENCES Personnel(ID_Personnel) ON DELETE CASCADE
);

-- TABLE PRATIQUE_SOINS
CREATE TABLE Pratique_Soins (
    ID_Animal NUMBER,
    ID_Personnel NUMBER,
    Date_Soin DATE,
    Description_Soin VARCHAR2(200),
    CONSTRAINT PK_Pratique_Soins PRIMARY KEY (ID_Animal, ID_Personnel, Date_Soin),
    CONSTRAINT FK_Pratique_Soins_Animal FOREIGN KEY (ID_Animal) REFERENCES Animal(ID_Animal) ON DELETE CASCADE,
    CONSTRAINT FK_Pratique_Soins_Personnel FOREIGN KEY (ID_Personnel) REFERENCES Personnel(ID_Personnel) ON DELETE CASCADE
);

-- TABLE EST_AFFECTEE_A
CREATE TABLE Est_Affectee_A (
    ID_Zone NUMBER,
    ID_Personnel NUMBER,
    CONSTRAINT PK_Est_Affectee_A PRIMARY KEY (ID_Zone, ID_Personnel),
    CONSTRAINT FK_Est_Affectee_A_Zone FOREIGN KEY (ID_Zone) REFERENCES Zone(ID_Zone) ON DELETE CASCADE,
    CONSTRAINT FK_Est_Affectee_A_Personnel FOREIGN KEY (ID_Personnel) REFERENCES Personnel(ID_Personnel) ON DELETE CASCADE
);

-- TABLE TRAVAILLE_DANS_LA_BOUTIQUE
CREATE TABLE Travaille_Dans_La_Boutique (
    ID_Boutique NUMBER,
    ID_Personnel NUMBER,
    CONSTRAINT PK_Trvaille_Dans_La_Boutique PRIMARY KEY (ID_Boutique, ID_Personnel),
    CONSTRAINT FK_Trvaille_Dans_La_Boutique_Boutique FOREIGN KEY (ID_Boutique) REFERENCES Boutique(ID_Boutique) ON DELETE CASCADE,
    CONSTRAINT FK_Trvaille_Dans_La_Boutique_Personnel FOREIGN KEY (ID_Personnel) REFERENCES Personnel(ID_Personnel) ON DELETE CASCADE
);

-- TABLE REPARATION
CREATE TABLE Reparation (
    Date_Debut_Reparation DATE,
    Latitude_Enclos NUMBER,
    Longitude_Enclos NUMBER,
    ID_Personnel NUMBER,
    ID_Prestataire NUMBER,
    Date_Fin DATE,
    Nature_Reparation VARCHAR2(200),
    Cout_Reparation NUMBER(10,2),
    CONSTRAINT PK_Reparation PRIMARY KEY (Date_Debut_Reparation, Latitude_Enclos, Longitude_Enclos),
    CONSTRAINT FK_Reparation_Enclos FOREIGN KEY (Latitude_Enclos, Longitude_Enclos) REFERENCES Enclos(Latitude, Longitude) ON DELETE CASCADE,
    CONSTRAINT FK_Reparation_Personnel FOREIGN KEY (ID_Personnel) REFERENCES Personnel(ID_Personnel) ON DELETE CASCADE,
    CONSTRAINT FK_Reparation_Prestataire FOREIGN KEY (ID_Prestataire) REFERENCES Prestataire(ID_Prestataire) ON DELETE CASCADE
);