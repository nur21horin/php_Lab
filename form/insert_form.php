<?php
include "connection.php";

try {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        if (isset($_POST["btn_form"])) {

            $name = $_POST['name'];
            $email = $_POST['email'];
            $number=$_POST['number'];

            $sql = "INSERT INTO students(name, email,number)
                    VALUES('$name', '$email','$number')";

            $conn->exec($sql);

            echo "Form data inserted!";
        }
    }
} catch (PDOException $e) {
    echo "Form Insertion failed: " . $e->getMessage();
}
?>