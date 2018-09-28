<?php
class dbconf{
    
public static function dbcon(){
    return $dbconf=array(
        'driver' => 'mysql', 
        'host' => 'localhost',
        'user' => 'root',
        'password' => '',
        'database' => 'rabbit',
    );
    }
}



