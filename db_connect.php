<?php
header('Access-Control-Allow-Origin: *');
require_once('db.php');

class DBConnect{
    function connectToDB(){
        try {
            $dbh = new PDO(
                            'mysql:host='.DB::DB_HOST.
                            ';dbname='.DB::DB_NAME.
                           ';charset=utf8',                          
                            DB::DB_USER,
                            DB::DB_PASS,
                            DB::DB_OPTIONS
                        );
            return $dbh;
        } catch (PDOException $e) {
            echo "Cannot connect to Database".$e->getMessage();
        }
        
    }
}