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
    <?php 
     $nama="";
    $nameERR= "";
    $email=$emailERR="";
    $number=$numberERR="";
    ?>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        Name: <input type="text" name="name"><br><br>
        <span class="error"><?php echo $nameERR; ?></span><br><br>
        EMail:<input type="email" name="email"><br>
        <span class="error"><?php echo $emailERR;?></span><br><br>
        <br>
        Number: <input type="number" name="number"><br><br>
        <span class="error"><?php echo $numberERR; ?></span><br><br>
        <input id="button" class="button1" type="submit"><br><br>
    </form>

    <?php 
    function test_data($data){
        $data=trim($data);
        $data=stripslashes($data);
        $data=htmlspecialchars($data);
        return $data;
    }
   

    if($_SERVER["REQUEST_METHOD"]=="POST"){

    if(empty($_POST["name"])){
        $nameERR="Name is required";
       
    }else{
        $name=test_data($_POST["name"]);
    }

    if(empty($_POST["email"])){
        $emailERR="Email is required";
    }else{
         $email=test_data($_POST["email"]);
    }

    if(empty($_POST["number"])){
        $numberERR="Number is required";
    }else{
         $number=test_data($_POST["number"]);
    
    } 
    echo "Name: ".$name."<br>";
    echo "Email: ".$email."<br>";
    echo "Number: ".$number."<br>";
    }
    ?>

</body>
</html>