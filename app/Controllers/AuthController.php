<?php

namespace App\Controllers;

use App\Models\User;

class AuthController extends BaseController
{
    public function login(){
        return $this->view('login');
    }

    //autorizar el acceso al aplicativo
    public function auth(){
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);
        $user = new User();
        
        $user->where('email', $email);
        $query = $user->first();
        if($query){ //si existe el correo
            //verificar la contraseña
            if(password_verify($password, $query['password'])){ //si es correcta
                $_SESSION['nombre'] = $query['name'] . " " . $query['lastname'];
                $_SESSION['correo'] = $query['email'];
                $_SESSION['rol'] = $query['type'];
                $_SESSION['login'] = true;
                //redirección al dashboard
                header('Location: /dashboard');
            }else{ //si no es correcta
                return $this->view('login', ['error' => 'Correo y/o contraseña incorrecta']);
            }
        }

        
    }
}