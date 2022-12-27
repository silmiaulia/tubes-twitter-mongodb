<?php require_once 'connection.php'; ?>
<?php require_once 'library.php'; ?>
<?php
    
    if(isLogin()){
        header("Location: home.php");
    }
?>
<?php

    if(isset($_POST['login'])){

        $email = $_POST['email'];
        $upass = $_POST['password'];
        $criteria = array("email"=> $email);
        $query = $collection->findOne($criteria);

        if(empty($query)){

            echo "Email ID is not registered.";
            echo "Either <a href='register'>Register</a> with the new Email ID or <a href='login.php'>Login</a> with an already registered ID";
        
        }else{
            
                $pass = $query["password"];
                if(password_verify($upass,$pass)){
                    $var = setSession($email);

                    if($var){
                        header("Location: home.php");
                    }
                    else{
                        echo "Some error";
                    }
                }

                else{
                    echo "You have entered a wrong password";
                    echo "<br>";
                    echo "Either <a href='register'>Register</a> with the new Email ID or <a href='login.php'>Login</a> with an already registered ID";
                }
                
            
        
        }
    }
    

?>