<?php

/* Connection to MySQL database - standard*/
$mysqli = new mysqli("localhost", "root", "123456", "desafio", "3306"); //the variable mysqli can be called whatever you want
if($mysqli->connect_error){
    exit("Error connecting to database");
}