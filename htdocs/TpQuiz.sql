CREATE TABLE users (
  id INT PRIMARY KEY,
  pseudo VARCHAR(255),
  answered_questions_ids INT
);

CREATE TABLE questions (
  id INT PRIMARY KEY,
  title VARCHAR(255),
  option1 TEXT,
  option2 TEXT,
  option3 TEXT,
  option4 TEXT,
  goodAnswer TEXT,
  FOREIGN KEY (user_id) REFERENCES users(id)
);





CREATE TABLE score (
  id INT PRIMARY KEY,
  user_id INT,
  score INT,
  FOREIGN KEY (user_id) REFERENCES users(id)
);






