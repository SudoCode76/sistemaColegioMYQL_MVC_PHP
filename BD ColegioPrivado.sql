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

CREATE TABLE PADRE
(
    codPadre   INT AUTO_INCREMENT,
    cedulaId   VARCHAR(15) NOT NULL,
    nombre     VARCHAR(45) NOT NULL,
    apellido   VARCHAR(45) NOT NULL,
    estado     VARCHAR(45),
    direccion  VARCHAR(100),
    telefono   VARCHAR(15),
    parentesco VARCHAR(45),
    genero     VARCHAR(45),
    CONSTRAINT PK_PADRE PRIMARY KEY (codPadre)
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
    codPadre           INT,
    codAsistencia      INT,
    CONSTRAINT PK_ESTUDIANTE PRIMARY KEY (codEstudiante),
    CONSTRAINT FK_ESTUDIANTE_PADRE FOREIGN KEY (codPadre) REFERENCES PADRE (codPadre),
    CONSTRAINT FK_ESTUDIANTE_ASISTENCIA FOREIGN KEY (codAsistencia) REFERENCES ASISTENCIA (codAsistencia)
);
SELECT * FROM ESTUDIANTE;

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
    CONSTRAINT PK_USUARIO PRIMARY KEY (codUsuario),
    CONSTRAINT FK_ROL FOREIGN KEY (codRol) REFERENCES ROL (codRol)
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


INSERT INTO EMPLEADO (cedulaIdEmpleado, nombre, apellido, tipoEmpleado, direccion, celular, correo, estado)
VALUES ('12345678', 'Juan', 'Pérez', 'Docente', 'Av. Principal 123', '789654321', 'juan.perez@example.com', 'Activo'),
       ('23456789', 'María', 'García', 'Docente', 'Calle Secundaria 456', '789654322', 'maria.garcia@example.com',
        'Activo'),
       ('34567890', 'Pedro', 'Martínez', 'Administrativo', 'Av. Tercera 789', '789654323', 'pedro.martinez@example.com',
        'Activo'),
       ('45678901', 'Ana', 'López', 'Docente', 'Calle Cuarta 101', '789654324', 'ana.lopez@example.com', 'Activo'),
       ('56789012', 'Luis', 'González', 'Administrativo', 'Av. Quinta 202', '789654325', 'luis.gonzalez@example.com',
        'Activo'),
       ('67890123', 'Elena', 'Ramírez', 'Docente', 'Calle Sexta 303', '789654326', 'elena.ramirez@example.com',
        'Activo'),
       ('78901234', 'Carlos', 'Sánchez', 'Administrativo', 'Av. Séptima 404', '789654327', 'carlos.sanchez@example.com',
        'Activo'),
       ('89012345', 'Laura', 'Torres', 'Docente', 'Calle Octava 505', '789654328', 'laura.torres@example.com',
        'Activo'),
       ('90123456', 'Jorge', 'Fernández', 'Docente', 'Av. Novena 606', '789654329', 'jorge.fernandez@example.com',
        'Activo'),
       ('01234567', 'Sofía', 'Mendoza', 'Administrativo', 'Calle Décima 707', '789654330', 'sofia.mendoza@example.com',
        'Activo'),
       ('12345679', 'Miguel', 'Hernández', 'Docente', 'Av. Undécima 808', '789654331', 'miguel.hernandez@example.com',
        'Activo'),
       ('23456780', 'Carmen', 'Jiménez', 'Administrativo', 'Calle Duodécima 909', '789654332',
        'carmen.jimenez@example.com', 'Activo'),
       ('34567891', 'José', 'Ruiz', 'Docente', 'Av. Decimotercera 1010', '789654333', 'jose.ruiz@example.com',
        'Activo'),
       ('45678902', 'Verónica', 'Ortega', 'Administrativo', 'Calle Decimocuarta 1111', '789654334',
        'veronica.ortega@example.com', 'Activo'),
       ('56789013', 'Ricardo', 'Castro', 'Docente', 'Av. Decimoquinta 1212', '789654335', 'ricardo.castro@example.com',
        'Activo'),
       ('67890124', 'Patricia', 'Núñez', 'Administrativo', 'Calle Decimosexta 1313', '789654336',
        'patricia.nunez@example.com', 'Activo'),
       ('78901235', 'Fernando', 'Silva', 'Docente', 'Av. Decimoséptima 1414', '789654337', 'fernando.silva@example.com',
        'Activo'),
       ('89012346', 'Marta', 'Rojas', 'Administrativo', 'Calle Decimoctava 1515', '789654338',
        'marta.rojas@example.com', 'Activo'),
       ('90123457', 'Andrés', 'Paredes', 'Docente', 'Av. Decimonovena 1616', '789654339', 'andres.paredes@example.com',
        'Activo'),
       ('01234568', 'Isabel', 'Peña', 'Administrativo', 'Calle Vigésima 1717', '789654340', 'isabel.pena@example.com',
        'Activo');

