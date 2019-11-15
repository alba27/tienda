create database tienda;
create user tienda identified by 'tienda';
use tienda;
grant all on tienda.* to tienda;



--
CREATE TABLE producto (
  id int primary key not null,
  nombre VARCHAR(75),
  precio float not null
) engine =innodb;

INSERT INTO producto VALUES (1,'Vestido',34.99);
INSERT INTO producto VALUES (2,'Cardigan',24.99);
INSERT INTO producto VALUES (3,'Vestido nina',12.95);
INSERT INTO producto VALUES (4,'Botines',49.99);
INSERT INTO producto VALUES (5,'Collar',8.99);
--



--
CREATE TABLE usuario (
  dni char(9) primary key not null,
  email VARCHAR(75) not null,
  contrasena VARCHAR(40) not null
) engine =innodb;

INSERT INTO usuario VALUES ('81878163A','uno@uno.es','12345678');
INSERT INTO usuario VALUES ('91782240G','dos@dos.es','98765432');
INSERT INTO usuario VALUES ('69728026F','tres@tres.es','012349876');
--



--
CREATE TABLE compra (
  id_compra int primary key auto_increment, 
  id_producto varchar(20) not null, 
  dni_usuario char(9) not null,
  cantidad numeric(7) not null,
  precio numeric(7,2) not null,
  fecha date not null 
) engine =innodb;






--auto_increment
