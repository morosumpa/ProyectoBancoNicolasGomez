-- Crear la base de datos
DROP DATABASE IF EXISTS DisBank;
CREATE DATABASE DisBank;
USE DisBank;

-- Tabla Usuario
CREATE TABLE Usuario (
    ID INT PRIMARY KEY AUTO_INCREMENT,
    DNI VARCHAR(10) UNIQUE,
    Nombre VARCHAR(255),
    Apellidos VARCHAR(255),
    Email VARCHAR(255),
    Fecha_nac DATE,
    Foto VARCHAR(255),
    Direccion VARCHAR(255),
    Codigo_postal VARCHAR(10),
    Ciudad VARCHAR(255),
    Provincia VARCHAR(255),
    Pais VARCHAR(255),
    Contrasenya VARCHAR(255)
);

-- Tabla Cuenta
CREATE TABLE Cuenta (
    ID INT PRIMARY KEY AUTO_INCREMENT,
    IBAN VARCHAR(20) UNIQUE,
    Saldo DECIMAL(10,2),
    Tipo_cuenta VARCHAR(255),
    Estado_cuenta VARCHAR(255),
    ID_usuario INT,
    FOREIGN KEY (ID_usuario) REFERENCES Usuario(ID)
);

-- Tabla Movimientos
CREATE TABLE Movimientos (
    ID INT PRIMARY KEY AUTO_INCREMENT,
    Cantidad DECIMAL(10,2),
    Tipo_movimiento VARCHAR(255),
    IBAN VARCHAR(20),
    Fecha_hora TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    ID_usuario INT,
    FOREIGN KEY (IBAN) REFERENCES Cuenta(IBAN),
    FOREIGN KEY (ID_usuario) REFERENCES Usuario(ID)
);

-- Tabla Chat
CREATE TABLE Chat (
    ID_mensaje INT PRIMARY KEY AUTO_INCREMENT,
    Mensajes TEXT,
    Fecha_hora TIMESTAMP,
    Estado_mensaje VARCHAR(255),
    ID_usuario_1 INT,
    ID_usuario_2 INT,
    FOREIGN KEY (ID_usuario_1) REFERENCES Usuario(ID),
    FOREIGN KEY (ID_usuario_2) REFERENCES Usuario(ID)
);

-- Tabla Estandar
CREATE TABLE Estandar (
    ID_usuario INT PRIMARY KEY,
    Nivel_acceso INT,
    FOREIGN KEY (ID_usuario) REFERENCES Usuario(ID)
);

-- Tabla Administrador
CREATE TABLE Administrador (
    ID_usuario INT PRIMARY KEY,
    Nivel_acceso INT,
    Registro_actividades TEXT,
    FOREIGN KEY (ID_usuario) REFERENCES Usuario(ID)
);

-- Tabla Registro
CREATE TABLE Registro (
    ID_usuario INT PRIMARY KEY,
    Fecha_hora_registro TIMESTAMP,
    Tipo_accion VARCHAR(50),
    Descripcion TEXT,
    FOREIGN KEY (ID_usuario) REFERENCES Usuario(ID)
);

-- Tabla Login
CREATE TABLE Login (
    ID_usuario INT PRIMARY KEY,
    Clave VARCHAR(255),
    FOREIGN KEY (ID_usuario) REFERENCES Usuario(ID)
);

-- Tabla Prestamos
CREATE TABLE Prestamos (
    ID_prestamo INT PRIMARY KEY AUTO_INCREMENT,
    DNI_usuario VARCHAR(10) UNIQUE,
    Monto_pedido DECIMAL(10,2),
    Descripcion varchar(1000),
    Monto_prestado DECIMAL(10,2),
    Tasa_interes DECIMAL(5,2),
    Plazo_meses INT,
    Fecha_inicio TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    Fecha_final DATE,
    Estado VARCHAR(20),
    FOREIGN KEY (DNI_usuario) REFERENCES Usuario(DNI)
);

-- Tabla CambioMoneda
CREATE TABLE CambioMoneda (
    ID INT PRIMARY KEY AUTO_INCREMENT,
    IBAN_origen VARCHAR(20),
    Moneda_origen VARCHAR(255),
    Moneda_destino VARCHAR(255),
    Monto_origen DECIMAL(10,2),
    Monto_destino DECIMAL(10,2),
    Tasa_cambio DECIMAL(10,2),
    Fecha_hora TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (IBAN_origen) REFERENCES Cuenta(IBAN)
);
INSERT INTO Usuario (DNI, Nombre, Apellidos, Email, Fecha_nac, Foto, Direccion, Codigo_postal, Ciudad, Provincia, Pais, Contrasenya)
VALUES (
    '123456789A', 
    'Admin',      
    'Admin',      
    'admin@example.com', 
    '2000-01-01',  
    'default.jpg', 
    'Calle Admin 123', 
    '12345',       
    'Ciudad Admin',
    'Provincia Admin',
    'Pais Admin', 
    'admin'       
);

-- Modificar la tabla Movimientos
ALTER TABLE Movimientos
ADD COLUMN DNI_usuario VARCHAR(10),
ADD FOREIGN KEY (DNI_usuario) REFERENCES Usuario(DNI);

SELECT
    Movimientos.*,
    Cuenta.IBAN,
    Cuenta.Saldo,
    Usuario.ID AS ID_usuario,  
    Usuario.DNI AS DNI_usuario
FROM
    Movimientos
LEFT JOIN Cuenta ON Movimientos.IBAN = Cuenta.IBAN
LEFT JOIN Usuario ON Movimientos.ID_usuario = Usuario.ID;


SELECT IBAN, Saldo FROM Cuenta WHERE ID_usuario = 1;

SELECT IBAN FROM Cuenta WHERE ID_usuario = (SELECT ID FROM Usuario WHERE DNI = '123456');


select * from usuario;
select * from cuenta;
select * from CambioMoneda;
select * from Movimientos;

select * from Prestamos;

select * from Registro;
select * from Login;

