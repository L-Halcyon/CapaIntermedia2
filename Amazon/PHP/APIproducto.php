<?php
require_once "../PHP/conexion.php";

class ApiProductos {
    function search($keyword) {
        $conexion = new Conexion();
        $productos = array();
        $productos["items"] = array();

        $res = $this->obtenerproductos($conexion);

        if ($res->rowCount()) {
            while ($row = $res->fetch(PDO::FETCH_ASSOC)) {
                $item = array(
                    'Producto_ID' => $row['Producto_ID'],
                    'Descripcion' => $row['Descripcion'],
                    'Nombre' => $row['Nombre'],
                    'Precio' => $row['Precio'],
                    'Tipo_Oferta' => $row['Tipo_Oferta'],
                    'Disponibilidad' => $row['Disponibilidad'],
                    'Eliminado' => $row['Eliminado'],
                    'Usu_ID' => $row['Usu_ID']
                );
                array_push($productos['items'], $item);
            }
            echo json_encode($productos);
        } else {
            echo json_encode(array('mensaje' => 'No se encontraron productos'));
        }
    }

    /*function obtenerproductos($conexion) {
        $query = $conexion->obtenerConexion()->query("SELECT * FROM Producto");
        return $query;
    }*/
    function obtenerproductos($conexion) {
        $query = $conexion->obtenerConexion()->prepare("SELECT * FROM Producto WHERE Nombre LIKE :keyword");
        $query->execute(['keyword' => '%' . $_GET['keyword'] . '%']);
        return $query;
    }
    
}

if (isset($_GET['keyword'])) {
    $apiProductos = new ApiProductos();
    $apiProductos->search($_GET['keyword']);
}




/*require_once "../PHP/conexion.php";

class ApiProductos {
    
    function search($keyword) {
        $conexion = new Conexion();
        $productos = array();
        $productos["items"] = array();
    
        $res = $this->obtenerproductos($conexion);

        if($res->rowCount()){
            while($row = $res->fetch(PDO::FETCH_ASSOC)){
                $item = array(
                    'Producto_ID' => $row['Producto_ID'],
                    'Descripcion' => $row['Descripcion'],
                    'Nombre' => $row['Nombre'],
                    'Precio' => $row['Precio'],
                    'Tipo_Oferta' => $row['Tipo_Oferta'],
                    'Disponibilidad' => $row['Disponibilidad'],
                    'Eliminado' => $row['Eliminado'],
                   
                    'Usu_ID' => $row['Usu_ID']
                );
                array_push($productos['items'], $item);
            }

            echo json_encode($productos);
        }
        else{
            echo json_encode(array('mensaje' => 'No se encontraron productos'));
        }
    }

    function obtenerproductos($conexion){
        $query = $conexion->obtenerConexion()->query("SELECT * FROM Producto");
        return $query;
    }
}

// Crear una instancia de ApiProductos y llamar al método search si se recibe una solicitud AJAX
if(isset($_GET['keyword'])) {
    $apiProductos = new ApiProductos();
    $apiProductos->search($_GET['keyword']);
}*/
?>
