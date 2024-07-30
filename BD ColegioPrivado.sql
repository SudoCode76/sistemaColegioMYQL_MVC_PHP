CREATE DATABASE colegioPrivado;
USE colegioPrivado;


CREATE TABLE EMPLEADO
(
    codEmpleado      INT AUTO_INCREMENT,
    cedulaIdEmpleado VARCHAR(15)  NOT NULL,
    nombre           VARCHAR(45)  NOT NULL,
    apellido         VARCHAR(45)  NOT NULL,
    tipoEmpleado     VARCHAR(45)  NOT NULL,
    direccion        VARCHAR(100) NOT NULL,
    celular          VARCHAR(15),
    correo           VARCHAR(45),
    estado           VARCHAR(45),
    CONSTRAINT PK_EMPLEADO PRIMARY KEY (codEmpleado)
);


CREATE TABLE MATERIA
(
    codMateria    INT AUTO_INCREMENT,
    nombreMateria VARCHAR(45) NOT NULL,
    gestion       VARCHAR(4)  NOT NULL,
    CONSTRAINT PK_MATERIA PRIMARY KEY (codMateria)
);

CREATE TABLE CURSO
(
    codCurso    INT AUTO_INCREMENT,
    nombreCurso VARCHAR(45) NOT NULL,
    nivel       VARCHAR(45) NOT NULL,
    CONSTRAINT PK_CURSO PRIMARY KEY (codCurso)
);

CREATE TABLE CURSOMATERIA
(
    codCursoMateria INT AUTO_INCREMENT,
    codCurso        INT,
    codMateria      INT,
    CONSTRAINT PK_CURSOMATERIA PRIMARY KEY (codCursoMateria),
    CONSTRAINT FK_CURSOMATERIA_CURSO FOREIGN KEY (codCurso) REFERENCES CURSO (codCurso),
    CONSTRAINT FK_CURSOMATERIA_MATERIA FOREIGN KEY (codMateria) REFERENCES MATERIA (codMateria)
);

CREATE TABLE SALARIO
(
    codSalario  INT AUTO_INCREMENT,
    tipoSalario VARCHAR(45)    NOT NULL,
    monto       DECIMAL(10, 2) NOT NULL,
    codEmpleado INT,
    frecuencia  VARCHAR(45) DEFAULT 'Mensual',
    CONSTRAINT PK_SALARIO PRIMARY KEY (codSalario),
    CONSTRAINT FK_SALARIO_EMPLEADO FOREIGN KEY (codEmpleado) REFERENCES EMPLEADO (codEmpleado)
);



CREATE TABLE ASIGNACIONCURSO
(
    codAsignacion   INT AUTO_INCREMENT,
    fechaAsignacion DATE,
    codEmpleado     INT,
    codCursoMateria INT,
    CONSTRAINT PK_ASIGNACIONCURSO PRIMARY KEY (codAsignacion),
    CONSTRAINT FK_ASIGNACIONCURSO_EMPLEADO FOREIGN KEY (codEmpleado) REFERENCES EMPLEADO (codEmpleado),
    CONSTRAINT FK_ASIGNACIONCURSO_CURSOMATERIA FOREIGN KEY (codCursoMateria) REFERENCES CURSOMATERIA (codCursoMateria)
);

CREATE TABLE HORARIO
(
    codHorario      INT AUTO_INCREMENT,
    periodo         VARCHAR(45) NOT NULL,
    horaInicio      TIME        NOT NULL,
    horaFin         TIME        NOT NULL,
    codCursoMateria INT,
    CONSTRAINT PK_HORARIO PRIMARY KEY (codHorario),
    CONSTRAINT FK_HORARIO_CURSOMATERIA FOREIGN KEY (codCursoMateria) REFERENCES CURSOMATERIA (codCursoMateria)
);



CREATE TABLE ASISTENCIA
(
    codAsistencia INT AUTO_INCREMENT,
    estado        VARCHAR(45),
    fecha         DATE NOT NULL,
    CONSTRAINT PK_ASISTENCIA PRIMARY KEY (codAsistencia)
);

