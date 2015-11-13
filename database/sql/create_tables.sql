CREATE TABLE users(
  id SERIAL PRIMARY KEY,
  first_name varchar(255) NOT NULL,
  last_name varchar(255) NOT NULL,
  email varchar(255) NOT NULL UNIQUE,
  remember_token varchar(100),
  created_at TIMESTAMP NOT NULL,
  updated_at TIMESTAMP
);

CREATE TABLE guides(
  id SERIAL PRIMARY KEY,
  title varchar(100) NOT NULL UNIQUE,
  description varchar(255) NOT NULL,
  created_at TIMESTAMP NOT NULL,
  updated_at TIMESTAMP,
  
  user_id int,

  CONSTRAINT guides_user_id_foreign FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE comments(
  id SERIAL PRIMARY KEY,
  content varchar NOT NULL,
  created_at TIMESTAMP NOT NULL,
  updated_at TIMESTAMP,
  
  user_id int,
  guide_id int,
  
  CONSTRAINT comments_user_id_foreign FOREIGN KEY (user_id) REFERENCES users(id),
  CONSTRAINT comments_guide_id_foreign FOREIGN KEY (guide_id) REFERENCES guides(id)
);

CREATE TABLE contributions(
  id SERIAL PRIMARY KEY,
  title varchar(100) NOT NULL UNIQUE,
  description varchar(255) NOT NULL,
  created_at TIMESTAMP NOT NULL,
  updated_at TIMESTAMP,
  
  user_id int,
  guide_id int,

  CONSTRAINT contributions_user_id_foreign FOREIGN KEY (user_id) REFERENCES users(id),
  CONSTRAINT contributions_guide_id_foreign FOREIGN KEY (guide_id) REFERENCES guides(id),
);

CREATE TABLE steps(
  id SERIAL PRIMARY KEY,
  title varchar(100) NOT NULL UNIQUE,
  content varchar(255) NOT NULL,
  image varchar(255),
  created_at TIMESTAMP NOT NULL,
  updated_at TIMESTAMP,
  
  user_id int,
  guide_id int,

  CONSTRAINT steps_user_id_foreign FOREIGN KEY (user_id) REFERENCES users(id),
  CONSTRAINT steps_guide_id_foreign FOREIGN KEY (guide_id) REFERENCES guides(id)
);

CREATE TABLE step_contributions(
  id SERIAL PRIMARY KEY,
  title varchar(100) NOT NULL UNIQUE,
  content varchar(255) NOT NULL,
  image varchar(255),
  created_at TIMESTAMP NOT NULL,
  updated_at TIMESTAMP,
  
  user_id int,
  step_id int,
  
  PRIMARY KEY (ID)
  CONSTRAINT step_contributions_user_id_foreign FOREIGN KEY (user_id) REFERENCES users(id),
  CONSTRAINT step_contributions_step_id_foreign FOREIGN KEY (step_id) REFERENCES steps(id)
);

CREATE TABLE tips(
  id SERIAL PRIMARY KEY,
  content varchar(255) NOT NULL,
  created_at TIMESTAMP NOT NULL,
  updated_at TIMESTAMP,
  
  user_id int,
  guide_id int

  CONSTRAINT tips_user_id_foreign FOREIGN KEY (user_id) REFERENCES users(id),
  CONSTRAINT tips_guide_id_foreign FOREIGN KEY (guide_id) REFERENCES guides(id)
);

CREATE TABLE source_citations(
  id SERIAL PRIMARY KEY,
  text varchar(255) NOT NULL,
  link varchar(255) NOT NULL,
  created_at TIMESTAMP NOT NULL,
  updated_at TIMESTAMP,
  
  user_id int,
  guide_id int,
  
  PRIMARY KEY (ID)
  CONSTRAINT source_citations_user_id_foreign FOREIGN KEY (user_id) REFERENCES users(id),
  CONSTRAINT source_citations_guide_id_foreign FOREIGN KEY (guide_id) REFERENCES guides(id)
);