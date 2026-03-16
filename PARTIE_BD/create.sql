-- =========================
-- TABLE FONCTION
-- =========================
CREATE TABLE Fonction (
    ID_Fonction NUMBER PRIMARY KEY,
    Nom_Fonction VARCHAR2(50),
    Description VARCHAR2(200)
);

-- =========================
-- TABLE PERSONNEL
-- =========================
CREATE TABLE Personnel (
    ID_Personnel NUMBER PRIMARY KEY,
    ID_Remplacant NUMBER, -- Référence à lui-même si aucun remplaçant attitré
    ID_Superieur NUMBER, -- Référence à lui-même si aucun supérieur hiérarchique
    ID_Fonction NUMBER NOT NULL,
    Nom VARCHAR2(50),
    Prenom VARCHAR2(50),
    Mail VARCHAR2(100),
    MDP VARCHAR2(100) NOT NULL,
    Date_Entree DATE NOT NULL,
    Salaire NUMBER(10,2),
    LOGIN VARCHAR2(50) NOT NULL UNIQUE,
    estArchive NUMBER(1) DEFAULT 1, -- 1 pour actif et 0 pour archivé
    FOREIGN KEY (ID_Remplacant) REFERENCES Personnel(ID_Personnel) ON DELETE SET NULL,
    FOREIGN KEY (ID_Superieur) REFERENCES Personnel(ID_Personnel) ON DELETE SET NULL,
    FOREIGN KEY (ID_Fonction) REFERENCES Fonction(ID_Fonction) ON DELETE CASCADE
);

-- =========================
-- TABLE CONTRAT_TRAVAIL
-- =========================
CREATE TABLE Contrat_Travail (
    ID_Contrat NUMBER PRIMARY KEY,
    ID_Personnel NUMBER NOT NULL,
    ID_Fonction NUMBER NOT NULL,
    Date_Debut DATE,
    Date_Fin DATE,
    FOREIGN KEY (ID_Personnel) REFERENCES Personnel(ID_Personnel) ON DELETE CASCADE,
    FOREIGN KEY (ID_Fonction) REFERENCES Fonction(ID_Fonction) ON DELETE CASCADE
);

-- =========================
-- TABLE ZONE
-- =========================
CREATE TABLE Zone (
    ID_Zone NUMBER PRIMARY KEY,
    Nom_Zone VARCHAR2(100),
    ID_Manager NUMBER NOT NULL,
    FOREIGN KEY (ID_Manager) REFERENCES Personnel(ID_Personnel) ON DELETE CASCADE
);

-- =========================
-- TABLE BOUTIQUE
-- =========================
CREATE TABLE Boutique (
    ID_Boutique NUMBER PRIMARY KEY,
    ID_Manager NUMBER NOT NULL,
    ID_Zone NUMBER NOT NULL,
    Nom_Boutique VARCHAR2(100),
    Description_Boutique VARCHAR2(200),
    FOREIGN KEY (ID_Manager) REFERENCES Personnel(ID_Personnel) ON DELETE CASCADE,
    FOREIGN KEY (ID_Zone) REFERENCES Zone(ID_Zone) ON DELETE CASCADE
);

-- =========================
-- TABLE CHIFFRE_AFFAIRES
-- =========================
CREATE TABLE Chiffre_Affaires (
    ID_Boutique NUMBER,
    Date_CA_Journalier DATE,
    Montant NUMBER(10,2),
    PRIMARY KEY (ID_Boutique, Date_CA_Journalier),
    FOREIGN KEY (ID_Boutique) REFERENCES Boutique(ID_Boutique) ON DELETE CASCADE
);

-- =========================
-- TABLE PRESTATAIRE
-- =========================
CREATE TABLE Prestataire (
    ID_Prestataire NUMBER PRIMARY KEY,
    Nom_Prestataire VARCHAR2(50),
    Prenom_Prestataire VARCHAR2(50)
);

