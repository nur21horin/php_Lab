<?php
$host="localhost";
$dbname="collage_db";
$username="root";
$password= "";

$conn=new PDO("mysql:host=$host;dbname=$dbname",$username,$password);

$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

$name=$email=$number="";
$nameErr=$emailERR=$numberERR="";
$editData= "";

if(isset($_GET["delete"])){
    
}