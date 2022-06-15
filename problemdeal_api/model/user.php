<?php

class User{
    
    public function getAll()
    {
        if(!$this->conn){
            return false;
        }
        $stmt = mysqli_query($this->conn,"SELECT * FROM users");
        				
        $result = mysqli_fetch_all($stmt,1);	
        return $result;	
    }

    public function getdetails($data)
    {
        if(! $this->conn && $data==null){
            return false;
        }

        if(isset($data['gmail'])){
            $gmail = $data['gmail'];
            $stmt = mysqli_query($this->conn,"SELECT  *, (SELECT COUNT(*) FROM business WHERE business.user_id = users.id) AS 'business',
            (SELECT COUNT(*) FROM ideas WHERE ideas.user_id = users.id) AS 'ideas',
            (SELECT COUNT(*) FROM investor WHERE investor.user_id = users.id) AS 'investor'
            FROM users WHERE users.email='$gmail'");

        }else if(isset($data['id'])){
            $id = $data['id'];
            $stmt = mysqli_query($this->conn,"SELECT  *, (SELECT COUNT(*) FROM business WHERE business.user_id = users.id) AS 'business',
            (SELECT COUNT(*) FROM ideas WHERE ideas.user_id = users.id) AS 'ideas',
            (SELECT COUNT(*) FROM investor WHERE investor.user_id = users.id) AS 'investor'
            FROM users WHERE users.id ='$id'");

        }else if(isset($data['email'])){
            $email = $data['email'];
            $stmt = mysqli_query($this->conn,"SELECT  *, (SELECT COUNT(*) FROM business WHERE business.user_id = users.id) AS 'business',
            (SELECT COUNT(*) FROM ideas WHERE ideas.user_id = users.id) AS 'ideas',
            (SELECT COUNT(*) FROM investor WHERE investor.user_id = users.id) AS 'investor'
            FROM users WHERE users.email='$email'");

        }else if(isset($data['username'])){
            $username = $data['username'];
            $stmt = mysqli_query($this->conn,"SELECT  *, (SELECT COUNT(*) FROM business WHERE business.user_id = users.id) AS 'business',
            (SELECT COUNT(*) FROM ideas WHERE ideas.user_id = users.id) AS 'ideas',
            (SELECT COUNT(*) FROM investor WHERE investor.user_id = users.id) AS 'investor'
            FROM users WHERE users.username='$username'");

        }else{
            return false;
        }

        $result = mysqli_fetch_array($stmt,1);
        return $result;	

    }

    public function checksignupdata($data)
    {
        if(!$this->conn){
            $this->errorcode = '101';
            return false;
        }

        $username = $data['username'];
        $email = $data['email'];

        $username_check = mysqli_fetch_array(mysqli_query($this->conn, "SELECT * FROM users WHERE username='$username'"));

        if($username_check){
            $this->errorcode = '111';
            return false;
        }

        $email_check = mysqli_fetch_array(mysqli_query($this->conn, "SELECT * FROM users WHERE email='$email' "));

        if($email_check){
            // if($email_check['signin_type']=='2'){
            //     $this->errorcode = '113';
            // }else{
            //     $this->errorcode = '112';
            // }
            $this->errorcode = '112';
            return false;
        }

        return true;

    }

    public function create($data)
    {
        if(!$this->conn){
            return false;
        }

        $email = $data['email'];
        $username = $data['username'];
        $name =$data['name'];
        $password = encrypt_password($data['password']);

        $date = gmdate("Y-m-d H:i:s");

        $qry = "INSERT INTO users(id,name,username,email,password,pic,bio,verified,role,signin_type,updated,created)
                    VALUES('0', '$name', '$username', '$email', '$password', '','','1','user','1', '$date', '$date')";

        if($this->conn->query($qry)){
            return true;

        }else{
            return false;

        }         

    }

    public function update($data){

        if(!$this->conn && $data==null && !isset($data['id'])){
            return false;
        }
        $id = $data['id'];
        
        $current_user = mysqli_fetch_array(mysqli_query($this->conn,"SELECT * FROM users WHERE id='$id'"),1);
        if(!$current_user){
            return false;
        }

        $name=""; $username=""; $email=""; $password=""; $pic=""; $bio = ""; $verified=""; $role=""; $signin_type=""; 

        if(isset($data['name'])){$name = $data['name'];}else{$name = $current_user['name'];}
        if(isset($data['username'])){$username = $data['username'];}else{$username = $current_user['username'];}
        if(isset($data['email'])){$email = $data['email'];}else{$email = $current_user['email'];}
        if(isset($data['password'])){$password = $data['password'];}else{$password = $current_user['password'];}
        if(isset($data['pic'])){$pic = $data['pic'];}else{$pic = $current_user['pic'];}
        if(isset($data['bio'])){$bio = $data['bio'];}else{$bio = $current_user['bio'];}
        if(isset($data['verified'])){$verified = $data['verified'];}else{$verified = $current_user['verified'];}
        if(isset($data['role'])){$role = $data['role'];}else{$role = $current_user['role'];}
        if(isset($data['signin_type'])){$signin_type = $data['signin_type'];}else{$signin_type = $current_user['signin_type'];}
        if(isset($data['token'])){$token=$data['token'];}else{$token=$current_user['token'];}

        $stmt = "UPDATE users SET name='$name', username='$username', email='$email', password='$password', pic='$pic', bio='$bio', 
        verified='$verified', role='$role', token='$token', signin_type='$signin_type' WHERE id=$id";

        if($this->conn->query($stmt)){
            return true;

        }else{
            return false;

        }
        
    }


    public function creategmail($data)
    {
        if(!$this->conn){
            return false;
        }

        $email = $data['gmail'];
        $username = $data['username'];
        $name =$data['name'];
        $password = encrypt_password($data['password']);

        $date = gmdate("Y-m-d H:i:s");

        $qry = "INSERT INTO users(id,name,username,email,password,pic,bio,verified,role,signin_type,updated,created)
                    VALUES('0', '$name', '$username', '$email', '$password', '','','1','user','1', '$date', '$date')";

        if($this->conn->query($qry)){
            return true;

        }else{
            return false;

        }
    }

    
    public function deleteUser($id)
    {
        if(!$this->conn && $id!=null){
            return false;
        }

        $stmt = "DELETE FROM users WHERE id=$id";

        if($this->conn->query($stmt)){
            $output['code']='200';
            $output['msg']='user deleted';

        }else{
            $output['code']='101';
            $output['msg']='failed error:- '.$this->conn->error;

        }

        return $output;
    

    }

    public function email_signup($data)
    {
        if(!$this->conn){
            return false;
        }

        $name = $data['name'];
        $username = $data['username'];
        $email = $data['email'];
        $password = encrypt_password($data['password']);

        $current_user=mysqli_fetch_array(mysqli_query($this->conn,"SELECT * FROM users WHERE username=$username"));

        if($current_user && isset($current_user['username']) && $current_user['username']==$username){
            $output['code']='201';
            $output['msg']='username already exists';

        }else if($current_user && isset($current_user['email']) && $current_user['email']==$email){
            $output['code']="202";
            $output['msg']="email already exitst";
        }
        else{
          $stmt = "INSERT INTO users(id, name, username, email, password, pic, bio, verified, role, signin_type)
         VALUES ('0','$name','$username','$email','$password','','','0','user','email') ";

        if($this->conn->query($stmt)){
            $output['code']='200';
            $output['msg']='user created successfully';

        }else{
            $output['code']='101';
            $output['msg']='failed error:- '.$this->conn->error;

        }  
        }

        return $output;

    }
    
    function checkusername($username)
    {
        if(!$this->conn){
            return false;
        }
        
        $stmt = mysqli_query($this->conn,"SELECT * FROM users WHERE username='$username'");

        $result = mysqli_fetch_array($stmt,1);
        
        if($result){

            return false;

        }else{
            return true;
        }

    }

    public function showdetailsbyusername($username){
        if(!$this->conn && $username==null){
            return false;
        }

        $stmt = mysqli_query($this->conn,"SELECT * FROM users WHERE username = $username");
        $result = mysqli_fetch_array($stmt,1);
        return $result;	

    }

    public function showdetailsbyemail($email){
        if(!$this->conn && $email==null){
            return false;
        }

        $stmt = mysqli_query($this->conn,"SELECT * FROM users WHERE email = $email");
        $result = mysqli_fetch_array($stmt,1);
        return $result;	

    }


}

?>