CREATE DATABASE  IF NOT EXISTS `bdm` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `bdm`;
-- MySQL dump 10.13  Distrib 8.0.36, for Win64 (x86_64)
--
-- Host: localhost    Database: bdm
-- ------------------------------------------------------
-- Server version	8.0.36

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `carrito`
--

DROP TABLE IF EXISTS `carrito`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `carrito` (
  `Carrito_ID` int NOT NULL AUTO_INCREMENT,
  `Cantidad` int DEFAULT NULL,
  `Precio_Unitario` float DEFAULT NULL,
  `Estado` int DEFAULT NULL,
  `Prod_ID` int DEFAULT NULL,
  `Usu_ID` int DEFAULT NULL,
  PRIMARY KEY (`Carrito_ID`),
  KEY `Prod_ID` (`Prod_ID`),
  KEY `Usu_ID` (`Usu_ID`),
  CONSTRAINT `carrito_ibfk_1` FOREIGN KEY (`Prod_ID`) REFERENCES `producto` (`Producto_ID`),
  CONSTRAINT `carrito_ibfk_2` FOREIGN KEY (`Usu_ID`) REFERENCES `usuario` (`Usuario_ID`),
  CONSTRAINT `carrito_chk_1` CHECK (((`Estado` = 0) or (`Estado` = 1)))
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `categoria`
--

DROP TABLE IF EXISTS `categoria`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categoria` (
  `Categoria_ID` int NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(50) NOT NULL,
  `Descripcion` varchar(50) NOT NULL,
  `Eliminado` int DEFAULT NULL,
  `Usu_ID` int NOT NULL,
  PRIMARY KEY (`Categoria_ID`),
  KEY `Usu_ID` (`Usu_ID`),
  CONSTRAINT `categoria_ibfk_1` FOREIGN KEY (`Usu_ID`) REFERENCES `usuario` (`Usuario_ID`),
  CONSTRAINT `categoria_chk_1` CHECK (((`Eliminado` = 0) or (`Eliminado` = 1)))
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `T2` AFTER UPDATE ON `categoria` FOR EACH ROW UPDATE Producto JOIN Categoria ON Producto.categ_ID = Categoria.Categoria_ID SET Producto.Eliminado = 1 WHERE Categoria.Eliminado = 1 */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `comentario`
--

DROP TABLE IF EXISTS `comentario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `comentario` (
  `Comentario_ID` int NOT NULL AUTO_INCREMENT,
  `Comentario` varchar(200) DEFAULT NULL,
  `Valoracion` float DEFAULT NULL,
  `Prod_ID` int DEFAULT NULL,
  `Usu_ID` int DEFAULT NULL,
  PRIMARY KEY (`Comentario_ID`),
  KEY `Prod_ID` (`Prod_ID`),
  KEY `Usu_ID` (`Usu_ID`),
  CONSTRAINT `comentario_ibfk_1` FOREIGN KEY (`Prod_ID`) REFERENCES `producto` (`Producto_ID`),
  CONSTRAINT `comentario_ibfk_2` FOREIGN KEY (`Usu_ID`) REFERENCES `usuario` (`Usuario_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `contactos`
--

DROP TABLE IF EXISTS `contactos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `contactos` (
  `IdUsuario` int DEFAULT NULL,
  `IdUsuariocon` int DEFAULT NULL,
  KEY `IdUsuario` (`IdUsuario`),
  KEY `IdUsuariocon` (`IdUsuariocon`),
  CONSTRAINT `contactos_ibfk_1` FOREIGN KEY (`IdUsuario`) REFERENCES `usuario` (`Usuario_ID`),
  CONSTRAINT `contactos_ibfk_2` FOREIGN KEY (`IdUsuariocon`) REFERENCES `usuario` (`Usuario_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `imagen_prod`
--

DROP TABLE IF EXISTS `imagen_prod`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `imagen_prod` (
  `Imagen_ID` int NOT NULL AUTO_INCREMENT,
  `nombre` text,
  `imagen` longblob,
  `tipo` varchar(11) DEFAULT NULL,
  `Prod_ID` int DEFAULT NULL,
  PRIMARY KEY (`Imagen_ID`),
  KEY `Prod_ID` (`Prod_ID`),
  CONSTRAINT `imagen_prod_ibfk_1` FOREIGN KEY (`Prod_ID`) REFERENCES `producto` (`Producto_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `lista`
--

DROP TABLE IF EXISTS `lista`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `lista` (
  `Lista_ID` int NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(50) NOT NULL,
  `Descripcion` varchar(200) NOT NULL,
  `Tipo` char(7) NOT NULL,
  `Eliminado` int DEFAULT NULL,
  `Usu_ID` int DEFAULT NULL,
  PRIMARY KEY (`Lista_ID`),
  KEY `Usu_ID` (`Usu_ID`),
  CONSTRAINT `lista_ibfk_1` FOREIGN KEY (`Usu_ID`) REFERENCES `usuario` (`Usuario_ID`),
  CONSTRAINT `lista_chk_1` CHECK (((`Tipo` = _utf8mb4'publica') or (`Tipo` = _utf8mb4'privada'))),
  CONSTRAINT `lista_chk_2` CHECK (((`Eliminado` = 0) or (`Eliminado` = 1)))
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mensajes`
--

DROP TABLE IF EXISTS `mensajes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `mensajes` (
  `ID_usuario` int DEFAULT NULL,
  `Mensaje` varchar(200) DEFAULT NULL,
  `ID_usuariorecibidor` int DEFAULT NULL,
  `Producto_ID` int DEFAULT NULL,
  `FechaHora` datetime DEFAULT CURRENT_TIMESTAMP,
  KEY `Producto_ID` (`Producto_ID`),
  KEY `ID_usuario` (`ID_usuario`),
  KEY `ID_usuariorecibidor` (`ID_usuariorecibidor`),
  CONSTRAINT `mensajes_ibfk_1` FOREIGN KEY (`Producto_ID`) REFERENCES `producto_cotizable` (`Producto_ID`),
  CONSTRAINT `mensajes_ibfk_2` FOREIGN KEY (`ID_usuario`) REFERENCES `usuario` (`Usuario_ID`),
  CONSTRAINT `mensajes_ibfk_3` FOREIGN KEY (`ID_usuariorecibidor`) REFERENCES `usuario` (`Usuario_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pedido`
--

DROP TABLE IF EXISTS `pedido`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pedido` (
  `Pedido_ID` int NOT NULL AUTO_INCREMENT,
  `FechaHora` datetime DEFAULT NULL,
  `IDCateg` int DEFAULT NULL,
  `IDProd` int DEFAULT NULL,
  `Precio` float DEFAULT NULL,
  `Usu_ID` int DEFAULT NULL,
  PRIMARY KEY (`Pedido_ID`),
  KEY `Usu_ID` (`Usu_ID`),
  CONSTRAINT `pedido_ibfk_1` FOREIGN KEY (`Usu_ID`) REFERENCES `usuario` (`Usuario_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `prodcot_admin`
--

DROP TABLE IF EXISTS `prodcot_admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `prodcot_admin` (
  `IdProdCot` int DEFAULT NULL,
  `IdUsuAdmin` int DEFAULT NULL,
  KEY `IdProdCot` (`IdProdCot`),
  KEY `IdUsuAdmin` (`IdUsuAdmin`),
  CONSTRAINT `prodcot_admin_ibfk_1` FOREIGN KEY (`IdProdCot`) REFERENCES `producto` (`Producto_ID`),
  CONSTRAINT `prodcot_admin_ibfk_2` FOREIGN KEY (`IdUsuAdmin`) REFERENCES `usuario` (`Usuario_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `producto`
--

DROP TABLE IF EXISTS `producto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `producto` (
  `Producto_ID` int NOT NULL AUTO_INCREMENT,
  `Descripcion` varchar(150) NOT NULL,
  `Nombre` varchar(50) NOT NULL,
  `Precio` float NOT NULL,
  `Tipo_Oferta` int DEFAULT NULL,
  `Cantidad` int DEFAULT NULL,
  `Disponibilidad` int NOT NULL,
  `Eliminado` int DEFAULT NULL,
  `Validado` int DEFAULT NULL,
  `categ_ID` int DEFAULT NULL,
  `Usu_ID` int DEFAULT NULL,
  PRIMARY KEY (`Producto_ID`),
  KEY `Usu_ID` (`Usu_ID`),
  KEY `categ_ID` (`categ_ID`),
  CONSTRAINT `producto_ibfk_1` FOREIGN KEY (`Usu_ID`) REFERENCES `usuario` (`Usuario_ID`),
  CONSTRAINT `producto_ibfk_2` FOREIGN KEY (`categ_ID`) REFERENCES `categoria` (`Categoria_ID`),
  CONSTRAINT `producto_chk_1` CHECK (((`Tipo_Oferta` = 0) or (`Tipo_Oferta` = 1))),
  CONSTRAINT `producto_chk_2` CHECK (((`Eliminado` = 0) or (`Eliminado` = 1))),
  CONSTRAINT `producto_chk_3` CHECK (((`Validado` = 0) or (`Validado` = 1)))
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `producto_cotizable`
--

DROP TABLE IF EXISTS `producto_cotizable`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `producto_cotizable` (
  `Producto_ID` int NOT NULL AUTO_INCREMENT,
  `Producto_ID2` int DEFAULT NULL,
  `Descripcion` varchar(150) NOT NULL,
  `Nombre` varchar(50) NOT NULL,
  `Precio` float NOT NULL,
  `Cantidad` int DEFAULT NULL,
  `Especificaciones` varchar(50) DEFAULT NULL,
  `ID_usuario` int DEFAULT NULL,
  `ID_usuariorecibidor` int DEFAULT NULL,
  `Eliminado` int DEFAULT NULL,
  PRIMARY KEY (`Producto_ID`),
  KEY `ID_usuario` (`ID_usuario`),
  KEY `ID_usuariorecibidor` (`ID_usuariorecibidor`),
  CONSTRAINT `producto_cotizable_ibfk_1` FOREIGN KEY (`ID_usuario`) REFERENCES `usuario` (`Usuario_ID`),
  CONSTRAINT `producto_cotizable_ibfk_2` FOREIGN KEY (`ID_usuariorecibidor`) REFERENCES `usuario` (`Usuario_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `producto_lista`
--

DROP TABLE IF EXISTS `producto_lista`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `producto_lista` (
  `Prod_ID` int DEFAULT NULL,
  `Lis_ID` int DEFAULT NULL,
  KEY `Prod_ID` (`Prod_ID`),
  KEY `Lis_ID` (`Lis_ID`),
  CONSTRAINT `producto_lista_ibfk_1` FOREIGN KEY (`Prod_ID`) REFERENCES `producto` (`Producto_ID`),
  CONSTRAINT `producto_lista_ibfk_2` FOREIGN KEY (`Lis_ID`) REFERENCES `lista` (`Lista_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `usuario`
--

DROP TABLE IF EXISTS `usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuario` (
  `Usuario_ID` int NOT NULL AUTO_INCREMENT,
  `Correo` varchar(30) NOT NULL,
  `NomUsu` varchar(20) NOT NULL,
  `Contrasena` varchar(50) NOT NULL,
  `Rol` char(20) DEFAULT NULL,
  `Nombres` varchar(30) DEFAULT NULL,
  `Apellidos` varchar(30) DEFAULT NULL,
  `FechaNac` date DEFAULT NULL,
  `Sexo` char(1) DEFAULT NULL,
  `FechaIngreso` datetime DEFAULT NULL,
  `Eliminado` int DEFAULT NULL,
  `Privacidad` int DEFAULT NULL,
  `ImagenPerfil` longblob,
  PRIMARY KEY (`Usuario_ID`),
  CONSTRAINT `usuario_chk_1` CHECK (((`Privacidad` = 0) or (`Privacidad` = 1) or (`Privacidad` = 2))),
  CONSTRAINT `usuario_chk_2` CHECK (((`Sexo` = _utf8mb4'F') or (`Sexo` = _utf8mb4'M'))),
  CONSTRAINT `usuario_chk_3` CHECK (((`Rol` = _utf8mb4'vendedores') or (`Rol` = _utf8mb4'clientes') or (`Rol` = _utf8mb4'administradores'))),
  CONSTRAINT `usuario_chk_4` CHECK (((`Eliminado` = 0) or (`Eliminado` = 1)))
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `T1` AFTER UPDATE ON `usuario` FOR EACH ROW UPDATE Producto JOIN Usuario ON Producto.Usu_ID = Usuario.Usuario_ID SET Producto.Eliminado = 1 WHERE Usuario.Eliminado = 1 */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Temporary view structure for view `v1`
--

DROP TABLE IF EXISTS `v1`;
/*!50001 DROP VIEW IF EXISTS `v1`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `v1` AS SELECT 
 1 AS `Producto_ID`,
 1 AS `Descripcion`,
 1 AS `Nombre`,
 1 AS `Precio`,
 1 AS `Tipo_Oferta`,
 1 AS `Cantidad`,
 1 AS `Disponibilidad`,
 1 AS `Eliminado`,
 1 AS `Validado`,
 1 AS `categ_ID`,
 1 AS `Usu_ID`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `v4`
--

DROP TABLE IF EXISTS `v4`;
/*!50001 DROP VIEW IF EXISTS `v4`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `v4` AS SELECT 
 1 AS `Categoria_ID`,
 1 AS `Nombre`,
 1 AS `Descripcion`,
 1 AS `Eliminado`,
 1 AS `Usu_ID`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `v5`
--

DROP TABLE IF EXISTS `v5`;
/*!50001 DROP VIEW IF EXISTS `v5`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `v5` AS SELECT 
 1 AS `ID_usuario`,
 1 AS `Mensaje`,
 1 AS `ID_usuariorecibidor`,
 1 AS `Producto_ID`,
 1 AS `FechaHora`*/;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `venta`
--

DROP TABLE IF EXISTS `venta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `venta` (
  `Venta_ID` int NOT NULL AUTO_INCREMENT,
  `FechaHora` datetime DEFAULT NULL,
  `Prod_ID` int DEFAULT NULL,
  `precioactualP` float DEFAULT NULL,
  `cant` int DEFAULT NULL,
  `Usu_ID` int DEFAULT NULL,
  PRIMARY KEY (`Venta_ID`),
  KEY `Usu_ID` (`Usu_ID`),
  KEY `Prod_ID` (`Prod_ID`),
  CONSTRAINT `venta_ibfk_1` FOREIGN KEY (`Usu_ID`) REFERENCES `usuario` (`Usuario_ID`),
  CONSTRAINT `venta_ibfk_2` FOREIGN KEY (`Prod_ID`) REFERENCES `producto` (`Producto_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `video_producto`
--

DROP TABLE IF EXISTS `video_producto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `video_producto` (
  `Vid_ID` int NOT NULL AUTO_INCREMENT,
  `direccion` varchar(200) DEFAULT NULL,
  `tipo` varchar(200) DEFAULT NULL,
  `tamano` int DEFAULT NULL,
  `Prod_ID` int DEFAULT NULL,
  PRIMARY KEY (`Vid_ID`),
  KEY `Prod_ID` (`Prod_ID`),
  CONSTRAINT `video_producto_ibfk_1` FOREIGN KEY (`Prod_ID`) REFERENCES `producto` (`Producto_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping events for database 'bdm'
--

--
-- Dumping routines for database 'bdm'
--
/*!50003 DROP FUNCTION IF EXISTS `F1` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` FUNCTION `F1`(idprod INT, cantidad INT) RETURNS float
    DETERMINISTIC
BEGIN
	declare total FLOAT;
    declare idP int;
    select Precio into idP from Producto where Producto_ID = idprod;
	select idP * cantidad into total;
	return total;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP FUNCTION IF EXISTS `F2` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` FUNCTION `F2`(idprod INT, TPAGAR FLOAT, cantidad INT) RETURNS float
    DETERMINISTIC
BEGIN
	declare PrecProd FLOAT;
    declare DinxProd FLOAT;
    declare TOTAL FLOAT;
    select Precio into PrecProd from Producto where Producto_ID = idprod;
    select PrecProd * cantidad into DinxProd;
    select DinxProd + TPAGAR into TOTAL;
    return TOTAL;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `AltaUsuario` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `AltaUsuario`(
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
    
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `BajaUsuario` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `BajaUsuario`(
    IN usuario_id INT
)
BEGIN
    UPDATE Usuario 
    SET eliminado = 1
    WHERE ID_Usuario = usuario_id;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `CambioUsuario` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `CambioUsuario`(
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
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `EditarCategoria` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `EditarCategoria`(
    IN p_Categoria_ID INT,
    IN p_Nombre VARCHAR(50),
    IN p_Descripcion VARCHAR(50)
   
)
BEGIN
    UPDATE Categoria
    SET Nombre = p_Nombre,
        Descripcion = p_Descripcion
    WHERE Categoria_ID = p_Categoria_ID;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `EditarLista` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `EditarLista`(
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
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `IniciarSesion` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `IniciarSesion`(
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
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `InsertarAlCarrito` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `InsertarAlCarrito`(
    IN p_Cantidad INT,
    IN p_Precio FLOAT,
    IN p_Prod_ID INT,
    IN p_Usu_ID INT
)
BEGIN
    -- Insertar datos en la tabla Carrito
    INSERT INTO Carrito (Cantidad, Precio_Unitario, Estado, Prod_ID, Usu_ID)
    VALUES (p_Cantidad, p_Precio, 1, p_Prod_ID, p_Usu_ID);
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `InsertarProductoCotizable` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `InsertarProductoCotizable`(
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
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `MarcarProductoCotizableAceptado` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `MarcarProductoCotizableAceptado`(
    IN p_Producto_ID INT,
    IN p_Eliminado INT
)
BEGIN
    UPDATE Producto_cotizable
    SET Eliminado = p_Eliminado
    WHERE Producto_ID2 = p_Producto_ID;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `ModificarProducto` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `ModificarProducto`(
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
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `ModificarUsuario` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `ModificarUsuario`(
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
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `ObtenerInfoUsuario` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `ObtenerInfoUsuario`(
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
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `ObtenerInfoUsuarioPorId` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `ObtenerInfoUsuarioPorId`(
    IN usuarioId INT
)
BEGIN
    SELECT 
        ImagenAvatar,
        NombreCompleto, 
        Genero, 
        FechaNacimiento, 
        Email, 
        Contraseña
    FROM Usuario
    WHERE Id_Usuario = usuarioId;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `ObtenerPerfilUsuario` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `ObtenerPerfilUsuario`(
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
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_consultar_pedidos` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_consultar_pedidos`(IN p_Usu_ID INT)
BEGIN
    SELECT 
        v.FechaHora,
        v.Usu_ID,
        v.Prod_ID,
        p.Nombre AS NombreProducto,
        p.Precio AS PrecioProducto,
        c.Nombre AS NombreCategoria,
        v.cant AS Cantidad,
        cm.Valoracion AS Calificacion
    FROM venta v
    INNER JOIN producto p ON v.Prod_ID = p.Producto_ID
    INNER JOIN categoria c ON p.categ_ID = c.Categoria_ID
    LEFT JOIN comentario cm ON cm.Prod_ID = v.Prod_ID
    WHERE v.Usu_ID = p_Usu_ID
    ORDER BY v.FechaHora DESC;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Final view structure for view `v1`
--

/*!50001 DROP VIEW IF EXISTS `v1`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v1` AS select `producto`.`Producto_ID` AS `Producto_ID`,`producto`.`Descripcion` AS `Descripcion`,`producto`.`Nombre` AS `Nombre`,`producto`.`Precio` AS `Precio`,`producto`.`Tipo_Oferta` AS `Tipo_Oferta`,`producto`.`Cantidad` AS `Cantidad`,`producto`.`Disponibilidad` AS `Disponibilidad`,`producto`.`Eliminado` AS `Eliminado`,`producto`.`Validado` AS `Validado`,`producto`.`categ_ID` AS `categ_ID`,`producto`.`Usu_ID` AS `Usu_ID` from `producto` where ((`producto`.`Validado` = 0) and (`producto`.`Eliminado` = 0)) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v4`
--

/*!50001 DROP VIEW IF EXISTS `v4`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v4` AS select `categoria`.`Categoria_ID` AS `Categoria_ID`,`categoria`.`Nombre` AS `Nombre`,`categoria`.`Descripcion` AS `Descripcion`,`categoria`.`Eliminado` AS `Eliminado`,`categoria`.`Usu_ID` AS `Usu_ID` from `categoria` where (`categoria`.`Eliminado` = 0) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v5`
--

/*!50001 DROP VIEW IF EXISTS `v5`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v5` AS select `mensajes`.`ID_usuario` AS `ID_usuario`,`mensajes`.`Mensaje` AS `Mensaje`,`mensajes`.`ID_usuariorecibidor` AS `ID_usuariorecibidor`,`mensajes`.`Producto_ID` AS `Producto_ID`,`mensajes`.`FechaHora` AS `FechaHora` from `mensajes` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-06-03  9:46:02