CREATE TABLE ESTUDIANTE
(
    codEstudiante      INT AUTO_INCREMENT,
    cedulaIdEstudiante VARCHAR(15) NOT NULL,
    nombre             VARCHAR(45) NOT NULL,
    apellido           VARCHAR(45) NOT NULL,
    nacionalidad       VARCHAR(45),
    genero             VARCHAR(45),
    tutor              VARCHAR(45),
    direccion          VARCHAR(100),
    estado             VARCHAR(45),
    fechaNacimiento    DATE,
    celular            VARCHAR(15),
    correo             VARCHAR(45),
    codAsistencia      INT,
    CONSTRAINT PK_ESTUDIANTE PRIMARY KEY (codEstudiante),
    CONSTRAINT FK_ESTUDIANTE_ASISTENCIA FOREIGN KEY (codAsistencia) REFERENCES ASISTENCIA (codAsistencia)
);
SELECT *
FROM ESTUDIANTE;

CREATE TABLE NOTA
(
    codNota         INT AUTO_INCREMENT,
    codEstudiante   INT           NOT NULL,
    codCursoMateria INT           NOT NULL,
    trimestre       VARCHAR(45)   NOT NULL,
    nota            DECIMAL(5, 2) NOT NULL,
    CONSTRAINT PK_NOTA PRIMARY KEY (codNota),
    CONSTRAINT FK_NOTA_ESTUDIANTE FOREIGN KEY (codEstudiante) REFERENCES ESTUDIANTE (codEstudiante),
    CONSTRAINT FK_NOTA_CURSOMATERIA FOREIGN KEY (codCursoMateria) REFERENCES CURSOMATERIA (codCursoMateria)
);


-- Crear la tabla de roles
CREATE TABLE ROL
(
    codRol INT AUTO_INCREMENT,
    nombre VARCHAR(30),
    CONSTRAINT PK_ROL PRIMARY KEY (codRol)
);

-- Crear la tabla de usuarios
CREATE TABLE USUARIO
(
    codUsuario    INT AUTO_INCREMENT,
    nombreUsuario VARCHAR(45) NOT NULL,
    contrasenia   VARCHAR(45) NOT NULL,
    codRol        INT,
    codEmpleado   INT,
    CONSTRAINT PK_USUARIO PRIMARY KEY (codUsuario),
    CONSTRAINT FK_ROL FOREIGN KEY (codRol) REFERENCES ROL (codRol),
    CONSTRAINT FK_USUARIO_EMPLEADO FOREIGN KEY (codEmpleado) REFERENCES EMPLEADO (codEmpleado)
);


CREATE TABLE PAGO_MENSUAL
(
    codPago     INT AUTO_INCREMENT,
    codEmpleado INT            NOT NULL,
    mesPago     DATE           NOT NULL,
    monto       DECIMAL(10, 2) NOT NULL,
    estadoPago  VARCHAR(45)    NOT NULL DEFAULT 'Pendiente',
    CONSTRAINT PK_PAGO_MENSUAL PRIMARY KEY (codPago),
    CONSTRAINT FK_PAGO_MENSUAL_EMPLEADO FOREIGN KEY (codEmpleado) REFERENCES EMPLEADO (codEmpleado)
);



CREATE TABLE PAGO_MENSUALIDAD_ESTUDIANTE
(
    codPago       INT AUTO_INCREMENT,
    codEstudiante INT            NOT NULL,
    mesPago       DATE           NOT NULL,
    monto         DECIMAL(10, 2) NOT NULL,
    estadoPago    VARCHAR(45)    NOT NULL DEFAULT 'Pendiente',
    CONSTRAINT PK_PAGO_MENSUALIDAD_ESTUDIANTE PRIMARY KEY (codPago),
    CONSTRAINT FK_PAGO_MENSUALIDAD_ESTUDIANTE_ESTUDIANTE FOREIGN KEY (codEstudiante) REFERENCES ESTUDIANTE (codEstudiante)
);

DELIMITER //
CREATE TRIGGER after_student_insert
    AFTER INSERT
    ON ESTUDIANTE
    FOR EACH ROW
BEGIN
    INSERT INTO PAGO_MENSUALIDAD_ESTUDIANTE (codEstudiante, mesPago, monto, estadoPago)
    VALUES (NEW.codEstudiante, CURDATE(), 500.00, 'Pendiente');
