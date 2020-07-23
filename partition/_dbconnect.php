<?php
$servername="localhost";
$username="root";
$password="";
$database="expandature";

// CREATING A CONNECTION
$conn=mysqli_connect($servername, $username, $password,$database);

// DIE IF CONNECTION IS NOT SUCCESSFUL
if(!$conn){
    die("Sorry we failed to connect: ".mysqli_connect_error());
}
?>