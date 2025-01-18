<?php 

namespace App\Controllers;

class BaseController{
    
    public function view($route, $data = []){
        //desestructuración de data
        extract($data);
        $route = str_replace('.', '/', $route);
        if(file_exists("../resources/views/$route.php")){
            ob_start();
            include "../resources/views/$route.php";
            $content = ob_get_clean();
            return $content;
        }else{
            return "El archivo no existe";
        }
    }

}
