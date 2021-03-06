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
        if($data!=null && isset($data['password']) && (isset($data['email']) || isset($data['username']))){
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

                    $mail['to'] = $data['email'];
                    $mail['sub'] = "Verify your account";
                    $mail['msg'] = "Hi ".$data['username'].", \nWelcome to".APP_NAME." you have recently signind in Please verify your email here \n". BASE_URL.'verify/signup.php?token='.encrypt_password($data['msg']['id']);
                    
                    if(send_email($mail)){
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
        $this->loadModel('User');
        if($_FILES!=null){

            if($data!=null && isset($data['id'])){
                $prefix=rand(1000,999999);

                $originalImgName= $prefix.$_FILES['u_file']['name'];
                $tempName= $_FILES['u_file']['tmp_name'];
                $folder= UPLOADS_DIR;
                
                if(move_uploaded_file($tempName,$folder.$originalImgName)){

                    $path = "uploads/images/".$originalImgName;
                    $data['pic'] = $path;

                    if($this->User->update($data)){
                        $details = $this->User->getdetails($data);
                        $output['code'] = 200;
                        $output['message'] = json_encode($details);
    
                    }else{
                        $output['code'] = 201;
                        $output['message'] = 'user not found :-'.$this->User->conn->error;
                    }

                }else{
                    $output['code'] = 101;
                    $output['message'] = 'failed to move files';
                }

                echo json_encode($output);
                die;

            }else{
                incomplete_data($data);
            }

        }else{
            if($data!=null && isset($data['id'])){

                if($this->User->update($data)){
                    $details = $this->User->getdetails($data);
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
                if(is_array($details) && $this->Business->conn->error==null){
                    $output['code'] = '201';
                    $output['msg'] = "no records";
                }else{
                    $output['code'] = '101';
                    $output['msg'] = "server error :-".$this->Business->conn->error;
                }
               

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
                $output['msg'] = "server error :-".$this->Idea->conn->error;

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
                if($details==[] && $this->Idea->conn->error==null){
                    $output['code'] = '201';
                    $output['msg'] = "no records";
                }else{
                    $output['code'] = '101';
                    $output['msg'] = "server error :-".$this->Idea->conn->error;
                }

            }

            echo json_encode($output);
            die_($data);

        }else{
            incomplete_data($data);
        }

    }

    public function getuserallprivateideas()//200, 101=error
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

            $details = $this->Idea->getuserprivate($data);

            if($details){
            
                $output['code'] = '200';
                $output['msg'] = $details;

            }else{
                if($details==[] && $this->Idea->conn->error==null){
                    $output['code'] = '201';
                    $output['msg'] = "no records";
                }else{
                    $output['code'] = '101';
                    $output['msg'] = "server error :-".$this->Idea->conn->error;
                }

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
            $this->loadModel('investor');

            $details = $this->investor->getallbyuserid($data);

            if($details){
            
                $output['code'] = '200';
                $output['msg'] = $details;

            }else{
                $output['code'] = '101';
                $output['msg'] = "server error :-".$this->investor->conn->error;

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

    public function getinvestordetails()
    {
        $data = $this->getInputs();
        if($data!=null && isset($data['id'])){
            $this->loadModel('investor');
            $this->loadModel('User');
            $this->loadModel('Business');
            $this->loadModel('Idea');

            $details = $this->investor->getdetails($data);

            if($details){
                
                $get['sp'] = 0;
                $get['user_id'] = $details['user_id'];

                $business = $this->Business->getallbyuserid($get);
                $ideas = $this->Idea->getallbyuserid($get);

                $id['id'] = $details['user_id'];
                $user = $this->User->getdetails($id);

                if(!count($business)>0){
                    $business=[];
                }

                if(!count($ideas)>0){
                    $ideas = [];
                }

                $output['code'] = 200;
                $output['msg'] = $details;
                $output['business'] = $business;
                $output['idea'] = $ideas;
                $output['user'] = $user;

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
            echo json_encode(array('code'=>'101','message'=>'incomplete params'));
            die;
        }
        
        $this->loadModel('Business');

        $prefix=rand(1000,999999);

        $originalImgName= $prefix.$_FILES['u_file']['name'];
        $tempName= $_FILES['u_file']['tmp_name'];
        $folder= UPLOADS_DIR;
        
        if(move_uploaded_file($tempName,$folder.$originalImgName)){

            $date = gmdate("Y-m-d H:i:s");

            if(isset($data['description'])){
                $data['description'] = str_replace("'","\'",$data['description']);
            }

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
                echo json_encode(['code'=>'200','message'=>'{"success":"true","id":"'.$this->Business->InsertId.'"}']);

            }else{
                echo json_encode(['code'=>'101','message'=>'error'.$this->Business->conn->error]);
                unlink($folder.$originalImgName);

            }

        }else{
        	echo json_encode(['code'=>'101','message'=>'error moving file']);

        }

        die;

    }

    public function uploadidea()
    {
        
        $data = $this->getInputs();
        if($data==null){
            echo json_encode(array('code'=>'101','message'=>'incomplete params'));
            die;
        }
        
        $this->loadModel('Idea');

        $prefix=rand(1000,999999);

        $originalImgName= $prefix.$_FILES['u_file']['name'];
        $tempName= $_FILES['u_file']['tmp_name'];
        $folder= UPLOADS_DIR;
        
        if(move_uploaded_file($tempName,$folder.$originalImgName)){

            $date = gmdate("Y-m-d H:i:s");

            if(isset($data['description'])){
                $data['description'] = str_replace("'","\'",$data['description']);
            }

            $create_data['user_id'] = $data['id'];
            $create_data['name'] = $data['idea_name'];
            $create_data['category'] = $data['category'];
            $create_data['icon'] = "uploads/images/".$originalImgName;
            $create_data['description'] = $data['description'];
            $create_data['equity'] = $data['equity'];
            $create_data['status'] = '1';
            $create_data['extra'] = 'n';
            $create_data['updated'] = $date;
            $create_data['created'] = $date;

            if($this->Idea->create($create_data)){
                echo json_encode(['code'=>'200','message'=>'{"success":"true","id":"'.$this->Idea->InsertId.'"}']);

            }else{
                echo json_encode(['code'=>'101','message'=>'error'.$this->Idea->conn->error]);
                unlink($folder.$originalImgName);

            }

        }else{
        	echo json_encode(['code'=>'101','message'=>'error moving file']);

        }

        die;

    }

    public function updateidea()
    {
        
        $data = $this->getInputs();

        if($_FILES!=null && isset($_FILES['u_file'])){

            $prefix=rand(1000,999999);
            $originalImgName= $prefix.$_FILES['u_file']['name'];
            $tempName= $_FILES['u_file']['tmp_name'];
            $folder= UPLOADS_DIR;
            
            if(move_uploaded_file($tempName,$folder.$originalImgName)){
                $data['icon'] = "uploads/images/".$originalImgName;
            }

        }

        if(isset($data['description'])){
            $data['description'] = str_replace("'","\'",$data['description']);
        }

        if($data==null){
            echo json_encode(array('code'=>'101','message'=>'incomplete params'));
            die;
        }
        
        $this->loadModel('Idea');
    
        if($this->Idea->update($data)){
            echo json_encode(array('code'=>'200','message'=>'success'));
        }else{
            echo json_encode(array('code'=>'101','message'=>''.$this->Idea->error));
        }

        die;

    }

    public function updatebusiness()
    {
        
        $data = $this->getInputs();
        if($data==null){
            echo json_encode(array('code'=>'101','message'=>'incomplete params'));
            die;
        }

        if($_FILES!=null && isset($_FILES['u_file'])){

            $prefix=rand(1000,999999);
            $originalImgName= $prefix.$_FILES['u_file']['name'];
            $tempName= $_FILES['u_file']['tmp_name'];
            $folder= UPLOADS_DIR;
            
            if(move_uploaded_file($tempName,$folder.$originalImgName)){
                $data['icon'] = "uploads/images/".$originalImgName;
            }

        }

        if(isset($data['description'])){
            $data['description'] = str_replace("'","\'",$data['description']);
        }
        
        $this->loadModel('Business');
    
        if($this->Business->update($data)){
            echo json_encode(array('code'=>'200','message'=>'success'));
        }else{
            echo json_encode(array('code'=>'101','message'=>''.$this->Business->error));
        }

        die;

    }

    public function deleteidea()
    {
        $data = $this->getInputs();
        if($data!=null && isset($data['id'])){
            $this->loadModel('Idea');
            if($this->Idea->delete($data['id'])){
                $output = ['code'=>'200','msg'>="success"];
            }else{
                $output = ['code'=>'101','msg'>="failed"];
            }
        
            echo json_encode($output);

        }else{
            incomplete_data();
        }

    }

    public function deletebusiness()
    {
        $data = $this->getInputs();
        if($data!=null && isset($data['id'])){
            $this->loadModel('Business');
            if($this->Business->delete($data['id'])){
                $output = ['code'=>'200','msg'>="success"];
            }else{
                $output = ['code'=>'101','msg'>="failed"];
            }

            echo json_encode($output);
        
        }else{
            incomplete_data();
        }

    }
    

    public function deleteinvestor()
    {
        $data = $this->getInputs();
        if($data!=null && isset($data['id'])){
            $this->loadModel('investor');
            if($this->investor->delete($data['id'])){
                $output = ['code'=>'200','msg'>="success"];
            }else{
                $output = ['code'=>'101','msg'>="failed"];
            }

            echo json_encode($output);
        
        }else{
            incomplete_data();
        }

    }

    public function uploadinvestor()
    {
        
        $data = $this->getInputs();
        if($data==null){
            echo json_encode(array('code'=>'101','message'=>'incomplete params'));
            die;
        }
        
        $this->loadModel('investor');

        $prefix=rand(1000,999999);

        $originalImgName= $prefix.$_FILES['u_file']['name'];
        $tempName= $_FILES['u_file']['tmp_name'];
        $folder= UPLOADS_DIR;
        
        if(move_uploaded_file($tempName,$folder.$originalImgName)){

            $date = gmdate("Y-m-d H:i:s");

            if(isset($data['description'])){
                $data['description'] = str_replace("'","\'",$data['description']);
            }

            $create_data['user_id'] = $data['id'];
            $create_data['name'] = $data['name'];
            $create_data['category'] = $data['category'];
            $create_data['icon'] = "uploads/images/".$originalImgName;
            $create_data['description'] = $data['description'];
            $create_data['equity'] = '0';
            $create_data['status'] = '1';
            $create_data['extra'] = 'n';
            $create_data['updated'] = $date;
            $create_data['created'] = $date;

            if($this->investor->create($create_data)){
                echo json_encode(['code'=>'200','message'=>'{"success":"true","id":"muje ni pta yar"}']);

            }else{
                echo json_encode(['code'=>'101','message'=>'error'.$this->investor->conn->error]);
                unlink($folder.$originalImgName);

            }

        }else{
        	echo json_encode(['code'=>'101','message'=>'error moving file']);

        }

        die;

    }

    public function update_token()
    {
        $data=$this->getInputs();
        if($data==null && !isset($data["id"])){
            incomplete_data();

        }

        $this->loadModel('User');
        if($this->User->update($data)){
            echo json_encode(['code'=>'200','message'=>'success']);

        }else{
        	echo json_encode(['code'=>'101','message'=>'error']);

        }

        die;
        
    }

    public function sendchatnotification()
    {
        $data = $this->getInputs();
        if($data==null){
            incomplete_data();
        }

        $this->loadModel('User');
        $s['id'] = $data['sender_id'];
        $r['id'] = $data['other_user_id'];
        $sender = $this->User->getdetails($s);
        $other_user = $this->User->getdetails($r);

        if($other_user['token']!=null){
            $msg['title'] = "You hava a new message from ".$sender['name'];
            $msg['msg'] = $data['msg'];

            $res = sendPushNotification($other_user['token'],$msg);
            $result = json_decode($res,true);

            if($result!=null && $result['success']==1){
                $output['code'] = '200';
                $output['msg'] = 'success';

            }else{
                $output['code'] = '101';
                $output['msg'] = 'fcm error '.$res ;
            }

        }else{
            $output['code'] = '101';
            $output['msg'] = 'user token missing impossible to send message';
        }

        echo json_encode($output);
        die;

    }

    public function resendverificationemail() //200=success, 101=error , 201 = already verified , 111 faild to send email
    {
        $data = $this->getInputs();
        if($data!=null && isset($data['id'])){
            $this->loadModel('User');

            $details = $this->User->getdetails($data);

            if($details){
                
                if($details['verified']==0){

                    $mail['to'] = $details['email'];
                    $mail['sub'] = "Verify your account";
                    $mail['msg'] = "Hi ".$details['username'].", \nWelcome to".APP_NAME." you have recently signind in Please verify your email here \n". BASE_URL.'verify/signup.php?token='.encrypt_password($details['id']);

                    if(send_email($mail)){
                        $output['code'] = '200';
                        $output['msg'] = 'success';

                    }else{
                        $output['code'] = '111';
                        $output['msg'] = 'failed to send email please try again later';
                    }

                }else{
                    $output['code'] = '201';
                    $output['msg'] = 'already verifies '.$details['verified'];

                }


            }else{
                $output['code'] = '101';
                $output['msg'] = 'user not found :-'.$this->User->conn->error;
            }
            
            echo json_encode($output);
            die_($this->conn);

        }else{
            incomplete_data($data);
        }

    }

    public function verifyuser()
    {
        $data = $this->getInputs();
        if(isset($data['id'])){
            $this->loadModel('User');

            $details = $this->User->getdetails($data);

            if($details){
                if($details['verified']=='0'){
                    $update['id'] = $data['id'];
                    $update['verified'] = '1';

                    if($this->User->update($update)){
                        $out['code'] = '200';
                        $out['msg'] =  'success';

                    }else{
                        $out['code'] = '211';
                        $out['msg'] =  'update failed';
                    }

                }else{
                    $out['code'] = '201';
                    $out['msg'] =  'verification status '.$details['verification'];
                }

            }else{
                $out['code'] = '101';
                $out['msg'] =  'user not found';
            }

            
        }else{
            incomplete_data();
        }
    }

    public function getInputs()
    {
        $php_input = json_decode(file_get_contents("php://input"),true);
        $data = $_POST;
        if($php_input!=null && $data!=null){
            $data = array_merge($data,$php_input);
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