END;
//
DELIMITER ;


-- Insertar 20 registros en la tabla EMPLEADO
INSERT INTO EMPLEADO (cedulaIdEmpleado, nombre, apellido, tipoEmpleado, direccion, celular, correo, estado)
VALUES
('1234567890', 'Juan', 'Pérez', 'Profesor', 'Av. Siempre Viva 123', '123456789', 'juan.perez@example.com', 'Activo'),
('1234567891', 'María', 'García', 'Profesor', 'Calle Falsa 456', '123456788', 'maria.garcia@example.com', 'Activo'),
('1234567892', 'Pedro', 'Martínez', 'Secretaria', 'Av. Central 789', '123456787', 'pedro.martinez@example.com', 'Activo'),
('1234567893', 'Ana', 'López', 'Secretaria', 'Calle Principal 321', '123456786', 'ana.lopez@example.com', 'Activo'),
('1234567894', 'Luis', 'González', 'Profesor', 'Av. Las Flores 654', '123456785', 'luis.gonzalez@example.com', 'Activo'),
('1234567895', 'Elena', 'Rodríguez', 'Profesor', 'Calle Secundaria 987', '123456784', 'elena.rodriguez@example.com', 'Activo'),
('1234567896', 'Carlos', 'Fernández', 'Profesor', 'Av. Las Palmas 123', '123456783', 'carlos.fernandez@example.com', 'Activo'),
('1234567897', 'Sofía', 'Gómez', 'Secretaria', 'Calle Tercera 456', '123456782', 'sofia.gomez@example.com', 'Activo'),
('1234567898', 'Jorge', 'Díaz', 'Profesor', 'Av. Los Álamos 789', '123456781', 'jorge.diaz@example.com', 'Activo'),
('1234567899', 'Laura', 'Sánchez', 'Secretaria', 'Calle Cuarta 321', '123456780', 'laura.sanchez@example.com', 'Activo'),
('1234567810', 'Miguel', 'Ramírez', 'Profesor', 'Av. Los Pinos 654', '123456779', 'miguel.ramirez@example.com', 'Activo'),
('1234567811', 'Julia', 'Torres', 'Profesor', 'Calle Quinta 987', '123456778', 'julia.torres@example.com', 'Activo'),
('1234567812', 'Ricardo', 'Vargas', 'Profesor', 'Av. Los Robles 123', '123456777', 'ricardo.vargas@example.com', 'Activo'),
('1234567813', 'Patricia', 'Castro', 'Secretaria', 'Calle Sexta 456', '123456776', 'patricia.castro@example.com', 'Activo'),
('1234567814', 'Daniel', 'Ríos', 'Profesor', 'Av. Los Cedros 789', '123456775', 'daniel.rios@example.com', 'Activo'),
('1234567815', 'Angela', 'Mendoza', 'Secretaria', 'Calle Séptima 321', '123456774', 'angela.mendoza@example.com', 'Activo'),
('1234567816', 'Fernando', 'Ortiz', 'Profesor', 'Av. Las Acacias 654', '123456773', 'fernando.ortiz@example.com', 'Activo'),
('1234567817', 'Sara', 'Morales', 'Secretaria', 'Calle Octava 987', '123456772', 'sara.morales@example.com', 'Activo'),
('1234567818', 'Alberto', 'Herrera', 'Profesor', 'Av. Los Laureles 123', '123456771', 'alberto.herrera@example.com', 'Activo'),
('1234567819', 'Gabriela', 'Rojas', 'Secretaria', 'Calle Novena 456', '123456770', 'gabriela.rojas@example.com', 'Activo');

-- Insertar 20 registros en la tabla MATERIA
INSERT INTO MATERIA (nombreMateria, gestion)
VALUES
('Matemáticas', '2024'),
('Lenguaje', '2024'),
('Ciencias', '2024'),
('Historia', '2024'),
('Geografía', '2024'),
('Física', '2024'),
('Química', '2024'),
('Biología', '2024'),
('Inglés', '2024'),
('Arte', '2024'),
('Música', '2024'),
('Educación Física', '2024'),
('Tecnología', '2024'),
('Economía', '2024'),
('Filosofía', '2024'),
('Psicología', '2024'),
('Sociología', '2024'),
('Civismo', '2024'),
('Informática', '2024'),
('Religión', '2024');

