<?php
// DATABASE CONNECTION
try {
    $conn = new PDO("mysql:host=localhost;dbname=collage_db", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e){
    die("Connection failed: " . $e->getMessage());
}

// INSERT
if(isset($_POST['insert'])){
    $sql = "INSERT INTO students(name,email,number)
            VALUES(:name,:email,:number)";
   $conn->exec($sql)
}

// DELETE
if(isset($_GET['delete'])){
    $id=$_GET['delete'];
   $sql="DELETE FROM students WHERE id='$id'";
   $conn->exec($sql);
}

// LOAD FOR EDIT
$edit = null;
if(isset($_GET['edit'])){
    $sql = 'SELECT * FROM students WHERE id='$id'';
    $conn->exec($sql);
}

// UPDATE
if(isset($_POST['update'])){
    $sql = "UPDATE students 
            SET name=:name, email=:email, number=:number 
            WHERE id=:id";

   $conn->exec($sql)
    
}
?>

<!DOCTYPE html>
<html>
<head>
<title>CRUD System</title>
<style>
table{border-collapse:collapse;width:80%;}
th,td{border:1px solid black;padding:8px;text-align:center;}
th{background:black;color:white;}
</style>
</head>
<body>

<h2>Student Form</h2>

<form method="post">

<input type="hidden" name="id" value="<?php echo $edit['id'] ?? ''; ?>">

Name:
<input type="text" name="name" value="<?php echo $edit['name'] ?? ''; ?>">
<br><br>

Email:
<input type="text" name="email" value="<?php echo $edit['email'] ?? ''; ?>">
<br><br>

Number:
<input type="text" name="number" value="<?php echo $edit['number'] ?? ''; ?>">
<br><br>

<?php if($edit){ ?>
    <button name="update">Update</button>
<?php } else { ?>
    <button name="insert">Insert</button>
<?php } ?>

</form>

<hr>

<h2>Student List</h2>
<table>
<tr>
<th>ID</th>
<th>Name</th>
<th>Email</th>
<th>Number</th>
<th>Action</th>
</tr>

<?php
$result = $conn->query("SELECT * FROM students");

while($row = $result->fetch()){
    echo "<tr>
        <td>{$row['id']}</td>
        <td>{$row['name']}</td>
        <td>{$row['email']}</td>
        <td>{$row['number']}</td>
        <td>
            <a href='?edit={$row['id']}'>Edit</a> |
            <a href='?delete={$row['id']}' onclick=\"return confirm('Delete?')\">Delete</a>
        </td>
    </tr>";
}
?>

</table>

</body>
</html>