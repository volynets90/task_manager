<?php
class DB{
    const DB_NAME='tasks';
    const DB_USER='root';
    const DB_PASS='';
    const DB_HOST='localhost';
    const DB_PORT='8080';
    const DB_OPTIONS=[
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];
}
    