-- Insertar 20 registros en la tabla CURSO
INSERT INTO CURSO (nombreCurso, nivel)
VALUES
('Primero', 'Primaria'),
('Segundo', 'Primaria'),
('Tercero', 'Primaria'),
('Cuarto', 'Primaria'),
('Quinto', 'Primaria'),
('Sexto', 'Primaria'),
('Primero', 'Secundaria'),
('Segundo', 'Secundaria'),
('Tercero', 'Secundaria'),
('Cuarto', 'Secundaria'),
('Quinto', 'Secundaria'),
('Sexto', 'Secundaria'),
('Primero', 'Bachillerato'),
('Segundo', 'Bachillerato'),
('Tercero', 'Bachillerato'),
('Cuarto', 'Bachillerato'),
('Quinto', 'Bachillerato'),
('Sexto', 'Bachillerato'),
('Séptimo', 'Bachillerato'),
('Octavo', 'Bachillerato');

-- Insertar 20 registros en la tabla CURSOMATERIA
INSERT INTO CURSOMATERIA (codCurso, codMateria)
VALUES
(1, 1), (2, 2), (3, 3), (4, 4), (5, 5),
(6, 6), (7, 7), (8, 8), (9, 9), (10, 10),
(11, 11), (12, 12), (13, 13), (14, 14), (15, 15),
(16, 16), (17, 17), (18, 18), (19, 19), (20, 20);

-- Insertar 20 registros en la tabla SALARIO
INSERT INTO SALARIO (tipoSalario, monto, codEmpleado, frecuencia)
VALUES
('Base', 1500.00, 1, 'Mensual'),
('Base', 1500.00, 2, 'Mensual'),
('Base', 1500.00, 3, 'Mensual'),
('Base', 1500.00, 4, 'Mensual'),
('Base', 1500.00, 5, 'Mensual'),
('Base', 1500.00, 6, 'Mensual'),
('Base', 1500.00, 7, 'Mensual'),
('Base', 1500.00, 8, 'Mensual'),
('Base', 1500.00, 9, 'Mensual'),
('Base', 1500.00, 10, 'Mensual'),
('Base', 1500.00, 11, 'Mensual'),
('Base', 1500.00, 12, 'Mensual'),
('Base', 1500.00, 13, 'Mensual'),
('Base', 1500.00, 14, 'Mensual'),
('Base', 1500.00, 15, 'Mensual'),
('Base', 1500.00, 16, 'Mensual'),
('Base', 1500.00, 17, 'Mensual'),
('Base', 1500.00, 18, 'Mensual'),
('Base', 1500.00, 19, 'Mensual'),
('Base', 1500.00, 20, 'Mensual');

-- Insertar 20 registros en la tabla ASIGNACIONCURSO
INSERT INTO ASIGNACIONCURSO (fechaAsignacion, codEmpleado, codCursoMateria)
VALUES
('2024-01-01', 1, 1),
('2024-01-02', 2, 2),
('2024-01-03', 3, 3),
('2024-01-04', 4, 4),
('2024-01-05', 5, 5),
('2024-01-06', 6, 6),
('2024-01-07', 7, 7),
('2024-01-08', 8, 8),
('2024-01-09', 9, 9),
('2024-01-10', 10, 10),
('2024-01-11', 11, 11),
('2024-01-12', 12, 12),
('2024-01-13', 13, 13),
('2024-01-14', 14, 14),
('2024-01-15', 15, 15),
('2024-01-16', 16, 16),
('2024-01-17', 17, 17),
('2024-01-18', 18, 18),
('2024-01-19', 19, 19),
('2024-01-20', 20, 20);

