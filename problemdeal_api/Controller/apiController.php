<?php

class ApiController {

    public function init($request)
    {
        
        try {

            $db = new Database();
            $this->conn = $db->getConnection();
            $this-> $request();
        } catch (\Throwable $th) {
            //echo $th;
            no_method($request);
        }

    }

    public function emaillogin() //200 success, 201=wrong pass, 101=usernot 113=gmail
    {
        $data = $this->getInputs();
        if($data!=null && isset($data['password']) && (isset($data['email']) || isset($data['user_name']))){
            $this->loadModel('User');
            $details = $this->User->getdetails($data);
            if($details){
                if($details['password'] == encrypt_password($data['password'])){
                    $output['code'] = "200";
                    $output['msg'] = $details;

                }else{
                    $output['code'] = "201";
                    $output['msg'] = "wrong password";
                }

            }
            // else if($details['signin_type']=='2'){
            //     $output['code'] = '113';
            //     $output['msg'] = 'please log in via username';

            // }
            else{
                $output['code'] = "101";
                $output['msg'] = "user not found error:- ".$this->User->conn->error;
            }

            echo json_encode($output);
            die_($this->conn);

        }else{
            incomplete_data($data);
        }

    }

    public function emailsignup() //101 connection error , 111=username ,112= email; , 113=gmail
    {
        $data = $this->getInputs();
        if($data!=null && isset($data['email']) && isset($data['username'])){
            $this->loadModel('User');
            if($this->User->checksignupdata($data)){

                if($this->User->create($data)){

                    $user['username'] = $data['username'];
                    $output['code'] = '200';
                    $output['msg'] = $this->User->getdetails($user);

                    $email['to'] = $data['email'];
                    $email['subject'] = "Verify your account";
                    $email['msg'] = "hi ".$data['name'].", \nPlease visit this link to verify your account ".BASE_URL."verify/signup.php?token=".encrypt_password($data['email']);

                    if(send_email($email)){
                        $output['v_email'] = "200";
                    }else{
                        $output['v_email'] = "101";
                    }

                }else{
                    $output['code'] = '401';
                    $output['msg'] = "db error:- ".$this->User->conn->error;
                }

            }else{
                $output['code'] = $this->User->errorcode;
                $output['msg'] = "error";
            }

            echo json_encode($output);
            die_($this->conn);

        }else{
            incomplete_data($data);
        }

    }

    public function gmaillogin() //200 =success, 201=signup
    {
        $data = $this->getInputs();
        if($data!=null && isset($data['gmail'])){
            $details = $this->User->getdetails($data);
            if($details){
                $output['code'] = '200';
                $output['msg'] = $details;

            }else{
                $output['code'] = '201';
                $output['msg'] = 'signup';
            }

        }else{
            incomplete_data($data);
        } 

    }

    public function creategmailuser() //101 connection error , 111=username ,112= email; , 113=gmail
    {
        $data = $this->getInputs();
        if($data!=null && isset($data['username']) && isset($data['gmail'])){
            $this->loadModel('User');

            $check_params['username'] = $data['username'];
            $check_params['email'] = $data['gmail'];
            
            if($this->User->checksignupdata($check_params)){
                if($this->User->creategmail($data)){
                    $output['code'] = '200';
                    $output['msg'] = $this->User->getdetails($data);

                }else{
                    $output['code'] = "114";
                    $output['msg'] = "error ".$this->User->conn->error;
                }

            }else{
                $output['code'] = $this->User->errorcode;
                $output['msg'] = "error";
            }

            echo json_encode($output);
            die_($this->conn);

        }else{
            incomplete_data($data);
        }
    }

    public function changeprofilepic()//200 =success, 201=sqlerrror; 101 = file error
    {
        $data = $this->getInputs();
        if($data!=null && isset($data['image']) && isset($data['id'])){

            $filename = uniqid().".jpg";
            $sql_path = "uploads/images/".$filename;
            $fullpath = UPLOADS_DIR."/".$filename;

            $img = $data['image'];
            $img = str_replace('data:image/png;base64,', '', $img);
            $img = str_replace(' ', '+', $img);
            $img = base64_decode($img);

            $success=file_put_contents($fullpath, $img);

            if($success){
                $update['id'] = $data['id'];
                $update['pic'] = $sql_path;

                if($this->User->update($update)){
                    $output['code'] = '200';
                    $output['msg'] = $this->User->getdetails($update);

                }else{
                    $output['code'] = '201';
                    $output['msg'] = 'db error:-'.$this->User->conn->error;
                }

            }else{
                $output['code'] = '101';
                $output['msg'] = 'file error';
            }

            echo json_encode($output);
            die_($this->conn);

        }else{
            incomplete_data($data);
        }
    }

