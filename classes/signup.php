<?php
    

    class Signup
    {
        private $error = "";

        public function evaluate($data)
        {
            foreach ($data as $key => $value){
                if(empty($value))
                {
                    $this->error  = $this->error . $key . "is empty!<br> ";
                }
                
                if($key == "email")
                {
                    if(!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/",$value)){
                        $this->error = $this->error . "Invalid email address!<br>";
                    }
                }

                if($key == "first_name")
                {
                    if(is_numeric($value))
                     {
                        $this->error = $this->error . "first name can't be a number<br>";
                    }
                    if(strstr($value," "))
                    {
                        $this->error = $this->error . "first name can't have space<br>";
                    }
                }

                if($key == "last_name")
                {
                    if(is_numeric($value)){
                        $this->error = $this->error . "last name can't be a number<br>";
                    }
                    if(strstr($value," "))
                    {
                        $this->error = $this->error . "last name can't have space<br>";
                    }
                }


            }

            if($this->error == "")
            {
                //no error
                $this->create_user($data);
            }
            else{
                return $this->error;
            }
        }

        public function create_user($data)
        {
            $firstname = ucfirst($data['first_name']);
            $lastname = ucfirst($data['last_name']);
            $gender = $data['gender'];
            $email = $data['email'];
            $password = $data['password'];
            $url_address = strtolower($firstname) . "." . strtolower($lastname) ;
            $userid = $this->create_userid();

            $query = "INSERT INTO users
             (user_id,first_name,last_name,gender,email,password,url_address)
              values('$userid','$firstname','$lastname','$gender','$email','$password','$url_address')";
              
             $DB = new Database();
             $DB->save($query);
        }

        private function create_userid()
        {
            $length= rand(4,19);
            $number = "";
            for ($i=1; $i <$length ; $i++) { 
                $new_rand= rand(0,9);
                $number = $number.$new_rand;
            }
            return $number;
        }

       

    }


?>