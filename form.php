<?php
// DB CONNECTION
$host="localhost";
$dbname="collage_db";
$username="root";
$password="";

$conn = new PDO("mysql:host=$host;dbname=$dbname",$username,$password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// INIT
$name=$email=$number="";
$nameERR=$emailERR=$numberERR="";
$editData = null;

// ===================== DELETE =====================
if(isset($_GET['delete'])){
    $stmt = $conn->prepare("DELETE FROM students WHERE id=:id");
    $stmt->execute([':id'=>$_GET['delete']]);
    header("Location: index.php");
    exit();
}

// ===================== LOAD DATA FOR EDIT =====================
if(isset($_GET['edit'])){
    $stmt = $conn->prepare("SELECT * FROM students WHERE id=:id");
    $stmt->execute([':id'=>$_GET['edit']]);
    $editData = $stmt->fetch();
}

// ===================== INSERT =====================
if(isset($_POST['insert'])){

    $valid=true;

    if(empty($_POST['name'])){
        $nameERR="Required";
        $valid=false;
    }else{
        $name=htmlspecialchars($_POST['name']);
    }

    if(empty($_POST['email'])){
        $emailERR="Required";
        $valid=false;
    }else{
        $email=htmlspecialchars($_POST['email']);
    }

    if(empty($_POST['number'])){
        $numberERR="Required";
        $valid=false;
    }else{
        $number=htmlspecialchars($_POST['number']);
    }

    if($valid){
        $sql="INSERT INTO students(name,email,number)
              VALUES(:name,:email,:number)";
        $stmt=$conn->prepare($sql);
        $stmt->execute([
            ':name'=>$name,
            ':email'=>$email,
            ':number'=>$number
        ]);

        header("Location: index.php");
        exit();
    }
}

// ===================== UPDATE =====================
if(isset($_POST['update'])){

    $sql="UPDATE students 
          SET name=:name, email=:email, number=:number 
          WHERE id=:id";

    $stmt=$conn->prepare($sql);
    $stmt->execute([
        ':name'=>$_POST['name'],
        ':email'=>$_POST['email'],
        ':number'=>$_POST['number'],
        ':id'=>$_POST['id']
    ]);

    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<style>
body{font-family:Arial;}
table{border-collapse:collapse;width:80%;}
td,th{border:1px solid black;padding:8px;text-align:center;}
th{background:black;color:white;}
.error{color:red;}
</style>
</head>
<body>

<h2>Student Form</h2>

<form method="post">

<input type="hidden" name="id" value="<?php echo $editData['id'] ?? ''; ?>">

Name:
<input type="text" name="name" value="<?php echo $editData['name'] ?? ''; ?>">
<span class="error"><?php echo $nameERR; ?></span>
<br><br>

Email:
<input type="text" name="email" value="<?php echo $editData['email'] ?? ''; ?>">
<span class="error"><?php echo $emailERR; ?></span>
<br><br>

Number:
<input type="text" name="number" value="<?php echo $editData['number'] ?? ''; ?>">
<span class="error"><?php echo $numberERR; ?></span>
<br><br>

<?php if(isset($editData)){ ?>
    <button type="submit" name="update">Update</button>
<?php } else { ?>
    <button type="submit" name="insert">Insert</button>
<?php } ?>

</form>

<hr>

<h2>Student Table (READ)</h2>

<table>
<tr>
<th>ID</th>
<th>Name</th>
<th>Email</th>
<th>Number</th>
<th>Action</th>
</tr>

<?php
$sql="SELECT * FROM students ORDER BY id DESC";
$result=$conn->query($sql);

foreach($result as $row){
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