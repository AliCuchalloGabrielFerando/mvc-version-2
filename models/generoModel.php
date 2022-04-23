<?php

class GeneroModel {
    protected $db;
    function __construct()
    {
        $this->db = new Database();
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
    function getGeneros(){
        $generos = [];
        try {
            $query = $this->db->getPDO()->query('SELECT * FROM GENERO');
         /*  $query = $this->db->getPDO()->prepare('SELECT * FROM GENERO WHERE ID>:ID');
           $query->execute([
                'ID'=>3
           ]);*/
            while ($row = $query->fetch()) {
                $genero = (object)array();
                $genero->id = $row['id'];
                $genero->nombre = $row['nombre'];
                array_push($generos, $genero);
            }
            $this->db->closeConnect();
            return $generos;
        } catch (PDOException $e) {
            $genero = (object)array();
                $genero->id = -1;
                $genero->nombre = 'error en el modelo';
            return [$genero];
        }
    }
    function createGenero($datos){
        try{
            $query = $this->db->getPDO()->prepare('INSERT INTO GENERO (ID,NOMBRE) VALUES (:ID, :NOMBRE)');
            $query->execute([
                'ID' => $datos->id, 
                'NOMBRE' => $datos->nombre
            ]);
           
           // var_dump($query); 
           /*
           $id = $this->db->getPDO()->lastInsertId();
           
                var_dump($id);
                $query = $this->db->getPDO()->query('select last_insert_id()');
                while ($row = $query->fetch()) {
                   var_dump($row);
                 } 
                 */
          
            return 'genero creado';
        }catch(PDOException $e){
            return $this->getErrorMessage($e);
        }
    }
    function updateGenero($datos){
        try{
            $query = $this->db->getPDO()->prepare('UPDATE GENERO SET NOMBRE=:NOMBRE WHERE ID=:ID');
            $query->execute(['ID'=>$datos->id, 'NOMBRE'=> $datos->nombre]);
            return 'genero actualizado';
        }catch(PDOException $e){
            return $this->getErrorMessage($e);
        }
    }
    function deleteGenero($datos){
        try{
            $query = $this->db->getPDO()->prepare('DELETE FROM GENERO WHERE ID=:ID');
            $query->execute(['ID'=>$datos->id]);
            return 'genero eliminado';
        }catch(PDOException $e){
            return $this->getErrorMessage($e);
        }
    }

}

?>