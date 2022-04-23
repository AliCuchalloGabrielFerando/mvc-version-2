<?php
class AlquilerDetalleModel{
    protected $db;
    protected $datos;

    function __construct()
    {
        $this->db = new Database();
        $this->datos = (object)array();
        $this->datos->alquiler_codigo = '';
        $this->datos->pelicula_codigo = '';
    }
    protected function getErrorMessage(PDOException $e){
        switch ($e->getCode()) {
            case 23000:
                // AQUI Analizar cual de todos los tipos es
                return 'Clave repetida';
            default:
                return $e->getMessage();
        }
    }

    function getDetalles($alquiler_codigo){
        $detalles = [];
        try{
            $query = $this->db->getPDO()->prepare('SELECT * FROM DETALLEALQUILER WHERE ALQUILER_CODIGO =:ALQUILER_CODIGO');
            $query->execute([
                'ALQUILER_CODIGO'=>$alquiler_codigo
            ]);
            while($row = $query->fetch()){
                 $detalle = (object)array();
                 $detalle->alquiler_codigo = $row['alquiler_codigo'];
                 $detalle->pelicula_codigo = $row['pelicula_codigo'];
                 array_push($detalles,$detalle);
            }
            
            return $detalles;

        }catch(PDOException $e){
           return [$this->datos];
          
        }
    }

    function createDetalles($alquiler_codigo,$peliculas){
        try{
            foreach($peliculas as $codigo){
                $query = $this->db->getPDO()->prepare('INSERT INTO DETALLEALQUILER (ALQUILER_CODIGO,PELICULA_CODIGO) VALUES(:A,:B)');
                $query->execute([
                    'A'=>$alquiler_codigo,
                    'B'=>$codigo
                ]);
            }
            //$this->db->closeConnect();
            return 'detalles creados';
        }catch(PDOException $e){
            return $this->getErrorMessage($e);
        }
    }
    function updateDetalles($alquiler_codigo,$peliculas){
        try{
            $query = $this->db->getPDO()->prepare('DELETE FROM DETALLEALQUILER WHERE ALQUILER_CODIGO=:ALQUILER_CODIGO');
            $query->execute([
                'ALQUILER_CODIGO'=>$alquiler_codigo
            ]);
            foreach($peliculas as $codigo){
                $query = $this->db->getPDO()->prepare('INSERT INTO DETALLEALQUILER (ALQUILER_CODIGO,PELICULA_CODIGO) VALUES(:A,:B)');
                $query->execute([
                    'A'=>$alquiler_codigo,
                    'B'=>$codigo
                ]);
            }
            return 'detalles actualizados';
        }catch(PDOException $e){
            return $this->getErrorMessage($e);
        }
    }
    
    function deleteDetalles($alquiler_codigo){
        try{
            $query = $this->db->getPDO()->prepare('DELETE FROM DETALLEALQUILER WHERE ALQUILER_CODIGO=:ALQUILER_CODIGO');
            $query->execute([
                'ALQUILER_CODIGO'=>$alquiler_codigo
            ]);
            return 'detalles eliminados';
        }catch(PDOException $e){
            return $this->getErrorMessage($e);
        } 
    }
}

?>