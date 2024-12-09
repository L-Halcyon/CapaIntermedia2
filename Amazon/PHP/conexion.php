
<?php
class Conexion {
    private $conexion;
    
    public function __construct() {
        $Host = 'localhost';
        $Usuario = 'root';
        $Contrasena = '51423dsca';
        $DBnombre = 'bdm';
        
        try {
            // Establecer la conexión con PDO
            $this->conexion = new PDO("mysql:host=$Host;dbname=$DBnombre", $Usuario, $Contrasena);
            
            // Mostrar mensaje de éxito si la conexión es exitosa
            echo "Conexión exitosa a la base de datos :)";
        } catch (PDOException $exp) {
            // Mostrar mensaje de error si la conexión falla
            echo "Fallo la conexión :(";
            die($exp->getMessage());
        }
    }
    
    public function obtenerConexion() {
        return $this->conexion;
    }
}
?>
