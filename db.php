<?php
    $server="localhost";
    $db="develotecapp";
    $user="root";
    $password="";
    
    try {
        $connection=new PDO("mysql:host=$server;dbname=$db",$user, $password);
    } catch(Exception $ex) {
        echo $ex->getMessage();
    }

    /*$createdb = "CREATE DATABASE IF NOT EXISTS develotecapp";
    if ($connection->query($createdb) === TRUE) {
        echo "DB CREATED";
    } else {
        echo "DB ALREADY EXISTS";
    }*/

    /*
    CREATE DATABASE IF NOT EXISTS develotecapp
    USE develotecapp;
    CREATE TABLE IF NOT EXISTS employees (
        id INT(11) PRIMARY KEY AUTO_INCREMENT,
        firstname VARCHAR (100) NOT NULL,
        middlename VARCHAR (100) NULL,
        lastname VARCHAR (100) NOT NULL,
        photo VARCHAR (250) NOT NULL,
        cv VARCHAR (250) NOT NULL,
        email VARCHAR (250) NOT NULL,
        idposition INT (11) NOT NULL,
        startdate DATE NOT NULL,
        INDEX (idposition(11))
    );

    USE develotecapp;
    CREATE TABLE IF NOT EXISTS users (
        id INT(11) PRIMARY KEY AUTO_IMCREMENT,
        username VARCHAR(200) NOT NULL,
        email VARCHAR(255) NOT NULL,
        password VARCHAR(255) NOT NULL
    );

    USE develotecapp;
    CREATE TABLE IF NOT EXISTS positions (
        id int(11) PRIMARY KEY AUTO_INCREMENT,
        positionname VARCHAR(200)
    );
    */
?>