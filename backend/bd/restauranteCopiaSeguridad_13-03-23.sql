SET NAMES UTF8;
drop database if exists LuaChea;
create database if not exists LuaChea;
use LuaChea;

create table if not exists trabajador(
id_trabajador int auto_increment,
nie_trabajador varchar(9) null,
pasaporte_trabajador varchar(12) null,
nombre varchar(40) not null,
apellido1 varchar(40) not null,
apellido2 varchar(40) null,
correo varchar(40) not null unique,
fecha TIMESTAMP not null,
num_telef varchar(9) not null,
id_rol int not null,
estado_trabajador enum('activado','desactivado') not null default 'desactivado',
trabajando enum('si','no') not null DEFAULT'si',
contraseña varchar(255) not null unique,
constraint pk_idTrabajador primary key (id_trabajador)
);

create table if not exists usuario(
id_usuario int auto_increment,
nombre varchar(40) not null,
apellido1 varchar(40) not null,
apellido2 varchar(40) null,
correo varchar(40) not null unique,
fecha TIMESTAMP not null,
num_telef varchar(9) not null,
id_rol int not null,
estado_usuario enum('activado','desactivado') not null default 'desactivado',
NIF varchar(9)  null unique,
direccion varchar(1000) null,
cp varchar(5) null,
img varchar(100) not null,
contraseña varchar(255) not null unique,

constraint pk_idUsuario primary key (id_usuario)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;


create table if not exists datos_usuario(
id_datos_usuario int auto_increment,
id_usuario int,
nombre varchar(40) not null,
apellido1 varchar(40) not null,
apellido2 varchar(40) null,
fecha TIMESTAMP not null,
num_telef varchar(9) not null,
NIF varchar(9)  null,
direccion varchar(1000) null,
cp varchar(5) null,
constraint pk_id primary key (id_datos_usuario)
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
tipo int not null,
subtipo int null,
fecha_inicio date not null,
fecha_fin date null,
precio float not null,
disponible  enum('si','no') not null default 'si',
img varchar(100) not null,

constraint pk_id primary key (id_comida)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

create table if not exists tipo (
id_tipo int auto_increment,
nombre_tipo varchar(100),

constraint pk_tipo primary key (id_tipo)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

create table if not exists subtipo(
id_subtipo int auto_increment,
nombre_subtipo varchar(100) not null,

constraint pk_subTipo primary key (id_subtipo)
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
)ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS pedidos (
  id_ped INT NOT NULL AUTO_INCREMENT,
  id_usuario int not null,
  fecha date NOT NULL,
  enviado enum('si', 'no') NOT NULL default "no",
  restaurante VARCHAR(10) NOT NULL,
  PRIMARY KEY (id_ped)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


create table if not exists factura(
id_factura int auto_increment,
id_usuario int not null,
cif_empresa varchar(10) not null,
fecha TIMESTAMP not null,
total float not null,
modo_pago int not null,
id_ped int not null,

constraint pk_id_factura primary key (id_factura)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

create table if not exists modo_pago(
  id_modo_pago int not null auto_increment primary key,
  nombre varchar(50) not null
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

create table if not exists empresa(
cif varchar(10) not null,
nombreLocal varchar(120) not null,
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
comida_cantidad longtext,
id_ped int,
constraint pk_id primary key (id_carro)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE if not exists ped_prod (
  id_ped_prod int NOT NULL auto_increment,
  id_ped int NOT NULL,
  id_prod int NOT NULL,
  cantidad int NOT NULL,
  precio float NOT NULL,
  constraint pk_id_ped_prod primary key (id_ped_prod)
)ENGINE=InnoDB DEFAULT CHARSET=latin1;

create table if not exists reservas (
id_reservas	int auto_increment,
id_usuario int,
id_restaurante varchar(10),
id_mesa int,
fecha_reserva date not null,
turno enum('comer', 'cenar'),
reservaAceptada enum('si', 'no')DEFAULT "no",
constraint pk_id primary key (id_reservas)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

create table if not exists mesas (
id_mesa	int auto_increment,
enumMesa varchar(20) not null,
constraint pk_id primary key (id_mesa)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

 

###########################################################################################
#FOREIGN KEYS
ALTER TABLE ped_prod ADD FOREIGN KEY (id_ped) REFERENCES pedidos(id_ped);
ALTER TABLE ped_prod ADD FOREIGN KEY (id_prod) REFERENCES carta_comida(id_comida);

ALTER TABLE factura ADD FOREIGN KEY (id_usuario) REFERENCES usuario(id_usuario);
ALTER TABLE factura ADD FOREIGN KEY (cif_empresa) REFERENCES empresa(cif);
ALTER TABLE factura ADD FOREIGN KEY (modo_pago) REFERENCES modo_pago(id_modo_pago);
ALTER TABLE factura ADD FOREIGN KEY (id_ped) REFERENCES pedidos(id_ped);

ALTER TABLE carrito ADD FOREIGN KEY (id_usuario) REFERENCES usuario(id_usuario);
ALTER TABLE carrito ADD FOREIGN KEY (id_ped) REFERENCES pedidos(id_ped);

ALTER TABLE reservas ADD FOREIGN KEY (id_usuario) REFERENCES usuario(id_usuario);
ALTER TABLE reservas ADD FOREIGN KEY (id_restaurante) REFERENCES empresa(cif);
ALTER TABLE reservas ADD FOREIGN KEY (id_mesa) REFERENCES mesas(id_mesa);

ALTER TABLE pedidos ADD FOREIGN KEY (restaurante) REFERENCES empresa(cif);

ALTER TABLE usuario ADD FOREIGN KEY (id_rol) REFERENCES roles(id_rol);
ALTER TABLE datos_usuario ADD FOREIGN KEY (id_usuario) REFERENCES usuario(id_usuario);

ALTER TABLE carta_alergenos ADD FOREIGN KEY (id_alergeno) REFERENCES alergenos(id_alergeno);
ALTER TABLE carta_alergenos ADD FOREIGN KEY (id_comida) REFERENCES carta_comida(id_comida);

ALTER TABLE carta_comida ADD FOREIGN KEY (tipo) references tipo(id_tipo);
ALTER TABLE carta_comida ADD FOREIGN KEY (subtipo) references subtipo(id_subtipo);
#ALTER TABLE carro ADD CONSTRAINT FK_ArrayProducto FOREIGN KEY (array_producto) REFERENCES factura(producto);

###########################################################################################

###########################################################################################
#INSERT
INSERT INTO modo_pago (nombre) values ('efectivo'); 
INSERT INTO modo_pago (nombre) values ('tarjeta'); 
INSERT INTO modo_pago (nombre) values ('otro'); 

INSERT INTO tipo (nombre_tipo) VALUES ('Entrantes');
INSERT INTO tipo (nombre_tipo) VALUES ('Arroz');
INSERT INTO tipo (nombre_tipo) VALUES ('Carne');
INSERT INTO tipo (nombre_tipo) VALUES ('Cachopo');
INSERT INTO tipo (nombre_tipo) VALUES ('Pescado');
INSERT INTO tipo (nombre_tipo) VALUES ('Postre');
INSERT INTO tipo (nombre_tipo) VALUES ('Bebida');

INSERT INTO subtipo (nombre_subtipo) VALUES ('Croquetas');
INSERT INTO subtipo (nombre_subtipo) VALUES ('Ensaladas');
INSERT INTO subtipo (nombre_subtipo) VALUES ('Mar');
INSERT INTO subtipo (nombre_subtipo) VALUES ('Tierra');
INSERT INTO subtipo (nombre_subtipo) VALUES ('CachopoPollo');
INSERT INTO subtipo (nombre_subtipo) VALUES ('CachopoTJamon');
INSERT INTO subtipo (nombre_subtipo) VALUES ('CachopoTCecina');

INSERT INTO roles (nombre_rol) VALUES ('Administrador');
INSERT INTO roles (nombre_rol) VALUES ('Gestor');
INSERT INTO roles (nombre_rol) VALUES ('Trabajador');
INSERT INTO roles (nombre_rol) VALUES ('Registrado');
INSERT INTO roles (nombre_rol) VALUES ('Sin registrar');

INSERT INTO alergenos (nombre_alergeno, descripcion) values ('ninguno', 'No contiene alergenos.');
INSERT INTO alergenos (nombre_alergeno, descripcion, img) values ('altramuces', 'Contiene altramuces.', 'url');
INSERT INTO alergenos (nombre_alergeno, descripcion, img) values ('apio', 'Contiene apio.', 'url');
INSERT INTO alergenos (nombre_alergeno, descripcion, img) values ('cacahuete', 'Contiene cacahuete.', 'url');
INSERT INTO alergenos (nombre_alergeno, descripcion, img) values ('crustaceos', 'Contiene crustaceos.', 'url');
INSERT INTO alergenos (nombre_alergeno, descripcion, img) values ('huevo', 'Contiene huevo.', 'url');
INSERT INTO alergenos (nombre_alergeno, descripcion, img) values ('lacteos', 'Contiene lacteos.', 'url');
INSERT INTO alergenos (nombre_alergeno, descripcion, img) values ('moluscos', 'Contiene moluscos.', 'url');
INSERT INTO alergenos (nombre_alergeno, descripcion, img) values ('mostaza', 'Contiene mostaza.', 'url');
INSERT INTO alergenos (nombre_alergeno, descripcion, img) values ('pescado', 'Contiene pescado.', 'url');
INSERT INTO alergenos (nombre_alergeno, descripcion, img) values ('soja', 'Contiene soja.', 'url');
INSERT INTO alergenos (nombre_alergeno, descripcion, img) values ('sulfitos', 'Contiene sulfitos.', 'url');
INSERT INTO alergenos (nombre_alergeno, descripcion, img) values ('sesamo', 'Contiene Sesamo.', 'url');
INSERT INTO alergenos (nombre_alergeno, descripcion, img) values ('frutoscascara', 'Contiene Frutos de Cascara.', 'url');
INSERT INTO alergenos (nombre_alergeno, descripcion, img) values ('gluten', 'Contiene Gluten', 'url');

#FALTA AGREGAR LOS CAMPOS DE ALERGENOS !!!!!!!!
# INSERT INTO carta_comida (nombre, descripcion, tipo, subtipo, fecha_inicio, fecha_fin, precio, disponible, img) VALUES ('Surtido de Croquetas','Jamón, Cecina y Pulpo',1, 1,DATE(NOW()), null,'13.50',1,'url');

INSERT INTO `carta_comida` (`nombre`, `descripcion`, `tipo`, `subtipo`, `fecha_inicio`, `fecha_fin`, `precio`, `disponible`, `img`) VALUES
('Surtido de Croquetas', 'Jamón, Cecina y Pulpo', 1, 1, '2023-03-12', NULL, 13.5, 'si', '../imagenes/imgProductos/1.jpg'),
('Croqueta de Pulpo', 'Pulpo', 1, 1, '2023-03-12', NULL, 12.5, 'si', '../imagenes/imgProductos/2.jpg'),
('Croqueta de rulo de cabra y cebolla caramelizada', 'Rulo de cabra y cebolla caramelizada', 1, 1, '2023-03-12', NULL, 12, 'si', '../imagenes/imgProductos/3.jpg'),
('Croquetas de Cecina y Queso San Simón', 'Cecina y Queso San Simón', 1, 1, '2023-03-12', NULL, 11.5, 'si', '../imagenes/imgProductos/4.jpg'),
('Croquetas de Jamón', 'Jamón serrano', 1, 1, '2023-03-12', NULL, 10, 'si', '../imagenes/imgProductos/5.jpg'),
('Cesar con Pollo', '', 1, 2, '2023-03-12', NULL, 13.5, 'si', '../imagenes/imgProductos/6.jpg'),
('Tomate, Ventresca y Anchoa', '', 1, 2, '2023-03-12', NULL, 12.5, 'si', '../imagenes/imgProductos/7.jpg'),
('Mixta LuaChea', 'Lechuga, Tomate, Cebolla, Esparrago, Pimiento asado, Huevo duro, Atún', 1, 2, '2023-03-12', NULL, 13.5, 'si', '../imagenes/imgProductos/8.png'),
('Simple', 'Lechuga, Tomate y Cebolla', 1, 2, '2023-03-12', NULL, 13.5, 'si', '../imagenes/imgProductos/9.jpg'),
('Pulpo con Queso Tetilla', '', 1, 3, '2023-03-12', NULL, 21, 'si', '../imagenes/imgProductos/10.jpg'),
('Pulpo a feira', '', 1, 3, '2023-03-12', NULL, 20, 'si', '../imagenes/imgProductos/11.jpg'),
('Langostinos a la plancha', '', 1, 3, '2023-03-12', NULL, 18, 'si', '../imagenes/imgProductos/12.jpg'),
('Salteado de Chipirones con Trigueros y Champiñones', '', 1, 3, '2023-03-12', NULL, 13, 'si', '../imagenes/imgProductos/13.jpg'),
('Pastel de cabracho', '', 1, 3, '2023-03-12', NULL, 12, 'si', '../imagenes/imgProductos/14.jpg'),
('Calamares', '', 1, 3, '2023-03-12', NULL, 11.5, 'si', '../imagenes/imgProductos/15.jpg'),
('Mejillones a la vinagreta', '', 1, 3, '2023-03-12', NULL, 8.5, 'si', '../imagenes/imgProductos/16.jpg'),
('Mejillones al vapor', '', 1, 3, '2023-03-12', NULL, 7, 'si', '../imagenes/imgProductos/17.jpg'),
('Salteado de pulpo, setas y trigueros', NULL, 1, 4, '2023-03-12', NULL, 16, 'si', ''),
('Fabada', '', 1, 4, '2023-03-12', NULL, 15, 'si', '../imagenes/imgProductos/19.jpg'),
('Involtini de berenjenas con Salsa Oporto', NULL, 1, 4, '2023-03-12', NULL, 13.5, 'si', ''),
('Setas rellenas de Cecina y Tetilla con Salsa Gorgonzola', NULL, 1, 4, '2023-03-12', NULL, 13.5, 'si', ''),
('Huevos rotos con salsa de Setas y Foie ', NULL, 1, 4, '2023-03-12', NULL, 12.5, 'si', ''),
('Parrillada de verduras con Queso de Cabra', NULL, 1, 4, '2023-03-12', NULL, 11.5, 'si', ''),
('Chicken Finger', '', 1, 4, '2023-03-12', NULL, 8.5, 'si', '../imagenes/imgProductos/24.jpg'),
('Pimientos de Padrón', '', 1, 4, '2023-03-12', NULL, 6, 'si', '../imagenes/imgProductos/25.jpg'),
('Pan (Por Persona)', '', 1, 4, '2023-03-12', NULL, 1, 'si', '../imagenes/imgProductos/26.jpg'),
('Cigalas, Pulpo y Langostinos', NULL, 2, NULL, '2023-03-12', NULL, 23, 'si', ''),
('Arroz negro con calamares y pulpo', NULL, 2, NULL, '2023-03-12', NULL, 23, 'si', ''),
('Meloso de Senyoret', 'Gambas, Mejillón y Calamar todo pelado', 2, NULL, '2023-03-12', NULL, 22, 'si', ''),
('Marisco', NULL, 2, NULL, '2023-03-12', NULL, 22, 'si', ''),
('Meloso de Ciervo y Hongos', NULL, 2, NULL, '2023-03-12', NULL, 20, 'si', ''),
('Solomillo de ternera con salsa oporto', NULL, 3, NULL, '2023-03-12', NULL, 23, 'si', ''),
('Entrecot de vaca con salsa de setas y foie', NULL, 3, NULL, '2023-03-12', NULL, 20.5, 'si', ''),
('Entrecot de vaca con salsa de queso', NULL, 3, NULL, '2023-03-12', NULL, 19, 'si', ''),
('Chuletillas de lechazo con ajo y aceite', NULL, 3, NULL, '2023-03-12', NULL, 18, 'si', ''),
('Escalopines de ternera rellenos de setas con salsa a elegir', 'Salsa Foie o Salsa Gorgonzola', 3, NULL, '2023-03-12', NULL, 16.5, 'si', ''),
('Rodaballo', NULL, 5, NULL, '2023-03-12', NULL, 26, 'si', ''),
('Bacalao cocido con escalivada de pimiento', NULL, 5, NULL, '2023-03-12', NULL, 21, 'si', ''),
('Lubina a la espalda', NULL, 5, NULL, '2023-03-12', NULL, 21, 'si', ''),
('Dorada a la espaldacon ensalada y cachelo', NULL, 5, NULL, '2023-03-12', NULL, 20, 'si', ''),
('Jamón, queso trufado y setas', '', 4, 6, '2023-03-12', NULL, 29.5, 'si', '../imagenes/imgProductos/41.png'),
('Jamón y queso gorgonzola', '', 4, 6, '2023-03-12', NULL, 27, 'si', '../imagenes/imgProductos/42.png'),
('Jamón, setas y tetilla', '', 4, 6, '2023-03-12', NULL, 28, 'si', '../imagenes/imgProductos/43.png'),
('Jamón y provolone', '', 4, 6, '2023-03-12', NULL, 26, 'si', '../imagenes/imgProductos/44.png'),
('Jamón y mozzarella', '', 4, 6, '2023-03-12', NULL, 26, 'si', '../imagenes/imgProductos/45.png'),
('4 Quesos', 'Jamón serrano, tetilla, cabrales, oveja y provolone', 4, 6, '2023-03-12', NULL, 30, 'si', '../imagenes/imgProductos/46.png'),
('Jamón y tetilla', '', 4, 6, '2023-03-12', NULL, 26, 'si', '../imagenes/imgProductos/47.png'),
('Jamón, queso tetilla, cheddar, cebolla caramelizada y tomate', '', 4, 6, '2023-03-12', NULL, 30, 'si', '../imagenes/imgProductos/48.png'),
('Jamón, queso provolone y cebolla caramelizada', '', 4, 6, '2023-03-12', NULL, 28, 'si', '../imagenes/imgProductos/49.png'),
('Jamón, queso mozzarella, tomate y orégano', '', 4, 6, '2023-03-12', NULL, 26, 'si', '../imagenes/imgProductos/50.png'),
('Jamón, queso tetilla y tomate natural', '', 4, 6, '2023-03-12', NULL, 27, 'si', '../imagenes/imgProductos/51.png'),
('Jamón, setas y cabrales', '', 4, 6, '2023-03-12', NULL, 29, 'si', '../imagenes/imgProductos/52.png'),
('Jamón y queso de oveja', '', 4, 6, '2023-03-12', NULL, 26, 'si', '../imagenes/imgProductos/53.png'),
('Jamón y queso cabrales', '', 4, 6, '2023-03-12', NULL, 28, 'si', '../imagenes/imgProductos/54.png'),
('Jamón y rulo de cabra', '', 4, 6, '2023-03-12', NULL, 27, 'si', '../imagenes/imgProductos/55.png'),
('Jamón, queso gorgonzola y tomate natural', '', 4, 6, '2023-03-12', NULL, 29, 'si', '../imagenes/imgProductos/56.png'),
('Cecina, cebolla caramelizada, rulo de cabra y tomate natural', '', 4, 7, '2023-03-12', NULL, 31, 'si', '../imagenes/imgProductos/57.png'),
('Cecina, cebolla caramelizada y queso tetilla', '', 4, 7, '2023-03-12', NULL, 29, 'si', '../imagenes/imgProductos/58.png'),
('Cecina, cebolla caramelizada y provolone', '', 4, 7, '2023-03-12', NULL, 28, 'si', '../imagenes/imgProductos/59.png'),
('Cecina, pimientos asados y cabrales', '', 4, 7, '2023-03-12', NULL, 30, 'si', '../imagenes/imgProductos/60.png'),
('Cecina, rulo de cabra y tomate', '', 4, 7, '2023-03-12', NULL, 28, 'si', '../imagenes/imgProductos/61.png'),
('Cecina y queso de oveja', '', 4, 7, '2023-03-12', NULL, 25, 'si', '../imagenes/imgProductos/62.png'),
('Cecina y tetilla', '', 4, 7, '2023-03-12', NULL, 28, 'si', '../imagenes/imgProductos/63.png'),
('Cecina y rulo de cabra', '', 4, 7, '2023-03-12', NULL, 27, 'si', '../imagenes/imgProductos/64.png'),
('Cecina y mozzarella', '', 4, 7, '2023-03-12', NULL, 28, 'si', '../imagenes/imgProductos/65.png'),
('Pollo, jamón, rulo de cabra, cebolla caramelizada y tomate natural', '', 4, 5, '2023-03-12', NULL, 29, 'si', '../imagenes/imgProductos/66.png'),
('Pollo, jamón, cheddar, tetilla y tomate', '', 4, 5, '2023-03-12', NULL, 26, 'si', '../imagenes/imgProductos/67.png'),
('Pollo, bacon, cheddar, tetilla y salsa bbq', '', 4, 5, '2023-03-12', NULL, 29, 'si', '../imagenes/imgProductos/68.png'),
('Pollo, jamón y queso de oveja', '', 4, 5, '2023-03-12', NULL, 26, 'si', '../imagenes/imgProductos/69.png'),
('Pollo, bacon y tetilla', '', 4, 5, '2023-03-12', NULL, 27, 'si', '../imagenes/imgProductos/70.png'),
('Pollo, jamón y tetilla', '', 4, 5, '2023-03-12', NULL, 26, 'si', '../imagenes/imgProductos/71.png'),
('Pollo, bacon, cebolla caramelizada y tetilla', '', 4, 5, '2023-03-12', NULL, 29, 'si', '../imagenes/imgProductos/72.png'),
('Brownie rock slide con helado de vainilla', NULL, 6, NULL, '2023-03-12', NULL, 7, 'si', ''),
('Muerte por chocolate con salsa de chocolate fondant', NULL, 6, NULL, '2023-03-12', NULL, 6, 'si', ''),
('Tarta de manzana con helado de vainilla', NULL, 6, NULL, '2023-03-12', NULL, 6, 'si', ''),
('Tarta de queso al horno con salsa de frutos rojos', NULL, 6, NULL, '2023-03-12', NULL, 5.5, 'si', ''),
('Profiteroles con helado y salsa de chocolate fondant', NULL, 6, NULL, '2023-03-12', NULL, 5.25, 'si', ''),
('Helados', NULL, 6, NULL, '2023-03-12', NULL, 5, 'si', ''),
('Tarta de la abuela', NULL, 6, NULL, '2023-03-12', NULL, 5, 'si', ''),
('Arroz con leche', NULL, 6, NULL, '2023-03-12', NULL, 4.5, 'si', '');

INSERT INTO carta_alergenos (id_alergeno, id_comida) values (15,1);
INSERT INTO carta_alergenos (id_alergeno, id_comida) values (6,1);
INSERT INTO carta_alergenos (id_alergeno, id_comida) values (7,1);

INSERT INTO carta_alergenos (id_alergeno, id_comida) values (8,2);

INSERT INTO carta_alergenos (id_alergeno, id_comida) values (8,10);
INSERT INTO carta_alergenos (id_alergeno, id_comida) values (7,10);

INSERT INTO carta_alergenos (id_alergeno, id_comida) values (8,11);

INSERT INTO carta_alergenos (id_alergeno, id_comida) values (7,41);
INSERT INTO carta_alergenos (id_alergeno, id_comida) values (15,41);
INSERT INTO carta_alergenos (id_alergeno, id_comida) values (6,41);
INSERT INTO carta_alergenos (id_alergeno, id_comida) values (12,41);

INSERT INTO carta_alergenos (id_alergeno, id_comida) values (7,42);
INSERT INTO carta_alergenos (id_alergeno, id_comida) values (15,42);
INSERT INTO carta_alergenos (id_alergeno, id_comida) values (6,42);
INSERT INTO carta_alergenos (id_alergeno, id_comida) values (12,42);

INSERT INTO carta_alergenos (id_alergeno, id_comida) values (7,43);
INSERT INTO carta_alergenos (id_alergeno, id_comida) values (15,43);
INSERT INTO carta_alergenos (id_alergeno, id_comida) values (6,43);
INSERT INTO carta_alergenos (id_alergeno, id_comida) values (12,43);

INSERT INTO carta_alergenos (id_alergeno, id_comida) values (7,44);
INSERT INTO carta_alergenos (id_alergeno, id_comida) values (15,44);
INSERT INTO carta_alergenos (id_alergeno, id_comida) values (6,44);
INSERT INTO carta_alergenos (id_alergeno, id_comida) values (12,44);

INSERT INTO usuario (nombre, apellido1, apellido2, correo, fecha, num_telef, id_rol, estado_usuario, NIF, direccion, cp, img, contraseña) VALUES ('Guillermo','André','','guille1insua@gmail.com',DATE(NOW()),'667821250',4,'activado', '54a','','','','$2y$10$xl8U8Xd6AHSYSnW5k4n0B.7lXk9HavWen43stDMlyg9EBpz13j6.O');
INSERT INTO usuario (nombre, apellido1, apellido2, correo, fecha, num_telef, id_rol, estado_usuario, NIF, direccion, cp, img, contraseña) VALUES ('Gabriel','Domínguez','Borines','cambes6@gmail.com',DATE(NOW()),'699204155',4, 'activado','','','','','$2y$10$CWUoOkAv9YneiFlglkqoRuP28nVduK3aOUTOHW5onv7cAKk3Y.wGC');
INSERT INTO usuario (nombre, apellido1, apellido2, correo, fecha, num_telef, id_rol, estado_usuario, NIF, direccion, cp, img, contraseña) VALUES ('Nuria','Buceta','García','nuriabuceta@gmail.com',DATE(NOW()),'622838028',4, 'activado','89j','','','','$2y$10$HxDSrQwOEEqVv4uloY5VDe0/NuZnStwORxLwUO..ORK1GmtzKom/.');

INSERT INTO trabajador (nombre, apellido1, apellido2, correo, fecha, num_telef, id_rol, estado_trabajador, nie_trabajador, pasaporte_trabajador, contraseña) VALUES ('Gabriel','Domínguez','Borines','cambes6@gmail.com',DATE(NOW()),'699204155',1, 'activado','','','$2y$10$lysg/2UocV/RJJUh0.Ov6uc/hgBrMTPLw9D4gEZ4jJVkmf28ZJtsi');
INSERT INTO trabajador (nombre, apellido1, apellido2, correo, fecha, num_telef, id_rol, estado_trabajador, nie_trabajador, pasaporte_trabajador, contraseña) VALUES ('Pepe','Domínguez','','cambes1@gmail.com',DATE(NOW()),'123123123',2, 'activado','','','$2y$10$aalysg/2UocV/RJJUh0.Ov6uc/hgBrMTPLw9D4gEZ4jJVkmf28ZJtsi');
INSERT INTO trabajador (nombre, apellido1, apellido2, correo, fecha, num_telef, id_rol, estado_trabajador, nie_trabajador, pasaporte_trabajador, contraseña) VALUES ('Maria','Rodriguez','perez','cambes2@gmail.com',DATE(NOW()),'234234234',3, 'activado','','','$2y$10$lysgss/2UocV/RJJUh0.Ov6uc/hgBrMTPLw9D4gEZ4jJVkmf28ZJtsi');
INSERT INTO trabajador (nombre, apellido1, apellido2, correo, fecha, num_telef, id_rol, estado_trabajador, nie_trabajador, pasaporte_trabajador,trabajando, contraseña) VALUES ('Juan','Alvarez','','cambes3@gmail.com',DATE(NOW()),'345345345',3, 'activado','','','no','$2y$10$aalysg/2UocdasdV/RJJUh0.Ov6uc/hgBrMTPLw9D4gEZ4jJVkmf28ZJtsi');
INSERT INTO trabajador (nombre, apellido1, apellido2, correo, fecha, num_telef, id_rol, estado_trabajador, nie_trabajador, pasaporte_trabajador,trabajando, contraseña) VALUES ('Pepe','vazquez','pena','cambes4@gmail.com',DATE(NOW()),'456456456',1, 'activado','','','no','$2y$10$lysg/2aaUocV/RJJUh0.Ov6uc/hgBrMTPLw9D4gEZ4jJVkmf28ZJtsi');
  
INSERT INTO empresa (cif, nombreLocal, nombre_sociedad, direccion, ciudad, cp, telefono, logo) VALUES ('B27788272','Novo Lua Chea','LUENGOS ANDRE S.L.','Rua de Eduardo Cabello, 25','Vigo','36208','986132537','url');
INSERT INTO empresa (cif, nombreLocal, nombre_sociedad, direccion, ciudad, cp, telefono, logo) VALUES ('B28789542','Viejo Lua Chea','LUENGOS ANDRES S.L.','Rua de Otero Pedrallo, 30','Vigo','36208','986132537','url');

#insert into pedidos (id_usuario, cif_empresa, fecha, total, modo_pago, id_ped) values (3,'B27788272', DATE(NOW()), 20, 1, 20, 1);
#insert into factura (id_usuario, cif_empresa, fecha, total, modo_pago, id_ped) values (3,'B27788272', DATE(NOW()), 20, 1, 20, 1);
#insert into factura (id_usuario, cif_empresa, fecha, total, modo_pago, id_ped) values (3,'B27788272', DATE(NOW()), 20, 1, 20, 1);
#insert into factura (id_usuario, cif_empresa, fecha, total, modo_pago, id_ped) values (3,'B27788272', DATE(NOW()), 20, 1, 20, 1);

INSERT INTO mesas (enumMesa) values ('T1');
INSERT INTO mesas (enumMesa) values ('T2');
INSERT INTO mesas (enumMesa) values ('T3');
INSERT INTO mesas (enumMesa) values ('T4');
INSERT INTO mesas (enumMesa) values ('T5');
INSERT INTO mesas (enumMesa) values ('C1');
INSERT INTO mesas (enumMesa) values ('C2');
INSERT INTO mesas (enumMesa) values ('C3');
INSERT INTO mesas (enumMesa) values ('C4');
INSERT INTO mesas (enumMesa) values ('C5');
INSERT INTO mesas (enumMesa) values ('S1');
INSERT INTO mesas (enumMesa) values ('S2');
INSERT INTO mesas (enumMesa) values ('S3');
INSERT INTO mesas (enumMesa) values ('S4');
INSERT INTO mesas (enumMesa) values ('S5');

INSERT INTO reservas (id_usuario, id_restaurante, id_mesa, fecha_reserva, turno) values (2, 'B27788272', 13, "2023-06-20",'comer');
INSERT INTO reservas (id_usuario, id_restaurante, id_mesa, fecha_reserva, turno) values (2, 'B28789542', 10, "2017-06-20",'cenar');
INSERT INTO reservas (id_usuario, id_restaurante, id_mesa, fecha_reserva, turno) values (2, 'B27788272', 4, "2017-06-20",'comer');
INSERT INTO reservas (id_usuario, id_restaurante, id_mesa, fecha_reserva, turno) values (2, 'B28789542', 9, "2017-06-20",'cenar');
INSERT INTO reservas (id_usuario, id_restaurante, id_mesa, fecha_reserva, turno) values (2, 'B27788272', 12, "2017-06-20",'comer');
INSERT INTO reservas (id_usuario, id_restaurante, id_mesa, fecha_reserva, turno) values (2, 'B27788272', 1, "2017-06-20",'comer');
INSERT INTO reservas (id_usuario, id_restaurante, id_mesa, fecha_reserva, turno) values (2, 'B27788272', 2, "2017-06-20",'comer');
INSERT INTO reservas (id_usuario, id_restaurante, id_mesa, fecha_reserva, turno) values (2, 'B27788272', 3, "2017-06-20",'comer');
INSERT INTO reservas (id_usuario, id_restaurante, id_mesa, fecha_reserva, turno) values (2, 'B27788272', 4, "2017-06-20",'comer');
INSERT INTO reservas (id_usuario, id_restaurante, id_mesa, fecha_reserva, turno) values (2, 'B27788272', 5, "2017-06-20",'comer');
INSERT INTO reservas (id_usuario, id_restaurante, id_mesa, fecha_reserva, turno) values (2, 'B27788272', 6, "2017-06-20",'comer');
INSERT INTO reservas (id_usuario, id_restaurante, id_mesa, fecha_reserva, turno) values (2, 'B27788272', 7, "2017-06-20",'comer');
INSERT INTO reservas (id_usuario, id_restaurante, id_mesa, fecha_reserva, turno) values (2, 'B27788272', 8, "2017-06-20",'comer');
INSERT INTO reservas (id_usuario, id_restaurante, id_mesa, fecha_reserva, turno) values (2, 'B27788272', 11, "2017-06-20",'comer');
INSERT INTO reservas (id_usuario, id_restaurante, id_mesa, fecha_reserva, turno) values (2, 'B27788272', 14, "2017-06-20",'comer');
INSERT INTO reservas (id_usuario, id_restaurante, id_mesa, fecha_reserva, turno) values (2, 'B27788272', 15, "2017-06-20",'comer');

#insert into carrito (id_usuario, id_comida, cantidad) values (3, 4, 1);

#select * from reservas;
#select * from mesas;
#select * from roles;
#select * from carrito;
#select * from carta_comida;
#select * from tipo;
#select * from subtipo;

select * from carta_comida as cc inner join carta_alergenos as ca on cc.id_comida = ca.id_comida inner join alergenos as a on ca.id_alergeno = a.id_alergeno;
select * from carta_alergenos;
select * from alergenos;

#select img, nombre, descripcion, fecha_inicio, fecha_fin, precio from carta_comida;
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
#CREATE USER IF NOT EXISTS Raul IDENTIFIED BY 'LuaChea@Raul1';
#CREATE USER IF NOT EXISTS login	IDENTIFIED BY 'login@1234';

#DROP ROLE IF EXISTS 'administrador','gestor','trabajador';
#CREATE ROLE IF NOT EXISTS 'administrador';

#GRANT SELECT, INSERT, UPDATE, DELETE, CREATE, DROP ON LuaChea.* TO Raul;
#GRANT SELECT, INSERT, UPDATE ON LuaChea.* TO login;
#GRANT SELECT, INSERT, UPDATE, DELETE ON LuaChea.* TO gestor;
#GRANT SELECT ON LuaChea.* to trabajador;

#create role trabajador, registrado, sin_registrar;
#grant select on restaurante.* TO trabajador, registrado, sin_registrar;

#GRANT administrador TO 'administrador'@'localhost';
#GRANT 'administrador' TO 'Raul'@'localhost';
#GRANT gestor TO 'gabriel'@'localhost'; 
#GRANT trabajador TO 'nuria'@'localhost';
#GRANT administrador TO 'root'@'localhost';

#FLUSH PRIVILEGES;

#SHOW GRANTS;

###########################################################################################
# HACERLO CON PROCEDURE
DELIMITER $$
CREATE TRIGGER asignar_fecha_usuario
BEFORE INSERT ON usuario
FOR EACH ROW
BEGIN
    SET NEW.fecha = IFNULL(NEW.fecha, NOW());
END$$

CREATE EVENT elimina_usuario_event
ON SCHEDULE EVERY 1 DAY
DO
BEGIN
    DELETE FROM usuario WHERE activado = 0 AND fecha < DATE_SUB(NOW, INTERVAL 10 DAY);
END$$

CREATE TRIGGER actualizar_usuario AFTER UPDATE ON usuario
FOR EACH ROW
BEGIN
    INSERT INTO datos_usuario (id_usuario, nombre, apellido1, apellido2, fecha, num_telef, nif, direccion, cp)
    VALUES (NEW.id_usuario, NEW.nombre, NEW.apellido1, NEW.apellido2, NOW(), NEW.num_telef, NEW.nif, NEW.direccion, NEW.cp);
END$$
DELIMITER ;

select * from alergenos;
select id_comida from carta_alergenos where id_alergeno = 8;
select * from carta_alergenos as ca inner join carta_comida as cc on cc.id_comida=ca.id_comida where id_alergeno != 8;
select * from carta_comida as cc inner join carta_alergenos as ca on cc.id_comida=ca.id_comida inner join alergenos as a on ca.id_alergeno = a.id_alergeno;
SELECT * FROM carta_comida WHERE id_comida NOT IN (
    select id_comida from carta_alergenos where id_alergeno = 8
);

select * from alergenos;
select * from carta_alergenos;
select * from carta_comida;
SELECT * FROM carta_comida WHERE id_comida NOT IN (
    SELECT id_comida
    FROM carta_alergenos
    WHERE id_alergeno = 8
);
SELECT * from carta_comida WHERE id_comida NOT IN (
	SELECT id_comida 
	FROM carta_alergenos 
	WHERE id_alergeno IN (7, 8)
);

SELECT nombre, descripcion, tipo, precio, img, disponible, id_comida from carta_comida WHERE id_comida NOT IN ( SELECT id_comida FROM carta_alergenos WHERE id_alergeno IN (7, 8));
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

#insert into provincia values ('27','Lugo');

#GRANT SELECT,INSERT,UPDATE,DELETE ON *.* TO 'johndoe'@'localhost' IDENTIFIED BY 'password';
#GRANT SELECT, INSERT, UPDATE, DELETE, GRANT OPTION ON *.* TO 'johndoe'@'localhost';

#UPDATE carta_comida SET subtipo='enum('','','','','','','')';

select * from datos_usuario where id_usuario=1;
select * from datos_usuario where id_usuario = 3;
update usuario set nombre = "Nuria AA AA" where id_usuario=3;
select * from usuario;

#CREATE USER IF NOT EXISTS administrador IDENTIFIED BY 'renaido2023';

#GRANT SELECT, INSERT, UPDATE, DELETE, CREATE, DROP
#    ON restaurante.*
#	TO 'root'@'localhost';

#GRANT SELECT, INSERT, UPDATE, DELETE, CREATE, DROP
#    ON restaurante.*
#	TO 'administrador'@'localhost';
################################################################################