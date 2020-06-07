CREATE DATABASE db_domosoft;

USE db_domosoft;

CREATE TABLE temperatura(

Id      int(255) primary key auto_increment not null,

Valor 	decimal(10,2),

Fecha	 TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

Lugar varchar(255),

Id_Dispositivo varchar(255),

Red	varchar(255),

Ip varchar(255)

)ENGINE=InnoDb;

CREATE TABLE humedad(

Id      int(255) primary key auto_increment not null,

Valor 	decimal(10,2),

Fecha	 TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

Lugar varchar(255),

Id_Dispositivo varchar(255),

Red	varchar(255),

Ip varchar(255)

)ENGINE=InnoDb;

CREATE TABLE led(

Id      int(255) primary key auto_increment not null,

Valor 	BIT,

Fecha	 TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

Id_Dispositivo varchar(255),

Lugar varchar(255),

Red	varchar(255),

Ip varchar(255)

)ENGINE=InnoDb;

CREATE TABLE token(

Id      int(255) primary key auto_increment not null,

Fecha	 TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

Id_Dispositivo varchar(255),

token varchar(255)

)ENGINE=InnoDb;

