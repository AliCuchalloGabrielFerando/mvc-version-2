<?php

class PeliculaModel{
    protected $db;
    protected $datos;
    function __construct()
    {
        $this->db = new Database();
        $this->datos = (object)Array();
        $this->datos->codigo = 0;
        $this->datos->nombre = '';
        $this->datos->duracion = '';
        $this->datos->genero_id = 0;
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
    function getPeliculas(){
        $peliculas = [];
        try{
            $query = $this->db->getPDO()->query('SELECT * FROM PELICULA');
            while($row = $query->fetch()){
                $pelicula = (object)Array();
                $pelicula->codigo = $row['codigo'];
                $pelicula->nombre = $row['nombre'];
                $pelicula->duracion = $row['duracion'];
                $pelicula->genero_id = $row['genero_id'];
                array_push($peliculas,$pelicula);
            }
            $this->db->closeConnect();
            return $peliculas;

        }catch(PDOException $e){
            $pelicula = (object)Array();
            $pelicula->codigo = 1;
            $pelicula->nombre = $e->getMessage();
            $pelicula->duracion = '';
            $pelicula->genero_id = 1;
            return [$pelicula]; 
        }
    }
    
    function createPelicula($datos){
        try{
            $this->datos = $datos;
            $query = $this->db->getPDO()->prepare('INSERT INTO PELICULA (CODIGO,NOMBRE,DURACION,GENERO_ID) VALUES (:CODIGO, :NOMBRE, :DURACION, :GENERO_ID)');
            $query->execute([
                'CODIGO' => $this->datos->codigo,
                'NOMBRE' => $this->datos->nombre,
                'DURACION' => $this->datos->duracion,
                'GENERO_ID' => $this->datos->genero_id
            ]);
            
            return 'pelicula creada';
        }catch(PDOException $e){
            return $this->getErrorMessage($e);
        }
    }
    function updatePelicula($datos){
        try{
            $this->datos = $datos;
            $query = $this->db->getPDO()->prepare('UPDATE PELICULA SET NOMBRE=:NOMBRE, DURACION=:DURACION, GENERO_ID=:GENERO_ID WHERE CODIGO=:CODIGO');
            $query->execute([
                'CODIGO' => $this->datos->codigo,
                'NOMBRE' => $this->datos->nombre,
                'DURACION' => $this->datos->duracion,
                'GENERO_ID' => $this->datos->genero_id
            ]);
            return 'pelicula actualizada';
        }catch(PDOException $e){
            return $this->getErrorMessage($e);
        }
    }

    function deletePelicula($datos){
        try{
            $this->datos = $datos;
            $query = $this->db->getPDO()->prepare('DELETE FROM PELICULA WHERE CODIGO=:CODIGO');
            $query->execute([
                'CODIGO' => $this->datos->codigo
            ]);
            return 'pelicula eliminada';
        }catch(PDOException $e){
            return $this->getErrorMessage($e);
        }
    }
}


?>