-- Insertar 20 registros en la tabla HORARIO
INSERT INTO HORARIO (periodo, horaInicio, horaFin, codCursoMateria)
VALUES
('Mañana', '08:00:00', '09:00:00', 1),
('Mañana', '09:00:00', '10:00:00', 2),
('Mañana', '10:00:00', '11:00:00', 3),
('Mañana', '11:00:00', '12:00:00', 4),
('Tarde', '14:00:00', '15:00:00', 5),
('Tarde', '15:00:00', '16:00:00', 6),
('Tarde', '16:00:00', '17:00:00', 7),
('Tarde', '17:00:00', '18:00:00', 8),
('Mañana', '08:00:00', '09:00:00', 9),
('Mañana', '09:00:00', '10:00:00', 10),
('Mañana', '10:00:00', '11:00:00', 11),
('Mañana', '11:00:00', '12:00:00', 12),
('Tarde', '14:00:00', '15:00:00', 13),
('Tarde', '15:00:00', '16:00:00', 14),
('Tarde', '16:00:00', '17:00:00', 15),
('Tarde', '17:00:00', '18:00:00', 16),
('Mañana', '08:00:00', '09:00:00', 17),
('Mañana', '09:00:00', '10:00:00', 18),
('Mañana', '10:00:00', '11:00:00', 19),
('Mañana', '11:00:00', '12:00:00', 20);

-- Insertar 20 registros en la tabla ASISTENCIA
INSERT INTO ASISTENCIA (estado, fecha)
VALUES
('Presente', '2024-01-01'),
('Ausente', '2024-01-02'),
('Presente', '2024-01-03'),
('Ausente', '2024-01-04'),
('Presente', '2024-01-05'),
('Ausente', '2024-01-06'),
('Presente', '2024-01-07'),
('Ausente', '2024-01-08'),
('Presente', '2024-01-09'),
('Ausente', '2024-01-10'),
('Presente', '2024-01-11'),
('Ausente', '2024-01-12'),
('Presente', '2024-01-13'),
('Ausente', '2024-01-14'),
('Presente', '2024-01-15'),
('Ausente', '2024-01-16'),
('Presente', '2024-01-17'),
('Ausente', '2024-01-18'),
('Presente', '2024-01-19'),
('Ausente', '2024-01-20');

