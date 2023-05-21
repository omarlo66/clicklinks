
<!DOCTYPE html>
<html lang="en">
<head>

<?php 
    require 'options.php';
    $user = current_user();
    if($user['id']==0){
        echo "<script>location.href = '/login.php'</script>";
        return;
    }

    $user_name = $user['name'];
    $user_id = $user['id'];
    remove_old_clicks_from_user_meta();
    $user_credit = get_user_credit($user_id) > 0 ? get_user_credit($user_id) : 0;
?>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User | <?php echo $user_name?></title>
</head>
<body>
        <link rel="stylesheet" href=" /assets/style.css">
        <?php require 'header.php';?>
        <h3><?php echo "Welcome ".$user_name;?></h3>
    <div class="widget_anaytics">
        <?php
        $analytics = analytics();
        ?>
        <div class="dashboard_links">
            <p><?php echo $analytics['links'] + get_options('add_to_links');?></p>
            <p>Links</p></div>
        <div class="dashboard_users">
            <p><?php echo $analytics['users'] + get_options('add_to_users');?></p>
            <p>Active user</p></div>
        <div class="dashboard_points">
            <p><?php echo user_points($user_id);?></p>
            <p>Points</p>
        </div>
    </div>
    <?php echo "<div class='ad_widget'>".get_options('ad_1')."</div>";?>
        <?php
        $user_name = current_user()['name'];
        $user_email = current_user()['email'];
        $points = user_points(current_user()['id']);
        $links = get_link_by_user(current_user()['id']);
        ?>
    <div class="user_page">
        <?php 
        if(isset($_COOKIE['ref'])){
            $ref = $_COOKIE['ref'];
            $ref_user = get_user($ref);
            if($ref_user && $ref_user->id > 0){
                $user_id = current_user()['id'];
                add_referral($ref, $user_id);
                update_user_meta($user_id, 'ref_by', $ref);
                $ref_points = get_options('ref_points');
                update_points($user_id,get_options('new_ref_points'));
                    echo "<div><h3 class='points_added>  + ".get_options('new_ref_points')."</h3></div>";
                    ?>
                    <script>
                        $('.points_added')[0].css({color:'green',size:'24px',left:'25%',top:'5%'},3000);
                        setInterval(function(){
                            $('.notification')[0].css({color:'green',size:'24px',left:'-25',top:'5%'},3000);
                        }
                        , 10000);
                    </script>
                    <?php
                }
            setcookie('ref', '', time() - 3600, '/');
        }
        ?>

    <div class="Earning">   
        <h2>Your Points</h2>
            <div style='height:10px;'></div>
            <i class="fa fa-money" aria-hidden="true"></i><p class="points"> <span><?php echo $points;?></span> </p>
            <a href=" /links.php" class="links_btn">Link Exchange</a>
            <div style='height:10px;'></div>
    </div>
    <div class="credit">
        <h2>Your Credit</h2>
        <span><?php echo $user_credit;?></span>    
    </div>
    <?php echo "<div class='ad_widget'>".get_options('ad_3')."</div>";?>
    <div class="your_links">
        <h2>Your Links</h2>
        <div class="links_list">
        <?php
        $count = user_links_count(current_user()['id']);
        echo "<p>You have ( <span>$count</span> ) link</p>"
        ?>
        <a href=" /add_link.php" style="padding:0;"><button onclick="add_new_link()">add new link</button></a>
        <div style='height:20px;'></div>
        <a href=" /my_links.php">Your Links</a>
        <div style='height:10px;'></div>
    </div>

    <div class="ref_widget">
        <h2>Your refferals</h2>
            <div>
                <p><span><?php echo count_referrals($user_id)?></span></p>
            </div>
            <p>Refer your friends and earn <?php echo get_options('ref_points');?> points for each friend</p>
            <input type="text" value="<?php echo get_options('url').'register.php?ref='.$user_id;?>" id="ref_link" disabled>
            <button onclick="copy_ref()">Copy</button>
            <div style='height:10px;'></div>
    </div>
        
    <?php echo "<div class='ad_widget'>".get_options('ad_2')."</div>";?>

    <div class="market">
        <h2>Your points in market</h2>
        <span><?php echo count(get_market_items('user_id',$user_id,1000));?></span>
        <a href="/my_points.php">See more</a>
    </div>
    </div>
    <?php echo "<div class='ad_widget'>".get_options('ad_4')."</div>";?>
    <?php include_once 'footer.php'?>
    <script>
        function copy_ref(){
            var text_link = $('#ref_link').val();
            navigator.clipboard.writeText(text_link);
            $('.msg').html('<h3 class="notification success">Link copied</h3>');
            setInterval(function(){
                $('.notification').remove();
            }, 6000);
        }
        $.get('/user/wallet.php',(data)=>{
            ('.wallet').append(data);
        });
    </script>


</body>
</html>