    public function getuserdetails() //200=success, 201=error
    {
        $data = $this->getInputs();
        if($data!=null && isset($data['id'])){
            $this->loadModel('User');
            $this->loadModel('Business');
            $this->loadModel('Idea');
            $this->loadModel('investor');
            

             $details = $this->User->getdetails($data);
            if($details){
                // $details['business'] = $this->Business->countbyid($details['id'])[0];
                // $details['ideas'] = $this->Idea->countbyid($details['id'])[0];
                // $details['investor'] = $this->investor->countbyid($details['id'])[0];

                $output['code'] = '200';
                $output['msg'] = $details;

                

            }else{
                $output['code'] = '201';
                $output['msg'] = 'user not found :-'.$this->User->conn->error;
            }
            
            echo json_encode($output);
            die_($this->conn);

        }else{
            incomplete_data($data);
        }

    }


    public function updateuser() //200 succ, 201 error
    {
        $data = $this->getInputs();
        if($data!=null && isset($data['id'])){
            $this->loadModel('User');
            $this->loadModel('Business');
            $this->loadModel('Idea');
            $this->loadModel('Investor');

            if($this->User->update($data)){
                $details = $this->User->getdetails($data);
                $details['business'] = $this->Business->countbyid($details['id'])[0];
                $details['ideas'] = $this->Idea->countbyid($details['id'])[0];
                $details['investor'] = $this->Investor->countbyid($details['id'])[0];

                $output['code'] = '200';
                $output['msg'] = $details;

            }else{
                $output['code'] = '201';
                $output['msg'] = 'user not found :-'.$this->User->conn->error;
            }
            
            echo json_encode($output);
            die_($this->conn);

        }else{
            incomplete_data($data);
        }
    }


    public function getallbusiness()//200, 201=no rec 101=error
    {
        $data = $this->getInputs();
        if($data==null){
            $data['sp'] = '0';

        }
        if($data!=null){
            $this->loadModel('Business');

            $details = $this->Business->getall($data);

            if($details){
                
                $output['code'] = '200';
                $output['msg'] = $details;

            }
            else{
                $output['code'] = '101';
                $output['msg'] = "server error :-".$this->Business->conn->error;

            }

            echo json_encode($output);
            die_($data);

        }else{
            incomplete_data($data);
        }

    }

    public function getuserallbusiness()//200, 201=no rec 101=error
    {
        $data = $this->getInputs();
        if(!isset($data['user_id'])){
            incomplete_data();
        }

        if(!isset($data['sp'])){
            $data['sp'] = '0';
        }
        
        if($data!=null){
            $this->loadModel('Business');

            $details = $this->Business->getallbyuserid($data);

            if($details){
                
                $output['code'] = '200';
                $output['msg'] = $details;

            }
            else{
                $output['code'] = '101';
                $output['msg'] = "server error :-".$this->Business->conn->error;

            }

            echo json_encode($output);
            die_($data);

        }else{
            incomplete_data($data);
        }

    }

    public function getallideas()//200, 101=error
    {
        $data = $this->getInputs();
        if($data==null){
            $data['sp'] = '0';
        }
        if($data!=null){
            $this->loadModel('Idea');

            $details = $this->Idea->getall($data);

            if($details){
            
                $output['code'] = '200';
                $output['msg'] = $details;

            }else{
                $output['code'] = '101';
                $output['msg'] = "server error :-".$this->Business->conn->error;

            }

            echo json_encode($output);
            die_($data);

        }else{
            incomplete_data($data);
        }

    }

    public function getuserallideas()//200, 101=error
    {
        $data = $this->getInputs();
        if(!isset($data['user_id'])){
            incomplete_data();
        }

        if(!isset($data['sp'])){
            $data['sp'] = '0';
        }
        
        if($data!=null){
            $this->loadModel('Idea');

            $details = $this->Idea->getallbyuserid($data);

            if($details){
            
                $output['code'] = '200';
                $output['msg'] = $details;

            }else{
                $output['code'] = '101';
                $output['msg'] = "server error :-".$this->Business->conn->error;

            }

            echo json_encode($output);
            die_($data);

        }else{
            incomplete_data($data);
        }

    }

    public function getallinvestor()//200, 101=error
    {
        $data = $this->getInputs();
        if($data==null){
            $data['sp'] = '0';
        }
        
        if($data!=null){
            $this->loadModel('Investor');

            $details = $this->Investor->getall($data);

            if($details){
            
                $output['code'] = '200';
                $output['msg'] = $details;

            }else{
                $output['code'] = '101';
                $output['msg'] = "server error :-".$this->Investor->conn->error;

            }

            echo json_encode($output);
            die_($data);

        }else{
            incomplete_data($data);
        }

    }

