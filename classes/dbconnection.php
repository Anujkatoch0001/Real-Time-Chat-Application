<?php
class Database
{

    private $servername = 'localhost';
    private $username = 'root';
    private $password = "";
    private $dbname = 'mybook_db';



    function connect()
    {
        $connection = mysqli_connect($this->servername, $this->username, $this->password, $this->dbname);
        return $connection;
    }





    function read($query)
    {
        $conn = $this->connect();
        $result = mysqli_query($conn,$query);

        if(!$result){
            return false;
        }
        else{
            $data = [];
            while($row = mysqli_fetch_assoc($result))
            {
                $data[] =  $row;
            }
            return $data;
        }
    }




    function save($query)
    {
        $conn = $this->connect();
        $result = mysqli_query($conn,$query);
        if(!$result){
            return false;
        }
        else{
            return true;
        }
        
    }
}



