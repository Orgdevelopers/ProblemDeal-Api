<?php

class Idea{

    public function countbyid($id)
    {
        if(!$this->conn){
            return false;
        }

        $qry = mysqli_query($this->conn, "SELECT COUNT(*) FROM ideas WHERE user_id='$id'");

        $result = mysqli_fetch_array($qry,2);

        return $result;

    }

    public function getall($data)
    {
        if(!$this->conn){
            return false;
        }

        if(isset($data['sp'])){
            $sp = $data['sp'];
            $qry = mysqli_query($this->conn, "SELECT ideas.*,
            ideas.category AS category_id,
            users.username,
            category.name AS category_name,
            category.icon AS category_icon
            FROM
            ideas, users, category
            WHERE ideas.user_id = users.id
            AND ideas.category = category.id ORDER BY id DESC LIMIT $sp,10 ;");
        }

        if(isset($data['all'])){
            $qry = mysqli_query($this->conn, "SELECT ideas.*,
            ideas.category AS category_id,
            users.username,
            category.name AS category_name,
            category.icon AS category_icon
            FROM
            ideas, users, category
            WHERE ideas.user_id = users.id
            AND ideas.category = category.id ORDER BY id DESC");

        }

        if(isset($data['sp']) && isset($data['all'])){
            $sp = $data['sp'];
            $qry = mysqli_query($this->conn, "SELECT ideas.*,
            ideas.category AS category_id,
            users.username,
            category.name AS category_name,
            category.icon AS category_icon
            FROM
            ideas, users, category
            WHERE ideas.user_id = users.id
            AND ideas.category = category.id ORDER BY id DESC LIMIT $sp,1000");

        }

        return mysqli_fetch_all($qry,1);

    }

    public function getdetails($data)
    {
        if(!$this->conn && isset($data['id'])){

            $id = $data['id'];
            $qry = mysqli_query($this->conn, "SELECT ideas.*,
            ideas.category AS category_id,
            users.username,
            category.name AS category_name,
            category.icon AS category_icon
            FROM
            ideas, users, category
            WHERE ideas.user_id = users.id
            AND ideas.category = category.id AND ideas.id='$id';");

            $details = mysqli_fetch_array($qry,1);

            if($details){
                return $details;
            }else{
                $this->error = $this->conn->error;
                return false;
            }

        }else{
            $this->error = "incomplete data";
            return false;
        }

    }
    

}

?>