-- Insertar 20 registros en la tabla ESTUDIANTE
INSERT INTO ESTUDIANTE (cedulaIdEstudiante, nombre, apellido, nacionalidad, genero, tutor, direccion, estado, fechaNacimiento, celular, correo, codAsistencia)
VALUES
('2345678901', 'Juan', 'López', 'Boliviana', 'Masculino', 'Pedro López', 'Calle 1', 'Activo', '2010-01-01', '1234567890', 'juan.lopez@example.com', 1),
('2345678902', 'María', 'Pérez', 'Boliviana', 'Femenino', 'Ana Pérez', 'Calle 2', 'Activo', '2010-01-02', '1234567891', 'maria.perez@example.com', 2),
('2345678903', 'Pedro', 'González', 'Boliviana', 'Masculino', 'Juan González', 'Calle 3', 'Activo', '2010-01-03', '1234567892', 'pedro.gonzalez@example.com', 3),
('2345678904', 'Ana', 'García', 'Boliviana', 'Femenino', 'María García', 'Calle 4', 'Activo', '2010-01-04', '1234567893', 'ana.garcia@example.com', 4),
('2345678905', 'Luis', 'Martínez', 'Boliviana', 'Masculino', 'Carlos Martínez', 'Calle 5', 'Activo', '2010-01-05', '1234567894', 'luis.martinez@example.com', 5),
('2345678906', 'Elena', 'Rodríguez', 'Boliviana', 'Femenino', 'Pedro Rodríguez', 'Calle 6', 'Activo', '2010-01-06', '1234567895', 'elena.rodriguez@example.com', 6),
('2345678907', 'Carlos', 'Hernández', 'Boliviana', 'Masculino', 'Ana Hernández', 'Calle 7', 'Activo', '2010-01-07', '1234567896', 'carlos.hernandez@example.com', 7),
('2345678908', 'Sofía', 'Díaz', 'Boliviana', 'Femenino', 'Luis Díaz', 'Calle 8', 'Activo', '2010-01-08', '1234567897', 'sofia.diaz@example.com', 8),
('2345678909', 'Jorge', 'Fernández', 'Boliviana', 'Masculino', 'Miguel Fernández', 'Calle 9', 'Activo', '2010-01-09', '1234567898', 'jorge.fernandez@example.com', 9),
('2345678910', 'Laura', 'Gómez', 'Boliviana', 'Femenino', 'Juan Gómez', 'Calle 10', 'Activo', '2010-01-10', '1234567899', 'laura.gomez@example.com', 10),
('2345678911', 'Miguel', 'Sánchez', 'Boliviana', 'Masculino', 'Pedro Sánchez', 'Calle 11', 'Activo', '2010-01-11', '1234567810', 'miguel.sanchez@example.com', 11),
('2345678912', 'Julia', 'Ramírez', 'Boliviana', 'Femenino', 'Ana Ramírez', 'Calle 12', 'Activo', '2010-01-12', '1234567811', 'julia.ramirez@example.com', 12),
('2345678913', 'Ricardo', 'Torres', 'Boliviana', 'Masculino', 'Carlos Torres', 'Calle 13', 'Activo', '2010-01-13', '1234567812', 'ricardo.torres@example.com', 13),
('2345678914', 'Patricia', 'Vargas', 'Boliviana', 'Femenino', 'Luis Vargas', 'Calle 14', 'Activo', '2010-01-14', '1234567813', 'patricia.vargas@example.com', 14),
('2345678915', 'Daniel', 'Castro', 'Boliviana', 'Masculino', 'Juan Castro', 'Calle 15', 'Activo', '2010-01-15', '1234567814', 'daniel.castro@example.com', 15),
('2345678916', 'Angela', 'Ríos', 'Boliviana', 'Femenino', 'Pedro Ríos', 'Calle 16', 'Activo', '2010-01-16', '1234567815', 'angela.rios@example.com', 16),
('2345678917', 'Fernando', 'Mendoza', 'Boliviana', 'Masculino', 'Ana Mendoza', 'Calle 17', 'Activo', '2010-01-17', '1234567816', 'fernando.mendoza@example.com', 17),
('2345678918', 'Sara', 'Ortiz', 'Boliviana', 'Femenino', 'Luis Ortiz', 'Calle 18', 'Activo', '2010-01-18', '1234567817', 'sara.ortiz@example.com', 18),
('2345678919', 'Alberto', 'Morales', 'Boliviana', 'Masculino', 'Carlos Morales', 'Calle 19', 'Activo', '2010-01-19', '1234567818', 'alberto.morales@example.com', 19),
('2345678920', 'Gabriela', 'Herrera', 'Boliviana', 'Femenino', 'Pedro Herrera', 'Calle 20', 'Activo', '2010-01-20', '1234567819', 'gabriela.herrera@example.com', 20);

-- Insertar 20 registros en la tabla NOTA
INSERT INTO NOTA (codEstudiante, codCursoMateria, trimestre, nota)
VALUES
(1, 1, 'Primer Trimestre', 85.5),
(2, 2, 'Primer Trimestre', 90.0),
(3, 3, 'Primer Trimestre', 78.5),
(4, 4, 'Primer Trimestre', 88.0),
(5, 5, 'Primer Trimestre', 92.0),
(6, 6, 'Primer Trimestre', 80.5),
(7, 7, 'Primer Trimestre', 87.5),
(8, 8, 'Primer Trimestre', 91.0),
(9, 9, 'Primer Trimestre', 89.0),
(10, 10, 'Primer Trimestre', 93.5),
(11, 11, 'Primer Trimestre', 84.0),
(12, 12, 'Primer Trimestre', 79.0),
(13, 13, 'Primer Trimestre', 88.5),
(14, 14, 'Primer Trimestre', 90.5),
(15, 15, 'Primer Trimestre', 85.0),
(16, 16, 'Primer Trimestre', 92.5),
(17, 17, 'Primer Trimestre', 81.0),
(18, 18, 'Primer Trimestre', 86.0),
(19, 19, 'Primer Trimestre', 89.5),
(20, 20, 'Primer Trimestre', 94.0);

