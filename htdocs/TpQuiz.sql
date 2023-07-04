CREATE TABLE questions (
  id INT PRIMARY KEY,
  titre VARCHAR(255),
  contenu TEXT,
  date_creation DATE,
  id_utilisateur INT,
  FOREIGN KEY (id_utilisateur) REFERENCES utilisateurs(id)
);


CREATE TABLE utilisateurs (
  id INT PRIMARY KEY,
  nom VARCHAR(255),
  email VARCHAR(255)
);



CREATE TABLE score (
  id INT PRIMARY KEY,
  id_utilisateur INT,
  score INT,
  FOREIGN KEY (id_utilisateur) REFERENCES utilisateurs(id)
);






