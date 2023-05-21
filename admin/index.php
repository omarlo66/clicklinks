<?php
include_once '../options.php';
if(current_user() && current_user()['role'] != 'admin' && current_user()['role'] == 'user'){
    $user_id = current_user()['id'];
    
    user_rate($user_id,-1);
    header('location:../index.php');
    exit();
}
if(current_user() && current_user()['role'] == 'admin'){
    require_once '../admin.php';
}

?>