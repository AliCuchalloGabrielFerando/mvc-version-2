<?php
class PeliculaView{
    protected $generos;
    protected $peliculas;
    protected $message;

    function __construct()
    {
        $this->generos = array();
        $this->message = '';
    }
    function render(){
        require 'views/pelicula/pelicula.php';
    }
    function setGeneros($generos){
        $newGeneros = array();
        foreach($generos as $genero){
            $newGeneros[$genero->id] = $genero->nombre;
        }
        $this->generos = $newGeneros;
    }
    function setDatos($peliculas,$message=''){
        $this->peliculas = $peliculas;
        $this->message = $message;
        $this->render();
    }
    //set datos

    
}
?>