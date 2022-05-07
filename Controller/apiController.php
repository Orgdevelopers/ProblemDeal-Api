<?php

class ApiController {

    public function startControll($method)
    {
        $method();


    }

    public function test()
    {
        echo "hit";
    }

}

?>