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
    $user = current_user();
    if(! $user){
        echo "<script>location.href = '/login.php'</script>";
    }
    if($user['id']==0){
        echo "<script>location.href = '/login.php'</script>";
        return;
    }
    $user_id = $user['id'];
    $user_name = $user['name'];
    $user_credit = get_user_credit($user_id);
    $user_points = user_points($user_id);
    ?>
    <style>
        .hint{
            font-size: 14px;
            color: #888;
        }
        .describe{
            font-size: 14px;
            color: #313131;
        }
    </style>

    <div class="form">
    <p class="hint">Count of Points that you want to sell it should be less than <?php echo $user_points;?> and make it looks like 100 or 1000 to help it published fast</p>
        <div class="input">
            <input type="number" name="points" id="count" max="<?php echo $user_points?>">
        </div>
        <p class="main">Price all points</p>
        <div class="input">
            <input type="number" name="price" id="price" value="" max='50' min='5'>
        </div>
        <p class="describe">The total value you will get after deducting fees who is <?php echo get_options('points_to_currency_fees');?></p>
        <div class="input">
            <input type="text" id='u_get' readonly>
        </div>
        <input type="hidden" name="fees" id="fees" value="<?php echo get_options('points_to_currency_fees');?>">

        <button id="sell">Sell</button>
        <p>By clicking this button you accept to deduct this count of points from your account until it's sold and real money will be added at that while</p>
    </div>
    <script>
        $('#price').change(()=>{
            var price = $('#price').val();
            var fees = $('#fees').val();
            var total = price - fees;
            $('#u_get').val(total);
        });

        $('#sell').click(()=>{
            var price = $('#price').val();
            var count = $('#count').val();
            $.post('/apis/add_to_market.php', {price: price, count: count}, (data)=>{
                $('.form').append(data);
            });
        });
    </script>

    <?php include_once 'footer.php'; ?>
</body>
</html>