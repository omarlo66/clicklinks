<?php

include_once 'options.php';

if(! current_user() || ! isset($_POST['id'])){
    header('location: ../login.php');
    return;
}

if(isset($_POST['id']) && isset($_POST['add'])){
    $notification = $_POST['add'];
    $id = $_POST['id'];
    $user_id = current_user()['id'];
    $add = add_notification_to_user($user_id, $notification);
    if($add){
        echo 'ok';
    }else{
        echo 'Something went wrong';
    }
}

if(isset($_GET['get'])){
    $user_id = current_user()['id'];
    $notifications = get_notifications($user_id);
    if($notifications){
        echo json_encode($notifications);
    }else{
        echo 'Something went wrong';
    }
}
if(isset($_GET['remove'])){
    $user_id = current_user()['id'];
    $remove = remove_notification($user_id, $_GET['content']);
    if($remove){
        echo 'ok';
    }else{
        echo 'Something went wrong';
    }
}
?>