<?php

include_once '../options.php';
if(current_user() && current_user()['id'] != 0){
    $user_id = current_user()['id'];
    if(isset($_POST['payment_method'])){
        $payment_method = $_POST['payment_method'];
        $amount = $_POST['amount'];
        $transaction_id = $_POST['transaction_id'];
        $file_base = $_FILES['transaction_file'];
        $file_name = $file_base['name'];
        $file_tmp = $file_base['tmp_name'];
        $file_size = $file_base['size'];
        $file_type = $file_base['type'];
        $file_ext = explode('/',$file_type)[1];
        $extensions = array('jpeg','jpg','png','gif','mp3','mp4','pdf','doc','docx','txt','zip','rar');
        if(in_array($file_ext,$extensions) === false){
            error_handeler('error','extension not allowed, please choose a JPEG or PNG file.');
            return false;
        }
        if($file_size > 2097152){
            error_handeler('error','File size must be excately 2 MB');
            return false;
        }
        $file_name = uniqid().'.'.$file_ext;
        if(move_uploaded_file($file_tmp,__DIR__."/../uploads/".$file_name)){
            $file_id = insert_upload(current_user()['id'],$file_name,$description,'//uploads/'.$file_name,$file_ext);
        }
        else{
            error_handeler('error','error uploading file');
            return false;
        }
        $res = insert_into_payments($user_id, $payment_method, $amount, $transaction_id.','.$file_id, 'deposit','pending');
        if($res){
            echo 'success';
        }else{
            echo 'Something went wrong';
        }
    }
}

?>