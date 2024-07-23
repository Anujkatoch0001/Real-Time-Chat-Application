<?php 
    $image = "social_images/user_male.jpg";
    if($FRIEND_ROW['gender']=="Female")
    {
        $image = "social_images/user_female.jpg";
    }


    if(file_exists($FRIEND_ROW['profile_image']))
    {
        $image = $image_class->get_thumb_profile($FRIEND_ROW['profile_image']); 
    }
?>


<div id="friends">
    <a href="profile.php?id=<?php echo $FRIEND_ROW['user_id'];?>">
    <img id="friends_img" src="social_images/user1.jpg" alt="">
    <br>
    <?php echo $FRIEND_ROW['first_name']  ." " .  $FRIEND_ROW['last_name'];?>
</a>
</div>