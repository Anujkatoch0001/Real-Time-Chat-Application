<?php
class Post
{
    private $error = "";

    public function create_post($userid, $data, $files)
    {
        if (!empty($data['post']) || !empty($files['file']['name']) || isset($data['is_profile_image']) || isset($data['is_cover_image'])) {
            $myimage = "";
            $has_image = 0;
            $is_cover_image = 0;
            $is_profile_image = 0;

            if (isset($data['is_profile_image']) || isset($data['is_cover_image'])) {
                $myimage = $files['file']['name'];
                $has_image = 1;
                $is_cover_image = isset($data['is_cover_image']) ? 1 : 0;
                $is_profile_image = isset($data['is_profile_image']) ? 1 : 0;
            } else {
                if (!empty($files['file']['name'])) {
                    $folder = "uploads/" . $userid . "/";
                    // Create folder
                    if (!file_exists($folder)) {
                        mkdir($folder, 0777, true);
                        file_put_contents($folder . "index.php", "");
                    }

                    $image_class = new Image();
                    $myimage = $folder . $image_class->generate_filename(15) . ".jpg";
                    move_uploaded_file($files['file']['tmp_name'], $myimage);
                    $image_class->resize_image($myimage, $myimage, 1500, 1500);
                    $has_image = 1;
                }
            }

            $post = isset($data['post']) ? addslashes($data['post']) : "";
            $postid = $this->create_postid();
            $query = "INSERT INTO posts (userid, postid, post, image, has_image, is_profile_image, is_cover_image) VALUES ('$userid', '$postid', '$post', '$myimage', '$has_image', '$is_profile_image', '$is_cover_image')";
            $DB = new Database();
            $DB->save($query);
        } else {
            $this->error = "Please type something to post!<br>";
        }
        return $this->error;
    }

    public function get_posts($id)
    {
        $query = "SELECT * FROM posts WHERE userid = '$id' ORDER BY id DESC LIMIT 10";
        $DB = new Database();
        $result = $DB->read($query);

        return $result ? $result : false;
    }

    public function get_one_post($postid)
    {
        if (!is_numeric($postid)) {
            return false;
        }
        $query = "SELECT * FROM posts WHERE postid = '$postid' LIMIT 1";
        $DB = new Database();
        $result = $DB->read($query);

        return $result ? $result[0] : false;
    }

    public function delete_post($postid)
    {
        if (!is_numeric($postid)) {
            return false;
        }
        $query = "DELETE FROM posts WHERE postid = '$postid' LIMIT 1";
        $DB = new Database();
        $DB->save($query);
    }

    public function i_own_post($postid, $mybook_userid)
    {
        if (!is_numeric($postid)) {
            return false;
        }
        $query = "SELECT * FROM posts WHERE postid = '$postid' LIMIT 1";
        $DB = new Database();
        $result = $DB->read($query);

        if (is_array($result) && $result[0]['userid'] == $mybook_userid) {
            return true;
        }
        return false;
    }

    public function like_post($id, $type, $mybook_userid)
    {
        if ($type == "post") {
            $DB = new Database();
            // Save like details
            $sql = "SELECT likes FROM likes WHERE type = 'post' AND contentid = '$id' LIMIT 1";
            $result = $DB->read($sql);
            if (is_array($result)) {
                $likes = json_decode($result[0]['likes'], true);
                $user_ids = array_column($likes, "user_id");

                if (!in_array($mybook_userid, $user_ids)) {
                    $arr["user_id"] = $mybook_userid;
                    $arr["date"] = date("Y-m-d H:i:s");
                    $likes[] = $arr;
                    $likes_string = json_encode($likes);
                    $sql = "UPDATE likes SET likes = '$likes_string' WHERE type = 'post' AND contentid = '$id' LIMIT 1";
                    $DB->save($sql);
                    // Increment the posts table
                    $sql = "UPDATE posts SET likes = likes + 1 WHERE postid = '$id' LIMIT 1";
                    $DB->save($sql);
                } else {
                    $key = array_search($mybook_userid, $user_ids);
                    unset($likes[$key]);
                    $likes_string = json_encode($likes);
                    $sql = "UPDATE likes SET likes = '$likes_string' WHERE type = 'post' AND contentid = '$id' LIMIT 1";
                    $DB->save($sql);
                    // Decrement the posts table
                    $sql = "UPDATE posts SET likes = likes - 1 WHERE postid = '$id' LIMIT 1";
                    $DB->save($sql);
                }
            } else {
                $arr["user_id"] = $mybook_userid;
                $arr["date"] = date("Y-m-d H:i:s");
                $arr2[] = $arr;
                $likes = json_encode($arr2);
                $sql = "INSERT INTO likes (type, contentid, likes) VALUES ('$type', '$id', '$likes')";
                $DB->save($sql);
                // Increment the posts table
                $sql = "UPDATE posts SET likes = likes + 1 WHERE postid = '$id' LIMIT 1";
                $DB->save($sql);
            }
        }
    }

    private function create_postid()
    {
        $length = rand(4, 19);
        $number = "";
        for ($i = 1; $i <= $length; $i++) {
            $number .= rand(0, 9);
        }
        return $number;
    }
}
?>
