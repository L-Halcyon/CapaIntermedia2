--CREACIÓN DE STORED PROCEDURES

--USUARIO

--ALTA

DELIMITER $$

CREATE PROCEDURE AltaUsuario(
    IN p_correo VARCHAR(255),
    IN p_nombre_usuario VARCHAR(255),
    IN p_apellido_usuario VARCHAR(255),
    IN p_contrasena VARCHAR(255),
    IN p_rol VARCHAR(255),
    IN p_imagen VARCHAR(255),
    IN p_nombre_completo VARCHAR(255),
    IN p_fecha_nacimiento DATE,
    IN p_sexo VARCHAR(1),
    IN p_fecha_ingreso DATE,
    IN p_privacidad BOOLEAN
)
BEGIN
    -- Validar correo electrónico único
    IF EXISTS (SELECT * FROM Usuario WHERE Correo = p_correo) THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Error: El correo electrónico ya está registrado.';
    END IF;
    
    -- Validar nombre de usuario único
    IF EXISTS (SELECT * FROM Usuario WHERE Nombre_usuario = p_nombre_usuario) THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Error: El nombre de usuario ya está en uso.';
    END IF;

    -- Validar formato de contraseña
    IF NOT (p_contrasena REGEXP '^(?=.[a-z])(?=.[A-Z])(?=.[0-9])(?=.[!@#$%^&*(),.?":{}|<>]).{8,}$') THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Error: La contraseña no cumple con el formato requerido.';
    END IF;

    -- Insertar el nuevo usuario si pasa todas las validaciones
    INSERT INTO Usuario (Correo, Nombre_usuario, Contraseña, Rol, Imagen, Nombre, Apellidos, Fecha_Nac, Sexo, Fecha_Ingreso, Privacidad)
    VALUES (p_correo, p_nombre_usuario, p_contrasena, p_rol, p_imagen, p_nombre_completo,p_apellido_usuario, p_fecha_nacimiento, p_sexo, p_fecha_ingreso, p_privacidad);
    
END$$

DELIMITER ;


--BAJA

DELIMITER $$

CREATE PROCEDURE BajaUsuario(
    IN usuario_id INT
)
BEGIN
    UPDATE Usuario 
    SET eliminado = 1
    WHERE ID_Usuario = usuario_id;
END$$

DELIMITER ;


--CAMBIO

DELIMITER $$

CREATE PROCEDURE CambioUsuario(
    IN usuario_id INT,
    IN correo VARCHAR(255),
    IN nombre VARCHAR(255),
    IN apellidos VARCHAR(255),
    IN rol VARCHAR(255),
    IN nombre_usuario VARCHAR(255),
    IN imagen VARCHAR(255),
    IN eliminado BOOLEAN,
    IN privacidad BOOLEAN,
    IN fecha_ingreso DATE,
    IN sexo VARCHAR(1),
    IN fecha_nac DATE,
    IN contrasena VARCHAR(255),
    IN direccion_id INT
)
BEGIN
    UPDATE Usuario 
    SET Correo = correo,
        Nombre = nombre,
        Apellidos = apellidos,
        Rol = rol,
        Nombre_usuario = nombre_usuario,
        Imagen = imagen,
        Eliminado = eliminado,
        Privacidad = privacidad,
        Fecha_Ingreso = fecha_ingreso,
        Sexo = sexo,
        Fecha_Nac = fecha_nac,
        Contraseña = contrasena,
        Direccion_ID = direccion_id
    WHERE ID_Usuario = usuario_id;
END$$

DELIMITER ;

--INICIO DE SESIÓN

DELIMITER $$

CREATE PROCEDURE IniciarSesion(
    IN p_usuario VARCHAR(255),
    IN p_contrasena VARCHAR(255)
)
BEGIN
    DECLARE usuario_encontrado INT;
    
    -- Verificar si el usuario existe y las credenciales son válidas
    SELECT COUNT(*) INTO usuario_encontrado
    FROM Usuario
    WHERE (Correo = p_usuario OR Nombre_usuario = p_usuario)
      AND Contraseña = p_contrasena
      AND Eliminado = 0;
    
    -- Si el usuario y contraseña son válidos, retornar 1
    IF usuario_encontrado = 1 THEN
        SELECT 1 AS inicio_sesion_valido;
    ELSE
        -- Si las credenciales son inválidas, retornar 0
        SELECT 0 AS inicio_sesion_valido;
    END IF;
END$$

DELIMITER ;

-- OBTENER INFO DE USUARIO PARA MOSTRAR EN LA PAGINA

DELIMITER $$

CREATE PROCEDURE ObtenerPerfilUsuario(
    IN p_usuario VARCHAR(255)
)
BEGIN
    -- Declarar variables para almacenar la información del perfil
    DECLARE v_id_usuario INT;
    DECLARE v_nombre_usuario VARCHAR(255);
    DECLARE v_imagen_usuario VARCHAR(255);
    
    -- Obtener información del perfil del usuario
    SELECT ID_Usuario, Nombre_usuario, Imagen
    INTO v_id_usuario, v_nombre_usuario, v_imagen_usuario
    FROM Usuario
    WHERE Correo = p_usuario OR Nombre_usuario = p_usuario;
    
    -- Mostrar la información del perfil del usuario
    SELECT v_id_usuario AS ID_Usuario,
           v_nombre_usuario AS Nombre_Usuario,
           v_imagen_usuario AS Imagen_Usuario;
END$$

DELIMITER ;



-- OBTENER INFO DE USUARIO PARA MODIFICAR

DELIMITER $$

CREATE PROCEDURE ObtenerInfoUsuario(
    IN p_usuario VARCHAR(255)
)
BEGIN
    -- Declarar variables para almacenar la información del usuario
    DECLARE v_id_usuario INT;
    DECLARE v_correo VARCHAR(255);
    DECLARE v_nombre VARCHAR(255);
    DECLARE v_apellidos VARCHAR(255);
    DECLARE v_rol VARCHAR(255);
    DECLARE v_nombre_usuario VARCHAR(255);
    DECLARE v_imagen VARCHAR(255);
    DECLARE v_privacidad BOOLEAN;
    DECLARE v_fecha_ingreso DATE;
    DECLARE v_sexo VARCHAR(1);
    DECLARE v_fecha_nacimiento DATE;

    -- Obtener información del usuario
    SELECT ID_Usuario, Correo, Nombre, Apellidos, Rol, Nombre_usuario, Imagen, Privacidad, Fecha_Ingreso, Sexo, Fecha_Nac
    INTO v_id_usuario, v_correo, v_nombre, v_apellidos, v_rol, v_nombre_usuario, v_imagen, v_privacidad, v_fecha_ingreso, v_sexo, v_fecha_nacimiento
    FROM Usuario
    WHERE Correo = p_usuario OR Nombre_usuario = p_usuario;
    
    -- Mostrar la información del usuario
    SELECT v_id_usuario AS ID_Usuario,
           v_correo AS Correo,
           v_nombre AS Nombre,
           v_apellidos AS Apellidos,
           v_rol AS Rol,
           v_nombre_usuario AS Nombre_Usuario,
           v_imagen AS Imagen,
           v_privacidad AS Privacidad,
           v_fecha_ingreso AS Fecha_Ingreso,
           v_sexo AS Sexo,
           v_fecha_nacimiento AS Fecha_Nacimiento;
END$$

DELIMITER ;