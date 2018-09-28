
<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Description of DBPDO
 *
 * @author Federico
 */
include('config.php');

class DB {
    protected $conn;
    protected static $instance=null;//INSTANCE OF CONNECTION
   
    
    protected function __construct(array $options) {
       
        $this->conn = new mysqli($options['host'],$options['user'],$options['password'],$options['database'] );
         
         if ( $this->conn->connect_error) {
             die("Connection failed: " . $this->conn->connect_error);
                } 
    }
    public static function getInstance()
    {
        $option= dbconf::dbcon();
      
             if(!static::$instance){
                static::$instance=new DB($option); //IF INSTANCE NOT EXISTS, CREATE IT WITH A CONNECTION TO DB
        }  
        return static::$instance;
                
    }
    public function getConn(){
        return $this->conn;
    }
}
