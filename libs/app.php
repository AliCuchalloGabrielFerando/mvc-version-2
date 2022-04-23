<?php
require_once 'controllers/errores.php';

class App
{
    function __construct()
    {
       // http://localhost/PHP%20puro/proyecto/genero
        //si la ruta es solo '/' va por defecto a Genero
        $url = isset($_GET['url']) ? $_GET['url'] : null;

        if (is_null($url)) {
            $fileControler = 'controllers/generoController.php';
            require_once $fileControler;
            $controller = new GeneroController(true);
            
            return false;
        }
        //carga el controlador de la ruta url '/genero/eliminar-genero/1/2/3' traera al controlador generoController
        $url = explode('/', $url);
        $fileControler = 'controllers/' . $url[0] . 'Controller.php';
        if (file_exists($fileControler)) {
            require_once $fileControler;
            $nameController = $url[0].'Controller';

            //numero de elementos
            $nparams = sizeof($url);
            //si hay un metodo que se requiera cargar y luego el metodo renderiza la vista
            if ($nparams >1){
                $controller = new $nameController;

                //convierte la notacion url a notacion de funcion ejem: ver-algo a verAlgo
                $funcion = explode('-',$url[1]);
                if (sizeof($funcion)>1){
                $funcion[1] = ucfirst($funcion[1]);
                $funcion = $funcion[0] . $funcion[1];
                }
                // si el metodo tiene parametros
                if ($nparams>2){
                    $params =[];
                    for ( $i = 2; $i<$nparams; $i++){
                        array_push($params,$url[$i]);
                    }
                    $controller->{$funcion}($params);
                }else{
                    //no tiene parametros
                    try {
                        $controller->{$funcion}();

                    } catch (Exception $err) {
                        echo "funcion no encontrada";
                    }
                }
            }else{
                //no hay metodo para cargar se renderiza la vista
                
                $controller = new $nameController(true);
            }

        } else {
            $controller = new Errors();
        }
    }
}
