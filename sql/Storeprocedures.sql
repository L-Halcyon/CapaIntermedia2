DELIMITER //

CREATE PROCEDURE ModificarUsuario (
    IN p_UsuarioID INT,
    IN p_Correo VARCHAR(30),
    IN p_NomUsu VARCHAR(20),
    IN p_Contrasena VARCHAR(50),
    IN p_Nombres VARCHAR(30),
    IN p_Apellidos VARCHAR(30),
    IN p_FechaNac DATE,
    IN p_Sexo CHAR(1),
     IN p_privasidad int,
    IN p_ImagenPerfil LONGBLOB
)
BEGIN
    UPDATE Usuario
    SET Correo = p_Correo,
        NomUsu = p_NomUsu,
        Contrasena = p_Contrasena,
        Nombres = p_Nombres,
        Apellidos = p_Apellidos,
        FechaNac = p_FechaNac,
        Sexo = p_Sexo,
        Privacidad = p_privasidad,
        ImagenPerfil = p_ImagenPerfil
    WHERE Usuario_ID = p_UsuarioID;
END //

DELIMITER ;

DELIMITER //

CREATE PROCEDURE EditarCategoria(
    IN p_Categoria_ID INT,
    IN p_Nombre VARCHAR(50),
    IN p_Descripcion VARCHAR(50)
   
)
BEGIN
    UPDATE Categoria
    SET Nombre = p_Nombre,
        Descripcion = p_Descripcion
    WHERE Categoria_ID = p_Categoria_ID;
END //

DELIMITER ;
-- DROP PROCEDURE IF EXISTS EditarCategoria;
DELIMITER //

CREATE PROCEDURE EditarLista(
    IN p_Lista_ID INT,
    IN p_Nombre VARCHAR(50),
    IN p_Descripcion VARCHAR(200),
    IN p_Tipo CHAR(7)
 
)
BEGIN
    UPDATE Lista
    SET Nombre = p_Nombre,
        Descripcion = p_Descripcion,
        Tipo = p_Tipo
    WHERE Lista_ID = p_Lista_ID;
END //

DELIMITER ;
DROP PROCEDURE IF EXISTS InsertarProductoCotizable;
DELIMITER //

CREATE PROCEDURE InsertarProductoCotizable(
    IN Producto_ID INT,
    IN Descripcion VARCHAR(150),
    IN Nombre VARCHAR(50),
    IN Precio FLOAT,
    IN Cantidad INT,
    IN Especificaciones varchar(50),
    IN ID_usuario INT,
    IN ID_usuariorecibidor INT,
     IN Eliminado INT
)
BEGIN
    -- Insertar datos en la tabla Producto_cotizable
    INSERT INTO Producto_cotizable (Producto_ID2, Descripcion, Nombre, Precio, Cantidad, Especificaciones, ID_usuario, ID_usuariorecibidor,Eliminado)
    VALUES (Producto_ID, Descripcion, Nombre, Precio, Cantidad, Especificaciones, ID_usuario, ID_usuariorecibidor,Eliminado);
END //

DELIMITER ;
DROP PROCEDURE IF EXISTS MarcarProductoCotizableAceptado;
DELIMITER //

CREATE PROCEDURE MarcarProductoCotizableAceptado(
    IN p_Producto_ID INT,
    IN p_Eliminado INT
)
BEGIN
    UPDATE Producto_cotizable
    SET Eliminado = p_Eliminado
    WHERE Producto_ID2 = p_Producto_ID;
END //

DELIMITER ;
DELIMITER //

CREATE PROCEDURE InsertarAlCarrito(
    IN p_Cantidad INT,
    IN p_Precio FLOAT,
    IN p_Prod_ID INT,
    IN p_Usu_ID INT
)
BEGIN
    -- Insertar datos en la tabla Carrito
    INSERT INTO Carrito (Cantidad, Precio_Unitario, Estado, Prod_ID, Usu_ID)
    VALUES (p_Cantidad, p_Precio, 1, p_Prod_ID, p_Usu_ID);
END //

DELIMITER ;

/* ---------- Modificar producto ---------- */
DELIMITER //
CREATE PROCEDURE ModificarProducto(
    IN id_producto INT,
    IN nueva_descripcion VARCHAR(150),
    IN nuevo_nombre VARCHAR(50),
    IN nuevo_precio FLOAT,
    IN nuevo_tipo_oferta INT,
    IN nueva_disponibilidad INT,
    IN nuevo_eliminado INT,
    IN nuevo_validado INT,
    IN nuevo_categ_ID INT,
    IN nuevo_Usu_ID INT
)
BEGIN
    UPDATE Producto
    SET Descripcion = nueva_descripcion,
        Nombre = nuevo_nombre,
        Precio = nuevo_precio,
        Tipo_Oferta = nuevo_tipo_oferta,
        Disponibilidad = nueva_disponibilidad,
        Eliminado = nuevo_eliminado,
        Validado = nuevo_validado,
        categ_ID = nuevo_categ_ID,
        Usu_ID = nuevo_Usu_ID
    WHERE Producto_ID = id_producto;
END //
DELIMITER ;
DROP PROCEDURE IF EXISTS ModificarProducto;
/* ---------- VIEW aqui faltan views ---------- */
create view V1 as SELECT * FROM Producto WHERE Validado = 0 AND Eliminado = 0;
create view V4 as SELECT * FROM Categoria WHERE Eliminado = 0;
create view V5 as SELECT * FROM Mensajes;

/* ---------- TRIGGER ---------- */
create trigger T1
after update on Usuario
for each row
	UPDATE Producto JOIN Usuario ON Producto.Usu_ID = Usuario.Usuario_ID SET Producto.Eliminado = 1 WHERE Usuario.Eliminado = 1;
create trigger T2
after update on Categoria
for each row
	UPDATE Producto JOIN Categoria ON Producto.categ_ID = Categoria.Categoria_ID SET Producto.Eliminado = 1 WHERE Categoria.Eliminado = 1;
    
/* ---------- FUNCTION ---------- */
DELIMITER //
create function F1 (idprod INT, cantidad INT) returns FLOAT DETERMINISTIC
BEGIN
	declare total FLOAT;
    declare idP int;
    select Precio into idP from Producto where Producto_ID = idprod;
	select idP * cantidad into total;
	return total;
END//
DELIMITER ;
DELIMITER //
create function F2 (idprod INT, TPAGAR FLOAT, cantidad INT) returns FLOAT DETERMINISTIC
BEGIN
	declare PrecProd FLOAT;
    declare DinxProd FLOAT;
    declare TOTAL FLOAT;
    select Precio into PrecProd from Producto where Producto_ID = idprod;
    select PrecProd * cantidad into DinxProd;
    select DinxProd + TPAGAR into TOTAL;
    return TOTAL;
END//
DELIMITER ;
