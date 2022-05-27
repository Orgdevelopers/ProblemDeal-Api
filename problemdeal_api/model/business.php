<?php

class Business{

    public function countbyid($id)
    {
        if(!$this->conn){
            return false;
        }

        $qry = mysqli_query($this->conn, "SELECT COUNT(*) FROM business WHERE user_id='$id'");

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
            $qry = mysqli_query($this->conn, "SELECT business.*,
                                business.category AS category_id,
                                users.username,
                                category.name AS category_name,
                                category.icon AS category_icon
                                FROM
                                business, users, category
                                WHERE business.user_id = users.id
                                AND business.category = category.id
                                ORDER BY id DESC LIMIT $sp,10 ;
                                    ");
        }

        if(isset($data['all'])){
            $qry = mysqli_query($this->conn, "SELECT business.*,
                                business.category AS category_id,
                                users.username,
                                category.name AS category_name,
                                category.icon AS category_icon
                                FROM
                                business, users, category
                                WHERE business.user_id = users.id
                                AND business.category = category.id ORDER BY id DESC ; 
                                " );

        }

        if(isset($data['sp']) && isset($data['all'])){
            $sp = $data['sp'];
            $qry = mysqli_query($this->conn, "SELECT business.*,
            business.category AS category_id,
            users.username,
            category.name AS category_name,
            category.icon AS category_icon
        FROM
        business, users, category
        WHERE business.user_id = users.id
        AND business.category = category.id ORDER BY id DESC LIMIT $sp,1000");

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
            $qry = mysqli_query($this->conn, "SELECT business.*,
                                business.category AS category_id,
                                users.username,
                                category.name AS category_name,
                                category.icon AS category_icon
                                FROM
                                business, users, category
                                WHERE business.user_id = '$id'
                                AND business.user_id = users.id
                                AND business.category = category.id
                                ORDER BY id DESC LIMIT $sp,10 ;
                                    ");
        }

        if(isset($data['all'])){
            $qry = mysqli_query($this->conn, "SELECT business.*,
                                business.category AS category_id,
                                users.username,
                                category.name AS category_name,
                                category.icon AS category_icon
                                FROM
                                business, users, category
                                WHERE business.user_id = '$id'
                                AND business.user_id = users.id
                                AND business.category = category.id ORDER BY id DESC ; 
                                " );

        }

        if(isset($data['sp']) && isset($data['all'])){
            $sp = $data['sp'];
            $qry = mysqli_query($this->conn, "SELECT business.*,
            business.category AS category_id,
            users.username,
            category.name AS category_name,
            category.icon AS category_icon
        FROM
        business, users, category
        WHERE business.user_id = '$id'
        AND business.user_id = users.id
        AND business.category = category.id ORDER BY id DESC LIMIT $sp,1000");

        }

        return mysqli_fetch_all($qry,1);

    }

    public function getdetails($data)
    {
        if($this->conn && isset($data['id'])){

            $id = $data['id'];
            $qry = mysqli_query($this->conn, "SELECT business.*,
            business.category AS category_id,
            users.username,
            category.name AS category_name,
            category.icon AS category_icon
            FROM
            business, users, category
            WHERE business.user_id = users.id
            AND business.category = category.id AND business.id='$id';");

            $details = mysqli_fetch_array($qry,1);

            return $details;

        }else{
            return false;
        }

    }

    public function create($create_data)
    {
        if(!$this->conn){
            return false;
        }

        $user_id = $create_data['user_id'];
        $name = $create_data['name'];
        $cat = $create_data['category'];
        $icon = $create_data['icon'];
        $desc = $create_data['description'];
        $equity = $create_data['equity'];
        $status = $create_data['status']; 
        $extra = $create_data['extra'];  
        $updated = $create_data['updated'];   
        $created = $create_data['created'];    

        $qry = "INSERT INTO 
        `business`(`id`, `user_id`, `name`, `category`, `icon`, `description`, `equity`, `status`, `extra`, `updated`, `created`)
         VALUES ('0','$user_id','$name','$cat','$icon','$desc','$equity','1','n','$updated','$created')";

        if($this->conn->query($qry)){
            $this->InsertId = $this->conn->insert_id;
            return true;
        }else{
            return false;
        }
        
    }
    
}

?>