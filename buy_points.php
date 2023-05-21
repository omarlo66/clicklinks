<!DOCTYPE html>
<html lang="en">
<head>
    <?php include_once 'options.php';?>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Market | <?php echo get_options('title');?></title>
</head>
<body>
    <?php
    require_once 'header.php';
    if($user['id']==0){
        echo "<script>location.href = '/login.php'</script>";
        return;
    }
    $user_id = $user['id'];
    $user_name = $user['name'];
    $user_credit = get_user_credit($user_id);
    if($user_credit < 5){
        echo "<div class='notification error'> You may need to make a deposit to buy points <a href='/user.php'>Ok</a></div>";
    }
    if(isset($_GET['item_id'])){
        $item = get_market_item($_GET['item_id']);
        if(! $item){
            echo "<div class='notification error'>Item not found</div>";
            return;
        }
        if($user_credit < $item->price){
            echo "<div class='notification error'> You may need to make a deposit to buy points <a href='/deposit.php'>make a deposit</a></div>";
        }else{
            $auth = random_int(100000,999999);
            update_user_meta($user_id,'order_details',$auth);
            echo "<div class='market_item'>";
            echo "<div class='market_item_title'><h2>".$item->title."</h2></div>";
            echo "<div class='market_item_price'>Buy:".$item->amount." Points</div>";
            echo "<div class='market_item_price'> for: ".$item->price."$ </div>";
            echo "<p>After you buy this you will have ".user_points($user_id) + $item->amount." points and ".$user_credit - $item->price."$ to continue press buy</p>";
            echo "<button onclcick='buy_points(".$item->id.")'>Buy</button>";
            echo "</div>";
        ?>
        <script>
            function buy_points(item_id){
                $.post('/apis/buy_points.php',{item_id:item_id,auth:'<?php echo $auth?>'},function(data){
                    if(data == 'ok'){
                        location.href = '/user.php';
                    }else{
                        alert('Something went wrong');
                    }
                });
            }
        </script>
        <?php
        }
    }else{

    ?>
    
    <div class="market_page">
        <?php
        $per_page = isset($_GET['per_page']) ? $_GET['per_page'] : 10;
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $points = user_points($user_id);
        $credit = get_user_credit($user_id);
        $price = get_options('points_to_currency_fees');
        $exchanges = get_market_items();
        if(! $exchanges){
            echo "<div class='notification error'> No items found </div>";
        }else{
            foreach($exchanges as $exchange){
                //echo json_encode($exchange);
                echo "<div class='market_item'>";
                echo "<div class='market_item_title'><h2>".$exchange['title']."</h2></div>";
                echo "<div class='market_item_price'>Buy:".$exchange['amount']." Points</div>";
                echo "<div class='market_item_price'> for: ".$exchange['price']."$ </div>";
                echo "<button><a href='/buy_points.php?item_id=".$exchange['id']."'>Buy</a></button>";
                echo "</div>";
            }
        }
        
        
        ?>
    </div>
    <?php }
    include_once 'footer.php';?>
</body>
</html>