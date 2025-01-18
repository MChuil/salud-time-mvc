<?php

namespace App\Models;

class User extends Model{

    protected $table = 'users';


    //funcion para traducir
    public function translate($type)
    {
        $traducciones = [
            'admin' => 'Administrador',
            'receptionist' => 'Recepcionista',
            'doctor' => 'Doctor',
            'patient' => 'Paciente'
        ];
        return isset($traducciones[$type]) ? $traducciones[$type] : '';
    }
}