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

    public function showinfoById($id){	
        if(! $this->conn){
            return false;
        }
        $stmt = mysqli_query($this->conn,"SELECT * FROM users WHERE id=$id");
        $result = mysqli_fetch_array($stmt,1);
        return $result;	
    }

    public function updateUser($data){

        if(!$this->conn && $data==null && !isset($data['id'])){
            return false;
        }
        $id = $data['id'];
        
        $current_user = mysqli_fetch_array(mysqli_query($this->conn,"SELECT * FROM users WHERE id=$id"),1);
        if(!$current_user){
            return false;
        }

        $name=""; $user_name=""; $email=""; $password=""; $pic=""; $bio = ""; $verified=""; $role=""; $signin_type=""; 

        if(isset($data['name'])){$name = $data['name'];}else{$name = $current_user['name'];}
        if(isset($data['user_name'])){$user_name = $data['user_name'];}else{$user_name = $current_user['user_name'];}
        if(isset($data['email'])){$email = $data['email'];}else{$email = $current_user['email'];}
        if(isset($data['password'])){$password = $data['password'];}else{$password = $current_user['password'];}
        if(isset($data['pic'])){$pic = $data['pic'];}else{$pic = $current_user['pic'];}
        if(isset($data['bio'])){$bio = $data['bio'];}else{$bio = $current_user['bio'];}
        if(isset($data['verified'])){$verified = $data['verified'];}else{$verified = $current_user['verified'];}
        if(isset($data['role'])){$role = $data['role'];}else{$role = $current_user['role'];}
        if(isset($data['signin_type'])){$signin_type = $data['signin_type'];}else{$signin_type = $current_user['signin_type'];}

        $stmt = "UPDATE users SET name='$name', user_name='$user_name', email='$email', password='$password', pic='$pic', bio='$bio', 
        verified='$verified', role='$role', signin_type='$signin_type' WHERE id=$id";

        if($this->conn->query($stmt)){
            $output['code']='200';
            $output['msg']='user updated';

        }else{
            $output['code']='101';
            $output['msg']='failed error:- '.$this->conn->error;

        }

        return $output;
        
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
        $user_name = $data['user_name'];
        $email = $data['email'];
        $password = encrypt_password($data['password']);

        $current_user=mysqli_fetch_array(mysqli_query($this->conn,"SELECT * FROM users WHERE user_name=$user_name"));

        if($current_user && isset($current_user['user_name']) && $current_user['user_name']==$user_name){
            $output['code']='201';
            $output['msg']='username already exists';

        }else if($current_user && isset($current_user['email']) && $current_user['email']==$email){
            $output['code']="202";
            $output['msg']="email already exitst";
        }
        else{
          $stmt = "INSERT INTO users(id, name, user_name, email, password, pic, bio, verified, role, signin_type)
         VALUES ('0','$name','$user_name','$email','$password','','','0','user','email') ";

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
    
    function checkUsernameAvailability($user_name)
    {
        if(!$this->conn){
            return false;
        }
        
        $stmt = mysqli_query($this->conn,"SELECT * FROM users WHERE user_name=$user_name");

        $result = mysqli_fetch_array($stmt);
        
        if($result){

            $output['code']="199";
            $output['msg']="username alredy taken";

        }else{
            $output['code']="200";
            $output['msg']="username available";
        }

        return $output;

    }

    public function showdetailsbyusername($user_name){
        if(!$this->conn && $user_name==null){
            return false;
        }

        $stmt = mysqli_query($this->conn,"SELECT * FROM users WHERE user_name = $user_name");
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