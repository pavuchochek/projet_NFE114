CREATE TABLE IF NOT EXISTS salle(
   id_salle INT AUTO_INCREMENT,
   nom VARCHAR(50) NOT NULL,
   capacite_max SMALLINT NOT NULL,
   PRIMARY KEY(id_salle)
);

CREATE TABLE IF NOT EXISTS coach(
   id_coach INT AUTO_INCREMENT,
   nom VARCHAR(50) NOT NULL,
   prenom VARCHAR(50) NOT NULL,
   telephone CHAR(10) NOT NULL,
   mail VARCHAR(50) NOT NULL,
   ddn DATE,
   prix_heure DECIMAL(15,2),
   mdp VARCHAR(300) NOT NULL,
   PRIMARY KEY(id_coach),
   UNIQUE(mail)
);

CREATE TABLE IF NOT EXISTS adherent(
   id_adherent INT AUTO_INCREMENT,
   nom VARCHAR(50) NOT NULL,
   prenom VARCHAR(50) NOT NULL,
   mail VARCHAR(50) NOT NULL,
   telephone CHAR(10) NOT NULL,
   ddn DATE,
   mdp VARCHAR(300) NOT NULL,
   date_adherence DATE NOT NULL,
   PRIMARY KEY(id_adherent),
   UNIQUE(mail)
);

CREATE TABLE IF NOT EXISTS cours(
   id_cours INT AUTO_INCREMENT,
   nom VARCHAR(100) NOT NULL,
   description VARCHAR(200),
   type VARCHAR(100),
   date_cours DATETIME NOT NULL,
   duree DECIMAL(15,2) NOT NULL,
   capacite_max SMALLINT NOT NULL,
   id_salle INT NOT NULL,
   id_coach INT NOT NULL,
   PRIMARY KEY(id_cours),
   FOREIGN KEY(id_salle) REFERENCES salle(id_salle),
   FOREIGN KEY(id_coach) REFERENCES coach(id_coach)
);

CREATE TABLE IF NOT EXISTS participe(
   id_adherent INT,
   id_cours INT,
   date_reservation DATETIME,
   statut VARCHAR(50),
   PRIMARY KEY(id_adherent, id_cours),
   FOREIGN KEY(id_adherent) REFERENCES adherent(id_adherent),
   FOREIGN KEY(id_cours) REFERENCES cours(id_cours)
);


TRUNCATE TABLE salle;
TRUNCATE TABLE coach;
TRUNCATE TABLE adherent;
TRUNCATE TABLE cours;
TRUNCATE TABLE participe;


INSERT INTO salle (nom, capacite_max) VALUES
('Salle Zen', 20),
('Salle Cardio', 30);

INSERT INTO coach (nom, prenom, telephone, mail, ddn, prix_heure, mdp) VALUES
('Durand', 'Luc', '0612345678', 'luc.durand@fitbooking.fr', '1985-04-12', 45.00,
 '$2y$10$Xfr.tgN6.MInIlNlXwavtebVnltcmVeNY6zwVhdhyf8sbiHWVLmJi'),
('Martin', 'Sophie', '0698765432', 'sophie.martin@fitbooking.fr', '1990-09-25', 50.00,
 '$2y$10$Xfr.tgN6.MInIlNlXwavtebVnltcmVeNY6zwVhdhyf8sbiHWVLmJi');


INSERT INTO adherent (nom, prenom, mail, telephone, ddn, mdp, date_adherence) VALUES
('Lefevre', 'Paul', 'paul.lefevre@mail.com', '0600000001', '1998-06-10',
 '$2y$10$Xfr.tgN6.MInIlNlXwavtebVnltcmVeNY6zwVhdhyf8sbiHWVLmJi', '2024-01-10'),

('Bernard', 'Emma', 'emma.bernard@mail.com', '0600000002', '1995-03-18',
 '$2y$10$Xfr.tgN6.MInIlNlXwavtebVnltcmVeNY6zwVhdhyf8sbiHWVLmJi', '2024-02-05'),

('Moreau', 'Lucas', 'lucas.moreau@mail.com', '0600000003', '2000-11-02',
 '$2y$10$Xfr.tgN6.MInIlNlXwavtebVnltcmVeNY6zwVhdhyf8sbiHWVLmJi', '2024-02-20');

INSERT INTO cours (nom, description, type, date_cours, duree, capacite_max, id_salle, id_coach) VALUES
('Yoga détente', 'Séance de yoga pour relaxation et souplesse',
 'Yoga', '2026-03-01 18:00:00', 1.30, 15, 1, 1),

('Cardio training', 'Entraînement cardio intensif',
 'Cardio', '2026-03-02 19:00:00', 1.00, 25, 2, 2);


INSERT INTO participe (id_adherent, id_cours, date_reservation, statut) VALUES
(1, 1, NOW(), 'reserve');