-- =========================
-- TABLE ENCLOS
-- =========================
CREATE TABLE Enclos (
    Latitude NUMBER,
    Longitude NUMBER,
    ID_Zone NUMBER,
    Type_Enclos VARCHAR2(50),
    PRIMARY KEY (Latitude, Longitude),
    FOREIGN KEY (ID_Zone) REFERENCES Zone(ID_Zone) ON DELETE CASCADE
);

-- =========================
-- TABLE ESPECE
-- =========================
CREATE TABLE Espece (
    ID_Espece NUMBER PRIMARY KEY,
    Nom_Espece VARCHAR2(100),
    Nom_Latin_Espece VARCHAR2(100),
    Est_Menacee NUMBER(1)
);

-- =========================
-- TABLE ANIMAL
-- =========================
CREATE TABLE Animal (
    ID_Animal NUMBER PRIMARY KEY,
    Latitude_Enclos NUMBER NOT NULL,
    Longitude_Enclos NUMBER NOT NULL,
    ID_Espece NUMBER NOT NULL,
    Date_Naissance DATE NOT NULL,
    Nom_Animal VARCHAR2(50),
    Poids NUMBER(6,2),
    Regime_Alimentaire VARCHAR2(50),
    estArchive NUMBER(1) DEFAULT 1, -- 1 pour actif et 0 pour archivé
    FOREIGN KEY (Latitude_Enclos, Longitude_Enclos)
        REFERENCES Enclos(Latitude, Longitude) ON DELETE CASCADE,
    FOREIGN KEY (ID_Espece) REFERENCES Espece(ID_Espece) ON DELETE CASCADE
);

-- =========================
-- TABLE VISITEUR
-- =========================
CREATE TABLE Visiteur (
    ID_Visiteur NUMBER PRIMARY KEY,
    ID_Parrainage NUMBER,
    Nom_Visiteur VARCHAR2(50)
);

-- =========================
-- TABLE PARRAINAGE
-- =========================
CREATE TABLE Parrainage (
    ID_Parrainage NUMBER PRIMARY KEY,
    Niveau VARCHAR2(50)
);

ALTER TABLE Visiteur
ADD FOREIGN KEY (ID_Parrainage) REFERENCES Parrainage(ID_Parrainage) ON DELETE CASCADE;

-- =========================
-- TABLE PRESTATION
-- =========================
CREATE TABLE Prestation (
    ID_Prestation NUMBER PRIMARY KEY,
    Description_Prestation VARCHAR2(200)
);

-- =========================
-- TABLE EST_PARRAINE
-- =========================
CREATE TABLE Est_Parraine (
    ID_Animal NUMBER NOT NULL,
    ID_Visiteur NUMBER NOT NULL,
    PRIMARY KEY (ID_Animal, ID_Visiteur),
    FOREIGN KEY (ID_Animal) REFERENCES Animal(ID_Animal) ON DELETE CASCADE,
    FOREIGN KEY (ID_Visiteur) REFERENCES Visiteur(ID_Visiteur) ON DELETE CASCADE
);

-- =========================
-- TABLE A_ACCES_A
-- =========================
CREATE TABLE A_Acces_A (
    ID_Parrainage NUMBER NOT NULL,
    ID_Prestation NUMBER NOT NULL,
    PRIMARY KEY (ID_Parrainage, ID_Prestation),
    FOREIGN KEY (ID_Parrainage) REFERENCES Parrainage(ID_Parrainage) ON DELETE CASCADE,
    FOREIGN KEY (ID_Prestation) REFERENCES Prestation(ID_Prestation) ON DELETE CASCADE
);

-- =========================
-- TABLE EST_COMPATIBLE_AVEC
-- =========================
CREATE TABLE Est_Compatible_Avec (
    ID_Espece1 NUMBER NOT NULL,
    ID_Espece2 NUMBER NOT NULL,
    PRIMARY KEY (ID_Espece1, ID_Espece2),
    FOREIGN KEY (ID_Espece1) REFERENCES Espece(ID_Espece) ON DELETE CASCADE,
    FOREIGN KEY (ID_Espece2) REFERENCES Espece(ID_Espece) ON DELETE CASCADE
);

