DROP TABLE IF EXISTS Compose;
DROP TABLE IF EXISTS Inclus;
DROP TABLE IF EXISTS Contient;
DROP TABLE IF EXISTS Date_limite;
DROP TABLE IF EXISTS Liste_niveau;
DROP TABLE IF EXISTS Materiel;
DROP TABLE IF EXISTS Sous_categorie;
DROP TABLE IF EXISTS Commande;
DROP TABLE IF EXISTS Message;
DROP TABLE IF EXISTS Parent;
DROP TABLE IF EXISTS Niveau;
DROP TABLE IF EXISTS Etat;

CREATE TABLE Etat(
	id_etat INT AUTO_INCREMENT NOT NULL,
	libelle_etat VARCHAR(50),
	PRIMARY KEY (id_etat)
) ENGINE=InnoDB;

CREATE TABLE Niveau(
	`code` char(1) NOT NULL,
	`Libelle` varchar(200) NOT NULL,
	 PRIMARY KEY (`code`)
) ENGINE=InnoDB;

CREATE TABLE Parent(
	id_parent INT AUTO_INCREMENT NOT NULL,
	nom_parent VARCHAR(40),
	mdp_parent VARCHAR(40),
	email_parent VARCHAR(40),
	tel_parent VARCHAR(20),
	nb_enfants INT,
	droits_parents TINYINT(1),
	id_etat INT NOT NULL,
	PRIMARY KEY (id_parent),
	FOREIGN KEY (id_etat) REFERENCES Etat (id_etat)
) Engine=InnoDB;

CREATE TABLE Message(
	id_message INT AUTO_INCREMENT NOT NULL,
	email_parent VARCHAR(40),
	objet VARCHAR(40),
	message VARCHAR(256),
	jma date,
	lu TINYINT(1),
	utilisateur TINYINT(1),
	id_parent INT NOT NULL,
	PRIMARY KEY (id_message),
	FOREIGN KEY (id_parent) REFERENCES Parent (id_parent) ON DELETE CASCADE
) Engine=InnoDB;

CREATE TABLE Commande(
	id_commande INT AUTO_INCREMENT NOT NULL,
	date_cmd DATE,
	etat INT,
	id_parent INT NOT NULL,
	PRIMARY KEY (id_commande),
	FOREIGN KEY (id_parent) REFERENCES Parent (id_parent) ON DELETE CASCADE
) Engine=InnoDB;

CREATE TABLE Sous_categorie(
	id_scat INT AUTO_INCREMENT NOT NULL,
	categorie VARCHAR(80),
	scat VARCHAR(80),
	PRIMARY KEY (id_scat)
) Engine=InnoDB;

CREATE TABLE Materiel(
	id_mat INT AUTO_INCREMENT NOT NULL,
	ref_mat VARCHAR(20) NOT NULL,
	desc_mat VARCHAR(80),
	prix_mat numeric(5,2),
	id_scat INT NOT NULL,
	PRIMARY KEY (id_mat),
	FOREIGN KEY (id_scat) REFERENCES Sous_categorie (id_scat)
) Engine=InnoDB;

CREATE TABLE Liste_niveau(
	id_nivliste INT AUTO_INCREMENT NOT NULL,
	niveau VARCHAR(10),
	forfait DOUBLE,
	PRIMARY KEY (id_nivliste)
) Engine=InnoDB;

CREATE TABLE Date_limite(
	jma DATE NOT NULL,
	PRIMARY KEY(jma)
) Engine=InnoDB;

CREATE TABLE Contient(
	id_commande INT NOT NULL,
	id_mat INT NOT NULL,
	quantite INT,
	PRIMARY KEY (id_commande, id_mat)
) Engine=InnoDB;

CREATE TABLE Inclus(
	id_commande INT NOT NULL,
	id_nivliste INT NOT NULL,
	exemplaire INT,
	PRIMARY KEY (id_commande, id_nivliste)
) Engine=InnoDB;

