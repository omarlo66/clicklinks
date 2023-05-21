<?php

include_once '../options.php';
if(current_user() && current_user()['id']){
    $user_id = current_user()['id'];
    if(isset($_POST['payment_method'])){
        $payment_method = $_POST['payment_method'];
        $amount = $_POST['amount'];
        $account = $_POST['account'];
        if(get_user_credit($user_id) < $amount){
            echo 'You don\'t have this amount of money';
            user_rate($user_id, -1);
            exit();
        }
        $credit = insert_into_credit($user_id, -$amount, 'withdrawal');
        if($credit){
            $res = insert_into_payments($user_id, $payment_method, $amount, $account, 'withdraw','pending');
        }
        if($res){
            echo 'success';
            return;
        }else{
            echo 'Something went wrong';
            return;
        }
    }
}

?>