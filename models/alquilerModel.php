<?php
 require 'models/alquilerDetalleModel.php';
class AlquilerModel{
    protected $db;
    protected $datos;
    protected $alquilerDetalleModel;


    function __construct()
    {
        $this->db = new Database();
        $this->datos = (object)array();
        $this->alquilerDetalleModel =new AlquilerDetalleModel;
        $this->datos->codigo = '';
        $this->datos->fecha = '';
        $this->datos->monto = '';
        $this->datos->detalles = [];
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
    function getAlquileres(){
        $alquileres = [];
        try{
            $query = $this->db->getPDO()->query('SELECT * FROM ALQUILER');
            while($row = $query->fetch()){
                $alquiler = (object)array();
                $alquiler->codigo = $row['codigo'];
                $alquiler->fecha = $row['fecha'];
                $alquiler->monto = $row['monto'];
                $alquiler->detalles = $this->alquilerDetalleModel->getDetalles($alquiler->codigo);
                array_push($alquileres,$alquiler);
            }
            $this->db->closeConnect();
            return $alquileres;
        }catch(PDOException $e){
                return [$this->datos];
        }
    }
    function createAlquiler($datos){
        try{
            $this->datos = $datos;
            $query = $this->db->getPDO()->prepare('INSERT INTO ALQUILER(CODIGO,FECHA,MONTO) VALUES(:CODIGO,:FECHA,:MONTO)');
            $query->execute([
                'CODIGO'=> $this->datos->codigo,
                'FECHA'=> $this->datos->fecha,
                'MONTO'=> $this->datos->monto
            ]);
            $message = $this->alquilerDetalleModel->createDetalles($this->datos->codigo,$this->datos->detalles);
            return 'se ha creado el alquiler y ' . $message;

        }catch(PDOException $e){
            return $this->getErrorMessage($e);
        }
    }

    function updateAlquiler($datos){
        try{
            $this->datos = $datos;
            $query = $this->db->getPDO()->prepare('UPDATE ALQUILER SET FECHA=:FECHA, MONTO=:MONTO WHERE CODIGO=:CODIGO');
            $query->execute([
                'FECHA'=> $this->datos->fecha,
                'MONTO'=> $this->datos->monto,
                'CODIGO'=> $this->datos->codigo
            ]);
            $message =  $this->alquilerDetalleModel->updateDetalles($this->datos->codigo,$this->datos->detalles);
            return 'se actualizo el alquiler y ' . $message;

        }catch(PDOException $e){
            return $this->getErrorMessage($e);
        }
    }

    function deleteAlquiler($datos){
        try{
            $this->datos = $datos;
            $message = $this->alquilerDetalleModel->deleteDetalles($this->datos->codigo);
            $query = $this->db->getPDO()->prepare('DELETE FROM ALQUILER WHERE CODIGO=:CODIGO');
            $query->execute([
                'CODIGO'=>$this->datos->codigo
            ]);
            return 'alquiler eliminado y ' . $message;
        }catch(PDOException $e){
            return $this->getErrorMessage($e);
        }
    }

}

?>