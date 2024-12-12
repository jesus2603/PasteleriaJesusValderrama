DROP DATABASE IF EXISTS pasteleria;
CREATE DATABASE IF NOT EXISTS pasteleria;

USE pasteleria;

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL-- ,
    -- isadmin TINYINT NOT NULL default=0;
);

CREATE TABLE dulces (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    precio DECIMAL(10, 2) NOT NULL
);

-- Dulces de ejemplo
INSERT INTO dulces (nombre, precio) VALUES
('Tarta de Chocolate', 15.99),
('Croissant', 2.00),
('Tarta de Fresa', 18.75),
('Brownie de Chocolate', 10.00),
('Tarta de Queso', 16.50),
('Bizcocho de Limón', 8.00),
('Galletas de Chocolate', 3.00);


select * from usuarios;