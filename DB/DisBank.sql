DROP DATABASE IF EXISTS DisBank;
CREATE DATABASE DisBanK;
USE DisBank;

-- Crear la tabla Usuario
CREATE TABLE Usuario (
    DNI VARCHAR(10) PRIMARY KEY,
    Nombre VARCHAR(50),
    Apellidos VARCHAR(50),
    Email VARCHAR(100),
    Fecha_nac DATE,
    Foto VARCHAR(255),
    Direccion VARCHAR(100),
    Codigo_postal VARCHAR(10),
    Ciudad VARCHAR(50),
    Provincia VARCHAR(50),
    Pais VARCHAR(50),
    IBAN VARCHAR(20) UNIQUE
);

-- Crear la tabla Cuenta
CREATE TABLE Cuenta (
    IBAN VARCHAR(20) PRIMARY KEY,
    Saldo DECIMAL(10,2),
    Tipo_cuenta VARCHAR(20),
    Estado_cuenta VARCHAR(20),
    FOREIGN KEY (IBAN) REFERENCES Usuario(IBAN)
);

-- Crear la tabla Transferencias
CREATE TABLE Transferencias (
    ID_transferencia INT PRIMARY KEY,
    Monto DECIMAL(10,2),
    Fecha_hora TIMESTAMP,
    Estado_transferencia VARCHAR(20),
    Comentarios TEXT,
    Cuenta_origen VARCHAR(20),
    Cuenta_destino VARCHAR(20),
    FOREIGN KEY (Cuenta_origen) REFERENCES Cuenta(IBAN),
    FOREIGN KEY (Cuenta_destino) REFERENCES Cuenta(IBAN)
);

-- Crear la tabla Chat
CREATE TABLE Chat (
    ID_mensaje INT PRIMARY KEY,
    Mensajes TEXT,
    Fecha_hora TIMESTAMP,
    Estado_mensaje VARCHAR(20),
    DNI_1 VARCHAR(10),
    DNI_2 VARCHAR(10),
    FOREIGN KEY (DNI_1) REFERENCES Usuario(DNI),
    FOREIGN KEY (DNI_2) REFERENCES Usuario(DNI)
);

-- Crear la tabla Estandar
CREATE TABLE Estandar (
    DNI VARCHAR(10) PRIMARY KEY,
    Nivel_acceso INT,
    FOREIGN KEY (DNI) REFERENCES Usuario(DNI)
);

-- Crear la tabla Administrador
CREATE TABLE Administrador (
    DNI VARCHAR(10) PRIMARY KEY,
    Nivel_acceso INT,
    Registro_actividades TEXT,
    FOREIGN KEY (DNI) REFERENCES Usuario(DNI)
);

-- Crear la tabla Registro
CREATE TABLE Registro (
    DNI VARCHAR(10) PRIMARY KEY,
    Fecha_hora_registro TIMESTAMP,
    Tipo_accion VARCHAR(50),
    Descripcion TEXT,
    FOREIGN KEY (DNI) REFERENCES Usuario(DNI)
);

-- Crear la tabla Login
CREATE TABLE Login (
    DNI VARCHAR(10) PRIMARY KEY,
    Clave VARCHAR(255),
    FOREIGN KEY (DNI) REFERENCES Usuario(DNI)
);

-- Crear la tabla Prestamos
CREATE TABLE Prestamos (
    ID_prestamo INT PRIMARY KEY,
    DNI_usuario VARCHAR(10),
    Monto_prestado DECIMAL(10,2),
    Tasa_interes DECIMAL(5,2),
    Plazo_meses INT,
    Fecha_inicio DATE,
    Estado VARCHAR(20),
    FOREIGN KEY (DNI_usuario) REFERENCES Usuario(DNI)
);
