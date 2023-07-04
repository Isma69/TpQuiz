CREATE TABLE questions (
  id INT PRIMARY KEY,
  title VARCHAR(255),
  content TEXT,
  creation_date DATE,
  user_id INT,
  FOREIGN KEY (user_id) REFERENCES users (id)
);


CREATE TABLE users (
  id INT PRIMARY KEY,
  pseudo VARCHAR(255),
);



CREATE TABLE score (
  id INT PRIMARY KEY,
  user_id INT,
  score INT,
  FOREIGN KEY (user_id) REFERENCES users(id)
);






