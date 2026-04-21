<!DOCTYPE html>
<html>
<head>
<style>
#button{
    background-color:black;
    color:white;
    padding:10px 20px;
    border:none;
    border-radius:5px;
    cursor:pointer;
}

.button1:hover{
    background-color:white;
    color:black;
    border:1px solid black;
}

.error{
    color:red;
}
</style>
</head>

<body>

<?php 
$name = $email = $number = "";
$nameERR = $emailERR = $numberERR = "";
?>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

Name:
<input type="text" name="name" value="<?php echo $name; ?>">
<span class="error"><?php echo $nameERR; ?></span>
<br><br>

Email:
<input type="email" name="email" value="<?php echo $email; ?>">
<span class="error"><?php echo $emailERR; ?></span>
<br><br>

Number:
<input type="number" name="number" value="<?php echo $number; ?>">
<span class="error"><?php echo $numberERR; ?></span>
<br><br>

<input id="button" class="button1" type="submit">

</form>

<?php 

$host="localhost";
$dbname="collage_db";
$username="root";
$password= "";

try{
    $conn=new PDO("mysql:host=$host;dbname=$dbname",$username,$password);
    $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully <br>";

}catch(PDOException $e){
    echo "Connection failed: " . $e->getMessage()."<br>";
}


function test_data($data){
    return htmlspecialchars(stripslashes(trim($data)));
}

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $valid = true;

    if(empty($_POST["name"])){
        $nameERR = "Name is required";
        $valid = false;
    } else {
        $name = test_data($_POST["name"]);
    }

    if(empty($_POST["email"])){
        $emailERR = "Email is required";
        $valid = false;
    } else {
        $email = test_data($_POST["email"]);
    }

    if(empty($_POST["number"])){
        $numberERR = "Number is required";
        $valid = false;
    } else {
        $number = test_data($_POST["number"]);
    }

    // Show output only if valid
    if($valid){

    $sql = "INSERT INTO students (name, email, number)
            VALUES ('$name', '$email', '$number')";

    // $stmt = $conn->prepare($sql);

    // $stmt->bindParam(':name', $name);
    // $stmt->bindParam(':email', $email);
    // $stmt->bindParam(':number', $number);

    $conn->exec($sql);

    echo "<h3 style='color:green'>Data inserted successfully</h3>";

    // prevent duplicate insert on refresh
    header("Location: ".$_SERVER['PHP_SELF']);
    exit();
} else {
    echo "<h3 style='color:red'>Please fill in all fields</h3>";
}

}
?>
<tbody>
<?php
$sql = "SELECT * FROM students" ;
$result = $conn->query($sql) ;
if($result->rowCount() > 0){
while($row = $result->fetch()){
echo "<tr>";
echo "<td>" . $row['id'] . "</td>";
echo "<td>" . $row['name'] . "</td>";
echo "<td>" . $row['email'] . "</td>";
echo "<td>" . $row['number'] . "</td>";
echo "</tr>";
}
"<br>";
} else{
echo "No records found";
}
?><br>
</tbody><br>

</body>
</html>