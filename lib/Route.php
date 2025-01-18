<?php 

    namespace Lib;

    class Route {

        private static $routes = [];
        /*$routes['GET'][
            '/' => function(){}, 
            'contacto' => function(){}, 
            'clientes' => function(){}, 
            'nosotros'=> function(){}
        ]*/

        //$routes['POST']['nosotros']

        //agregar rutas GET al array de rutas
        public static function get($uri, $callback){
            $uri = trim($uri, '/'); 
            self::$routes['GET'][$uri] = $callback;
        }

        //agregar rutas POST al array de rutas
        public static function post($uri, $callback){
            $uri = trim($uri, '/'); 
            self::$routes['POST'][$uri] = $callback;
        }

        //recuperar la uri y ejecutar la funcion callback
        public static function dispatch(){
            $uri = $_SERVER['REQUEST_URI'];
            $uri = trim($uri, '/');

            $method = $_SERVER['REQUEST_METHOD']; //identifica el metodo de la peticion

            foreach(self::$routes[$method] as $route => $callback){
                // course/:slug
                if(strpos($route, ':') !== false){
                    $route = preg_replace("#:[a-zA-Z]+#", "([a-zA-Z]+)", $route);
                }

                //uri = course/cualquiercosa
                if(preg_match("#^$route$#", $uri, $matches)){
                    $params = array_slice($matches, 1);  //recuperamos los parametros en un array
                    if(is_callable($callback)){  //verificamos si es una funcion
                        $response = $callback(...$params);
                    }

                    if(is_array($callback)){ //verificamos si es un array
                        $controller = new $callback[0]; // $controller= new HomeController
                        $response = $controller->{$callback[1]}(...$params); // $controller->index()
                    }

                    if(is_array($response) || is_object($response)){
                        echo json_encode($response);
                        return;
                    }
                    echo $response;
                    return;
                }
            }
            echo "404 Not Found";
        }
    }