<?php
    //import db connection
    require_once('db.php');
    session_start();
    if (!is_writable(session_save_path())) {
        echo 'Session path "'.session_save_path().'" is not writable for PHP!'; 
    }
    //if user is already logged in, redirect to index.php
    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
        $response = array(
            'status' => 3,
            'message' => 'user already logged in'
        );
    }else{
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            //get data from form
            $data = json_decode(file_get_contents("php://input"));
            $username = $data->username;
            $password = $data->password;
            //encrypt password for comparison with db password hash
            $password = md5($password);
            //query
            $sql = "SELECT * FROM users WHERE (username = '$username' or email = '$username' ) AND password = '$password'";
            //run query
            $result = mysqli_query($conn, $sql);
            //check if query returns any results
            if($result->num_rows > 0){
                //get user id from result set and store in session variable
                $row = mysqli_fetch_assoc($result);
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['username'] = $username;
                $_SESSION['loggedin'] = true;
                $response = array(
                    'status' => 1,
                    'message' => 'Login successful'
                );    
            }else{
                $response = array(
                    'status' => 2,
                    'message' => 'Login failed'
                );        
            }
            //return response   
        }
    }
    echo json_encode($response);
?>
        