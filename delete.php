<?php
include("classes/autoload.php");

$login = new Login();
$user_data = $login->check_login($_SESSION['mybook_userid']);

$Post = new POST();
$ERROR = "";
if (isset($_GET['id'])) {

    $ROW = $Post->get_one_post($_GET['id']);

    if (!$ROW) {
        $ERROR = "No such post was found!";
    } else {
        if ($ROW['userid'] != $_SESSION['mybook_userid']) {
            $ERROR = "Access denied";
        }
    }
} else {
    $ERROR = "No such post was found!";
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $Post->delete_Post($_POST['postid']);
    header("Location: profile.php");
    die;
}

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete | MYbook</title>
</head>
<style type="text/css">
    #blue_bar {
        height: 50px;
        background-color: #405d9b;
        color: #d9dfeb;
    }

    #search_box {
        width: 400px;
        height: 20px;
        border-radius: 5px;
        border: none;
        padding: 4px;
        font-size: 14px;
        background-image: url('social_images/search.png');
        background-repeat: no-repeat;
        background-position: right;
    }

    #profile_pic {
        width: 150px;
        border-radius: 50%;
        border: solid 2px white;
    }

    #menu-buttons {
        width: 100px;
        display: inline-block;
        margin: 2px;
    }

    #friends_img {
        width: 75px;
        float: left;
        margin: 8px;
    }

    #friends_bar {
        min-height: 400px;
        margin-top: 20px;
        padding: 8px;
        text-align: center;
        font-size: 20px;
        color: #405d9b;
    }

    #friends {
        clear: both;
        font-size: 12px;
        font-weight: bold;
        color: #405d9b;
    }

    textarea {
        width: 100%;
        border: none;
        font-family: tahoma;
        font-size: 14px;
        height: 60px;
    }

    #post_button {
        float: right;
        background-color: #405d9b;
        border: none;
        color: white;
        padding: 4px;
        font-size: 14px;
        border-radius: 2px;
        width: 50px;
    }

    #post_bar {
        margin-top: 20px;
        background-color: white;
        padding: 10px;
    }

    #post {
        padding: 4px;
        font-size: 13px;
        display: flex;
        margin-bottom: 20px;
    }
</style>

<body style="font-family:tahoma; background-color: #d0d8e4;">
    <br>
    <!--  top bar -->
    <?php include("header.php");
    ?>

    <!--cover area  -->

    <div style="width:800px; margin: auto; min-height: 400px;">


        <!-- below cover area -->
        <div style="display:flex;">

            <!-- post area -->
            <div style="min-height:400px; flex:2.5; padding:20px;padding-right:0px;">
                <div style="border:solid thin #aaa; padding:10px;background-color:white;">


                    <form method="post">


                        <?php
                        if ($ERROR != "") {
                            echo $ERROR;
                        } else {
                            echo "Are you sure want to delete this post??<br><br>";
                            $user = new User();
                            $ROW_USER = $user->get_user($ROW['userid']);
                            include("post_delete.php");
                            echo  "<input type='hidden' name='postid' value=' $ROW[postid]'>";
                            echo  "<input type='submit' id='post_button' value='Delete'>";
                        }
                        ?>


                        <br>
                    </form>
                </div>


            </div>
        </div>
    </div>
</body>

</html>