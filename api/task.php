<?php
//restful api for user registration
require_once('db.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // get group id from url
    $group_id = $_GET['group_id'];
    $query = "SELECT * FROM groups WHERE id = '$group_id' AND user_id = '$_SESSION[user_id]'";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) > 0) {
        //return tasks of the group
        $query = "SELECT * FROM tasks WHERE group_id = '$group_id'";
        $result = mysqli_query($conn, $query);
        $tasks = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $tasks[] = $row;
        }
        $response = $tasks;
    } else {
        $response = array(
            'status' => 0,
            'message' => "You are not authorized to access this page"
        );
    }
} else if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
    $data = json_decode(file_get_contents("php://input"));
    $title = $data->title;
    $description = $data->description;
    $status = $data->status;
    $task_id = $data->id;
    //update status, title and description of the task in the database
    $query = "UPDATE tasks SET title = '$title', description = '$description', status = '$status' WHERE id = '$task_id'";
    $result = mysqli_query($conn, $query);
    if ($result) {
        $response = array(
            'status' => 1,
            'message' => "Task updated successfully"
        );
    } else {
        $response = array(
            'status' => 0,
            'message' => "Task update failed"
        );
    }
} else if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    //get delete task id
    $task_id = $_GET['task_id'];
    //get group id from tas table
    $query = "SELECT group_id FROM tasks WHERE id = '$task_id'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $group_id = $row['group_id'];
    //check if group pertences to user and delete task
    $query = "SELECT * FROM groups WHERE id = '$group_id' AND user_id = '$_SESSION[user_id]'";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) > 0) {
        //delete task
        $query = "DELETE FROM tasks WHERE id = '$task_id'";
        $result = mysqli_query($conn, $query);
        if ($result) {
            $response = array(
                'status' => 1,
                'message' => "Task deleted successfully"
            );
        } else {
            $response = array(
                'status' => 0,
                'message' => "Task could not be deleted"
            );
        }
    } else {
        $response = array(
            'status' => 0,
            'message' => "You are not authorized to access this page"
        );
    }
} else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents("php://input"));
    $title = $data->title;
    $description = $data->description;
    $status = $data->status;
    $group_id = $data->group_id;
    //verify if group pertenece to user
    $query = "SELECT * FROM groups WHERE id = '$group_id' AND user_id = '$_SESSION[user_id]'";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) > 0) {
        $query = "INSERT INTO tasks (title, description, status, group_id) VALUES ('$title', '$description', '$status', '$group_id')";
        $result = mysqli_query($conn, $query);
        if (!$result) {
            echo "Error: " . mysqli_error($conn);
        }
        if ($result) {
            $response = array(
                'status' => 0,
                'message' => 'Task created successfully'
            );
        } else {

            $response = array(
                'status' => 1,
                'message' => 'Task creation failed'
            );
        }
    } else {
        $response = array(
            'status' => 1,
            'message' => 'Group does not exist'
        );
    }
} else {
    //method not allowed
    $response = array(
        'status' => 0,
        'message' => 'Method not allowed'
    );
}
echo json_encode($response);
