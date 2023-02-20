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
tipo int not null,
subtipo int null,
fecha_inicio date not null,
fecha_fin date null,
precio float not null,
disponible boolean not null,
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
);

<<<<<<< Updated upstream
create table if not exists pedidos (
  id_ped int NOT NULL auto_increment,
  fecha datetime NOT NULL,
  enviado boolean NOT NULL,
  restaurante varchar(10) NOT NULL
=======
CREATE TABLE IF NOT EXISTS pedidos (
  id_ped INT NOT NULL AUTO_INCREMENT,
  fecha DATETIME NOT NULL,
  enviado BOOLEAN NOT NULL,
  restaurante VARCHAR(10) NOT NULL,
  PRIMARY KEY (id_ped)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
>>>>>>> Stashed changes


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
<<<<<<< Updated upstream
id_pedido int,
=======
id_ped int,
>>>>>>> Stashed changes
constraint pk_id primary key (id_carro)
);

###########################################################################################
#FOREIGN KEYS
ALTER TABLE factura ADD FOREIGN KEY (id_usuario) REFERENCES usuario(id_usuario);
ALTER TABLE factura ADD FOREIGN KEY (cif_empresa) REFERENCES empresa(cif);

ALTER TABLE carrito ADD FOREIGN KEY (id_usuario) REFERENCES usuario(id_usuario);
ALTER TABLE carrito ADD FOREIGN KEY (id_comida) REFERENCES carta_comida(id_comida);
ALTER TABLE carrito ADD FOREIGN KEY (id_ped) REFERENCES pedidos(id_ped);
<<<<<<< Updated upstream
<<<<<<< Updated upstream
=======

>>>>>>> Stashed changes

ALTER TABLE pedidos ADD FOREIGN KEY (restaurante) REFERENCES empresa(cif);
=======
>>>>>>> Stashed changes

ALTER TABLE usuario ADD FOREIGN KEY (id_rol) REFERENCES roles(id_rol);

ALTER TABLE carta_alergenos ADD FOREIGN KEY (id_alergeno) REFERENCES alergenos(id_alergeno);
ALTER TABLE carta_alergenos ADD FOREIGN KEY (id_comida) REFERENCES carta_comida(id_comida);

ALTER TABLE carta_comida ADD FOREIGN KEY (tipo) references tipo(id_tipo);
ALTER TABLE carta_comida ADD FOREIGN KEY (subtipo) references subtipo(id_subtipo);
#ALTER TABLE carro ADD CONSTRAINT FK_ArrayProducto FOREIGN KEY (array_producto) REFERENCES factura(producto);

###########################################################################################

###########################################################################################
#INSERT
INSERT INTO tipo (nombre_tipo) VALUES ('entrantes');
INSERT INTO tipo (nombre_tipo) VALUES ('arroz');
INSERT INTO tipo (nombre_tipo) VALUES ('carne');
INSERT INTO tipo (nombre_tipo) VALUES ('cachopo');
INSERT INTO tipo (nombre_tipo) VALUES ('pescado');
INSERT INTO tipo (nombre_tipo) VALUES ('postre');
INSERT INTO tipo (nombre_tipo) VALUES ('bebida');

INSERT INTO subtipo (nombre_subtipo) VALUES ('croquetas');
INSERT INTO subtipo (nombre_subtipo) VALUES ('ensaladas');
INSERT INTO subtipo (nombre_subtipo) VALUES ('mar');
INSERT INTO subtipo (nombre_subtipo) VALUES ('tierra');
INSERT INTO subtipo (nombre_subtipo) VALUES ('cachopoPollo');
INSERT INTO subtipo (nombre_subtipo) VALUES ('cachopoTJamon');
INSERT INTO subtipo (nombre_subtipo) VALUES ('cachopoTCecina');

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
INSERT INTO carta_comida (nombre, descripcion, tipo, subtipo, fecha_inicio, fecha_fin, precio, disponible, img) VALUES ('Surtido de Croquetas','Jamón, Cecina y Pulpo',1, 1,DATE(NOW()), null,'13.50',1,'url');
INSERT INTO carta_comida (nombre, tipo, subtipo, fecha_inicio, fecha_fin, precio, disponible, img) VALUES ('Pulpo',1, 1,DATE(NOW()), null,'12.50',1,'url');
INSERT INTO carta_comida (nombre, tipo, subtipo, fecha_inicio, fecha_fin, precio, disponible, img) VALUES ('Rulo de cabra y cebolla caramelizada',1, 1,DATE(NOW()), null,'12.00',1,'url');
INSERT INTO carta_comida (nombre, tipo, subtipo, fecha_inicio, fecha_fin, precio, disponible, img) VALUES ('Cecina y Queso San Simón',1, 1,DATE(NOW()), null,'11.50',1,'url');
INSERT INTO carta_comida (nombre, tipo, subtipo, fecha_inicio, fecha_fin, precio, disponible, img) VALUES ('Jamón',1, 1,DATE(NOW()), null,'10.00',1,'url');

INSERT INTO carta_comida (nombre, tipo, subtipo, fecha_inicio, fecha_fin, precio, disponible, img) VALUES ('Cesar con Pollo',1, 2,DATE(NOW()), null,'13.50',1,'url');
INSERT INTO carta_comida (nombre, tipo, subtipo, fecha_inicio, fecha_fin, precio, disponible, img) VALUES ('Tomate, Ventresca y Anchoa',1, 2,DATE(NOW()), null,'12.50',1,'url');
INSERT INTO carta_comida (nombre, descripcion, tipo, subtipo, fecha_inicio, fecha_fin, precio, disponible, img) VALUES ('Mixta LuaChea', 'Lechuga, Tomate, Cebolla, Esparrago, Pimiento asado, Huevo duro, Atún',1, 2,DATE(NOW()), null,'13.50',1,'url');
INSERT INTO carta_comida (nombre, descripcion, tipo, subtipo, fecha_inicio, fecha_fin, precio, disponible, img) VALUES ('Simple', 'Lechuga, Tomate y Cebolla',1, 2,DATE(NOW()), null,'13.50',1,'url');

INSERT INTO carta_comida (nombre, tipo, subtipo, fecha_inicio, fecha_fin, precio, disponible, img) VALUES ('Pulpo con Queso Tetilla',1, 3,DATE(NOW()), null,'21.00',1,'url');
INSERT INTO carta_comida (nombre, tipo, subtipo, fecha_inicio, fecha_fin, precio, disponible, img) VALUES ('Pulpo a feira',1, 3,DATE(NOW()), null,'20.00',1,'url');
INSERT INTO carta_comida (nombre, tipo, subtipo, fecha_inicio, fecha_fin, precio, disponible, img) VALUES ('Langostinos a la plancha',1, 3,DATE(NOW()), null,'18.00',1,'url');
INSERT INTO carta_comida (nombre, tipo, subtipo, fecha_inicio, fecha_fin, precio, disponible, img) VALUES ('Salteado de Chipirones con Trigueros y Champiñones',1, 3,DATE(NOW()), null,'13.00',1,'url');
INSERT INTO carta_comida (nombre, tipo, subtipo, fecha_inicio, fecha_fin, precio, disponible, img) VALUES ('Pastel de cabracho',1, 3,DATE(NOW()), null,'12.00',1,'url');
INSERT INTO carta_comida (nombre, tipo, subtipo, fecha_inicio, fecha_fin, precio, disponible, img) VALUES ('Calamares',1, 3,DATE(NOW()), null,'11.50',1,'url');
INSERT INTO carta_comida (nombre, tipo, subtipo, fecha_inicio, fecha_fin, precio, disponible, img) VALUES ('Mejillones a la vinagreta',1, 3,DATE(NOW()), null,'8.50',1,'url');
INSERT INTO carta_comida (nombre, tipo, subtipo, fecha_inicio, fecha_fin, precio, disponible, img) VALUES ('Mejillones al vapor',1, 3,DATE(NOW()), null,'7.00',1,'url');

INSERT INTO carta_comida (nombre, tipo, subtipo, fecha_inicio, fecha_fin, precio, disponible, img) VALUES ('Salteado de pulpo, setas y trigueros',1, 4,DATE(NOW()), null,'16.00',1,'url');
INSERT INTO carta_comida (nombre, tipo, subtipo, fecha_inicio, fecha_fin, precio, disponible, img) VALUES ('Fabada',1, 4,DATE(NOW()), null,'15.00',1,'url');
INSERT INTO carta_comida (nombre, tipo, subtipo, fecha_inicio, fecha_fin, precio, disponible, img) VALUES ('Involtini de berenjenas con Salsa Oporto',1, 4,DATE(NOW()), null,'13.50',1,'url');
INSERT INTO carta_comida (nombre, tipo, subtipo, fecha_inicio, fecha_fin, precio, disponible, img) VALUES ('Setas rellenas de Cecina y Tetilla con Salsa Gorgonzola',1, 4,DATE(NOW()), null,'13.50',1,'url');
INSERT INTO carta_comida (nombre, tipo, subtipo, fecha_inicio, fecha_fin, precio, disponible, img) VALUES ('Huevos rotos con salsa de Setas y Foie ',1, 4,DATE(NOW()), null,'12.50',1,'url');
INSERT INTO carta_comida (nombre, tipo, subtipo, fecha_inicio, fecha_fin, precio, disponible, img) VALUES ('Parrillada de verduras con Queso de Cabra',1, 4,DATE(NOW()), null,'11.50',1,'url');
INSERT INTO carta_comida (nombre, tipo, subtipo, fecha_inicio, fecha_fin, precio, disponible, img) VALUES ('Chicken Finger',1, 4,DATE(NOW()), null,'8.50',1,'url');
INSERT INTO carta_comida (nombre, tipo, subtipo, fecha_inicio, fecha_fin, precio, disponible, img) VALUES ('Pimientos de Padrón',1, 4,DATE(NOW()), null,'6.00',1,'url');
INSERT INTO carta_comida (nombre, tipo, subtipo, fecha_inicio, fecha_fin, precio, disponible, img) VALUES ('Pan (Por Persona)',1, 4,DATE(NOW()), null,'1.00',1,'url');

INSERT INTO carta_comida (nombre, tipo, fecha_inicio, fecha_fin, precio, disponible, img) VALUES ('Cigalas, Pulpo y Langostinos',2,DATE(NOW()), null,'23.00',1,'url');
INSERT INTO carta_comida (nombre, tipo, fecha_inicio, fecha_fin, precio, disponible, img) VALUES ('Arroz negro con calamares y pulpo',2, DATE(NOW()), null,'23.00',1,'url');
INSERT INTO carta_comida (nombre, descripcion, tipo, fecha_inicio, fecha_fin, precio, disponible, img) VALUES ('Meloso de Senyoret', 'Gambas, Mejillón y Calamar todo pelado',2,DATE(NOW()), null,'22.00',1,'url');
INSERT INTO carta_comida (nombre, tipo, fecha_inicio, fecha_fin, precio, disponible, img) VALUES ('Marisco',2,DATE(NOW()), null,'22.00',1,'url');
INSERT INTO carta_comida (nombre, tipo, fecha_inicio, fecha_fin, precio, disponible, img) VALUES ('Meloso de Ciervo y Hongos',2,DATE(NOW()), null,'20.00',1,'url');

INSERT INTO carta_comida (nombre, tipo, fecha_inicio, fecha_fin, precio, disponible, img) VALUES ('Solomillo de ternera con salsa oporto',3,DATE(NOW()), null,'23.00',1,'url');
INSERT INTO carta_comida (nombre, tipo, fecha_inicio, fecha_fin, precio, disponible, img) VALUES ('Entrecot de vaca con salsa de setas y foie',3, DATE(NOW()), null,'20.50',1,'url');
INSERT INTO carta_comida (nombre, tipo, fecha_inicio, fecha_fin, precio, disponible, img) VALUES ('Entrecot de vaca con salsa de queso',3,DATE(NOW()), null,'19.00',1,'url');
INSERT INTO carta_comida (nombre, tipo, fecha_inicio, fecha_fin, precio, disponible, img) VALUES ('Chuletillas de lechazo con ajo y aceite',3,DATE(NOW()), null,'18.00',1,'url');
INSERT INTO carta_comida (nombre, descripcion, tipo, fecha_inicio, fecha_fin, precio, disponible, img) VALUES ('Escalopines de ternera rellenos de setas con salsa a elegir','Salsa Foie o Salsa Gorgonzola',3,DATE(NOW()), null,'16.50',1,'url');

INSERT INTO carta_comida (nombre, tipo, fecha_inicio, fecha_fin, precio, disponible, img) VALUES ('Rodaballo',5,DATE(NOW()), null,'26.00',1,'url');
INSERT INTO carta_comida (nombre, tipo, fecha_inicio, fecha_fin, precio, disponible, img) VALUES ('Bacalao cocido con escalivada de pimiento',5, DATE(NOW()), null,'21.00',1,'url');
INSERT INTO carta_comida (nombre, tipo, fecha_inicio, fecha_fin, precio, disponible, img) VALUES ('Lubina a la espalda',5,DATE(NOW()), null,'21.00',1,'url');
INSERT INTO carta_comida (nombre, tipo, fecha_inicio, fecha_fin, precio, disponible, img) VALUES ('Dorada a la espaldacon ensalada y cachelo',5,DATE(NOW()), null,'20.00',1,'url');

INSERT INTO carta_comida (nombre, tipo, subtipo, fecha_inicio, fecha_fin, precio, disponible, img) VALUES ('Jamón, queso trufado y setas',4, 6,DATE(NOW()), null,'29.50',1,'url');
INSERT INTO carta_comida (nombre, tipo, subtipo, fecha_inicio, fecha_fin, precio, disponible, img) VALUES ('Jamón y queso gorgonzola',4, 6,DATE(NOW()), null,'27.00',1,'url');
INSERT INTO carta_comida (nombre, tipo, subtipo, fecha_inicio, fecha_fin, precio, disponible, img) VALUES ('Jamón, setas y tetilla',4, 6,DATE(NOW()), null,'28.00',1,'url');
INSERT INTO carta_comida (nombre, tipo, subtipo, fecha_inicio, fecha_fin, precio, disponible, img) VALUES ('Jamón y provolone',4, 6,DATE(NOW()), null,'26.00',1,'url');
INSERT INTO carta_comida (nombre, tipo, subtipo, fecha_inicio, fecha_fin, precio, disponible, img) VALUES ('Jamón y mozzarella',4, 6,DATE(NOW()), null,'26.00',1,'url');
INSERT INTO carta_comida (nombre, descripcion, tipo, subtipo, fecha_inicio, fecha_fin, precio, disponible, img) VALUES ('4 Quesos', 'Jamón serrano, tetilla, cabrales, oveja y provolone',4, 6,DATE(NOW()), null,'30.00',1,'url');
INSERT INTO carta_comida (nombre, tipo, subtipo, fecha_inicio, fecha_fin, precio, disponible, img) VALUES ('Jamón y tetilla',4, 6,DATE(NOW()), null,'26.00',1,'url');
INSERT INTO carta_comida (nombre, tipo, subtipo, fecha_inicio, fecha_fin, precio, disponible, img) VALUES ('Jamón, queso tetilla, cheddar, cebolla caramelizada y tomate',4, 6,DATE(NOW()), null,'30.00',1,'url');
INSERT INTO carta_comida (nombre, tipo, subtipo, fecha_inicio, fecha_fin, precio, disponible, img) VALUES ('Jamón, queso provolone y cebolla caramelizada',4, 6,DATE(NOW()), null,'28.00',1,'url');
INSERT INTO carta_comida (nombre, tipo, subtipo, fecha_inicio, fecha_fin, precio, disponible, img) VALUES ('Jamón, queso mozzarella, tomate y orégano',4, 6,DATE(NOW()), null,'26.00',1,'url');
INSERT INTO carta_comida (nombre, tipo, subtipo, fecha_inicio, fecha_fin, precio, disponible, img) VALUES ('Jamón, queso tetilla y tomate natural',4, 6,DATE(NOW()), null,'27.00',1,'url');
INSERT INTO carta_comida (nombre, tipo, subtipo, fecha_inicio, fecha_fin, precio, disponible, img) VALUES ('Jamón, setas y cabrales',4, 6,DATE(NOW()), null,'29.00',1,'url');
INSERT INTO carta_comida (nombre, tipo, subtipo, fecha_inicio, fecha_fin, precio, disponible, img) VALUES ('Jamón y queso de oveja',4, 6,DATE(NOW()), null,'26.00',1,'url');
INSERT INTO carta_comida (nombre, tipo, subtipo, fecha_inicio, fecha_fin, precio, disponible, img) VALUES ('Jamón y queso cabrales',4, 6,DATE(NOW()), null,'28.00',1,'url');
INSERT INTO carta_comida (nombre, tipo, subtipo, fecha_inicio, fecha_fin, precio, disponible, img) VALUES ('Jamón y rulo de cabra',4, 6,DATE(NOW()), null,'27.00',1,'url');
INSERT INTO carta_comida (nombre, tipo, subtipo, fecha_inicio, fecha_fin, precio, disponible, img) VALUES ('Jamón, queso gorgonzola y tomate natural',4, 6,DATE(NOW()), null,'29.00',1,'url');

INSERT INTO carta_comida (nombre, tipo, subtipo, fecha_inicio, fecha_fin, precio, disponible, img) VALUES ('Cecina, cebolla caramelizada, rulo de cabra y tomate natural',4, 7,DATE(NOW()), null,'31.00',1,'url');
INSERT INTO carta_comida (nombre, tipo, subtipo, fecha_inicio, fecha_fin, precio, disponible, img) VALUES ('Cecina, cebolla caramelizada y queso tetilla',4, 7,DATE(NOW()), null,'29.00',1,'url');
INSERT INTO carta_comida (nombre, tipo, subtipo, fecha_inicio, fecha_fin, precio, disponible, img) VALUES ('Cecina, cebolla caramelizada y provolone',4, 7,DATE(NOW()), null,'28.00',1,'url');
INSERT INTO carta_comida (nombre, tipo, subtipo, fecha_inicio, fecha_fin, precio, disponible, img) VALUES ('Cecina, pimientos asados y cabrales',4, 7,DATE(NOW()), null,'30.00',1,'url');
INSERT INTO carta_comida (nombre, tipo, subtipo, fecha_inicio, fecha_fin, precio, disponible, img) VALUES ('Cecina, rulo de cabra y tomate',4, 7,DATE(NOW()), null,'28.00',1,'url');
INSERT INTO carta_comida (nombre, tipo, subtipo, fecha_inicio, fecha_fin, precio, disponible, img) VALUES ('Cecina y queso de oveja',4, 7,DATE(NOW()), null,'25.00',1,'url');
INSERT INTO carta_comida (nombre, tipo, subtipo, fecha_inicio, fecha_fin, precio, disponible, img) VALUES ('Cecina y tetilla',4, 7,DATE(NOW()), null,'28.00',1,'url');
INSERT INTO carta_comida (nombre, tipo, subtipo, fecha_inicio, fecha_fin, precio, disponible, img) VALUES ('Cecina y rulo de cabra',4, 7,DATE(NOW()), null,'27.00',1,'url');
INSERT INTO carta_comida (nombre, tipo, subtipo, fecha_inicio, fecha_fin, precio, disponible, img) VALUES ('Cecina y mozzarella',4, 7,DATE(NOW()), null,'28.00',1,'url');

INSERT INTO carta_comida (nombre, tipo, subtipo, fecha_inicio, fecha_fin, precio, disponible, img) VALUES ('Pollo, jamón, rulo de cabra, cebolla caramelizada y tomate natural',4, 5,DATE(NOW()), null,'29.00',1,'url');
INSERT INTO carta_comida (nombre, tipo, subtipo, fecha_inicio, fecha_fin, precio, disponible, img) VALUES ('Pollo, jamón, cheddar, tetilla y tomate',4, 5,DATE(NOW()), null,'26.00',1,'url');
INSERT INTO carta_comida (nombre, tipo, subtipo, fecha_inicio, fecha_fin, precio, disponible, img) VALUES ('Pollo, bacon, cheddar, tetilla y salsa bbq',4, 5,DATE(NOW()), null,'29.00',1,'url');
INSERT INTO carta_comida (nombre, tipo, subtipo, fecha_inicio, fecha_fin, precio, disponible, img) VALUES ('Pollo, jamón y queso de oveja',4, 5,DATE(NOW()), null,'26.00',1,'url');
INSERT INTO carta_comida (nombre, tipo, subtipo, fecha_inicio, fecha_fin, precio, disponible, img) VALUES ('Pollo, bacon y tetilla',4, 5,DATE(NOW()), null,'27.00',1,'url');
INSERT INTO carta_comida (nombre, tipo, subtipo, fecha_inicio, fecha_fin, precio, disponible, img) VALUES ('Pollo, jamón y tetilla',4, 5,DATE(NOW()), null,'26.00',1,'url');
INSERT INTO carta_comida (nombre, tipo, subtipo, fecha_inicio, fecha_fin, precio, disponible, img) VALUES ('Pollo, bacon, cebolla caramelizada y tetilla',4, 5,DATE(NOW()), null,'29.00',1,'url');

INSERT INTO carta_comida (nombre, tipo, fecha_inicio, fecha_fin, precio, disponible, img) VALUES ('Brownie rock slide con helado de vainilla', 6,DATE(NOW()), null,'7.00',1,'url');
INSERT INTO carta_comida (nombre, tipo, fecha_inicio, fecha_fin, precio, disponible, img) VALUES ('Muerte por chocolate con salsa de chocolate fondant', 6,DATE(NOW()), null,'6.00',1,'url');
INSERT INTO carta_comida (nombre, tipo, fecha_inicio, fecha_fin, precio, disponible, img) VALUES ('Tarta de manzana con helado de vainilla', 6,DATE(NOW()), null,'6.00',1,'url');
INSERT INTO carta_comida (nombre, tipo, fecha_inicio, fecha_fin, precio, disponible, img) VALUES ('Tarta de queso al horno con salsa de frutos rojos', 6,DATE(NOW()), null,'5.50',1,'url');
INSERT INTO carta_comida (nombre, tipo, fecha_inicio, fecha_fin, precio, disponible, img) VALUES ('Profiteroles con helado y salsa de chocolate fondant', 6,DATE(NOW()), null,'5.25',1,'url');
INSERT INTO carta_comida (nombre, tipo, fecha_inicio, fecha_fin, precio, disponible, img) VALUES ('Helados', 6,DATE(NOW()), null,'5.00',1,'url');
INSERT INTO carta_comida (nombre, tipo, fecha_inicio, fecha_fin, precio, disponible, img) VALUES ('Tarta de la abuela', 6,DATE(NOW()), null,'5.00',1,'url');
INSERT INTO carta_comida (nombre, tipo, fecha_inicio, fecha_fin, precio, disponible, img) VALUES ('Arroz con leche', 6,DATE(NOW()), null,'4.50',1,'url');

INSERT INTO carta_alergenos (id_alergeno, id_comida) values (15,1);
INSERT INTO carta_alergenos (id_alergeno, id_comida) values (6,1);
INSERT INTO carta_alergenos (id_alergeno, id_comida) values (7,1);

INSERT INTO usuario (nombre, apellido1, apellido2, correo, fecha, num_telef, id_rol, estado_usuario, NIF, direccion, cp, contraseña) VALUES ('Guillermo','André','','guille1insua@gmail.com',DATE(NOW()),'667821250',4,'activado', '54a','','','123');
INSERT INTO usuario (nombre, apellido1, apellido2, correo, fecha, num_telef, id_rol, estado_usuario, NIF, direccion, cp, contraseña) VALUES ('Gabriel','Domínguez','Borines','cambes6@gmail.com',DATE(NOW()),'699204155',1, 'activado','','','','123a');
INSERT INTO usuario (nombre, apellido1, apellido2, correo, fecha, num_telef, id_rol, estado_usuario, NIF, direccion, cp, contraseña) VALUES ('Nuria','Buceta','García','nuriabuceta@gmail.com',DATE(NOW()),'622838028',4, 'activado','89j','','','123b');

INSERT INTO empresa (cif, nombre, nombre_sociedad, direccion, ciudad, cp, telefono, logo) VALUES ('B27788272','Novo Lua Chea','LUENGOS ANDRE S.L.','Rua de Eduardo Cabello, 25','Vigo','36208','986132537','url');


insert into factura (id_usuario, cif_empresa, precio, fecha, id_comida, total, modo_pago) values (2,'B27788272', 20, DATE(NOW()), 5, 20, 'efectivo');
insert into carrito (id_usuario, id_comida, cantidad) values (3, 4, 1);

select * from roles;
select * from carrito;
select * from carta_comida;
select * from tipo;
select * from subtipo;
select * from carta_alergenos;
select * from alergenos;
select img, nombre, descripcion, fecha_inicio, fecha_fin, precio from carta_comida;
select * from empresa;
select * from factura;
select * from carrito where id_usuario in (select id_usuario from factura);
select * from factura where id_usuario in (select id_usuario from carrito);
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

#DROP ROLE IF EXISTS 'administrador','gestor','trabajador';
#CREATE ROLE IF NOT EXISTS 'administrador';

GRANT SELECT, INSERT, UPDATE, DELETE, CREATE, DROP ON LuaChea.* TO Raul;
GRANT SELECT, INSERT, UPDATE ON LuaChea.* TO login;
#GRANT SELECT, INSERT, UPDATE, DELETE ON LuaChea.* TO gestor;
#GRANT SELECT ON LuaChea.* to trabajador;

#create role trabajador, registrado, sin_registrar;
#grant select on restaurante.* TO trabajador, registrado, sin_registrar;

#GRANT administrador TO 'administrador'@'localhost';
#GRANT 'administrador' TO 'Raul'@'localhost';
#GRANT gestor TO 'gabriel'@'localhost'; 
#GRANT trabajador TO 'nuria'@'localhost';
#GRANT administrador TO 'root'@'localhost';

FLUSH PRIVILEGES;

SHOW GRANTS;

###########################################################################################
CREATE TRIGGER elimina_usuario
BEFORE INSERT ON usuario
FOR EACH ROW
BEGIN
    SET NEW.fecha = IFNULL(NEW.fecha, NOW());
END;

CREATE EVENT elimina_usuario_event
ON SCHEDULE EVERY 1 DAY
DO
BEGIN
	DELETE FROM usuario WHERE activado = 0 AND fecha < DATE_SUB(NOW, INTERVAL 10 DAY);
END;
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

#insert into provincia values ('27','Lugo');

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