    public function getuserallinvestor()//200, 101=error
    {
        $data = $this->getInputs();
        if(!isset($data['user_id'])){
            incomplete_data();
        }

        if(!isset($data['sp'])){
            $data['sp'] = '0';
        }
        
        if($data!=null){
            $this->loadModel('Investor');

            $details = $this->Investor->getall($data);

            if($details){
            
                $output['code'] = '200';
                $output['msg'] = $details;

            }else{
                $output['code'] = '101';
                $output['msg'] = "server error :-".$this->Investor->conn->error;

            }

            echo json_encode($output);
            die_($data);

        }else{
            incomplete_data($data);
        }

    }

    public function getbusinessdetails()
    {
        $data = $this->getInputs();
        if($data!=null && isset($data['id'])){
            $this->loadModel('Business');
            $this->loadModel('User');

            $details = $this->Business->getdetails($data);

            if($details){

                $user_update['id'] = $details['user_id'];
                $user = $this->User->getdetails($user_update);

                $out['User'] = $user;
                $out['Business'] = $details;

                $output['code'] = '200';
                $output['msg'] = $out;

            }else{
                $output['code'] = '101';
                $output['msg'] = 'error:-'.$this->Business->conn->error;
            }

            echo json_encode($output);
            die_($this->conn);

        }else{
            incomplete_data();
        }

    }

    public function getideadetails()
    {
        $data = $this->getInputs();
        if($data!=null && isset($data['id'])){
            $this->loadModel('Idea');
            $this->loadModel('User');

            $details = $this->Idea->getdetails($data);

            if($details){

                $user_update['id'] = $details['user_id'];
                $user = $this->User->getdetails($user_update);

                $out['User'] = $user;
                $out['Idea'] = $details;

                $output['code'] = '200';
                $output['msg'] = $out;

            }else{
                $output['code'] = '101';
                $output['msg'] = 'error:-'.$this->Idea->error;

            }

            echo json_encode($output);
            die_($this->conn);

        }else{
            incomplete_data();
        }

    }


    public function getallcategories()
    {
        $this->loadModel('Category');

        $categories = $this->Category->getAll();

        if(count($categories)>0){
            $output['code'] = '200';
            $output['msg'] = $categories;

        }else{
            $output['code'] = '101';
            $output['msg'] = 'error :-'.$this->Category->conn->error;
        }

        echo json_encode($output);
        die;

    }

    public function uploadbusiness()
    {
        $data = $this->getInputs();
        if($data==null){
            echo json_encode(['code'=>101,'message'=>'incomplete params']);
            die;
        }
        
        $this->loadModel('Business');

        $prefix=rand(1000,999999);

        $originalImgName= $prefix.$_FILES['u_file']['name'];
        $tempName= $_FILES['u_file']['tmp_name'];
        $folder= UPLOADS_DIR;
        
        if(move_uploaded_file($tempName,$folder.$originalImgName)){

            $date = gmdate("Y-m-d H:i:s");

            $create_data['user_id'] = $data['id'];
            $create_data['name'] = $data['business_name'];
            $create_data['category'] = $data['category'];
            $create_data['icon'] = "uploads/images/".$originalImgName;
            $create_data['description'] = $data['description'];
            $create_data['equity'] = $data['equity'];
            $create_data['status'] = '1';
            $create_data['extra'] = 'n';
            $create_data['updated'] = $date;
            $create_data['created'] = $date;

            if($this->Business->create($create_data)){
                echo json_encode(['code'=>101,'message'=>'{"success":"true","id":"'.$this->Business->InsertId.'"}']);

            }else{
                echo json_encode(['code'=>101,'message'=>'error'.$this->Business->conn->error]);
            }

        }else{
        	echo json_encode(['code'=>101,'message'=>'error moving file']);

        }

        

    }

    public function getInputs()
    {
        $php_input = json_decode(file_get_contents("php://input"),true);
        $data = $_POST;
        if($php_input!=null && $data!=null){
            for($i=0;$i<count($php_input);$i++){
                $data[] = $php_input[$i];
            }
            return $data;
        }else if($php_input!=null && $data==null){
            return $php_input;

        }else if($php_input==null && $data!=null){
            return $data;
        }else{
            return null;
        }
        
        
    }

    public function loadModel($model)
    {
        $this->$model = new $model();
        $this->$model->conn = $this->conn;

    }

    public function testt()
    {
        echo "hit";
    }

}

?>