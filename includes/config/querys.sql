CREATE DATABASE IF NOT EXISTS alquiler ;

DROP DATABASE IF EXISTS alquiler ;
 
CREATE TABLE users (
  id INTEGER AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(30),
  last_name VARCHAR(30),
  email VARCHAR(60) UNIQUE KEY,
  password VARCHAR(60),
  is_admin BOOLEAN,
  token VARCHAR(60),
  confirm BOOLEAN
);

DROP TABLE  IF EXISTS users ; 

INSERT INTO users (name, last_name, email, password, is_admin, token, confirm)
VALUES
('fiorela', 'torres', 'fiorela@gmail.com', '123456', 0,'123', 1),
('pedro', 'torres', 'pedro1@gmail.com', '123456', 0,'123', 1),
('diana', 'torres', 'diana@gmail.com', '123456', 0,'123', 1),
('luis', 'torres', 'luis@gmail.com', '123456', 0,'123', 1),
('gabriela', 'torres', 'gabriela@gmail.com', '123456', 0,'123', 1),
('diego', 'torres', 'diego@gmail.com', '123456', 0,'123', 1),
('rocio', 'torres', 'rocio@gmail.com', '123456', 0,'123', 1),
('pepe', 'torres', 'pepe@gmail.com', '123456', 0,'123', 1),




CREATE TABLE districts (
  id INTEGER AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(30)
);

DROP TABLE  IF EXISTS districts ; 

INSERT INTO districts (name) 
VALUES('miraflores'),
('surco'),
('la molina'),
('chorrillos'),
('san borja'),
('sjm');




CREATE TABLE branches (
  id INTEGER AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(30),
  address VARCHAR(100),
  district_id INTEGER ,
  image VARCHAR(255),

  -- aunque explicitamente no le digas al sistema que es una restriccion
  -- de forma predeterminada las claves foraneas se toman como restriccion
  CONSTRAINT district_id_fk -- esto es un alias para identificar la restriccion
  FOREIGN KEY (district_id) REFERENCES  districts (id)
  ON DELETE SET NULL
  ON UPDATE CASCADE

);

DROP TABLE  IF EXISTS branches ; 

INSERT INTO branches (name, address, district_id, image) 
VALUES ('valle hermoso', 'av 2 jiron 2',1, 'image.webp' ),
('chacarilla', 'av 2 jiron 2',2, 'image.webp' ),
('gamarra 1', 'av 2 jiron 2',3, 'image.webp' ),
('open atocongo', 'av 2 jiron 2',4, 'image.webp' ),
('mall del sur', 'av 2 jiron 2',5, 'image.webp' ),
('plaza vea bolichera', 'av 2 jiron 2',6, 'image.webp' );



CREATE TABLE types (
  id INTEGER AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(10)
);


DROP TABLE  IF EXISTS types ; 

INSERT INTO types (name)
VALUES('futbol'),
('voley'), 
('basquet'), 
('tenis'); 




CREATE TABLE fields (
  id INTEGER AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(60),
  rental_price DECIMAL(10,2),
  branch_id INTEGER,
  type_id INTEGER,
  image VARCHAR(255),
  opening_hours TIME,
  closing_time TIME,
  
  CONSTRAINT branch_id_fk 
  FOREIGN KEY (branch_id) REFERENCES branches(id)
  ON DELETE SET NULL 
  ON UPDATE CASCADE,

  CONSTRAINT type_id_fk 
  FOREIGN KEY (type_id) REFERENCES types(id)
  ON DELETE SET NULL 
  ON UPDATE CASCADE
);

DROP TABLE  IF EXISTS fields ; 


INSERT INTO fields (name, rental_price, branch_id, type_id, image, opening_hours, closing_time)
VALUES('signal iduna park', 260, 1, 1, 'image.webp', '07:00', '23:00'),
('santiago bernabeun', 260, 2, 1, 'image.webp', '07:00', '23:00'),
('juventus stadium', 260, 3, 1, 'image.webp', '07:00', '23:00'),
('anfield', 260, 4, 1, 'image.webp', '07:00', '23:00'),
('old traford', 260, 2, 1, 'image.webp', '07:00', '23:00');





CREATE TABLE reservations (
  id INTEGER AUTO_INCREMENT PRIMARY KEY,
  user_id INTEGER,
  field_id INTEGER,
  -- total pay se puede calcular trayendo el campo rental_price de fields
  -- y multiplicandolo por rental_time
  total_pay DECIMAL(10,2),
  rental_time TINYINT,
  start_time TIME,
  rental_date DATE,

  CONSTRAINT user_id_fk 
  FOREIGN KEY (user_id) REFERENCES users(id)
  ON DELETE SET NULL 
  ON UPDATE CASCADE,

  CONSTRAINT field_id_fk 
  FOREIGN KEY (field_id) REFERENCES fields(id)
  ON DELETE SET NULL 
  ON UPDATE CASCADE
);

DROP TABLE  IF EXISTS reservations ;


INSERT INTO reservations (user_id, field_id, total_pay, rental_time,start_time, rental_date)
VALUES(1, 1, 250, 3, '10:00', '2025-02-27') ,
(1, 1, 250, 3, '07:00', '2025-02-28') ,
(1, 1, 250, 3, '10:00', '2025-02-28') ;


SELECT reservations.*, fields.name, fields.rental_price,
(reservations.rental_time*fields.rental_price) AS NUEVO_TOTAL 
FROM reservations 
INNER JOIN fields 
ON reservations.field_id = fields.id



