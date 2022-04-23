<?php
class GeneroView{
    public $generos;
    public $message;
    function __construct()
    {
        $this->generos = [];
        $this->message = '';
    }
    function render(){
        require 'views/genero/genero.php';
    }
    function setDatos($generos=[],$message=''){
        $this->generos = $generos;
        $this->message = $message;
        $this->render();
    }
    //set datos

    
}
?>