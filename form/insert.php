<?php
include "connection.php";
try{
    $sql="INSERT INTO students(name,email,course) VALUES('$name','$email','$course')";
    $conn->exec($sql);
    echo "Data inserted successfully";
}catch(PDOException $e){
    echo "Failed".$e->getMessage().
}