<?php

    include("classes/dbconnection.php");
    include("classes/signup.php");

       $first_name = "";
        $last_name = "";
        $gender = "";
        $email = "";


    if($_SERVER['REQUEST_METHOD']=='POST')
     {
        $signup = new Signup();
        $result=$signup->evaluate($_POST);

        if($result!= ""){

            echo "<div style='text-align:center;font-size:12px;color:white;background-color:gray;'>";
            echo "<br> The following errors occured<br>";
            echo $result;
            echo "</div>";
        }

        else{
            header("Location: login.php");
            die;

        }


        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $gender = $_POST['gender'];
        $email = $_POST['email'];
    } 

        
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>signup</title>
    <link rel="stylesheet" href="signup.css">
</head>
<body>
    <div  id="bar">
    <div style="font-size:40px;">MYbook</div>
    <div id="signup_button">login</div> 
    </div>

    <div id="card">
        Sign up to Mybook<br><br>

        <form action="" method="post">
            
         <input value="<?php echo $first_name?>"  name="first_name" type="text"  id ="text" placeholder="First name"><br><br>
         <input value="<?php echo $last_name?>" name="last_name" type="text"  id ="text" placeholder="Lastname"><br><br>

         <span style="font-weight:normal;">Gender:</span><br>
         <select name="gender" id="text">

         <option> <?php echo $gender?> </option>
           <option>Male</option>
          <option>Female</option>
         </select>
         <br><br>

         <input value="<?php echo $email?>" name="email"     type="text"      id="text"  placeholder="Email"><br><br>

         <input  name ="password" type="password"  id ="text"  placeholder="password"><br><br>
         <input  name="password2" type="password"    id="text" placeholder="Retype password" ><br><br>

         <input type="submit" id="button" value="Sign up">
         <br><br><br>

        </form>
    </div>
</body>
</html>