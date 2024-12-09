CREATE DATABASE BDM;
use BDM;

/*SET FOREIGN_KEY_CHECKS = 0;
TRUNCATE TABLE Usuario;
SET FOREIGN_KEY_CHECKS = 1;*/

SHOW DATABASES;
CREATE TABLE Usuario(
	Usuario_ID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    Correo VARCHAR(30) NOT NULL,
    NomUsu VARCHAR(20) NOT NULL,
    Contrasena VARCHAR(50) NOT NULL,
    Rol CHAR(20),
    Nombres VARCHAR(30),
    Apellidos VARCHAR(30),
    FechaNac DATE,
    Sexo CHAR(1),
    FechaIngreso DATETIME,
    Eliminado INT,
    Privacidad INT,
    ImagenPerfil LONGBLOB,
    CHECK (Privacidad = 0 OR Privacidad = 1 OR Privacidad = 2),
    CHECK (Sexo = 'F' OR Sexo = 'M'),
    CHECK (Rol = 'vendedores' OR Rol = 'clientes' OR Rol = 'administradores'),
    CHECK (Eliminado = 0 OR Eliminado = 1)
);
-- SELECT * FROM usuario;
-- SELECT * FROM Producto;


CREATE TABLE Categoria(
	Categoria_ID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    Nombre VARCHAR(50) NOT NULL,
    Descripcion VARCHAR(50) NOT NULL,
    Eliminado INT,
    Usu_ID INT NOT NULL,
    
    FOREIGN KEY (Usu_ID) REFERENCES Usuario(Usuario_ID),
    CHECK (Eliminado = 0 OR Eliminado = 1)
);


CREATE TABLE Producto(
	Producto_ID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    Descripcion VARCHAR(150) NOT NULL,
    Nombre VARCHAR(50) NOT NULL,
    Precio FLOAT NOT NULL,
    Tipo_Oferta INT,
    Cantidad int,
    Disponibilidad INT NOT NULL,
    Eliminado INT,
    Validado INT,
    categ_ID INT,
    Usu_ID INT,
  
   
    FOREIGN KEY (Usu_ID) REFERENCES Usuario(Usuario_ID),
    FOREIGN KEY (categ_ID) REFERENCES Categoria(Categoria_ID),
    CHECK (Tipo_Oferta = 0 OR Tipo_Oferta = 1),
    CHECK (Eliminado = 0 OR Eliminado = 1),
    CHECK (Validado = 0 OR Validado = 1)
);

CREATE TABLE Imagen_Prod(
	Imagen_ID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nombre text,
    imagen longblob,
    tipo varchar(11),
    Prod_ID INT,
    
    FOREIGN KEY (Prod_ID) REFERENCES Producto(Producto_ID)
);

CREATE TABLE Video_Producto(
Vid_ID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    direccion VARCHAR(200),
    tipo VARCHAR(200),
    tamano INT,
    Prod_ID INT,
    
    FOREIGN KEY (Prod_ID) REFERENCES Producto(Producto_ID)
);

CREATE TABLE Lista(
	Lista_ID  INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    Nombre VARCHAR(50) NOT NULL,
    Descripcion VARCHAR(200) NOT NULL,
    Tipo CHAR(7) NOT NULL,
    Eliminado INT,
    Usu_ID INT,
    
    FOREIGN KEY (Usu_ID) REFERENCES Usuario(Usuario_ID),
    CHECK (Tipo = 'publica' OR Tipo = 'privada'),
    CHECK (Eliminado = 0 OR Eliminado = 1)
);

CREATE TABLE Producto_Lista(
	Prod_ID INT,
    Lis_ID INT,
    
    FOREIGN KEY (Prod_ID) REFERENCES Producto(Producto_ID),
    FOREIGN KEY (Lis_ID) REFERENCES Lista(Lista_ID)
);

CREATE TABLE ProdCot_ADMIN(
	IdProdCot INT,
    IdUsuAdmin INT,
    FOREIGN KEY (IdProdCot) REFERENCES Producto(Producto_ID),
    FOREIGN KEY (IdUsuAdmin) REFERENCES Usuario(Usuario_ID)
);

CREATE TABLE Carrito(
	Carrito_ID INT auto_increment PRIMARY KEY,
	Cantidad INT,
    Precio_Unitario FLOAT,
    Estado INT,
    Prod_ID INT,
    Usu_ID INT,
    
    CHECK (Estado = 0 OR Estado = 1),
    FOREIGN KEY (Prod_ID) REFERENCES Producto(Producto_ID),
    FOREIGN KEY (Usu_ID) REFERENCES Usuario(Usuario_ID)
);

CREATE TABLE Contactos(
	IdUsuario INT,
    IdUsuariocon INT,
    
    FOREIGN KEY (IdUsuario) REFERENCES Usuario(Usuario_ID),
    FOREIGN KEY (IdUsuariocon) REFERENCES Usuario(Usuario_ID)
);

CREATE TABLE Mensajes(
	ID_usuario INT,
    Mensaje VARCHAR(200),
    ID_usuariorecibidor INT,
    Producto_ID INT,
 
     FOREIGN KEY (Producto_ID) REFERENCES Producto_cotizable(Producto_ID),
    FOREIGN KEY (ID_usuario) REFERENCES Usuario(Usuario_ID),
    FOREIGN KEY (ID_usuariorecibidor) REFERENCES Usuario(Usuario_ID)
);

CREATE TABLE Producto_cotizable(
    Producto_ID INT auto_increment PRIMARY KEY,
    Producto_ID2 INT,
    Descripcion VARCHAR(150) NOT NULL,
    Nombre VARCHAR(50) NOT NULL,
    Precio FLOAT NOT NULL,
    Cantidad int,
    Especificaciones varchar(50),
    ID_usuario INT,
     ID_usuariorecibidor INT,
     Eliminado int,
     FOREIGN KEY (ID_usuario) REFERENCES Usuario(Usuario_ID),
    FOREIGN KEY (ID_usuariorecibidor) REFERENCES Usuario(Usuario_ID)
    
);

CREATE TABLE Venta(
	Venta_ID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    FechaHora DATETIME,
    Prod_ID INT,
    precioactualP FLOAT,
    cant INT,
    Usu_ID INT,
    
    FOREIGN KEY (Usu_ID) REFERENCES Usuario(Usuario_ID),
    FOREIGN KEY (Prod_ID) REFERENCES Producto(Producto_ID)
);

CREATE TABLE Comentario(
	Comentario_ID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    Comentario VARCHAR(200),
    Valoracion FLOAT,
    Prod_ID INT,
    Usu_ID INT,
    
    FOREIGN KEY (Prod_ID) REFERENCES Producto(Producto_ID),
    FOREIGN KEY (Usu_ID) REFERENCES Usuario(Usuario_ID)
);

CREATE TABLE Pedido(
	Pedido_ID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    FechaHora DATETIME,
    IDCateg INT,
    IDProd INT,
    Precio FLOAT,
    Usu_ID INT,
    
    FOREIGN KEY (Usu_ID) REFERENCES Usuario(Usuario_ID)
);