INSERT INTO MATERIA (nombreMateria, gestion)
VALUES ('Matemáticas', '2024'),
       ('Lenguaje', '2024'),
       ('Historia', '2024'),
       ('Geografía', '2024'),
       ('Ciencias', '2024'),
       ('Biología', '2024'),
       ('Química', '2024'),
       ('Física', '2024'),
       ('Inglés', '2024'),
       ('Educación Física', '2024'),
       ('Arte', '2024'),
       ('Música', '2024'),
       ('Tecnología', '2024'),
       ('Informática', '2024'),
       ('Filosofía', '2024'),
       ('Economía', '2024'),
       ('Psicología', '2024'),
       ('Literatura', '2024'),
       ('Sociología', '2024'),
       ('Ética', '2024');

INSERT INTO CURSO (nombreCurso, nivel)
VALUES ('Primero de Secundaria', 'Secundaria'),
       ('Segundo de Secundaria', 'Secundaria'),
       ('Tercero de Secundaria', 'Secundaria'),
       ('Cuarto de Secundaria', 'Secundaria'),
       ('Pre Promo', 'Secundaria'),
       ('Promo', 'Secundaria');

INSERT INTO CURSOMATERIA (codCurso, codMateria)
VALUES
-- Primero de Secundaria
(1, 1),  -- Matemáticas
(1, 2),  -- Lenguaje
(1, 3),  -- Historia
(1, 4),  -- Geografía
(1, 5),  -- Ciencias
(1, 6),  -- Biología
(1, 9),  -- Inglés
(1, 10), -- Educación Física

-- Segundo de Secundaria
(2, 1),  -- Matemáticas
(2, 2),  -- Lenguaje
(2, 3),  -- Historia
(2, 4),  -- Geografía
(2, 5),  -- Ciencias
(2, 7),  -- Química
(2, 9),  -- Inglés
(2, 10), -- Educación Física

-- Tercero de Secundaria
(3, 1),  -- Matemáticas
(3, 2),  -- Lenguaje
(3, 3),  -- Historia
(3, 4),  -- Geografía
(3, 8),  -- Física
(3, 9),  -- Inglés
(3, 10), -- Educación Física
(3, 11), -- Arte

-- Cuarto de Secundaria
(4, 1),  -- Matemáticas
(4, 2),  -- Lenguaje
(4, 3),  -- Historia
(4, 4),  -- Geografía
(4, 7),  -- Química
(4, 8),  -- Física
(4, 9),  -- Inglés
(4, 10), -- Educación Física
(4, 12), -- Música

-- Pre Promo
(5, 1),  -- Matemáticas
(5, 2),  -- Lenguaje
(5, 3),  -- Historia
(5, 4),  -- Geografía
(5, 7),  -- Química
(5, 8),  -- Física
(5, 9),  -- Inglés
(5, 10), -- Educación Física
(5, 13), -- Tecnología

-- Promo
(6, 1),  -- Matemáticas
(6, 2),  -- Lenguaje
(6, 3),  -- Historia
(6, 4),  -- Geografía
(6, 7),  -- Química
(6, 8),  -- Física
(6, 9),  -- Inglés
(6, 10), -- Educación Física
(6, 14), -- Informática
(6, 15), -- Filosofía
(6, 16), -- Economía
(6, 17); -- Psicología