-- Insertar 20 registros en la tabla PAGO_MENSUAL
INSERT INTO PAGO_MENSUAL (codEmpleado, mesPago, monto, estadoPago)
VALUES
(1, '2024-01-01', 1500.00, 'Pendiente'),
(2, '2024-02-01', 1500.00, 'Pendiente'),
(3, '2024-03-01', 1500.00, 'Pendiente'),
(4, '2024-04-01', 1500.00, 'Pendiente'),
(5, '2024-05-01', 1500.00, 'Pendiente'),
(6, '2024-06-01', 1500.00, 'Pendiente'),
(7, '2024-07-01', 1500.00, 'Pendiente'),
(8, '2024-08-01', 1500.00, 'Pendiente'),
(9, '2024-09-01', 1500.00, 'Pendiente'),
(10, '2024-10-01', 1500.00, 'Pendiente'),
(11, '2024-11-01', 1500.00, 'Pendiente'),
(12, '2024-12-01', 1500.00, 'Pendiente'),
(13, '2025-01-01', 1500.00, 'Pendiente'),
(14, '2025-02-01', 1500.00, 'Pendiente'),
(15, '2025-03-01', 1500.00, 'Pendiente'),
(16, '2025-04-01', 1500.00, 'Pendiente'),
(17, '2025-05-01', 1500.00, 'Pendiente'),
(18, '2025-06-01', 1500.00, 'Pendiente'),
(19, '2025-07-01', 1500.00, 'Pendiente'),
(20, '2025-08-01', 1500.00, 'Pendiente');

-- Insertar 20 registros en la tabla PAGO_MENSUALIDAD_ESTUDIANTE
INSERT INTO PAGO_MENSUALIDAD_ESTUDIANTE (codEstudiante, mesPago, monto, estadoPago)
VALUES
(1, '2024-01-01', 500.00, 'Pendiente'),
(2, '2024-02-01', 500.00, 'Pendiente'),
(3, '2024-03-01', 500.00, 'Pendiente'),
(4, '2024-04-01', 500.00, 'Pendiente'),
(5, '2024-05-01', 500.00, 'Pendiente'),
(6, '2024-06-01', 500.00, 'Pendiente'),
(7, '2024-07-01', 500.00, 'Pendiente'),
(8, '2024-08-01', 500.00, 'Pendiente'),
(9, '2024-09-01', 500.00, 'Pendiente'),
(10, '2024-10-01', 500.00, 'Pendiente'),
(11, '2024-11-01', 500.00, 'Pendiente'),
(12, '2024-12-01', 500.00, 'Pendiente'),
(13, '2025-01-01', 500.00, 'Pendiente'),
(14, '2025-02-01', 500.00, 'Pendiente'),
(15, '2025-03-01', 500.00, 'Pendiente'),
(16, '2025-04-01', 500.00, 'Pendiente'),
(17, '2025-05-01', 500.00, 'Pendiente'),
(18, '2025-06-01', 500.00, 'Pendiente'),
(19, '2025-07-01', 500.00, 'Pendiente'),
(20, '2025-08-01', 500.00, 'Pendiente');


-- Insertar registros en la tabla de roles
INSERT INTO ROL (nombre)
VALUES ('Director'),
       ('Profesor'),
       ('Secretaria'),
       ('Estudiante'),
       ('Administrador');



-- Insertar registros en la tabla de usuarios
INSERT INTO USUARIO (nombreUsuario, contrasenia, codRol, codEmpleado)
VALUES ('director1', 'password1', 1, NULL),   -- Director sin relación con empleado
       ('profesor1', 'password2', 2, 1),      -- Profesor relacionado con empleado Juan Pérez
       ('secretaria1', 'password3', 3, 3),    -- Secretaria relacionada con empleado Pedro Martínez
       ('estudiante1', 'password4', 4, NULL), -- Estudiante sin relación con empleado
       ('director2', 'password5', 1, NULL),   -- Otro Director sin relación con empleado
       ('profesor2', 'password6', 2, 2),      -- Otro Profesor relacionado con empleado María García
       ('secretaria2', 'password7', 3, 4),    -- Otra Secretaria relacionada con empleado Ana López
       ('estudiante2', 'password8', 4, NULL), -- Otro Estudiante sin relación con empleado
       ('admin', 'admin', 5, NULL); -- Administrador sin relación con empleado



SELECT * FROM ESTUDIANTE;