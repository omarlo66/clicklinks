<?php

include_once '../options.php';

if(!current_user() || !current_user()['id'] > 0){
    header('location:../../../index.php');
    exit();
}

if(isset($_POST['item_id'])){
    $auth = $_POST['auth'];
    $item_id = $_POST['item_id'];
    $user_id = current_user()['id'];
    if($auth == get_user_meta($user_id , 'order_details')){
        delete_user_meta($user_id , 'order_details');
        $item = get_market_item($item_id);
        if(! $item){
            echo 'Item not found';
            exit();
        }
        $status = update_market_item($item_id,$item->title,$item->user_id,$item->amount,$item->price,'sold');
        $fees = get_options('points_to_currency_fees');
        $credit = insert_into_credit($user_id, -$item->price - $fees, 'You Bought '.$item->amount.' points for '.$item->price.' $');
        $points = insert_user_wallet($item->user_id, $item->amount, 'You Bought '.$item->amount.' points for '.$item->price.' $');
        $income = set_option('income_from_fees', get_options('income_from_fees') + $fees);
        if($credit && $points && $income && $status){
            echo 'ok';
        }else{
            echo 'Something went wrong';
        }
    }else{
        user_rate($user_id, -5);
        echo 'Wrong auth';
    }
}