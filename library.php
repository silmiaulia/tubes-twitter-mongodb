<?php
    require_once 'connection.php';
    session_start();

    // class for image 
    class Item {
        public $_id;
        
        function __construct(array $fields = array()) {
            foreach ($fields as $field => $value) {
                $this->$field = stripslashes($value);
            }
            if (empty($this->_id)) {
                $this->_id = (string) new ItemID;
            }
        }
    }

    class ItemID {
        function __tostring() {
            $template = '%04X%04X-%04X-%04X-%04X-%04X%04X%04X';
            return sprintf(
                $template, 
                mt_rand(0, 65535), 
                mt_rand(0, 65535), 
                mt_rand(0, 65535), 
                mt_rand(16384, 20479), 
                mt_rand(32768, 49151), 
                mt_rand(0, 65535), 
                mt_rand(0, 65535), 
                mt_rand(0, 65535)
            );
        }
    }

    // insert new doc account
    function register($document){

        global $collection;
        $collection->insertOne($document);
        return true;
    }

    // check if email already registered
    function checkEmail($email){
        
        global $collection;

        $temp = $collection->findOne(array('email'=> $email));

        if(empty($temp)){
            return true;
        }
        else{
            return false;
        }
    }

    // check if username already registered
    function checkUsername($username){
        
        global $collection;

        $temp = $collection->findOne(array('username'=> $username));

        if(empty($temp)){
            return true;
        }
        else{
            return false;
        }
    }

    // session login
    function setSession($email){
     
        $_SESSION["userLoggedIn"] = 1;
        global $collection;
        $temp = $collection->findOne(array('email'=> $email));
        $_SESSION["uname"] = $temp["username"];
        $_SESSION["email"] = $email;

        return true;
        
    }

    //check if session is set
    function isLogin(){
        
        if(isset($_SESSION["userLoggedIn"])){
            return true;
        }
        else{
            return false;
        }
    }

    // unset session
    function removeall(){
        unset($_SESSION["userLoggedIn"]);
        unset($_SESSION["uname"]);
        unset($_SESSION["email"]);
        return true;
    }

    
    // get data with email 
    function getData($email){
        
        global $collection;
        $temp = $collection->findOne(array('email'=> $email));

        return $temp;

    }

    // for get image 
    function parseQuery( $template ){
        $values = array_slice( func_get_args(), 1 );
        $query = vsprintf( $template, $values );
        $query = json_decode( $query, true );
        $query = var_export( $query, true );
        
        return eval("return $query;");
    }

?>