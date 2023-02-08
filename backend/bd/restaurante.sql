SET NAMES UTF8;
drop database if exists restaurante;
create database if not exists restaurante;

use restaurante;

create table if not exists usuario(
id_usuario int auto_increment,
nombre varchar(40) not null,
apellido1 varchar(40) not null,
apellido2 varchar(40) null,
correo varchar(40) not null unique,
fecha date not null,
num_telef varchar(9) not null,
rol enum('anonimo','registrado','administrador') not null default 'anonimo',
contraseña varchar(40) not null unique,

constraint pk_idUsuario primary key (id_usuario)
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

constraint pk_id primary key (id_comida),
constraint ck_tipo check (tipo in ('entrantes','arroz','carne','cachopo','pescado','postre','bebida'))
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

create table if not exists factura(
id_factura int auto_increment,
id_usuario int not null,
cif_empresa varchar(10) not null,
precio float not null,
fecha date not null,
producto varchar(100) not null, #ES UN ARRAY KEY:VALUE(id_comida:nombre) POR LO TANTO NO ES UN FK 
total int not null,
modo_pago enum('efectivo','tarjeta','otro modo') not null default 'efectivo',

constraint pk_id_factura primary key (id_factura),
constraint ck_pago check (modo_pago in ('efectivo','tarjeta','otro modo'))
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

create table if not exists empresa
( cif varchar(10) not null,
nombre varchar(120) not null,
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
array_producto varchar(100) not null,
#id_producto int not null,
#cantidad int not null,
#fecha Date not null,
constraint pk_id primary key (id_carro)
);

###########################################################################################
#FOREIGN KEYS
ALTER TABLE factura ADD FOREIGN KEY (id_usuario) REFERENCES usuario(id_usuario);
ALTER TABLE factura ADD FOREIGN KEY (cif_empresa) REFERENCES empresa(cif);

ALTER TABLE carrito ADD FOREIGN KEY (id_usuario) REFERENCES usuario(id_usuario);

#ALTER TABLE carro ADD CONSTRAINT FK_ArrayProducto FOREIGN KEY (array_producto) REFERENCES factura(producto);

###########################################################################################

###########################################################################################
#INSERT
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

INSERT INTO usuario (nombre, apellido1, apellido2, correo, fecha, num_telef, rol, contraseña) VALUES ('LUENGOS ANDRE','SL','','restaurante@b01.daw2d.iesteis.gal',DATE(NOW()),'628746312','administrador','Restaurante@1');
INSERT INTO usuario (nombre, apellido1, apellido2, correo, fecha, num_telef, rol, contraseña) VALUES ('Gabriel','Domínguez','Borines','gabrieldb@iesteis.gal',DATE(NOW()),'689526341','registrado','abc123..');
INSERT INTO usuario (nombre, apellido1, apellido2, correo, fecha, num_telef, rol, contraseña) VALUES ('Nuria','Buceta','García','nuriabg@iesteis.gal',DATE(NOW()),'621456983','registrado','abc123...');

select * from carrito;
select * from carta_comida;
select * from empresa;
select * from factura;
select * from usuario;

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

################################################################################
CREATE USER IF NOT EXISTS administrador IDENTIFIED BY 'renaido2023';

GRANT SELECT, INSERT, UPDATE, DELETE, CREATE, DROP
    ON restaurante.*
	TO 'root'@'localhost';

GRANT SELECT, INSERT, UPDATE, DELETE, CREATE, DROP
    ON restaurante.*
	TO 'administrador'@'localhost';
    
FLUSH PRIVILEGES;

select * from mysql.user;
################################################################################