CREATE TABLE Compose(
	qte_scat INT,
	id_mat VARCHAR(20) NOT NULL,
	id_nivliste INT NOT NULL,
	PRIMARY KEY (id_mat, id_nivliste)
) Engine=InnoDB;

INSERT INTO `Niveau` (`code`, `Libelle`) VALUES
('A', 'CP'),
('B', 'CE1'),
('C', 'CE2'),
('D', 'CM1'),
('E', 'CM2');

ALTER TABLE `Liste_niveau`
  ADD CONSTRAINT `Liste_niveau_ibfk_1` FOREIGN KEY (`niveau`) REFERENCES `Niveau` (`code`);


INSERT INTO `Etat` (`id_etat`, `libelle_etat`) VALUES
('1',''),
('2','Inscription valid�e'),
('3','Commander'),
('4','Commande valid�e');

INSERT INTO Parent (id_parent, nom_parent, mdp_parent, email_parent, tel_parent, nb_enfants, droits_parents, id_etat) VALUES
('6', 'admin', 'a419f1c93a9606c2f72a5b58142439723e445753', 'rentree.facile@gmail.com', '0123456789', 1, 1, 2);

INSERT INTO Sous_categorie (id_scat, categorie, scat) VALUES
(474, 'ECRITURE', ''),
(475, 'ECRITURE', 'STYLO A BILLE'),
(476, 'ECRITURE', 'STYLO A ENCRE, CARTOUCHES, EFFACEUR, CORRECTEUR'),
(477, 'ECRITURE', 'ROLLERS ET FEUTRES'),
(478, 'ECRITURE', 'SURLIGNEURS'),
(479, 'ECRITURE', 'FEUTRES EFFACABLES'),
(480, 'ECRITURE', 'CRAYONS DE PAPIER'),
(481, 'DIVERS TROUSSE', ''),
(482, ' CRAYONS COULEURS ET FEUTRES', ''),
(483, 'CAHIERS ', ''),
(484, 'CAHIERS ', 'CAHIER 17x22cm'),
(485, 'CAHIERS ', 'CAHIERS 21 x 29,7cm (A4)'),
(486, 'CAHIERS ', 'CAHIERS 24 x 32cm'),
(487, 'CAHIERS ', 'CAHIERS DE TEXTE - TP'),
(488, 'PROTEGE CAHIERS', ''),
(489, 'PROTEGE CAHIERS', '17x22cm'),
(490, 'PROTEGE CAHIERS', 'A4 (21x29,7cm)'),
(491, 'PROTEGE CAHIERS', '24X32cm'),
(492, 'Classeurs - Intercalaires - Feuilles - Protege documents - Chemises - Pochettes perforees', ''),
(493, 'PETIT MATERIEL', ''),
(494, 'ARTS PLASTIQUES', ''),
(495, 'PAPIER DESSIN - CALQUE - Papier Millmetre / MAJUSCULE', ''),
(496, 'DICTIONNAIRES-BESCHERELLES-CALCULATRICES', ''),
(497, 'DICTIONNAIRES-BESCHERELLES-CALCULATRICES', '');

