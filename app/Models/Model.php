<?php

namespace App\Models;

use mysqli;

class Model{

    protected $host = DB_HOST;
    protected $user = DB_USER;
    protected $password = DB_PASSWORD;
    protected $dbname = DB_NAME;
    protected $connection;
    protected $query;
    protected $table;

    public function __construct(){
        $this->connection();
    }

    public function connection(){      
        //Mysqli Connection (mysql)
        $this->connection = new mysqli($this->host, $this->user, $this->password, $this->dbname);
        
        // Check connection
        if($this->connection->connect_error){
            die("ERROR: No se conecto a la base de datos " . $this->connection->connect_error);
        }
    }

    public function query($sql){
        $this->query =  $this->connection->query($sql);
        return $this;
    }

    public function first(){
        return $this->query->fetch_assoc();
    }


    public function get(){
        return $this->query->fetch_all(MYSQLI_ASSOC); 
    }

    // ===================== CONSULTAS PREPARADAS =====================

    //listar todos los registros
    public function all(){
        $sql = "SELECT * FROM {$this->table}";
        return $this->query($sql)->get();
    }

    //buscar por el ID
    public function find($id){
        //SELECT * FROM contacts WHERE id = 1
        $sql = "SELECT * FROM {$this->table} WHERE id = {$id}";
        return $this->query($sql)->first();
    }

    //buscar por el campo y valor
    public function where($column, $operator, $value = null){
        if($value == null){
            $value = $operator;
            $operator = '=';
        }
        $sql ="SELECT * FROM {$this->table} WHERE {$column} {$operator} '{$value}'";
        $this->query($sql);
        return $this;
    }
}
