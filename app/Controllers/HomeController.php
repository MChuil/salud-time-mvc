<?php 

namespace App\Controllers;

use App\Models\Contact;

class HomeController extends BaseController{

    public function index(){
        $data =[
            'welcome' => 'Bienvenido al sistema ' . $_SESSION['nombre'],
            'title' => 'Dashboard 4.2'
        ];
        return $this->view('dashboard', $data);
    }

    public function home(){
        return "Inicio de MVC";
    }

}
