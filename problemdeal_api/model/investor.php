<?php

class Invester{

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
            $qry = mysqli_query($this->conn, "SELECT * FROM investor ORDER BY id DESC LIMIT $sp,10 ;");
        }

        if(isset($data['all'])){
            $qry = mysqli_query($this->conn, "SELECT * FROM investor ORDER BY id DESC");

        }

        if(isset($data['sp']) && isset($data['all'])){
            $sp = $data['sp'];
            $qry = mysqli_query($this->conn, "SELECT * FROM investor ORDER BY id DESC LIMIT $sp,1000");

        }

        return mysqli_fetch_all($qry,1);

    }
}

?>