<?php
//restful api for user registration
    
require_once('db.php');

session_start();



//check if user already logged in based on session user_id

if($_SERVER['REQUEST_METHOD'] == 'GET'){
    //get all groups with user_id = session user_id and return as json
    $sql = "SELECT * FROM groups WHERE user_id = '".$_SESSION['user_id']."'";
    $result = mysqli_query($conn, $sql);
    $response = array();
    while($row = mysqli_fetch_assoc($result)){
        $response[] = $row;
    }
}else if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $data = json_decode(file_get_contents("php://input"));
    $title = $data->title;
    if(isset($_SESSION['user_id'])){
        $user_id = $_SESSION['user_id'];
        $sql = "INSERT INTO groups (title, user_id) VALUES ('$title','$user_id')";
        $result = mysqli_query($conn, $sql);
        //echo error if query fails
        if(!$result){
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
        else{
            echo "Group created successfully";
        }

        if($result){
           //prepare json data for response
            $response = array(
                'status' => 1,
                'message' => 'Group created successfully'
            );
        }else{
            $response = array(
                'status' => 0,
                'message' => 'Group creation failed'
            );
        }
    }else{
        //prepare json data for response
        $response = array(
            'status' => 0,
            'message' => 'Please login to create group'
        );
    }
}else if($_SERVER['REQUEST_METHOD'] == 'DELETE'){
    //verifi if group pertences to user and delete
    $group_id = $_GET['group_id'];
    $query = "SELECT * FROM groups WHERE id = '$group_id' AND user_id = '$_SESSION[user_id]'";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) > 0) {
        $sql = "DELETE FROM groups WHERE id = '$group_id'";
        $result = mysqli_query($conn, $sql);
        if(!$result){
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
        if($result){
            $response = array(
                'status' => 1,
                'message' => 'Group deleted successfully'
            );
        }else{
            $response = array(
                'status' => 0,
                'message' => 'Group deletion failed'
            );
        }
    }else{
        $response = array(
            'status' => 0,
            'message' => 'Group does not exist'
        );
    }

}else{
    //method not allowed
    $response = array(
        'status' => 0,
        'message' => 'Method not allowed'
    );
}

echo json_encode($response);