<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        #button{
            background-color: black;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .button1:hover{
            background-color: white;
            color: black;
            border: 1px solid black;
        }
        </style>
</head>
<body>
    <form action="" method="post">
        Name: <input type="text" name="name"><br><br>
        EMail:<input type="email" name="email"><br>
        <br>
        Number: <input type="number" name="number"><br><br>
        <input id="button" class="button1" type="submit">
    </form>

    <?php 
    echo "Name:".$_POST['name'];
    echo "<br>";
    echo "Email:" .$_POST['email'];
    echo '<br>';
    echo "Number:".$_POST['number'];
    ?>

</body>
</html>