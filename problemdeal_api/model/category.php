<?php

class Category {

    public function getAll()
    {
        if(!$this->conn){
            return false;
        }
        $qry = mysqli_query($this->conn,'SELECT * FROM category');

        $array = mysqli_fetch_all($qry,1);

        return $array;

    }

}

?>