<?php
$host       = "localhost";
$username   = "root";
$password   = "root";
$dbname     = "bec_to_do"; 
$dsn        = "mysql:host=$host;dbname=$dbname"; 
$options    = array(
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
              );
?>