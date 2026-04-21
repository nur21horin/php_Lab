<?php
$host="localhost";
$dbname="collage_db";
$username="root";
$password="";

try{
    $conn=new PDO("mysql:host=$host;dbname=$dbname",$username,$password);
    $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    echo "connected successfull";
}catch(PDOException $e){
    echo "connected failed: " .$e->getMessage()."<br>";
}
?>