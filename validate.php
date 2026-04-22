<?php
// ===== DB CONNECTION =====
$conn = new PDO("mysql:host=localhost;dbname=college_db", "root", "");
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// ===== INIT =====
$name = $email = "";
$nameErr = $emailErr = "";

// ===== DELETE (optional) =====
if (isset($_GET['delete'])) {
    $stmt = $conn->prepare("DELETE FROM students WHERE id = :id");
    $stmt->execute([':id' => $_GET['delete']]);
    header("Location: ".$_SERVER['PHP_SELF']); // avoid repeat
    exit();
}

// ===== FORM SUBMIT (INSERT) =====
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // VALIDATION
    if (empty($_POST["name"])) {
        $nameErr = "Name required";
    } else {
        $name = htmlspecialchars(trim($_POST["name"]));
    }

    if (empty($_POST["email"])) {
        $emailErr = "Email required";
    } elseif (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        $emailErr = "Invalid email";
    } else {
        $email = htmlspecialchars(trim($_POST["email"]));
    }

    // INSERT only if valid
    if ($nameErr == "" && $emailErr == "") {
        $sql = "INSERT INTO students (name, email)
                VALUES (:name, :email)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':name' => $name,
            ':email' => $email
        ]);

        // clear form + prevent resubmit
        header("Location: ".$_SERVER['PHP_SELF']);
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>PHP Form + PDO CRUD</title>
    <style>
        body { font-family: Arial; margin: 20px; }
        input { padding: 6px; margin: 5px; }
        .error { color: red; }
        table { border-collapse: collapse; width: 70%; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: center; }
        th { background: #333; color: #fff; }
        a { text-decoration: none; }
    </style>
</head>
<body>

<h2>Student Form</h2>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    Name:
    <input type="text" name="name" value="<?php echo $name; ?>">
    <span class="error"><?php echo $nameErr; ?></span>
    <br><br>

    Email:
    <input type="text" name="email" value="<?php echo $email; ?>">
    <span class="error"><?php echo $emailErr; ?></span>
    <br><br>

    <input type="submit" value="Insert">
</form>

<hr>

<h2>Student List (READ)</h2>

<table>
<tr>
    <th>ID</th>
    <th>Name</th>
    <th>Email</th>
    <th>Action</th>
</tr>

<?php
$result = $conn->query("SELECT id, name, email FROM students ORDER BY id DESC");

foreach ($result as $row) {
    echo "<tr>
            <td>{$row['id']}</td>
            <td>".htmlspecialchars($row['name'])."</td>
            <td>".htmlspecialchars($row['email'])."</td>
            <td>
                <a href='?delete={$row['id']}' onclick=\"return confirm('Delete?')\">Delete</a>
            </td>
          </tr>";
}
?>
</table>

</body>
</html>