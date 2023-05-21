<?php
include_once '../../options.php';
if(current_user() && current_user()['role'] != 'admin' || !current_user()){
    header('location:../../index.php');
    exit();
}

if(isset($_POST['points_to_currency_fees'])){
    $res = set_option('points_to_currency_fees', $_POST['points_to_currency_fees']);
    $vodafone_cash = set_option('vodafone_cash', $_POST['vodafone_cash']);
    $vodafone_cash_instruction = set_option('vodafone_cash_instruction', $_POST['vodafone_cash_instruction']);
    $paypal = set_option('paypal', $_POST['paypal']);
    $paypal_instruction = set_option('paypal_instruction', $_POST['paypal_instruction']);
    $payeer = set_option('payeer', $_POST['payeer']);
    $payeer_instruction = set_option('payeer_instruction', $_POST['payeer_instruction']);
    if($res){
        echo 'Updated Successfully';
    }else{
        echo 'Something went wrong';
    }
}

?>