<?php


if(isset($_POST['id'])){
    $id = $_POST['id'];
    include '../options.php';
    $user_id = current_user()['id'];
    $link = get_link($id);
    $author = $link['author'];
    if($author == $user_id){
        echo 'you can\'t report your own link';
        return ;
    }
    link_reported($id);
    return true;
}


?>