INSERT INTO SALARIO (tipoSalario, monto, codEmpleado)
VALUES ('Mensual', 2500.00, 1),
       ('Mensual', 2600.00, 2),
       ('Mensual', 2700.00, 3),
       ('Mensual', 2800.00, 4),
       ('Mensual', 2900.00, 5),
       ('Mensual', 3000.00, 6),
       ('Mensual', 3100.00, 7),
       ('Mensual', 3200.00, 8),
       ('Mensual', 3300.00, 9),
       ('Mensual', 3400.00, 10),
       ('Mensual', 3500.00, 11),
       ('Mensual', 3600.00, 12),
       ('Mensual', 3700.00, 13),
       ('Mensual', 3800.00, 14),
       ('Mensual', 3900.00, 15),
       ('Mensual', 4000.00, 16),
       ('Mensual', 4100.00, 17),
       ('Mensual', 4200.00, 18),
       ('Mensual', 4300.00, 19),
       ('Mensual', 4400.00, 20);

INSERT INTO ASIGNACIONCURSO (fechaAsignacion, codEmpleado, codCursoMateria)
VALUES ('2024-01-01', 1, 1),
       ('2024-01-01', 2, 2),
       ('2024-01-01', 4, 4),
       ('2024-01-01', 6, 6),
       ('2024-01-01', 8, 8);


INSERT INTO HORARIO (periodo, horaInicio, horaFin, codCursoMateria)
VALUES ('Mañana', '08:00:00', '09:00:00', 1),
       ('Mañana', '09:00:00', '10:00:00', 2),
       ('Mañana', '10:00:00', '11:00:00', 3),
       ('Mañana', '11:00:00', '12:00:00', 4),
       ('Tarde', '13:00:00', '14:00:00', 5),
       ('Tarde', '14:00:00', '15:00:00', 6),
       ('Tarde', '15:00:00', '16:00:00', 7),
       ('Tarde', '16:00:00', '17:00:00', 8),
       ('Mañana', '08:00:00', '09:00:00', 9),
       ('Mañana', '09:00:00', '10:00:00', 10),
       ('Mañana', '10:00:00', '11:00:00', 11),
       ('Mañana', '11:00:00', '12:00:00', 12),
       ('Tarde', '13:00:00', '14:00:00', 13),
       ('Tarde', '14:00:00', '15:00:00', 14),
       ('Tarde', '15:00:00', '16:00:00', 15),
       ('Tarde', '16:00:00', '17:00:00', 16),
       ('Mañana', '08:00:00', '09:00:00', 17),
       ('Mañana', '09:00:00', '10:00:00', 18),
       ('Mañana', '10:00:00', '11:00:00', 19),
       ('Mañana', '11:00:00', '12:00:00', 20);

INSERT INTO PADRE (cedulaId, nombre, apellido, estado, direccion, telefono, parentesco, genero)
VALUES ('123456789', 'Juan', 'Pérez', 'Activo', 'Av. Principal 123', '789654321', 'Padre', 'Masculino'),
       ('234567890', 'María', 'García', 'Activo', 'Calle Secundaria 456', '789654322', 'Madre', 'Femenino'),
       ('345678901', 'Carlos', 'Rodríguez', 'Activo', 'Av. Tercera 789', '789654323', 'Padre', 'Masculino'),
       ('456789012', 'Ana', 'Martínez', 'Activo', 'Calle Cuarta 101', '789654324', 'Madre', 'Femenino'),
       ('567890123', 'Luis', 'González', 'Activo', 'Av. Quinta 202', '789654325', 'Padre', 'Masculino'),
       ('678901234', 'Elena', 'López', 'Activo', 'Calle Sexta 303', '789654326', 'Madre', 'Femenino'),
       ('789012345', 'Pedro', 'Ramírez', 'Activo', 'Av. Séptima 404', '789654327', 'Padre', 'Masculino'),
       ('890123456', 'Laura', 'Sánchez', 'Activo', 'Calle Octava 505', '789654328', 'Madre', 'Femenino'),
       ('901234567', 'Jorge', 'Fernández', 'Activo', 'Av. Novena 606', '789654329', 'Padre', 'Masculino'),
       ('012345678', 'Sofía', 'Mendoza', 'Activo', 'Calle Décima 707', '789654330', 'Madre', 'Femenino'),
       ('123456780', 'Miguel', 'Hernández', 'Activo', 'Av. Undécima 808', '789654331', 'Padre', 'Masculino'),
       ('234567891', 'Carmen', 'Jiménez', 'Activo', 'Calle Duodécima 909', '789654332', 'Madre', 'Femenino'),
       ('345678902', 'José', 'Ruiz', 'Activo', 'Av. Decimotercera 1010', '789654333', 'Padre', 'Masculino'),
       ('456789013', 'Verónica', 'Ortega', 'Activo', 'Calle Decimocuarta 1111', '789654334', 'Madre', 'Femenino'),
       ('567890124', 'Ricardo', 'Castro', 'Activo', 'Av. Decimoquinta 1212', '789654335', 'Padre', 'Masculino'),
       ('678901235', 'Patricia', 'Núñez', 'Activo', 'Calle Decimosexta 1313', '789654336', 'Madre', 'Femenino'),
       ('789012346', 'Fernando', 'Silva', 'Activo', 'Av. Decimoséptima 1414', '789654337', 'Padre', 'Masculino'),
       ('890123457', 'Marta', 'Rojas', 'Activo', 'Calle Decimoctava 1515', '789654338', 'Madre', 'Femenino'),
       ('901234568', 'Andrés', 'Paredes', 'Activo', 'Av. Decimonovena 1616', '789654339', 'Padre', 'Masculino'),
       ('012345679', 'Isabel', 'Peña', 'Activo', 'Calle Vigésima 1717', '789654340', 'Madre', 'Femenino');

