<!DOCTYPE html>
<html lang="en">
<head>
    <?php include_once 'options.php';?>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your points for Sale | <?php echo get_options('title');?></title>
</head>
<body>
    <?php include_once 'header.php';
    if(! current_user() || current_user()['id'] == 0){
        echo "<script>location.href = '/login.php'</script>";
        return;
    }
    $user_id = current_user()['id'];
    $per_page = isset($_GET['per_page']) ? $_GET['per_page'] : 10;
    $page = isset($_GET['page']) ? $_GET['page'] : 1;
    $user_points_in_market = get_market_items('user_id',$user_id,$per_page,$page);
    if(isset($_GET['edit'])){
        $item = get_market_item($_GET['edit']);
        ?>
            <div class="form">
                <p>Amount:</p>
                <div class="input">
                    <input type="number" id="amount" value="<?php echo $item->amount?>">
                </div>
                <p>Price:</p>
                <div class="input">
                    <input type="number" id="price" value="<?php echo $item->price?>">
                </div>
                <p>Remember this item will need revision again after edit.</p>
                <button onclick="update(<?php echo $item->id?>)">Update</button>
            </div>
        <?php
    }else{
    ?>
    <div class="market_page">
        <div class="market_page_title">
            <h2>Your points for sale</h2>
        </div>
        <div class="market_page_items">
            <?php
            if(count($user_points_in_market) == 0){
                echo "<div class='notification error'>You don't have any points for sale</div>";
            }else{
                foreach($user_points_in_market as $item){
                    $id = $item['id'];
                    echo "<div class='market_item'>";
                    echo "<div class='market_item_title'><h2>".$item['title']."</h2></div>";
                    echo "<div class='market_item_price'>Sell:".$item['amount']." Points</div>";
                    echo "<div class='market_item_price'> for: ".$item['price']."$ </div>";
                    echo "<div class='market_item_price'>Status: ".$item['status']."</div>";
                    echo "<button><a href='/my_points.php?edit=$id' >Edit</button>";
                    echo "<button><a href='/my_points.php?delete=$id' >Delete</button>";
                    echo "</div>";
                }
            }
            ?>
        </div>
    </div>
    <?php
    }
    ?>
    <script>
        function edit(item_id){
            location.href = '/my_points.php?edit='+item_id;
        }
        function update(id){
            let price = $('#price').val();
            let amount = $('#amount').val();
            $.post('/apis/add_to_market.php',{
                edit: id,
                price: price,
                amount: amount
            });
        }
        function delete_item(id){
            $.post('/apis/add_to_market.php',{
                delete: id
            },function(data){
                if(data == 'ok'){
                    location.href = '/my_points.php';
                }else{
                    alert(data);
                }
            });
        }
    </script>
</body>
</html>