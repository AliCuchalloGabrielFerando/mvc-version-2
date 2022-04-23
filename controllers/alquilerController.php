<?php
require 'models/alquilerModel.php';
require 'views/alquiler/alquilerView.php';
require 'models/peliculaModel.php';

class AlquilerController{

    protected $alquilerView;
    protected $alquilerModel;
    protected $peliculaModel;
    protected $peliculasSize;

    function __construct($metodo = false)
    {
        $this->alquilerView = new AlquilerView();
        $this->alquilerModel = new AlquilerModel();
        $this->peliculaModel = new PeliculaModel();
        $peliculas = $this->peliculaModel->getPeliculas();
        $this->peliculasSize = count($peliculas) + 3;
        $this->alquilerView->setPeliculas($peliculas);
        if($metodo){
            $this->alquilerView->setDatos($this->alquilerModel->getAlquileres());
        }
    }

    function registrarAlquiler(){
        $datos = (object)array();
        $datos->codigo = $_POST['codigo'];
        $datos->fecha = $_POST['fecha'];
        $datos->monto = $_POST['monto'];
        $datos->detalles = [];
    
        for( $i =3;$i<$this->peliculasSize;$i++){  
            if(array_key_exists($i,$_POST)){
                array_push($datos->detalles,$_POST[$i]);    
            }
        }
        $message = $this->alquilerModel->createAlquiler($datos);
        $alquileres = $this->alquilerModel->getAlquileres();
        $this->alquilerView->setDatos($alquileres,$message); 
    }

    function editarAlquiler(){
        $datos = (object)array();
        $datos->codigo = $_POST['codigo'];
        $datos->fecha = $_POST['fecha'];
        $datos->monto = $_POST['monto'];
        $datos->detalles = [];
        for( $i =3;$i<$this->peliculasSize;$i++){
            if( array_key_exists($i,$_POST)){
                array_push($datos->detalles,$_POST[$i]);
            }
        }
        $message = $this->alquilerModel->updateAlquiler($datos);
        $alquileres = $this->alquilerModel->getAlquileres();
        $this->alquilerView->setDatos($alquileres,$message); 
    }

    function eliminarAlquiler($codigo){
        $datos = (object)array();
        $datos->codigo = $codigo[0];

        $message = $this->alquilerModel->deleteAlquiler($datos);
        $alquileres = $this->alquilerModel->getAlquileres();
        $this->alquilerView->setDatos($alquileres,$message); 
    }

}


?>