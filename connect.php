<?php
//session_start();

$database_Host = 'localhost';
$database_User = 'root';
$database_Pass = '';
$database_Name = 'livreor';

$con = mysqli_connect($database_Host, $database_User, $database_Pass, $database_Name, 3307);
//$con = mysqli_connect($database_Host, $database_User, $database_Pass, $database_Name, 3307);
$request = $con->query('SELECT * FROM utilisateurs');
$data = $request->fetch_All();

if ( mysqli_connect_error() ) {
	// Si il y une erreur pendant la connection, on arrete le script et on affiche un message d'erreur.
	exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}