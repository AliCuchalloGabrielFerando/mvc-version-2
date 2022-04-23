<?php
    require 'models/generoModel.php';
    require 'views/genero/generoView.php';
    class GeneroController {

        protected $generoView;
        protected $generoModel;

        function __construct($metodo = false){
        $this->generoView = new GeneroView();
        $this->generoModel = new GeneroModel();
        if($metodo){
            $generos = $this->generoModel->getGeneros(); 
            $this->generoView->setDatos($generos);
            }
        }
        
        function registrarGenero(){
            $datos = (object)array();
            var_dump($_POST);
           /* if(is_null($_POST['nombre'])){
                echo "nooooo";
            }*/
            $datos->id = $_POST['codigo'];
            $datos->nombre = $_POST['nombre'];
          //  $message = $this->generoModel->createGenero($datos);
            $generos = $this->generoModel->getGeneros(); 
            $this->generoView->setDatos($generos,$generos);
           
        }
        function editarGenero(){
            $datos = (object)array();
            $datos->id = $_POST['codigo'];
            $datos->nombre = $_POST['nombre'];
            $message = $this->generoModel->updateGenero($datos);
            $generos = $this->generoModel->getGeneros(); 
            $this->generoView->setDatos($generos,$message);
           
        }
        function eliminarGenero($params){
            $datos = (object)Array();
            $datos->id = $params[0];
            $message = $this->generoModel->deleteGenero($datos);
            $generos = $this->generoModel->getGeneros(); 
            $this->generoView->setDatos($generos,$message);
        
           
          
        }
    }
?>