-- =========================
-- TABLE EST_LE_PARENT_DE
-- =========================
CREATE TABLE Est_Le_Parent_De (
    ID_Parent NUMBER NOT NULL,
    ID_Enfant NUMBER NOT NULL,
    PRIMARY KEY (ID_Parent, ID_Enfant),
    FOREIGN KEY (ID_Parent) REFERENCES Animal(ID_Animal) ON DELETE CASCADE,
    FOREIGN KEY (ID_Enfant) REFERENCES Animal(ID_Animal) ON DELETE CASCADE
);

-- =========================
-- TABLE BIEN_ETRE_QUOTIDIEN
-- =========================
CREATE TABLE Bien_Etre_Quotidien (
    ID_Animal NUMBER,
    ID_Personnel NUMBER,
    Date_Nourrit DATE,
    Dose_Nourriture NUMBER(6,2),
    PRIMARY KEY (ID_Animal, ID_Personnel, Date_Nourrit),
    FOREIGN KEY (ID_Animal) REFERENCES Animal(ID_Animal) ON DELETE CASCADE,
    FOREIGN KEY (ID_Personnel) REFERENCES Personnel(ID_Personnel) ON DELETE CASCADE
);

-- =========================
-- TABLE PRATIQUE_SOINS
-- =========================
CREATE TABLE Pratique_Soins (
    ID_Animal NUMBER,
    ID_Personnel NUMBER,
    Date_Soin DATE,
    Description_Soin VARCHAR2(200),
    PRIMARY KEY (ID_Animal, ID_Personnel, Date_Soin),
    FOREIGN KEY (ID_Animal) REFERENCES Animal(ID_Animal) ON DELETE CASCADE,
    FOREIGN KEY (ID_Personnel) REFERENCES Personnel(ID_Personnel) ON DELETE CASCADE
);

-- =========================
-- TABLE EST_AFFECTEE_A
-- =========================
CREATE TABLE Est_Affectee_A (
    ID_Zone NUMBER,
    ID_Personnel NUMBER,
    PRIMARY KEY (ID_Zone, ID_Personnel),
    FOREIGN KEY (ID_Zone) REFERENCES Zone(ID_Zone) ON DELETE CASCADE,
    FOREIGN KEY (ID_Personnel) REFERENCES Personnel(ID_Personnel) ON DELETE CASCADE
);

-- =========================
-- TABLE TRAVAILLE_DANS_LA_BOUTIQUE
-- =========================
CREATE TABLE Travaille_Dans_La_Boutique (
    ID_Boutique NUMBER,
    ID_Personnel NUMBER,
    PRIMARY KEY (ID_Boutique, ID_Personnel),
    FOREIGN KEY (ID_Boutique) REFERENCES Boutique(ID_Boutique) ON DELETE CASCADE,
    FOREIGN KEY (ID_Personnel) REFERENCES Personnel(ID_Personnel) ON DELETE CASCADE
);

-- =========================
-- TABLE REPARATION
-- =========================
CREATE TABLE Reparation (
    Date_Debut_Reparation DATE,
    Latitude_Enclos NUMBER,
    Longitude_Enclos NUMBER,
    ID_Personnel NUMBER,
    ID_Prestataire NUMBER,
    Date_Fin DATE,
    Nature_Reparation VARCHAR2(200),
    Cout_Reparation NUMBER(10,2),
    PRIMARY KEY (Date_Debut_Reparation, Latitude_Enclos, Longitude_Enclos),
    FOREIGN KEY (Latitude_Enclos, Longitude_Enclos)
        REFERENCES Enclos(Latitude, Longitude) ON DELETE CASCADE,
    FOREIGN KEY (ID_Personnel) REFERENCES Personnel(ID_Personnel) ON DELETE CASCADE,
    FOREIGN KEY (ID_Prestataire) REFERENCES Prestataire(ID_Prestataire) ON DELETE CASCADE
);