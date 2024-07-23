



<div id="post">
    <div>

        <?php

        $image =  "social_images/user_male.jpg";
        if($ROW_USER['gender'] == "Female")
        {
            $image = "social_images/user_female.jpg";
        }
       
        if(file_exists($ROW_USER['profile_image']))
        {
            $image = $image_class->get_thumb_profile($ROW_USER['profile_image']); 
        }

        


    ?>
        <img src="<?php echo $image ?>" style="width:75px; margin-right:4px; border-radius:50%;">
    </div>
    < style="width:100%;">
        <div style="font-weight:bold; color:#405d9b"><?php echo htmlspecialchars($ROW_USER['first_name']) . " ". htmlspecialchars($ROW_USER['last_name']);
    
        if($ROW['is_profile_image'])
        {
            $pronoun = "his";
            if($ROW_USER['gender']== "Female")
            {
                $pronoun = "her";
            }
            echo "<span style='font-weight:normal;color:#aaa;'> updated $pronoun profile image</span>";
        }

        if($ROW['is_cover_image'])
        {
            $pronoun = "his";
            if($ROW_USER['gender']== "Female")
            {
                $pronoun = "her";
            }
            echo "<span style='font-weight:normal;color:#aaa;'> updated $pronoun cover image</span>";
        }
         
        ?>
        </div>
    <?php echo htmlspecialchars($ROW['post'])?>
    <br><br>
    <?php 
            if(file_exists($ROW['image']))
            {
                $post_image = $image_class->get_thumb_post($ROW['image']);
                echo "<img src = '$post_image' style='width:80%;'/>";
            }
    ?>
    

        <br><br>
        <?php
        $likes = "";

        $likes = ($ROW['likes'] > 0) ? "(" . $ROW['likes']. ")": "" ;
       
        ?>

        <a href="like.php?type=post&id=<?php echo $ROW['postid']?>"> Like<?php echo  $likes ?></a> . <a href="">Comment</a> . 
        <span style="color:#999;">
            <?php echo $ROW['date']?>
        </span>
        
        <span style="color:#999; float:right">
            <?php
            
            $post = new Post();
            
            if($post->i_own_post($ROW['postid'],$_SESSION['mybook_userid'])){

            
            echo
           "<a href='edit.php'>
           Edit
           </a>  .
           <a href='delete.php?id= $ROW [postid]'' >
           Delete
           </a>" ;
            }
           ?>
           </span>

             <?php  

           if($ROW['likes'] > 0){
            echo "<br>";
            echo "<div style= 'text-align:left;'>". $ROW['likes'] . "people liked this post </div>";
           }

           ?> 
          
        
    


    </div>
</div>