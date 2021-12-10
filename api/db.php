<?php
    //create connection
    $conn = mysqli_connect('localhost', 'root', 'root', 'taskin');

    $env = 'dev';

    if ($env == 'dev') {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);

        
    } 

    
    
    //check connection
    if(!$conn){
        echo 'Connection error: '. mysqli_connect_error();
    }
?>