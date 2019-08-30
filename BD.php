<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept");
header("Access-Control-Allow-Methods: POST");
#header("Allow: GET, POST, OPTIONS, PUT, DELETE");


#if($_SERVER['REQUEST_METHOD'] == 'POST') {
   $host = "localhost";
   $db_name = "Proyecto";
   $username = "root";
   $password = "root";
#} else {
#   http_response_code(405);
#   die();
#}



$projects = [];
?>
