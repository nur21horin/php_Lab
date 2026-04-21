<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="insert_form.php" method="POST">
        Name:<input type="text" name="name"><br>
        Email:<input type="text" name="email"><br>
        <input type="submit" value="Submit" name="btn_form">
    </form>
</body>
<?php
include "connection.php";

try{
   <?php
include "connection.php";
try {
if($_SERVER["REQUEST_METHOD"]=="POST"){
if(isset($_POST["btn_form"])){
$name = $_POST[’name’];
$email = $_POST[’email’];
$course = $_POST[’course’];
$sql = "INSERT INTO students(name, email, course )
VALUES(’$name’, ’$email’, ’$course’)" ;
$conn->exec($sql) ;
echo "Form data inserted !" . "<br>";
}
}
} catch (PDOException $e) {
echo "Form Insertion failed:" . $e->getMessage() ."<br>";
}
?>
}

<?php
$sql = "UPDATE students SET name=’$name’, email=’$email’,
course=’$course’ WHERE id=’$id’ " ;
?>

<?php
$sql = "DELETE FROM students WHERE id=’$id’ " ;
?>

<?php
include "connection.php";
<tbody>
<?php
$sql = "SELECT * FROM students" ;
$result = $conn->query($sql) ;
if($result->rowCount() > 0){
while($row = $result->fetch()){
echo "<tr>";
echo "<td>" . $row[’id’] . "</td>";
echo "<td>" . $row[’name’] . "</td>";
echo "<td>" . $row[’email’] . "</td>";
echo "<td>" . $row[’course’] . "</td>";
echo "</tr>";
}
} else{
echo "No records found";
}
?>
</tbody>
?>
</html>
