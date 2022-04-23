<?php

class AlquilerView{

    protected $message;
    protected $peliculas;
    protected $alquilers;

    function __construct()
    {
        $this->message = '';
        $this->peliculas = array();
        $this->alquilers = array();
    }
    function setPeliculas($peliculas){
        $newPeliculas = array();
        foreach($peliculas as $pelicula){
            $newPeliculas[$pelicula->codigo] = $pelicula->nombre;
        }
        $this->peliculas = $newPeliculas;
    }
    function setDatos($alquileres = [], $message = ''){
        $this->alquileres = $alquileres;
        $this->message = $message;
        $this->render();

    }
    function render(){
        require 'views/alquiler/alquiler.php';
    }
}



?>