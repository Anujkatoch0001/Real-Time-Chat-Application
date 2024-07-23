<?php
    session_start();

    include("classes/dbconnection.php");
    include("classes/login.php");

        $email = "";
        $password = "";


    if($_SERVER['REQUEST_METHOD']=='POST')
     {
        $login = new Login();
        $result = $login->evaluate($_POST);

        if($result!= ""){

            echo "<div style='text-align:center;font-size:12px;color:white;background-color:gray;'>";
            echo "<br> The following errors occured<br>";
            echo $result;
            echo "</div>";
        }

        else{
            header("Location: profile.php");
            die;

        }

        $email = $_POST['email'];
        $password = $_POST['password'];
    } 

        
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <div  id="bar">
    <div style="font-size:40px;">MYbook</div>
    <div id="signup_button">Signup</div> 
    </div>

    <div id="card">
        <form  method="post">
        Log in to Mybook<br><br>
        <input name="email" value="<?php echo $email?>" type="text" name="" id="text" placeholder="Email"><br><br>
        <input name="password" value="<?php echo $password?>" type="password" name="" id ="text" placeholder="password"><br><br>
        <input type="submit" name="" value="Login" id="button">
        <br><br><br>
        </form>
    </div>
</body>
</html>