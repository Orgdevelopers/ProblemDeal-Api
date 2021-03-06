<?php

class investor{

    public function create($data)
    {
        if(!$this->conn){
            return false;
        }

        $user_id = $data['user_id'];
        $name = $data['name'];
        $cat = $data['category'];
        $icon = $data['icon'];
        $description = $data['description'];
        $equity = $data['equity'];
        $status = $data['status'];
        $extra = $data['extra'];
        $updated = $data['updated'];
        $created = $data['created'];

        $qry = "INSERT INTO `investor` (`id`, `user_id`, `name`, `category`, `icon`, `description`, `equity`, `status`, `extra`, `updated`, `created`)
                                VALUES ('0', '$user_id', '$name', '$cat', '$icon', '$description', '$equity', '$status', '$extra', '$updated', '$created');";

        if($this->conn->query($qry)){
            return true;
        }else{
            return false;
        }

    }

    public function countbyid($id)
    {
        if(!$this->conn){
            return false;
        }

        $qry = mysqli_query($this->conn, "SELECT COUNT(*) FROM investor WHERE user_id='$id'");

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
            $qry = mysqli_query($this->conn, "SELECT investor.*,
            investor.category AS category_id,
            users.username,
            category.name AS category_name,
            category.icon AS category_icon
            FROM
            investor, users, category
            WHERE investor.user_id = users.id
            AND investor.category = category.id ORDER BY id DESC LIMIT $sp,10 ;");
        }

        if(isset($data['all'])){
            $qry = mysqli_query($this->conn, "SELECT investor.*,
            investor.category AS category_id,
            users.username,
            category.name AS category_name,
            category.icon AS category_icon
            FROM
            investor, users, category
            WHERE investor.user_id = users.id
            AND investor.category = category.id ORDER BY id DESC");

        }

        if(isset($data['sp']) && isset($data['all'])){
            $sp = $data['sp'];
            $qry = mysqli_query($this->conn, "SELECT investor.*,
            investor.category AS category_id,
            users.username,
            category.name AS category_name,
            category.icon AS category_icon
            FROM
            investor, users, category
            WHERE investor.user_id = users.id
            AND investor.category = category.id ORDER BY id DESC LIMIT $sp,1000");

        }
        return mysqli_fetch_all($qry,1);

        
    }

    public function getallbyuserid($data)
    {
        if(!$this->conn && !isset($data['user_id'])){
            return false;
        }

        $id = $data['user_id'];

        if(isset($data['sp'])){
            $sp = $data['sp'];
            $qry = mysqli_query($this->conn, "SELECT investor.*,
            investor.category AS category_id,
            users.username,
            category.name AS category_name,
            category.icon AS category_icon
            FROM
            investor, users, category
            WHERE investor.user_id = '$id'
            AND investor.user_id = users.id
            AND investor.category = category.id ORDER BY id DESC LIMIT $sp,10 ;");
        }

        if(isset($data['all'])){
            $qry = mysqli_query($this->conn, "SELECT investor.*,
            investor.category AS category_id,
            users.username,
            category.name AS category_name,
            category.icon AS category_icon
            FROM
            investor, users, category
            WHERE investor.user_id = '$id'
            AND investor.user_id = users.id
            AND investor.category = category.id ORDER BY id DESC");

        }

        if(isset($data['sp']) && isset($data['all'])){
            $sp = $data['sp'];
            $qry = mysqli_query($this->conn, "SELECT investor.*,
            investor.category AS category_id,
            users.username,
            category.name AS category_name,
            category.icon AS category_icon
            FROM
            investor, users, category
            WHERE investor.user_id = '$id'
            AND investor.user_id = users.id
            AND investor.category = category.id ORDER BY id DESC LIMIT $sp,1000");

        }
        return mysqli_fetch_all($qry,1);

        
    }

    public function getdetails($data){
        if(!$this->conn){
            return false;
        }

        $id = $data['id'];

        $qry = mysqli_query($this->conn,"SELECT investor.*,
        investor.category AS category_id,
        users.username,
        category.name AS category_name,
        category.icon AS category_icon
        FROM
        investor, users, category
        WHERE investor.user_id = users.id
        AND investor.category = category.id
        AND investor.id = '$id' ;");

        $details = mysqli_fetch_array($qry,1);

        if($details){
            return $details;
        }else{
            return false;
        }

    }

    public function delete($id)
    {
        if(!$this->conn){
            return false;
        }

        $qry = "DELETE FROM investor WHERE id='$id'";

        if($this->conn->query($qry)){
            return true;
        }else{
            return false;
        }

    }

}

?>