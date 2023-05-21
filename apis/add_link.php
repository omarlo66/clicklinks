<?php
include_once('../options.php');
if(isset($_GET['link']) && current_user()){
    $user_id = current_user()['id'];
    $link = $_GET['link'];
    $link_id = str_replace(get_options('url').'go/', '', $link);
    $link = update_user_meta($user_id, 'next_link', $link_id);
    echo $link_id;
}
if(isset($_POST['link_id']) && isset($_COOKIE['user_id'])){
    $user_id = current_user()['id'];
    $link_id = $_POST['link_id'];
    $source = $_POST['src'];
    $budget = $_POST['budget'];
    $link = date('Y-m-d H:i:s');
    $user_maximum = get_user_meta($user_id, 'max_user_links') ? get_user_meta($user_id, 'max_user_links') : get_options('max_user_links');
    $user_links = user_links_count($user_id);
    if($user_links && $user_link >= $user_maximum){
        echo 'You have reached your maximum links';
        return;
    }
    if($budget == ''){
        $budget = get_options('min_points_per_link');
        echo "budget is empty";
        return;
    }
    $next_link = get_user_meta($user_id, 'next_link');
    delete_user_meta($user_id, 'next_link');
    if(function_exists('add_new_link')){
        if(add_new_link($link_id,$link,$source,$budget)){
            echo 'added successfully';
        }
        else{
            echo 'something went wrong';
            echo add_new_link($link_id,$link,$source,$budget);
        }
        $user_id = current_user()['id'];
        $ref = get_user_meta($user_id, 'add_link_bonus');
        if($ref){
            $action = insert_user_wallet($ref, get_options('add_link_bonus'), 'Add link bonus for referal');
            delete_user_meta($user_id, 'add_link_bonus');
            user_rate($ref,2);
        }
        user_rate($user_id,1);
    }
    else{
        echo 'function not found';
    }

}else{
    header('location: ../login.php');
}
