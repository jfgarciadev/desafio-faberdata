<?php
    //restful api for user registration
    
    require_once('db.php');

    $data = json_decode(file_get_contents("php://input"));
    $username = $data->username;
    $password = $data->password;
    $email = $data->email;

    //encode password to md5
    $password = md5($password);

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        //check if user already exists
        $query = "SELECT * FROM users WHERE username = '$username' OR email = '$email'";
        $result = mysqli_query($conn, $query);
        $num = mysqli_num_rows($result);
        if($num == 1){
            //user already exists
            $response = array(
                'status' => 0,
                'message' => 'User already exists'
            );
        }else{
            //insert user data into database
            $query = "INSERT INTO users (username, password, email) VALUES ('$username', '$password', '$email')";
            $result = mysqli_query($conn, $query);
            //if error in inserting data into database 
            if($result){
                //user registered successfully
                $response = array(
                    'status' => 1,
                    'message' => 'User registered successfully'
                );
                
            }else{
                //user registration failed
                $response = array(
                    'status' => 0,
                    'message' => 'User registration failed'
                );
            }
        }
    }else{
        //method not allowed
        $response = array(
            'status' => 0,
            'message' => 'Method not allowed'
        );
    }
    
    echo json_encode($response);
?>