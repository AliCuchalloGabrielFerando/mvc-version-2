<?php
require 'models/peliculaModel.php';
require 'models/generoModel.php';
require 'views/pelicula/peliculaView.php';
class PeliculaController{
    protected $peliculaView;
    protected $peliculaModel;
    protected $generoModel;

    function __construct($metodo=false){
        $this->peliculaView = new PeliculaView();
        $this->peliculaModel = new PeliculaModel();
        $this->generoModel = new GeneroModel();
        $this->peliculaView->setGeneros($this->generoModel->getGeneros());
        if($metodo){
        $this->peliculaView->setDatos($this->peliculaModel->getPeliculas());
        }
    }

   
    function registrarPelicula(){
        $datos = (object)array();
        $datos->codigo = $_POST['codigo'];
        $datos->nombre = $_POST['nombre'];
        $datos->duracion = $_POST['duracion'];
        $datos->genero_id = $_POST['genero_id'];

        $message = $this->peliculaModel->createPelicula($datos);
        $peliculas = $this->peliculaModel->getPeliculas();
        $this->peliculaView->setDatos($peliculas,$message);
    }
    function editarPelicula(){
        $datos = (object)array();
        $datos->codigo = $_POST['codigo'];
        $datos->nombre = $_POST['nombre'];
        $datos->duracion = $_POST['duracion'];
        $datos->genero_id = $_POST['genero_id'];

        $message = $this->peliculaModel->updatePelicula($datos);
        $peliculas = $this->peliculaModel->getPeliculas();
        
        $this->peliculaView->setDatos($peliculas,$message);
    }
    function eliminarPelicula($codigo){
        $datos = (object)array();
        $datos->codigo = $codigo[0];

        $message = $this->peliculaModel->deletePelicula($datos);
        $peliculas = $this->peliculaModel->getPeliculas();
        
        $this->peliculaView->setDatos($peliculas,$message);
    }
}






/*

TheBloodyGir117
hace 13 días
"En la simpleza, existe la complejidad.
En solo la complejidad, existe la estupidez."
*/
?>



