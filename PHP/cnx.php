<?php

$dsn = 'mysql:dbname=bddqcm2;host=localhost';
$user = 'root';
$motDePasse ='';
$bdd = new PDO($dsn,$user,$motDePasse, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
try{
    $cnx = new PDO($dsn, $user, $motDePasse, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
    
            
} catch (PDOException $e) {
    die('Erreur : ' . $e->getMessage() );
}