INSERT INTO ASISTENCIA (estado, fecha)
VALUES ('Presente', '2024-01-01'),
       ('Ausente', '2024-01-01'),
       ('Tarde', '2024-01-01'),
       ('Presente', '2024-01-02'),
       ('Ausente', '2024-01-02'),
       ('Tarde', '2024-01-02'),
       ('Presente', '2024-01-03'),
       ('Ausente', '2024-01-03'),
       ('Tarde', '2024-01-03'),
       ('Presente', '2024-01-04'),
       ('Ausente', '2024-01-04'),
       ('Tarde', '2024-01-04'),
       ('Presente', '2024-01-05'),
       ('Ausente', '2024-01-05'),
       ('Tarde', '2024-01-05'),
       ('Presente', '2024-01-06'),
       ('Ausente', '2024-01-06'),
       ('Tarde', '2024-01-06'),
       ('Presente', '2024-01-07'),
       ('Ausente', '2024-01-07');

INSERT INTO ESTUDIANTE (cedulaIdEstudiante, nombre, apellido, nacionalidad, genero, tutor, direccion, estado,
                        fechaNacimiento, celular, correo, codPadre, codAsistencia)
VALUES ('1000001', 'Ana', 'Sánchez', 'Boliviana', 'Femenino', 'Juan Pérez', 'Calle 1', 'Activo', '2008-01-15',
        '123456789', 'ana.sanchez@example.com', 1, 1),
       ('1000002', 'Luis', 'Pérez', 'Boliviana', 'Masculino', 'María García', 'Calle 2', 'Activo', '2007-02-20',
        '123456780', 'luis.perez@example.com', 2, 2),
       ('1000003', 'Carlos', 'Rodríguez', 'Boliviana', 'Masculino', 'Carlos Rodríguez', 'Calle 3', 'Activo',
        '2008-03-25', '123456781', 'carlos.rodriguez@example.com', 3, 3),
       ('1000004', 'María', 'López', 'Boliviana', 'Femenino', 'Ana Martínez', 'Calle 4', 'Activo', '2007-04-10',
        '123456782', 'maria.lopez@example.com', 4, 4),
       ('1000005', 'José', 'Fernández', 'Boliviana', 'Masculino', 'Luis González', 'Calle 5', 'Activo', '2008-05-05',
        '123456783', 'jose.fernandez@example.com', 5, 5),
       ('1000006', 'Elena', 'Ramírez', 'Boliviana', 'Femenino', 'Elena López', 'Calle 6', 'Activo', '2007-06-12',
        '123456784', 'elena.ramirez@example.com', 6, 6),
       ('1000007', 'Jorge', 'García', 'Boliviana', 'Masculino', 'Pedro Ramírez', 'Calle 7', 'Activo', '2008-07-18',
        '123456785', 'jorge.garcia@example.com', 7, 7),
       ('1000008', 'Laura', 'Martínez', 'Boliviana', 'Femenino', 'Laura Sánchez', 'Calle 8', 'Activo', '2007-08-22',
        '123456786', 'laura.martinez@example.com', 8, 8),
       ('1000009', 'Miguel', 'Hernández', 'Boliviana', 'Masculino', 'Jorge Fernández', 'Calle 9', 'Activo',
        '2008-09-30', '123456787', 'miguel.hernandez@example.com', 9, 9),
       ('1000010', 'Sofía', 'Jiménez', 'Boliviana', 'Femenino', 'Sofía Mendoza', 'Calle 10', 'Activo', '2007-10-15',
        '123456788', 'sofia.jimenez@example.com', 10, 10),
       ('1000011', 'Andrés', 'Ruiz', 'Boliviana', 'Masculino', 'Miguel Hernández', 'Calle 11', 'Activo', '2008-11-20',
        '123456789', 'andres.ruiz@example.com', 11, 11),
       ('1000012', 'Carmen', 'Ortega', 'Boliviana', 'Femenino', 'Carmen Jiménez', 'Calle 12', 'Activo', '2007-12-25',
        '123456790', 'carmen.ortega@example.com', 12, 12),
       ('1000013', 'José', 'Castro', 'Boliviana', 'Masculino', 'José Ruiz', 'Calle 13', 'Activo', '2008-01-05',
        '123456791', 'jose.castro@example.com', 13, 13),
       ('1000014', 'Patricia', 'Núñez', 'Boliviana', 'Femenino', 'Verónica Ortega', 'Calle 14', 'Activo', '2007-02-14',
        '123456792', 'patricia.nunez@example.com', 14, 14),
       ('1000015', 'Fernando', 'Silva', 'Boliviana', 'Masculino', 'Ricardo Castro', 'Calle 15', 'Activo', '2008-03-25',
        '123456793', 'fernando.silva@example.com', 15, 15),
       ('1000016', 'Marta', 'Rojas', 'Boliviana', 'Femenino', 'Patricia Núñez', 'Calle 16', 'Activo', '2007-04-30',
        '123456794', 'marta.rojas@example.com', 16, 16),
       ('1000017', 'Isabel', 'Paredes', 'Boliviana', 'Femenino', 'Fernando Silva', 'Calle 17', 'Activo', '2008-05-10',
        '123456795', 'isabel.paredes@example.com', 17, 17),
       ('1000018', 'Luis', 'Peña', 'Boliviana', 'Masculino', 'Marta Rojas', 'Calle 18', 'Activo', '2007-06-18',
        '123456796', 'luis.pena@example.com', 18, 18),
       ('1000019', 'Carlos', 'Torres', 'Boliviana', 'Masculino', 'Andrés Paredes', 'Calle 19', 'Activo', '2008-07-22',
        '123456797', 'carlos.torres@example.com', 19, 19),
       ('1000020', 'Verónica', 'Gómez', 'Boliviana', 'Femenino', 'Isabel Peña', 'Calle 20', 'Activo', '2007-08-25',
        '123456798', 'veronica.gomez@example.com', 20, 20);

