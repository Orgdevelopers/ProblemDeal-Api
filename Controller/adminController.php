<?php

class AdminController {

    public function startControll($method)
    {
        if(!function_exists($method)){
            no_method($method);

        }else{
            $method();

        }


    }

    public function test()
    {
        echo "hit admin";
    }

}

?>