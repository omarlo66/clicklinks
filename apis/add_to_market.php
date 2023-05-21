<?php 
include_once '../options.php';
    if(isset($_POST['price']) && isset($_POST['count']) && current_user()['id'] != 0){
        
        $price = $_POST['price'];
        $count = $_POST['count'];
        $user_id = current_user()['id'];
        $user_points = user_points($user_id);

        if($count > $user_points){
            echo "<script> alert('You don\'t have this count of points') </script>";
            user_rate($user_id, -1);
            return;
        }

        $fees = get_options('points_to_currency_fees');
        $deduct = insert_user_wallet($user_id,-$count, "Sell $count points for $price $");
        $insert = insert_into_market("Sell $count points for $price $",$user_id, $count, $price);
        if($deduct && $insert){
                echo "ok";
                echo "<script>location.href='/'</script>";
        }elseif($deduct && ! $insert){
            insert_user_wallet($user_id,$count, "Sell $count points for $price $ failed");
            add_notification_to_user($user_id, 'notifications');
        }
    }
    if(isset($_POST['edit']) && current_user()){
        $id = $_POST['id'];
        $price = $_POST['price'];
        $count = $_POST['amount'];
        $user_id = current_user()['id'];
        $item = update_market_item($id, "Sell $count points for $price $",$user_id, $count, $price,'pending');
        if($item){
            echo 'ok';
        }else{
            echo 'Something went wrong';
        }
    }

    if(isset($_POST['delete']) && current_user()){
        $id = $_POST['id'];
        $item = delete_market_item($id);
        if($item){
            echo 'ok';
        }else{
            echo 'Something went wrong';
        }
    }
    ?>