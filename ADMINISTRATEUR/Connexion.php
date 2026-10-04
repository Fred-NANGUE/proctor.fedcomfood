<?php
$host="localhost";
$user="root";
$password="";
$name_database="reservation_system";
$conn = new mysqli($host,$user,$password,$name_database);
if($conn ->connect_error){
    echo "failed to connect DB" .$conn ->connect_error;
}
?>