INSERT INTO NOTA (codEstudiante, codCursoMateria, trimestre, nota)
VALUES (1, 1, 'Primer Trimestre', 85.50),
       (1, 2, 'Primer Trimestre', 78.00),
       (2, 3, 'Primer Trimestre', 90.25),
       (2, 4, 'Primer Trimestre', 88.00),
       (3, 5, 'Primer Trimestre', 92.75),
       (3, 6, 'Primer Trimestre', 87.50),
       (4, 7, 'Primer Trimestre', 89.00),
       (4, 8, 'Primer Trimestre', 91.25),
       (5, 9, 'Primer Trimestre', 85.00),
       (5, 10, 'Primer Trimestre', 84.50),
       (6, 11, 'Primer Trimestre', 90.00),
       (6, 12, 'Primer Trimestre', 89.75),
       (7, 13, 'Primer Trimestre', 88.25),
       (7, 14, 'Primer Trimestre', 87.00),
       (8, 15, 'Primer Trimestre', 91.50),
       (8, 16, 'Primer Trimestre', 89.25),
       (9, 17, 'Primer Trimestre', 85.75),
       (9, 18, 'Primer Trimestre', 88.50),
       (10, 19, 'Primer Trimestre', 90.25),
       (10, 20, 'Primer Trimestre', 92.00),

       (1, 1, 'Segundo Trimestre', 87.00),
       (1, 2, 'Segundo Trimestre', 80.50),
       (2, 3, 'Segundo Trimestre', 91.00),
       (2, 4, 'Segundo Trimestre', 89.50),
       (3, 5, 'Segundo Trimestre', 93.50),
       (3, 6, 'Segundo Trimestre', 88.00),
       (4, 7, 'Segundo Trimestre', 90.50),
       (4, 8, 'Segundo Trimestre', 92.00),
       (5, 9, 'Segundo Trimestre', 86.50),
       (5, 10, 'Segundo Trimestre', 85.50),
       (6, 11, 'Segundo Trimestre', 91.00),
       (6, 12, 'Segundo Trimestre', 90.00),
       (7, 13, 'Segundo Trimestre', 89.00),
       (7, 14, 'Segundo Trimestre', 88.00),
       (8, 15, 'Segundo Trimestre', 92.50),
       (8, 16, 'Segundo Trimestre', 90.00),
       (9, 17, 'Segundo Trimestre', 86.50),
       (9, 18, 'Segundo Trimestre', 89.00),
       (10, 19, 'Segundo Trimestre', 91.00),
       (10, 20, 'Segundo Trimestre', 93.00);



