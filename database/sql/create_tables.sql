CREATE TABLE users(
  id int NOT NULL AUTO_INCREMENT,
  first_name varchar(255) NOT NULL,
  last_name varchar(255) NOT NULL,
  email varchar(255) NOT NULL UNIQUE,
  remember_token varchar(100),
  created_at TIMESTAMP NOT NULL,
  updated_at TIMESTAMP,
  PRIMARY KEY (ID)
);

CREATE TABLE guides(
  id int NOT NULL AUTO_INCREMENT,
  title varchar(100) NOT NULL UNIQUE,
  description varchar(255) NOT NULL,
  created_at TIMESTAMP NOT NULL,
  updated_at TIMESTAMP,
  
  user_id int NOT NULL UNSIGNED,
  
  PRIMARY KEY (ID)
  #FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE comments(
  id int NOT NULL AUTO_INCREMENT,
  content varchar NOT NULL,
  created_at TIMESTAMP NOT NULL,
  updated_at TIMESTAMP,
  
  user_id int UNSIGNED,
  guide_id int UNSIGNED,
  
  PRIMARY KEY (ID)
  #FOREIGN KEY (user_id) REFERENCES users(id),
  #FOREIGN KEY (guide_id) REFERENCES guides(id)
);

CREATE TABLE contributions(
  id int NOT NULL AUTO_INCREMENT,
  title varchar(100) NOT NULL UNIQUE,
  description varchar(255) NOT NULL,
  created_at TIMESTAMP NOT NULL,
  updated_at TIMESTAMP,
  
  user_id int UNSIGNED,
  guide_id int UNSIGNED,
  
  PRIMARY KEY (ID)
  #FOREIGN KEY (user_id) REFERENCES users(id),
  #FOREIGN KEY (guide_id) REFERENCES guides(id)
);

CREATE TABLE steps(
  id int NOT NULL AUTO_INCREMENT,
  title varchar(100) NOT NULL UNIQUE,
  content varchar(255) NOT NULL,
  image varchar(255),
  created_at TIMESTAMP NOT NULL,
  updated_at TIMESTAMP,
  
  user_id int UNSIGNED,
  guide_id int UNSIGNED,
  
  PRIMARY KEY (ID)
  #FOREIGN KEY (user_id) REFERENCES users(id),
  #FOREIGN KEY (guide_id) REFERENCES guides(id)
);

CREATE TABLE step_contributions(
  id int NOT NULL AUTO_INCREMENT,
  title varchar(100) NOT NULL UNIQUE,
  content varchar(255) NOT NULL,
  image varchar(255),
  created_at TIMESTAMP NOT NULL,
  updated_at TIMESTAMP,
  
  user_id int UNSIGNED,
  step_id int UNSIGNED,
  
  PRIMARY KEY (ID)
  #FOREIGN KEY (user_id) REFERENCES users(id),
  #FOREIGN KEY (step_id) REFERENCES steps(id)
);

CREATE TABLE tips(
  id int NOT NULL AUTO_INCREMENT,
  content varchar(255) NOT NULL,
  created_at TIMESTAMP NOT NULL,
  updated_at TIMESTAMP,
  
  user_id int UNSIGNED,
  guide_id int UNSIGNED,
  
  PRIMARY KEY (ID)
  #FOREIGN KEY (user_id) REFERENCES users(id),
  #FOREIGN KEY (guide_id) REFERENCES guides(id)
);

CREATE TABLE source_citations(
  id int NOT NULL AUTO_INCREMENT,
  text varchar(255) NOT NULL,
  link varchar(255) NOT NULL,
  created_at TIMESTAMP NOT NULL,
  updated_at TIMESTAMP,
  
  user_id int UNSIGNED,
  guide_id int UNSIGNED,
  
  PRIMARY KEY (ID)
  #FOREIGN KEY (user_id) REFERENCES users(id),
  #FOREIGN KEY (guide_id) REFERENCES guides(id)
);