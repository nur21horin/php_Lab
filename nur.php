<?php
// DB CONNECTION
$conn = new PDO("mysql:host=localhost;dbname=college_db","root","");
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// INSERT
if(isset($_POST['insert'])){
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $course = htmlspecialchars($_POST['course']);

    $stmt = $conn->prepare("INSERT INTO students(name,email,course)
                            VALUES(:name,:email,:course)");
    $stmt->execute([
        ':name'=>$name,
        ':email'=>$email,
        ':course'=>$course
    ]);
}

// DELETE
if(isset($_GET['delete'])){
    $stmt = $conn->prepare("DELETE FROM students WHERE id=:id");
    $stmt->execute([':id'=>$_GET['delete']]);
}
?>

<!DOCTYPE html>
<html>
<head>
<title>CRUD + JS DOM</title>
<style>
body{font-family:Arial;}
.error{color:red;}
table{border-collapse:collapse;}
td,th{border:1px solid black;padding:8px;}
</style>
</head>
<body>

<h2>Student Form</h2>

<form method="post" id="form">
Name: <input type="text" id="name" name="name">
<span id="nameErr" class="error"></span><br><br>

Email: <input type="text" id="email" name="email">
<span id="emailErr" class="error"></span><br><br>

Course: <input type="text" id="course" name="course">
<span id="courseErr" class="error"></span><br><br>

<button type="submit" name="insert">Submit</button>
</form>

<hr>

<h2>Student Table</h2>

<table>
<tr>
<th>ID</th><th>Name</th><th>Email</th><th>Course</th><th>Action</th>
</tr>

<?php
$result = $conn->query("SELECT * FROM students");

foreach($result as $row){
    echo "<tr>
        <td>{$row['id']}</td>
        <td>{$row['name']}</td>
        <td>{$row['email']}</td>
        <td>{$row['course']}</td>
        <td><a href='?delete={$row['id']}'>Delete</a></td>
    </tr>";
}
?>
</table>

<script>
// JS DOM VALIDATION (MAIN FOCUS)
document.getElementById("form").addEventListener("submit", function(e){

    let name = document.getElementById("name").value.trim();
    let email = document.getElementById("email").value.trim();
    let course = document.getElementById("course").value.trim();

    let valid = true;

    // reset errors
    document.getElementById("nameErr").innerText = "";
    document.getElementById("emailErr").innerText = "";
    document.getElementById("courseErr").innerText = "";

    if(name === ""){
        document.getElementById("nameErr").innerText = "Name required";
        valid = false;
    }

    if(email === ""){
        document.getElementById("emailErr").innerText = "Email required";
        valid = false;
    }

    if(course === ""){
        document.getElementById("courseErr").innerText = "Course required";
        valid = false;
    }

    if(!valid){
        e.preventDefault(); // stop form submit
    }
});
</script>

</body>
</html>