INSERT INTO Materiel (ref_mat, desc_mat, prix_mat, id_scat) VALUES
('00010', 'BIC CRISTAL Pointe Moyenne BLEU', 0.22, 475),
('00011', 'BIC CRISTAL Pointe Moyenne NOIR', 0.22, 475),
('00013', 'BIC CRISTAL Pointe Moyenne VERT', 0.22, 475),
('00040', 'BIC 4 couleurs Pointe Fine', 1.55, 475),
('01260', 'Feutre VELLEDA Pointe Fine BLEU', 0.48, 479),
('01261', 'Feutre VELLEDA Pointe Fine NOIR', 0.48, 479),
('01262', 'Feutre VELLEDA Pointe Fine ROUGE', 0.48, 479),
('01263', 'Feutre VELLEDA Pointe Fine VERT', 0.48, 479),
('01280', 'Marqueur VELLEDA Pointe Moyenne BLEU', 0.68, 479),
('01281', 'Marqueur VELLEDA Pointe Moyenne NOIR', 0.68, 479),
('01283', 'Marqueur VELLEDA Pointe Moyenne VERT', 0.68, 479),
('02300', 'Effaceur R��criveur MAGIC+ Paper Mate', 0.58, 476),
('101030', 'Crayon papier OPERA HB', 0.15, 480),
('103576', 'Prot�ge-Cahier 24X32 NOIR', 1.96, 491),
('104068', 'Crayon papier OPERA 2B', 0.15, 480),
('104542', 'Crayon papier Graphite MAJUSCULE HB', 0.11, 480),
('104845', 'Crayon papier Graphite MAJUSCULE 2B', 0.11, 480),
('10562', '48p 17X22 gds carreauxs 90g CLAIREFONTAINE', 0.61, 484),
('10563', '96p 17X22 gds carreaux 90g CLAIRFONTAINE', 0.63, 484),
('10566', '96p 21x29,7 gds carreaux 90g CLAIREFONTAINE', 1.33, 485),
('10568', '96p 24X32 gds carreaux 90g CLAIRFONTAINE', 1.68, 486),
('11256', 'Jeu 6 Intercalaires CARTE LUSTREE 220g A4', 0.79, 492),
('11262', 'Jeu 12 Intercalaires CARTE LUSTREE 220g A4', 0.75, 492),
('11462', 'B�ton Colle UHU  8,2g', 0.66, 481),
('11500', '50 Copies Doubles A4 perfor�es 5x5 petits carreaux 70g CALLIGRAPHE ', 1.25, 492),
('11685', 'Boite 12 crayons papier BIC EVOLUTION HB ', 1.09, 480),
('11686', 'Boite M�tal 12 crayons couleur BIC EVOLUTION', 3.34, 482),
('11688', 'Etui 12 crayons couleur BIC EVOLUTION', 2.43, 482),
('12793', 'BESCHERELLE Conjugaison', 8.30, 496),
('13336', 'Blister 160 Oeillets MAJUSCULE', 0.42, 493),
('13528', '50 Feuillets Mobiles A4 gds carreaux 90g CALLIGRAPHE', 0.85, 492),
('13534', '50 Feuillets Mobiles A4 5x5 petits carreaux 90g CALLIGRAPHE', 0.85, 492),
('15838', 'Ramette 500 Feuilles A4 80g Blanc CLAIREFONTAINE ALFA', 4.97, 493),
('15972', 'Bloc 20 feuilles dessin blanc 120g 21x29,7cm', 1.39, 495),
('16348', 'Boite 10 tubes 10ml GOUACHE MAJUSCULE coul. ass.', 2.75, 494),
('16349', 'Boite 5 tubes 10ml GOUACHE MAJUSCULE coul. ass.', 1.74, 494),
('16694', 'Brosse Plate N�8', 0.27, 494),
('20302', 'Stylo Plume Paper Mate', 3.81, 476),
('30176', 'Palette Rectangulaire Plastique 10 godets', 1.69, 494),
('31865', 'Paquet 28 Etiquettes de cahiers adh�sives MAJUSCULE', 0.38, 493),
('32368', 'Sous-Mains PVC 40X53cm  NOIR', 5.95, 493),
('32371', 'Sous-Mains PVC 40X53cm VERT', 5.95, 493),
('33146', 'Jeu 6 Intercalaires CARTE LUSTREE 220g A4+ (24,2x29,7cm)', 0.64, 492),
('34466', 'BIC 4 couleurs Pointe Moyenne', 1.55, 475),
('35329', 'Gomme Plastique MAJUSCULE', 0.16, 481),
('37884', 'Sachet 50 Cartouches courtes Encre Bleue MAJUSCULE', 1.04, 476),
('38403', 'Paper Mate FLEXGrip Ultra Mine R�tractable BLEU', 1.25, 475),
('38404', 'Paper Mate FLEXGrip Ultra Mine  R�tractable  NOIR', 1.25, 475),
('42025', 'Chemise 3 rabats � Elastiques Couv Polypro Opaque BLEU', 0.88, 492),
('42026', 'Chemise 3 rabats � Elastiques Couv Polypro Opaque ROUGE', 0.88, 492),
('42027', 'Chemise 3 rabats � Elastiques Couv Polypro Opaque VERT', 0.88, 492),
('42028', 'Chemise 3 rabats � Elastiques Couv Polypro Opaque NOIR', 0.88, 492),
('42599', 'Stylo Plume ECOLIER', 1.94, 476),
('43001', 'Pochette 12 Feuilles DESSIN blanc 180g 21x29,7cm ', 1.81, 495),
('43002', 'Pochette 12 Feuilles DESSIN blanc 180g 24x32cm', 1.18, 495),
('43004', 'Pochette 12 Feuilles DESSIN blanc 224g 24x32cm', 2.73, 495),
('43005', 'Pochette 12 Feuilles Papier Millim�tr� A4 90g ', 0.90, 495),
('43007', 'Pochette 12 Feuilles CALQUE 90g 21x29,7cm', 2.07, 495),
('43008', 'Pochette 20 Feuilles CALQUE 90g 24X32cm', 3.70, 495),
('43011', 'Pochette 12 Feuilles DESSIN 160g 24X32cm Coul. VIVES', 3.30, 495),
('43012', 'Pochette 12 Feuilles DESSIN 160g 24X32cm Coul. PASTEL', 3.30, 495),
('43028', '100 Pochettes Perfor�es Aspect Lisse 5/100', 3.01, 492),
('43221', '300 Feuillets Mobiles A4 gds carreaux 80g MAJUSCULE', 3.29, 492),
('43222', '150 Copies Doubles perfor�es A4 gds carreaux 80g MAJUSCULE', 3.17, 492),
('47422', 'Dictionnaire ROBERT JUNIOR CE-CM', 16.90, 496),
('47788', '96p 21x29,7 5X5(petits carreaux)70g CONQUERANT', 0.58, 485),
('47791', '96p 24x32 5x5 petits carreaux 70g CONGUERANT', 0.67, 486),
('47792', '192p 17x22 gds carreaux 70g CONQUERANT', 1.25, 484),
('47795', '192p broch� 24X32 gds carreaux 70g CONQUERANT', 2.60, 486),
('47796', 'Cahier de Texte 124p gds carreaux 70g CONQUERANT', 1.13, 487),
('47797', 'Cahier de TP 48p (gds carreaux 70g+Dessin) 17X22cm', 0.31, 487),
('47799', 'Cahier de TP 96p (gds carreaux 70g+Dessin) 17X22cm', 0.49, 487),
('47810', '50 Copies Doubles A4 perfor�es gds carreaux 70g CALLIGRAPHE', 1.25, 492),
('47863', 'Petit R�pertoire  11x17cm', 0.83, 493),
('47926', 'Cahier de Brouillon 96p 17X22 gds carreaux CALLIGRAPHE', 0.27, 484),
('48508', 'Classeur 4 anneaux A4 Dos 4cm  Carton MARINE', 1.22, 492),
('48509', 'Classeur 4 anneaux A4 Dos 4cm  Carton NOIR', 1.22, 492),
('48510', 'Classeur 4 anneaux A4 Dos 4cm  Carton ROUGE', 1.22, 492),
('48511', 'Classeur 4 anneaux A4 Dos 4cm  Carton VERT', 1.22, 492),
('48655', 'Prot�ge-Documents 40vues  Couv Polypro Souple  NOIR', 0.97, 492),
('48656', 'Prot�ge-Documents  40vues  Couv Polypro Souple BLEU', 0.97, 492),
('48657', 'Prot�ge-Documents 60vues  Couv Polypro Souple  NOIR', 1.14, 492),
('48658', 'Prot�ge-Documents 60vues  Couv Polypro Souple  BLEU', 1.14, 492),
('48659', 'Prot�ge-Documents 80vues  Couv Polypro Souple  NOIR', 1.17, 492),
('48660', 'Prot�ge-Documents 80vues  Couv Polypro Souple  BLEU', 1.17, 492),
('51335', 'Prot�ge-Cahier A4 BLEU', 0.44, 490),
('51337', 'Prot�ge-Cahier A4 ROUGE', 0.44, 490),
('51338', 'Prot�ge-Cahier A4 VERT FEUILLE', 0.44, 490),
('51339', 'Prot�ge-Cahier A4 JAUNE', 0.44, 490),
('51340', 'Prot�ge-Cahier A4 VIOLET', 0.44, 490),
('51343', 'Prot�ge-Cahier 17X22 BLEU', 0.26, 489),
('51345', 'Prot�ge-Cahier 17X22 ROUGE', 0.26, 489),
('51347', 'Prot�ge-Cahier 17X22 JAUNE', 0.26, 489),
('51349', 'Prot�ge-Cahier 17X22 VIOLET', 0.26, 489),
('51350', 'Prot�ge-Cahier 17X22 ROSE', 0.26, 489),
('51480', 'Agenda Journalier Sept 2012/Sept 2013 12X17cm', 5.08, 487),
('534756-2', 'Taille-Crayon MAPED Igloo', 0.77, 481),
('53968', 'Prot�ge-Cahier 24X32 BLEU', 1.00, 491),
('53970', 'Prot�ge-Cahier 24X32 ROUGE', 1.00, 491),
('53971', 'Prot�ge-Cahier 24X32 VERT FEUILLE', 1.00, 491),
('53972', 'Prot�ge-Cahier 24X32 JAUNE', 1.00, 491),
('54931', 'Mini Brosse pour Ardoise Effa�able', 2.34, 493),
('55906', 'Chemise 3 rabats � Elastiques Couv Polypro Opaque  JAUNE', 0.88, 492),
('56487', 'Prot�ge-Cahier A4 BLEU CIEL', 0.40, 490),
('56490', 'Prot�ge-Cahier A4 VERT CLAIR', 0.40, 490),
('56497', 'Prot�ge-Cahier 24X32 BLEU CIEL', 0.91, 491),
('56500', 'Prot�ge-Cahier 24X32 VERT CLAIR', 0.91, 491),
('56507', 'Prot�ge-Cahier 17X22 NOIR', 0.26, 489),
('56508', 'Prot�ge-Cahier A4 ORANGE', 0.44, 490),
('56509', 'Prot�ge-Cahier 24x32 ORANGE', 1.00, 491),
('56511', 'Prot�ge-Cahier 24X32 VIOLET', 1.00, 491),
('56858', 'Pinceau PONEY N�6', 0.20, 494),
('56860', 'Pinceau PONEY N�10', 0.23, 494),
('56861', 'Pinceau PONEY N�12', 0.25, 494),
('58084', 'Compas STUDY � bague avec Crayon', 0.88, 481),
('58211', 'Feutre moyen 1mm MBudget', 0.22, 477),
('58700', '50 Pochettes Perfor�es Aspect Lisse  5/100 (fines)', 1.70, 492),
('59298', 'Surligneur (de poche) Encre Liquide JAUNE', 1.20, 478),
('60825', 'Compas � mines MAPED STOP SYSTEM', 1.61, 481),
('61331', 'Rouleau adh�sif transparent MBudget (pour d�vidoir ci-dessus)', 0.27, 481),
('61484', 'Prot�ge-Documents 40 vues CHROMALINE Couv.Semi-rigide coul.ass ', 2.02, 492),
('61485', 'Prot�ge-Documents 60 vues CHROMALINE Couv.Semi-rigide coul.ass ', 2.57, 492),
('61486', 'Prot�ge-Documents 80 vues CHROMALINE Couv.Semi-rigide coul.ass ', 2.22, 492),
('62290', 'Classeur � levier plastique A4 Dos 8cm BLANC', 1.72, 492),
('63036', 'Chemise 3 rabats Carton � Elastiques BLEU', 0.65, 492),
('63037', 'Chemise 3 rabats Carton � Elastiques NOIR', 0.65, 492),
('63038', 'Chemise 3 rabats Carton � Elastiques ROUGE', 0.65, 492),
('63039', 'Chemise 3 rabats Carton � Elastiques VERT', 0.65, 492),
('63040', 'Chemise 3 rabats Carton � Elastiques HAVANE', 0.65, 492),
('63042', 'Chemise 3 rabats Carton � Elastiques LILAS', 0.65, 492),
('63043', 'Chemise 3 rabats Carton � Elastiques BLEU AZUR', 0.65, 492),
('63044', 'Chemise 3 rabats Carton � Elastiques JAUNE', 0.65, 492),
('63046', 'Chemise 3 rabats Carton � Elastiques ANIS', 0.65, 492),
('63618', 'D�vidoir Plastique Translucide VIDE (pour rouleau ci-dessous)', 0.35, 481),
('64156', '100 Pochettes Perfor�es Aspect Lisse 9/100', 6.22, 492),
('64159', '50 Pochettes Perfor�es Aspect Lisse  9/100   (�paisses)  ', 4.47, 492),
('64161', '48p 17X22 gds carreaux 90g MAJUSCULE', 0.25, 484),
('64163', '96p 17X22 gds carreaux 90g MAJUSCULE', 0.42, 484),
('64164', '96p 21x29,7 gds carreaux 90g MAJUSCULE', 0.78, 485),
('64165', '96p 24X32 gds carreaux 90g MAJUSCULE', 0.92, 486),
('64199', 'Classeur � levier plastique A4 Dos 8cm BLEU', 1.72, 492),
('64200', 'Classeur � levier plastique A4 Dos 8cm NOIR', 1.72, 492),
('64201', 'Classeur � levier plastique A4 Dos 8cm ROUGE', 1.72, 492),
('64202', 'Classeur � levier Plastique A4 Dos 8cm VERT', 1.72, 492),
('64203', 'Classeur � levier Plastique A4 Dos 8cm JAUNE', 1.72, 492),
('64534', 'Roller de Correction M BUSINESS 5mmx8m', 0.57, 476),
('65014', 'Rouleau Plastique Adh�sif 2X0,60m', 2.28, 493),
('65053', 'Tablier � manches 6-9 ans BLEU ', 4.60, 494),
('65095', 'Rouleau Plast Cristal lisse 10/100 tr�s r�sistant  5X0,7m', 2.46, 493),
('65383', 'Roller Effa�able PILOT FRIXION BLEU', 1.74, 477),
('65384', 'Roller Effa�able  PILOT FRIXION NOIR', 1.74, 477),
('65385', 'Roller Effa�able PILOT FRIXION ROUGE', 1.74, 477),
('65386', 'Roller Effa�able PILOT FRIXION VERT', 1.74, 477),
('67671', 'Feutre fin 0,3mm Softliner Mbusiness', 0.26, 477),
('68242', '48p 17X22 gds carreaux Couverture Polypro BLEU', 0.36, 484),
('68243', '48p 17X22 gds carreaux Couverture Polypro ROUGE', 0.36, 484),
('68244', '48p 17X22 gds carreaux Couverture Polypro VERT', 0.36, 484),
('68245', '48p 17X22 gds carreaux Couverture Polypro JAUNE', 0.36, 484),
('68250', 'Ardoise Effa�able � sec Uni/Sey�s 19X26cm', 1.06, 493),
('68253', '96p 17X22 gds carreaux Couverture Polypro BLEU', 0.53, 484),
('68254', '96p 17X22 gds carreaux Couverture Polypro ROUGE', 0.53, 484),
('68255', '96p 17X22 gds carreaux Couverture Polypro VERT', 0.53, 484),
('68256', '96p 17X22 gds carreaux Couverture Polypro JAUNE', 0.53, 484),
('68257', '96p 21x29,7 gds carreaux Couverture Polypro BLEU', 0.90, 485),
('68258', '96p 21x29,7 gds carreaux Couverture Polypro ROUGE', 0.90, 485),
('68259', '96p 21x29,7 gds carreaux Couverture Polypro VERT', 0.90, 485),
('68260', '96p 21x29,7 gds carreaux Couverture Polypro JAUNE', 0.90, 485),
('68261', '96p 24x32 gds carreaux Couverture Polypro  BLEU', 1.06, 486),
('68262', '96p 24x32 gds carreaux Couverture Polypro ROUGE', 1.06, 486),
('68263', '96p 24x32 gds carreaux Couverture Polypro VERT', 1.06, 486),
('68264', '96p 24x32 gds carreaux Couverture Polypro JAUNE', 1.06, 486),
('68381', 'Classeur A4 Couv.Polypro semi-rigideTranslucide Dos 2cm coul.assorties', 1.46, 492),
('68382', 'Classeur A4 Couv.Polypro semi-rigideTranslucide Dos 4cm coul assorties', 1.94, 492),
('68705', 'Etui 12 Feutres KID COULEUR BIC', 3.20, 482),
('68907', 'Classeur 4 anneaux A4 Couv.Polypro semi-rigide Dos 4cm BLEU', 1.60, 492),
('68908', 'Classeur 4 anneaux A4 Couv.Polypro semi-rigide Dos 4cm NOIR', 1.60, 492),
('68909', 'Classeur 4 anneaux A4 Couv.Polypro semi-rigide Dos 4cm ROUGE', 1.60, 492),
('68910', 'Classeur 4 anneaux A4 Couv.Polypro semi-rigide Dos 4cm VERT', 1.60, 492),
('68911', 'Classeur 4 anneaux A4 Couv.Polypro semi-rigide Dos 4cm JAUNE', 1.60, 492),
('70086', 'Mines pour compas: 2 blisters de 6 mines + taille-mine', 1.00, 481),
('70210', 'Prot�ge-Documents 40vues Couv Polypro Souple ROUGE', 0.97, 492),
('70211', 'Prot�ge-Documents 40vues Couv Polypro Souple VERT', 0.97, 492),
('70212', 'Prot�ge-Documents 60 vues Couv Polypro Souple ROUGE', 1.14, 492),
('70213', 'Prot�ge-Documents 60vues Couv Polypro Souple VERT', 1.14, 492),
('70214', 'Prot�ge-Documents 80 vues Couv Polypro Souple ROUGE', 1.17, 492),
('70215', 'Prot�ge-Documents 80vues Couv Polypro Souple VERT', 1.17, 492),
('70345', 'Paper Mate FLEXGrip Ultra Mine R�tractable  ROUGE', 1.25, 475),
('70346', 'Paper Mate FLEXGrip Ultra Mine R�tractable VERT', 1.25, 475),
('70456', 'Chemise 3 rabats Carton � Elastiques BLEU NUIT', 0.65, 492),
('70487', 'Pochette 4 Surligneurs couleurs assorties', 1.60, 478),
('71799', 'Calculatrice TI-COLLEGE PLUS', 16.35, 496),
('71966', 'B�ton Colle 8g STICK PERFECT (3M)', 0.20, 481),
('72073', 'Cahier de Texte 148p Couverture Polypro  90g OXFORD', 2.41, 487),
('72198', '96p 17X22 gds carreaux Couverture Polypro VIOLET', 0.53, 484),
('72199', '96p 17X22 gds carreaux Couverture Polypro ORANGE', 0.53, 484),
('72200', '48p 17X22 gds carreaux Couverture Polypro VIOLET', 0.36, 484),
('72201', '48p 17X22 gds carreaux Couverture Polypro ORANGE', 0.36, 484),
('72526', 'Double D�cim�tre incassable MAPED (souple et mall�able)', 0.42, 481),
('72527', 'Triple D�cim�tre incassable MAPED (souple et mall�able)', 0.64, 481),
('72528', 'R�gle Plate 30cm incassable MAPED (souple et mall�able)', 0.51, 481),
('72539', 'Etui 12 Feutres  GIOTTO COLOR', 1.62, 482),
('73034', 'Calculatrice FX 92 CASIO COLLEGE', 18.80, 496),
('74594', 'Paquet 10 Buvards 16X21cm 125g Coul Ass', 1.53, 493),
('74676', 'Etui 3 recharges FRIXION BLEU', 3.45, 477),
('74677', 'Etui 3 recharges FRIXION NOIR', 3.45, 477),
('74678', 'Etui 3 recharges FRIXION ROUGE', 3.45, 477),
('74680', 'Etui 3 recharges FRIXION VERT', 3.45, 477),
('74840', 'Tube Colle Gel 30ml MAJUSCULE', 0.55, 481),
('74849', 'Chemise 3 rabats � Elastiques Couv Polypro Opaque  VIOLET', 0.88, 492),
('74850', 'Chemise 3 rabats � Elastiques Couv Polypro Opaque  BORDEAUX', 0.88, 492),
('74851', 'Chemise 3 rabats � Elastiques Couv Polypro Opaque  GRIS', 0.88, 492),
('76569', 'Etui 12 crayons couleur GIOTTO STILNOVO', 1.43, 482),
('78324', 'R�gle Plate 30cm MAPED (plastique rigide)', 0.22, 481),
('78567', 'Boite 12 crayons papier Graphite MAJUSCULE HB', 1.33, 480),
('79576', 'Lot 5 b�tons Colle SCOTCH 8g', 3.43, 481),
('79821', 'Equerre 60� 21cm incassable MAPED', 0.51, 481),
('79822', 'Equerre 45� 21cm incassable MAPED', 0.51, 481),
('79846', 'Double D�cim�tre  MAPED (plastique rigide)', 0.14, 481),
('79851', '48p 17X22 gds carreaux Couverture Polypro INCOLORE', 0.36, 484),
('79852', '48p 17X22 gds carreaux Couverture Polypro GRIS', 0.36, 484),
('79853', '96p 17X22 gds carreaux Couverture Polypro INCOLORE', 0.53, 484),
('79854', '96p 17X22 gds carreaux Couverture Polypro GRIS', 0.53, 484),
('79855', '96p 24x32 gds carreaux Couverture Polypro VIOLET', 1.06, 486),
('79856', '96p 24x32 gds carreaux Couverture Polypro ORANGE', 1.06, 486),
('79857', '96p 24x32 gds carreaux Couverture Polypro INCOLORE', 1.06, 486),
('79858', '96p 24x32 gds carreaux Couverture Polypro GRIS', 1.06, 486),
('80351', 'Stylo Plume Sp�cial GAUCHER Bleu', 3.45, 476),
('81060', 'Ciseaux MAJUSCULE bouts ronds anneaux bicolores', 0.75, 481),
('81580', 'Triple D�cim�tre   MAPED (plastique rigide)', 0.29, 481),
('81597', '96p 21X29,7 5X5(petits carreaux) 90g Couverture Polypro Incolore', 0.83, 485),
('81598', '96p 24x32 5x5 petits carreaux 90g Couverture Polypro Incolore', 1.06, 486),
('82897', 'Classeur 4 anneaux A4 Dos 4cm  Carton JAUNE', 1.22, 492),
('83083', 'Compas 3 pi�ces (compas+ mine + bague pour crayon )', 1.43, 481),
('83202', '96p  21x29,7 gds carreaux Couverture Polypro VIOLET', 0.90, 485),
('83203', '96p  21x29,7 gds carreaux Couverture Polypro ORANGE', 0.90, 485),
('83204', '96p  21x29,7 gds carreaux Couverture Polypro GRIS', 0.90, 485),
('83205', '96p  21x29,7 gds carreaux Couverture Polypro INCOLORE', 0.90, 485);

INSERT INTO Date_limite (jma) VALUES
('2015-08-31');