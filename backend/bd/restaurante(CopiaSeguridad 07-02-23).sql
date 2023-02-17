SET NAMES UTF8;
drop database if exists LuaChea;
create database if not exists LuaChea;
use LuaChea;

create table if not exists trabajador(
id_trabajador int auto_increment,
nie_trabajdor varchar(9) null,
pasaporte_trabajador varchar(12) null,
nombre varchar(40) not null,
apellido1 varchar(40) not null,
apellido2 varchar(40) null,
fecha date not null,
num_telef varchar(9) not null,
id_rol int not null,
contraseña varchar(255) not null unique,
constraint pk_idTrabajador primary key (id_trabajador)
);

create table if not exists usuario(
id_usuario int auto_increment,
nombre varchar(40) not null,
apellido1 varchar(40) not null,
apellido2 varchar(40) null,
correo varchar(40) not null unique,
fecha date not null,
num_telef varchar(9) not null,
id_rol int not null,
estado_usuario enum('activado','desactivado') not null default 'desactivado',
NIF varchar(9) not null unique,
direccion varchar(1000) null,
cp varchar(5) null,
contraseña varchar(255) not null unique,

constraint pk_idUsuario primary key (id_usuario)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

create table if not exists roles(
id_rol	int	auto_increment,
nombre_rol varchar (100) not null,

constraint pk_idRol primary key (id_rol)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

create table if not exists carta_comida(
id_comida int auto_increment,
nombre varchar(100) not null,
descripcion varchar(300) null,
tipo enum('entrantes','arroz','carne','cachopo','pescado','postre','bebida') not null,
subtipo enum('croquetas','ensaladas','mar','tierra', 'cachopoPollo', 'cachopoTJamon', 'cachopoTCecina') null,
cantidad int not null,
precio float not null,
disponible boolean not null,
img varchar(100) not null,
tipo_alergeno int not null,

constraint pk_id primary key (id_comida),
constraint ck_tipo check (tipo in ('entrantes','arroz','carne','cachopo','pescado','postre','bebida'))
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

create table if not exists alergenos(
id_alergeno	int	auto_increment,
nombre_alergeno varchar(100) not null,
descripcion varchar(100) not null,
img varchar(100) null,

constraint pk_idAlergeno primary key (id_alergeno)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

create table if not exists carta_alergenos(
id_alergeno int not null,
id_comida int not null
);

create table if not exists factura(
id_factura int auto_increment,
id_usuario int not null,
cif_empresa varchar(10) not null,
precio float not null,
fecha date not null,
id_comida int not null,
total int not null,
modo_pago enum('efectivo','tarjeta','otro modo') not null default 'efectivo',

constraint pk_id_factura primary key (id_factura),
constraint ck_pago check (modo_pago in ('efectivo','tarjeta','otro modo'))
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

create table if not exists empresa(
cif varchar(10) not null,
nombre varchar(120) not null,
nombre_sociedad varchar(120) not null,
direccion varchar(60) not null,
ciudad varchar(20) not null,
cp int null,
telefono int(9) not null,
logo varchar(100) not null,

constraint pk_cif primary key (cif)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

create table if not exists carrito (
id_carro int auto_increment,
id_usuario int not null,
id_comida int not null,
cantidad int not null,
constraint pk_id primary key (id_carro)
);

###########################################################################################
#FOREIGN KEYS
ALTER TABLE factura ADD FOREIGN KEY (id_usuario) REFERENCES usuario(id_usuario);
ALTER TABLE factura ADD FOREIGN KEY (cif_empresa) REFERENCES empresa(cif);

ALTER TABLE carrito ADD FOREIGN KEY (id_usuario) REFERENCES usuario(id_usuario);
ALTER TABLE carrito ADD FOREIGN KEY (id_comida) REFERENCES carta_comida(id_comida);

ALTER TABLE usuario ADD FOREIGN KEY (id_rol) REFERENCES roles(id_rol);

ALTER TABLE carta_alergenos ADD FOREIGN KEY (id_alergeno) REFERENCES alergenos(id_alergeno);
ALTER TABLE carta_alergenos ADD FOREIGN KEY (id_comida) REFERENCES carta_comida(id_comida);

#ALTER TABLE carro ADD CONSTRAINT FK_ArrayProducto FOREIGN KEY (array_producto) REFERENCES factura(producto);

###########################################################################################

###########################################################################################
#INSERT
INSERT INTO roles (nombre_rol) VALUES ('Administrador');
INSERT INTO roles (nombre_rol) VALUES ('Gestor');
INSERT INTO roles (nombre_rol) VALUES ('Trabajador');
INSERT INTO roles (nombre_rol) VALUES ('Registrado');
INSERT INTO roles (nombre_rol) VALUES ('Sin registrar');

INSERT INTO alergenos (nombre_alergeno) values ('ninguno');
INSERT INTO alergenos (nombre_alergeno, img) values ('altramuces', 'url');
INSERT INTO alergenos (nombre_alergeno, img) values ('apio', 'url');
INSERT INTO alergenos (nombre_alergeno, img) values ('cacahuete', 'url');
INSERT INTO alergenos (nombre_alergeno, img) values ('crustaceos', 'url');
INSERT INTO alergenos (nombre_alergeno, img) values ('huevo', 'url');
INSERT INTO alergenos (nombre_alergeno, img) values ('lacteos', 'url');
INSERT INTO alergenos (nombre_alergeno, img) values ('moluscos', 'url');
INSERT INTO alergenos (nombre_alergeno, img) values ('mostaza', 'url');
INSERT INTO alergenos (nombre_alergeno, img) values ('pescado', 'url');
INSERT INTO alergenos (nombre_alergeno, img) values ('soja', 'url');
INSERT INTO alergenos (nombre_alergeno, img) values ('sulfitos', 'url');
INSERT INTO alergenos (nombre_alergeno, img) values ('sesamo', 'url');
INSERT INTO alergenos (nombre_alergeno, img) values ('frutoscascara', 'url');
INSERT INTO alergenos (nombre_alergeno, img) values ('gluten', 'url');

INSERT INTO carta_alergenos (id_alergeno, id_comida) values (15,1);
INSERT INTO carta_alergenos (id_alergeno, id_comida) values (6,1);
INSERT INTO carta_alergenos (id_alergeno, id_comida) values (7,1);

#FALTA AGREGAR LOS CAMPOS DE ALERGENOS !!!!!!!!
INSERT INTO carta_comida (nombre, descripcion, tipo, subtipo, cantidad, precio, disponible, img) VALUES ('Surtido de Croquetas','Jamón, Cecina y Pulpo','entrantes', 'croquetas','1','13.50','1','url');
INSERT INTO carta_comida (nombre, tipo, subtipo, cantidad, precio, disponible, img) VALUES ('Pulpo','entrantes', 'croquetas','1','12.50','1','url');
INSERT INTO carta_comida (nombre, tipo, subtipo, cantidad, precio, disponible, img) VALUES ('Rulo de cabra y cebolla caramelizada','entrantes', 'croquetas','1','12.00','1','url');
INSERT INTO carta_comida (nombre, tipo, subtipo, cantidad, precio, disponible, img) VALUES ('Cecina y Queso San Simón','entrantes', 'croquetas','1','11.50','1','url');
INSERT INTO carta_comida (nombre, tipo, subtipo, cantidad, precio, disponible, img) VALUES ('Jamón','entrantes', 'croquetas','1','10.00','1','url');

INSERT INTO carta_comida (nombre, tipo, subtipo, cantidad, precio, disponible, img) VALUES ('Cesar con Pollo','entrantes', 'ensaladas','1','13.50','1','url');
INSERT INTO carta_comida (nombre, tipo, subtipo, cantidad, precio, disponible, img) VALUES ('Tomate, Ventresca y Anchoa','entrantes', 'ensaladas','1','12.50','1','url');
INSERT INTO carta_comida (nombre, descripcion, tipo, subtipo, cantidad, precio, disponible, img) VALUES ('Mixta LuaChea', 'Lechuga, Tomate, Cebolla, Esparrago, Pimiento asado, Huevo duro, Atún','entrantes', 'ensaladas','1','13.50','1','url');
INSERT INTO carta_comida (nombre, descripcion, tipo, subtipo, cantidad, precio, disponible, img) VALUES ('Simple', 'Lechuga, Tomate y Cebolla','entrantes', 'ensaladas','1','13.50','1','url');

INSERT INTO carta_comida (nombre, tipo, subtipo, cantidad, precio, disponible, img) VALUES ('Pulpo con Queso Tetilla','entrantes', 'mar','1','21.00','1','url');
INSERT INTO carta_comida (nombre, tipo, subtipo, cantidad, precio, disponible, img) VALUES ('Pulpo a feira','entrantes', 'mar','1','20.00','1','url');
INSERT INTO carta_comida (nombre, tipo, subtipo, cantidad, precio, disponible, img) VALUES ('Langostinos a la plancha','entrantes', 'mar','1','18.00','1','url');
INSERT INTO carta_comida (nombre, tipo, subtipo, cantidad, precio, disponible, img) VALUES ('Salteado de Chipirones con Trigueros y Champiñones','entrantes', 'mar','1','13.00','1','url');
INSERT INTO carta_comida (nombre, tipo, subtipo, cantidad, precio, disponible, img) VALUES ('Pastel de cabracho','entrantes', 'mar','1','12.00','1','url');
INSERT INTO carta_comida (nombre, tipo, subtipo, cantidad, precio, disponible, img) VALUES ('Calamares','entrantes', 'mar','1','11.50','1','url');
INSERT INTO carta_comida (nombre, tipo, subtipo, cantidad, precio, disponible, img) VALUES ('Mejillones a la vinagreta','entrantes', 'mar','1','8.50','1','url');
INSERT INTO carta_comida (nombre, tipo, subtipo, cantidad, precio, disponible, img) VALUES ('Mejillones al vapor','entrantes', 'mar','1','7.00','1','url');

INSERT INTO carta_comida (nombre, tipo, subtipo, cantidad, precio, disponible, img) VALUES ('Salteado de pulpo, setas y trigueros','entrantes', 'tierra','1','16.00','1','url');
INSERT INTO carta_comida (nombre, tipo, subtipo, cantidad, precio, disponible, img) VALUES ('Fabada','entrantes', 'tierra','1','15.00','1','url');
INSERT INTO carta_comida (nombre, tipo, subtipo, cantidad, precio, disponible, img) VALUES ('Involtini de berenjenas con Salsa Oporto','entrantes', 'tierra','1','13.50','1','url');
INSERT INTO carta_comida (nombre, tipo, subtipo, cantidad, precio, disponible, img) VALUES ('Setas rellenas de Cecina y Tetilla con Salsa Gorgonzola','entrantes', 'tierra','1','13.50','1','url');
INSERT INTO carta_comida (nombre, tipo, subtipo, cantidad, precio, disponible, img) VALUES ('Huevos rotos con salsa de Setas y Foie ','entrantes', 'tierra','1','12.50','1','url');
INSERT INTO carta_comida (nombre, tipo, subtipo, cantidad, precio, disponible, img) VALUES ('Parrillada de verduras con Queso de Cabra','entrantes', 'tierra','1','11.50','1','url');
INSERT INTO carta_comida (nombre, tipo, subtipo, cantidad, precio, disponible, img) VALUES ('Chicken Finger','entrantes', 'tierra','1','8.50','1','url');
INSERT INTO carta_comida (nombre, tipo, subtipo, cantidad, precio, disponible, img) VALUES ('Pimientos de Padrón','entrantes', 'tierra','1','6.00','1','url');
INSERT INTO carta_comida (nombre, tipo, subtipo, cantidad, precio, disponible, img) VALUES ('Pan (Por Persona)','entrantes', 'tierra','1','1.00','1','url');

INSERT INTO carta_comida (nombre, tipo, cantidad, precio, disponible, img) VALUES ('Cigalas, Pulpo y Langostinos','arroz','1','23.00','1','url');
INSERT INTO carta_comida (nombre, tipo, cantidad, precio, disponible, img) VALUES ('Arroz negro con calamares y pulpo','arroz', '1','23.00','1','url');
INSERT INTO carta_comida (nombre, descripcion, tipo, cantidad, precio, disponible, img) VALUES ('Meloso de Senyoret', 'Gambas, Mejillón y Calamar todo pelado','arroz','1','22.00','1','url');
INSERT INTO carta_comida (nombre, tipo, cantidad, precio, disponible, img) VALUES ('Marisco','arroz','1','22.00','1','url');
INSERT INTO carta_comida (nombre, tipo, cantidad, precio, disponible, img) VALUES ('Meloso de Ciervo y Hongos','arroz','1','20.00','1','url');

INSERT INTO carta_comida (nombre, tipo, cantidad, precio, disponible, img) VALUES ('Solomillo de ternera con salsa oporto','carne','1','23.00','1','url');
INSERT INTO carta_comida (nombre, tipo, cantidad, precio, disponible, img) VALUES ('Entrecot de vaca con salsa de setas y foie','carne', '1','20.50','1','url');
INSERT INTO carta_comida (nombre, tipo, cantidad, precio, disponible, img) VALUES ('Entrecot de vaca con salsa de queso','carne','1','19.00','1','url');
INSERT INTO carta_comida (nombre, tipo, cantidad, precio, disponible, img) VALUES ('Chuletillas de lechazo con ajo y aceite','carne','1','18.00','1','url');
INSERT INTO carta_comida (nombre, descripcion, tipo, cantidad, precio, disponible, img) VALUES ('Escalopines de ternera rellenos de setas con salsa a elegir','Salsa Foie o Salsa Gorgonzola','carne','1','16.50','1','url');

INSERT INTO carta_comida (nombre, tipo, cantidad, precio, disponible, img) VALUES ('Rodaballo','pescado','1','26.00','1','url');
INSERT INTO carta_comida (nombre, tipo, cantidad, precio, disponible, img) VALUES ('Bacalao cocido con escalivada de pimiento','pescado', '1','21.00','1','url');
INSERT INTO carta_comida (nombre, tipo, cantidad, precio, disponible, img) VALUES ('Lubina a la espalda','pescado','1','21.00','1','url');
INSERT INTO carta_comida (nombre, tipo, cantidad, precio, disponible, img) VALUES ('Dorada a la espaldacon ensalada y cachelo','pescado','1','20.00','1','url');

INSERT INTO carta_comida (nombre, tipo, subtipo, cantidad, precio, disponible, img) VALUES ('Jamón, queso trufado y setas','cachopo', 'cachopoTJamon','1','29.50','1','url');
INSERT INTO carta_comida (nombre, tipo, subtipo, cantidad, precio, disponible, img) VALUES ('Jamón y queso gorgonzola','cachopo', 'cachopoTJamon','1','27.00','1','url');
INSERT INTO carta_comida (nombre, tipo, subtipo, cantidad, precio, disponible, img) VALUES ('Jamón, setas y tetilla','cachopo', 'cachopoTJamon','1','28.00','1','url');
INSERT INTO carta_comida (nombre, tipo, subtipo, cantidad, precio, disponible, img) VALUES ('Jamón y provolone','cachopo', 'cachopoTJamon','1','26.00','1','url');
INSERT INTO carta_comida (nombre, tipo, subtipo, cantidad, precio, disponible, img) VALUES ('Jamón y mozzarella','cachopo', 'cachopoTJamon','1','26.00','1','url');
INSERT INTO carta_comida (nombre, descripcion, tipo, subtipo, cantidad, precio, disponible, img) VALUES ('4 Quesos', 'Jamón serrano, tetilla, cabrales, oveja y provolone','cachopo', 'cachopoTJamon','1','30.00','1','url');
INSERT INTO carta_comida (nombre, tipo, subtipo, cantidad, precio, disponible, img) VALUES ('Jamón y tetilla','cachopo', 'cachopoTJamon','1','26.00','1','url');
INSERT INTO carta_comida (nombre, tipo, subtipo, cantidad, precio, disponible, img) VALUES ('Jamón, queso tetilla, cheddar, cebolla caramelizada y tomate','cachopo', 'cachopoTJamon','1','30.00','1','url');
INSERT INTO carta_comida (nombre, tipo, subtipo, cantidad, precio, disponible, img) VALUES ('Jamón, queso provolone y cebolla caramelizada','cachopo', 'cachopoTJamon','1','28.00','1','url');
INSERT INTO carta_comida (nombre, tipo, subtipo, cantidad, precio, disponible, img) VALUES ('Jamón, queso mozzarella, tomate y orégano','cachopo', 'cachopoTJamon','1','26.00','1','url');
INSERT INTO carta_comida (nombre, tipo, subtipo, cantidad, precio, disponible, img) VALUES ('Jamón, queso tetilla y tomate natural','cachopo', 'cachopoTJamon','1','27.00','1','url');
INSERT INTO carta_comida (nombre, tipo, subtipo, cantidad, precio, disponible, img) VALUES ('Jamón, setas y cabrales','cachopo', 'cachopoTJamon','1','29.00','1','url');
INSERT INTO carta_comida (nombre, tipo, subtipo, cantidad, precio, disponible, img) VALUES ('Jamón y queso de oveja','cachopo', 'cachopoTJamon','1','26.00','1','url');
INSERT INTO carta_comida (nombre, tipo, subtipo, cantidad, precio, disponible, img) VALUES ('Jamón y queso cabrales','cachopo', 'cachopoTJamon','1','28.00','1','url');
INSERT INTO carta_comida (nombre, tipo, subtipo, cantidad, precio, disponible, img) VALUES ('Jamón y rulo de cabra','cachopo', 'cachopoTJamon','1','27.00','1','url');
INSERT INTO carta_comida (nombre, tipo, subtipo, cantidad, precio, disponible, img) VALUES ('Jamón, queso gorgonzola y tomate natural','cachopo', 'cachopoTJamon','1','29.00','1','url');

INSERT INTO carta_comida (nombre, tipo, subtipo, cantidad, precio, disponible, img) VALUES ('Cecina, cebolla caramelizada, rulo de cabra y tomate natural','cachopo', 'cachopoTCecina','1','31.00','1','url');
INSERT INTO carta_comida (nombre, tipo, subtipo, cantidad, precio, disponible, img) VALUES ('Cecina, cebolla caramelizada y queso tetilla','cachopo', 'cachopoTCecina','1','29.00','1','url');
INSERT INTO carta_comida (nombre, tipo, subtipo, cantidad, precio, disponible, img) VALUES ('Cecina, cebolla caramelizada y provolone','cachopo', 'cachopoTCecina','1','28.00','1','url');
INSERT INTO carta_comida (nombre, tipo, subtipo, cantidad, precio, disponible, img) VALUES ('Cecina, pimientos asados y cabrales','cachopo', 'cachopoTCecina','1','30.00','1','url');
INSERT INTO carta_comida (nombre, tipo, subtipo, cantidad, precio, disponible, img) VALUES ('Cecina, rulo de cabra y tomate','cachopo', 'cachopoTCecina','1','28.00','1','url');
INSERT INTO carta_comida (nombre, tipo, subtipo, cantidad, precio, disponible, img) VALUES ('Cecina y queso de oveja','cachopo', 'cachopoTCecina','1','25.00','1','url');
INSERT INTO carta_comida (nombre, tipo, subtipo, cantidad, precio, disponible, img) VALUES ('Cecina y tetilla','cachopo', 'cachopoTCecina','1','28.00','1','url');
INSERT INTO carta_comida (nombre, tipo, subtipo, cantidad, precio, disponible, img) VALUES ('Cecina y rulo de cabra','cachopo', 'cachopoTCecina','1','27.00','1','url');
INSERT INTO carta_comida (nombre, tipo, subtipo, cantidad, precio, disponible, img) VALUES ('Cecina y mozzarella','cachopo', 'cachopoTCecina','1','28.00','1','url');

INSERT INTO carta_comida (nombre, tipo, subtipo, cantidad, precio, disponible, img) VALUES ('Pollo, jamón, rulo de cabra, cebolla caramelizada y tomate natural','cachopo', 'cachopoPollo','1','29.00','1','url');
INSERT INTO carta_comida (nombre, tipo, subtipo, cantidad, precio, disponible, img) VALUES ('Pollo, jamón, cheddar, tetilla y tomate','cachopo', 'cachopoPollo','1','26.00','1','url');
INSERT INTO carta_comida (nombre, tipo, subtipo, cantidad, precio, disponible, img) VALUES ('Pollo, bacon, cheddar, tetilla y salsa bbq','cachopo', 'cachopoPollo','1','29.00','1','url');
INSERT INTO carta_comida (nombre, tipo, subtipo, cantidad, precio, disponible, img) VALUES ('Pollo, jamón y queso de oveja','cachopo', 'cachopoPollo','1','26.00','1','url');
INSERT INTO carta_comida (nombre, tipo, subtipo, cantidad, precio, disponible, img) VALUES ('Pollo, bacon y tetilla','cachopo', 'cachopoPollo','1','27.00','1','url');
INSERT INTO carta_comida (nombre, tipo, subtipo, cantidad, precio, disponible, img) VALUES ('Pollo, jamón y tetilla','cachopo', 'cachopoPollo','1','26.00','1','url');
INSERT INTO carta_comida (nombre, tipo, subtipo, cantidad, precio, disponible, img) VALUES ('Pollo, bacon, cebolla caramelizada y tetilla','cachopo', 'cachopoPollo','1','29.00','1','url');

INSERT INTO carta_comida (nombre, tipo, cantidad, precio, disponible, img) VALUES ('Brownie rock slide con helado de vainilla', 'postre','1','7.00','1','url');
INSERT INTO carta_comida (nombre, tipo, cantidad, precio, disponible, img) VALUES ('Muerte por chocolate con salsa de chocolate fondant', 'postre','1','6.00','1','url');
INSERT INTO carta_comida (nombre, tipo, cantidad, precio, disponible, img) VALUES ('Tarta de manzana con helado de vainilla', 'postre','1','6.00','1','url');
INSERT INTO carta_comida (nombre, tipo, cantidad, precio, disponible, img) VALUES ('Tarta de queso al horno con salsa de frutos rojos', 'postre','1','5.50','1','url');
INSERT INTO carta_comida (nombre, tipo, cantidad, precio, disponible, img) VALUES ('Profiteroles con helado y salsa de chocolate fondant', 'postre','1','5.25','1','url');
INSERT INTO carta_comida (nombre, tipo, cantidad, precio, disponible, img) VALUES ('Helados', 'postre','1','5.00','1','url');
INSERT INTO carta_comida (nombre, tipo, cantidad, precio, disponible, img) VALUES ('Tarta de la abuela', 'postre','1','5.00','1','url');
INSERT INTO carta_comida (nombre, tipo, cantidad, precio, disponible, img) VALUES ('Arroz con leche', 'postre','1','4.50','1','url');

INSERT INTO usuario (nombre, apellido1, apellido2, correo, fecha, num_telef, id_rol, estado_usuario, NIF, direccion, cp, contraseña) VALUES ('LUENGOS ANDRE','SL','','restaurante@b01.daw2d.iesteis.gal',DATE(NOW()),'628746312',1,'activado','54918574N','','','Restaurante@1');
INSERT INTO usuario (nombre, apellido1, apellido2, correo, fecha, num_telef, id_rol, estado_usuario, NIF, direccion, cp, contraseña) VALUES ('Gabriel','Domínguez','Borines','gabrieldb@iesteis.gal',DATE(NOW()),'689526341',2, 'activado','54918574M','','','abc123..');
INSERT INTO usuario (nombre, apellido1, apellido2, correo, fecha, num_telef, id_rol, estado_usuario, NIF, direccion, cp, contraseña) VALUES ('Nuria','Buceta','García','nuriabg@iesteis.gal',DATE(NOW()),'621456983',3, 'desactivado','54918574A','','','abc123...');

INSERT INTO empresa (cif, nombre, nombre_sociedad, direccion, ciudad, cp, telefono, logo) VALUES ('B27788272','Novo Lua Chea','LUENGOS ANDRE S.L.','Rua de Eduardo Cabello, 25','Vigo','36208','986132537','url');


insert into factura (id_usuario, cif_empresa, precio, fecha, id_comida, total, modo_pago) values (1,'B27788272', 20, DATE(NOW()), 5, 20, 'efectivo');
insert into carrito (id_usuario, id_comida, cantidad) values (1, 4, 2);

#select * from roles;
#select * from carrito;
#select * from carta_comida;
#select * from carta_alergenos;
#select * from alergenos;
#select img, nombre, descripcion, cantidad, precio from carta_comida;
#select * from empresa;
#select * from factura;
#select * from carrito where id_usuario in (select id_usuario from factura);
#select * from factura where id_usuario in (select id_usuario from carrito);
#select * from factura as f inner join carrito as c
#				ON f.id_carro;
#select * from usuario;

###########################################################################################
################################################################################
#	ROLES Y USUARIOS 
#DROP USER IF EXISTS administrador;
#DROP USER IF EXISTS gabriel;
#DROP USER IF EXISTS nuria;
#DROP USER IF EXISTS Raul;

#DROP ROLE IF EXISTS 'administrador','gestor','trabajador', 'registrado', 'sin_registrar';

#CREATE USER IF NOT EXISTS administrador IDENTIFIED BY 'renaido2023';
#CREATE USER IF NOT EXISTS gabriel IDENTIFIED BY 'renaido2023';
#CREATE USER IF NOT EXISTS nuria IDENTIFIED BY 'renaido2023';
CREATE USER IF NOT EXISTS Raul IDENTIFIED BY 'LuaChea@Raul1';
CREATE USER IF NOT EXISTS login	IDENTIFIED BY 'login@1234';

DROP ROLE IF EXISTS 'administrador','gestor','trabajador';
CREATE ROLE IF NOT EXISTS 'administrador';

GRANT SELECT, INSERT, UPDATE, DELETE, CREATE, DROP ON LuaChea.* TO Raul;
GRANT SELECT, INSERT, UPDATE ON LuaChea.* TO login;
#GRANT SELECT, INSERT, UPDATE, DELETE ON LuaChea.* TO gestor;
#GRANT SELECT ON LuaChea.* to trabajador;

#create role trabajador, registrado, sin_registrar;
#grant select on restaurante.* TO trabajador, registrado, sin_registrar;

#GRANT administrador TO 'administrador'@'localhost';
GRANT administrador TO 'Raul'@'localhost';
#GRANT gestor TO 'gabriel'@'localhost'; 
#GRANT trabajador TO 'nuria'@'localhost';
#GRANT administrador TO 'root'@'localhost';

FLUSH PRIVILEGES;

SHOW GRANTS;

###########################################################################################
CREATE TRIGGER dbo.NombreTrigger
    ON dbo.MiTabla
    AFTER UPDATE
AS
BEGIN
    IF UPDATE(NombreColumna)
    BEGIN
	   UPDATE	 OtraTabla
	   SET
		  NombreColumna = i.NombreColumna
	   FROM
		  inserted i
    END
END
###########################################################################################

###########################################################################################
#CREATE TABLE if not exists roles (
#   id INT PRIMARY KEY AUTO_INCREMENT,
#   nombre VARCHAR(255) NOT NULL,
#   permisos VARCHAR(255) NOT NULL
#);

#INSERT INTO roles (nombre, permisos) VALUES ('administrador', 'TODOS');
#INSERT INTO roles (nombre, permisos) VALUES ('usuario registrado', 'SELECT, INSERT, UPDATE, DELETE');
#INSERT INTO roles (nombre, permisos) VALUES ('usuario anonimo', 'SELECT');

#para crear usuarios INSERT INTO usuarios (nombre, password, rol) VALUES ('johndoe', 'password', 'usuario registrado');


#GRANT SELECT,INSERT,UPDATE,DELETE ON *.* TO 'johndoe'@'localhost' IDENTIFIED BY 'password';
#GRANT SELECT, INSERT, UPDATE, DELETE, GRANT OPTION ON *.* TO 'johndoe'@'localhost';

#UPDATE carta_comida SET subtipo='enum('','','','','','','')';



#CREATE USER IF NOT EXISTS administrador IDENTIFIED BY 'renaido2023';

#GRANT SELECT, INSERT, UPDATE, DELETE, CREATE, DROP
#    ON restaurante.*
#	TO 'root'@'localhost';

#GRANT SELECT, INSERT, UPDATE, DELETE, CREATE, DROP
#    ON restaurante.*
#	TO 'administrador'@'localhost';
################################################################################