INSERT INTO PAGO_MENSUALIDAD_ESTUDIANTE (codEstudiante, mesPago, monto, estadoPago)
VALUES (1, '2024-01-05', 500.00, 'Pagado'),
       (2, '2024-02-05', 450.00, 'Pagado'),
       (3, '2024-03-05', 500.00, 'Pagado'),
       (4, '2024-04-05', 480.00, 'Pagado'),
       (5, '2024-05-05', 500.00, 'Pagado'),
       (6, '2024-06-05', 470.00, 'Pagado'),
       (7, '2024-07-05', 500.00, 'Pagado'),
       (8, '2024-08-05', 460.00, 'Pagado'),
       (9, '2024-09-05', 500.00, 'Pagado'),
       (10, '2024-10-05', 490.00, 'Pagado'),
       (11, '2024-11-05', 500.00, 'Pagado'),
       (12, '2024-12-05', 450.00, 'Pagado'),
       (13, '2025-01-05', 500.00, 'Pagado'),
       (14, '2025-02-05', 470.00, 'Pagado'),
       (15, '2025-03-05', 500.00, 'Pagado'),
       (16, '2025-04-05', 480.00, 'Pagado'),
       (17, '2025-05-05', 500.00, 'Pagado'),
       (18, '2025-06-05', 460.00, 'Pagado'),
       (19, '2025-07-05', 500.00, 'Pagado'),
       (20, '2025-08-05', 490.00, 'Pagado');

-- Insertar registros en la tabla de roles
INSERT INTO ROL (nombre)
VALUES ('Director'),
       ('Profesor'),
       ('Secretaria'),
       ('Estudiante');

-- Insertar registros en la tabla de usuarios
INSERT INTO USUARIO (nombreUsuario, contrasenia, codRol)
VALUES ('director1', 'password1', 1),   -- Director
       ('profesor1', 'password2', 2),   -- Profesor
       ('secretaria1', 'password3', 3), -- Secretaria
       ('estudiante1', 'password4', 4), -- Estudiante
       ('director2', 'password5', 1),   -- Otro Director
       ('profesor2', 'password6', 2),   -- Otro Profesor
       ('secretaria2', 'password7', 3), -- Otra Secretaria
       ('estudiante2', 'password8', 4), -- Otro Estudiante
       ('admin', 'admin', 1);



DELIMITER //
CREATE TRIGGER after_student_insert
AFTER INSERT ON ESTUDIANTE
FOR EACH ROW
BEGIN
    INSERT INTO PAGO_MENSUALIDAD_ESTUDIANTE (codEstudiante, mesPago, monto, estadoPago)
    VALUES (NEW.codEstudiante, CURDATE(), 500.00, 'Pendiente');
END;//
DELIMITER ;

SELECT PAGO_MENSUALIDAD_ESTUDIANTE.mesPago, PAGO_MENSUALIDAD_ESTUDIANTE.estadoPago, PAGO_MENSUALIDAD_ESTUDIANTE.monto, E.nombre
FROM PAGO_MENSUALIDAD_ESTUDIANTE JOIN ESTUDIANTE E on E.codEstudiante = PAGO_MENSUALIDAD_ESTUDIANTE.codEstudiante;