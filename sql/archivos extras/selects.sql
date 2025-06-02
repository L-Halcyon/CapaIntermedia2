use BDM;

SELECT * FROM Usuario;
SELECT * FROM Lista;
SELECT * FROM Producto;
SELECT * FROM Venta;
SELECT * FROM Comentario;
SELECT * FROM categoria;
SELECT * FROM mensajes;
SELECT * FROM contactos;
SELECT * FROM carrito;

SHOW TABLES;


SELECT 
    *
FROM
    Categoria
WHERE
    Nombre = 'hola';

ALTER TABLE mensajes
ADD COLUMN FechaHora DATETIME DEFAULT CURRENT_TIMESTAMP;

SELECT * FROM Producto_cotizable;

SELECT * FROM Producto_cotizable WHERE ID_usuario = 3 AND Eliminado = 1;

CALL MarcarProductoCotizableAceptado(4,2);

