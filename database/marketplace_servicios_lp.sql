DROP DATABASE IF EXISTS marketplace_servicios_lp;

CREATE DATABASE marketplace_servicios_lp
CHARACTER SET utf8mb4
COLLATE utf8mb4_general_ci;

USE marketplace_servicios_lp;

-- =========================
-- ROLES
-- =========================
CREATE TABLE roles (
    id_rol INT AUTO_INCREMENT PRIMARY KEY,
    nombre_rol VARCHAR(50) NOT NULL UNIQUE,
    descripcion VARCHAR(255),
    estado TINYINT(1) DEFAULT 1,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- =========================
-- USUARIOS
-- =========================
CREATE TABLE usuarios (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    id_rol INT NOT NULL,
    nombre VARCHAR(100) NOT NULL,
    apellido VARCHAR(100) NOT NULL,
    correo VARCHAR(120) NOT NULL UNIQUE,
    celular VARCHAR(20) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    estado ENUM('ACTIVO', 'INACTIVO', 'BLOQUEADO') DEFAULT 'ACTIVO',
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_usuario_rol
        FOREIGN KEY (id_rol) REFERENCES roles(id_rol)
        ON UPDATE CASCADE
        ON DELETE RESTRICT
);

-- =========================
-- CLIENTES
-- =========================
CREATE TABLE clientes (
    id_cliente INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL UNIQUE,
    direccion_referencia VARCHAR(255) NOT NULL,
    zona VARCHAR(100) NOT NULL,

    CONSTRAINT fk_cliente_usuario
        FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario)
        ON UPDATE CASCADE
        ON DELETE CASCADE
);

-- =========================
-- CATEGORIAS
-- =========================
CREATE TABLE categorias (
    id_categoria INT AUTO_INCREMENT PRIMARY KEY,
    nombre_categoria VARCHAR(100) NOT NULL UNIQUE,
    descripcion VARCHAR(255),
    estado TINYINT(1) DEFAULT 1,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- =========================
-- PROFESIONALES
-- =========================
CREATE TABLE profesionales (
    id_profesional INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL UNIQUE,
    id_categoria INT NOT NULL,

    tipo_documento_identidad ENUM('CI', 'NIT') NOT NULL,
    numero_documento VARCHAR(30) NOT NULL UNIQUE,

    experiencia_anios INT NOT NULL DEFAULT 0,
    descripcion_servicio TEXT NOT NULL,
    zona_trabajo VARCHAR(100) NOT NULL,

    estado_validacion ENUM('PENDIENTE', 'APROBADO', 'RECHAZADO') DEFAULT 'PENDIENTE',
    estado_disponibilidad ENUM('DISPONIBLE', 'NO_DISPONIBLE') DEFAULT 'NO_DISPONIBLE',

    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_profesional_usuario
        FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario)
        ON UPDATE CASCADE
        ON DELETE CASCADE,

    CONSTRAINT fk_profesional_categoria
        FOREIGN KEY (id_categoria) REFERENCES categorias(id_categoria)
        ON UPDATE CASCADE
        ON DELETE RESTRICT
);

-- =========================
-- DOCUMENTOS DEL PROFESIONAL
-- =========================
CREATE TABLE documentos_profesional (
    id_documento INT AUTO_INCREMENT PRIMARY KEY,
    id_profesional INT NOT NULL,

    tipo_documento_archivo ENUM(
        'CERTIFICADO_TECNICO',
        'REFERENCIA_LABORAL',
        'CI_ANVERSO',
        'CI_REVERSO',
        'NIT',
        'OTRO'
    ) NOT NULL DEFAULT 'CERTIFICADO_TECNICO',

    archivo VARCHAR(255) NOT NULL,
    estado_revision ENUM('PENDIENTE', 'APROBADO', 'RECHAZADO') DEFAULT 'PENDIENTE',
    observacion VARCHAR(255),
    fecha_subida TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_documento_profesional
        FOREIGN KEY (id_profesional) REFERENCES profesionales(id_profesional)
        ON UPDATE CASCADE
        ON DELETE CASCADE
);

-- =========================
-- SOLICITUDES DE SERVICIO
-- =========================
CREATE TABLE solicitudes_servicio (
    id_solicitud INT AUTO_INCREMENT PRIMARY KEY,
    id_cliente INT NOT NULL,
    id_profesional INT NOT NULL,
    descripcion_problema TEXT NOT NULL,
    direccion_servicio VARCHAR(255) NOT NULL,
    zona VARCHAR(100) NOT NULL,
    estado_servicio ENUM('PENDIENTE', 'ACEPTADA', 'EN_PROCESO', 'FINALIZADA', 'CANCELADA') DEFAULT 'PENDIENTE',
    fecha_solicitud TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_solicitud_cliente
        FOREIGN KEY (id_cliente) REFERENCES clientes(id_cliente)
        ON UPDATE CASCADE
        ON DELETE RESTRICT,

    CONSTRAINT fk_solicitud_profesional
        FOREIGN KEY (id_profesional) REFERENCES profesionales(id_profesional)
        ON UPDATE CASCADE
        ON DELETE RESTRICT
);

-- =========================
-- CALIFICACIONES
-- =========================
CREATE TABLE calificaciones (
    id_calificacion INT AUTO_INCREMENT PRIMARY KEY,
    id_solicitud INT NOT NULL UNIQUE,
    puntuacion INT NOT NULL,
    comentario VARCHAR(255),
    fecha_calificacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT chk_puntuacion CHECK (puntuacion BETWEEN 1 AND 5),

    CONSTRAINT fk_calificacion_solicitud
        FOREIGN KEY (id_solicitud) REFERENCES solicitudes_servicio(id_solicitud)
        ON UPDATE CASCADE
        ON DELETE CASCADE
);

-- =========================
-- UBICACION GPS
-- =========================
CREATE TABLE ubicacion_gps (
    id_ubicacion INT AUTO_INCREMENT PRIMARY KEY,
    id_profesional INT NOT NULL UNIQUE,
    latitud DECIMAL(10,6) NOT NULL,
    longitud DECIMAL(10,6) NOT NULL,
    ultima_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    CONSTRAINT fk_ubicacion_profesional
        FOREIGN KEY (id_profesional) REFERENCES profesionales(id_profesional)
        ON UPDATE CASCADE
        ON DELETE CASCADE
);

-- =========================
-- DATOS INICIALES
-- =========================
INSERT INTO roles (nombre_rol, descripcion) VALUES
('SUPER_ADMIN', 'Usuario con control total del sistema'),
('ADMIN', 'Usuario administrador del sistema'),
('PROFESIONAL', 'Usuario que ofrece servicios técnicos'),
('CLIENTE', 'Usuario que solicita servicios técnicos');

INSERT INTO categorias (nombre_categoria, descripcion) VALUES
('Electricista', 'Instalaciones eléctricas, cableado, mantenimiento, enchufes, térmicos y reparaciones eléctricas.'),
('Técnico electrónico', 'Reparación y mantenimiento de equipos electrónicos, placas, televisores, radios y dispositivos similares.');