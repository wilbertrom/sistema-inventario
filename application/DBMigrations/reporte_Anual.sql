CREATE TABLE reporte_anual (
    id INT AUTO_INCREMENT PRIMARY KEY,
    año YEAR NOT NULL
);

INSERT INTO reporte_anual values (null, 2024);

CREATE TABLE categorias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre_categoria VARCHAR(255) NOT NULL
);

CREATE TABLE servicio(
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre_servicio VARCHAR(255) NOT NULL,
    categoria_id INT,
    FOREIGN KEY (categoria_id) REFERENCES categorias(id)
);

INSERT INTO categorias values (null, "Suministros"), (null, "Sistemas de seguridad"), (null, "Condiciones");

INSERT INTO servicio values (null, "Aire a presion", 1), (null, "Agua", 1), (null, "Gas", 1), (null, "Electricidad", 1), (null, "Vapor", 1), (null, "Aire comprimido", 1), (null, "Otros", 1);

INSERT INTO servicio values (null, "Extintores", 2), (null, "Regaderas", 2), (null, "Lavaojos", 2), (null, "Extractores de gases", 2), (null, "Botiquín", 2), (null, "Alarma contra Incendio y Emergencia (pánico)", 2), (null, "Rutas de evacuacion de Emergencia y RPBI", 2), (null, "Sistema de Monitoreo por Cámaras", 2), (null, "otros", 2);

INSERT INTO servicio values (null, "Orden y limpieza", 3), (null, "Ventilación", 3), (null, "Iluminación", 3), (null, "Recipientes para basura", 3), (null, "Contenedores especiales", 3), (null, "Manejo de Residuos Biologico, Infecciosos, Punzocortantes y Químicos", 3), (null, "Otros", 3); 

CREATE TABLE registro_mensual (
    id INT AUTO_INCREMENT PRIMARY KEY,
    reporte_id INT,
    servicio_id INT,
    mes INT(2) NOT NULL,
    status ENUM('SI', 'NO', 'NA', '') NOT NULL,
    FOREIGN KEY (reporte_id) REFERENCES reporte_anual(id),
    FOREIGN KEY (servicio_id) REFERENCES servicio(id),
	UNIQUE (reporte_id, servicio_id, mes));