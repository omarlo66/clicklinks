<?php

include_once 'options.php';
$user_id = 0;
$traffic_role = 'user';
if(current_user() && current_user()['id'] != 0){
    $user_id = current_user()['id'];
    $traffic_role = current_user()['role'];
}
if($user_id !=0 && $traffic_role == 'admin'){
    admin_menu();
}elseif($user_id !=0 && $traffic_role == 'user'){
    user_menu();
}else{
    main_menu();
}
function main_menu(){
    ?>
    <div class='main_menu'>
    
    <?php
        echo "<a href='/'>Home</a>";
        echo "<a href='/contact_us'>Contact us</a>";
        echo "<a href='/about_us'>about us</a>";
        echo "<a href='/pages'>Blog</a>";
        echo "<a href='/login' class='login'>Login</a>";
    ?>
    
    </div>
    <?php
}


function user_menu(){
    ?>
    <div class='user_menu'>
    <?php
    if(current_user() && current_user()['id'] != 0){
        echo "<a href='/user/'>Dashboard</a>";
        echo "<a href='/add_link'>add link</a>";
        echo "<a href='/links'>links</a>";
        echo "<a href='/buy_points'>Market</a>";
        echo "<a href='/withdraw'>Withdraw</a>";
        echo "<a href='/deposit'>Deposit</a>";
        echo "<a href='/user/transactions'>transactions</a>";
        echo "<a href='/profile'>Profile</a>";
        echo "<a href='/logout'>Logout</a>";
    }else{
        echo "<a href='/login'>Login</a>";
        echo "<a href='/register'>Register</a>";
    }
    ?>
    </div>
    <?php
}

function admin_menu(){
    ?>
    <div class='admin_menu'>
    <?php
    if(current_user() && current_user()['id'] != 0){
        echo "<a href='/admin/'>Dashboard</a>";
        echo "<a href='/admin?page=users'>Users</a>";
        echo "<a href='/admin?page=links'>Links</a>";
        echo "<a href='/admin?page=transactions'>Transactions</a>";
        echo "<a href='/admin?page=withdraws'>Withdraws</a>";
        echo "<a href='/admin?page=deposits'>Deposits</a>";
        echo "<a href='/admin?page=settings'>Settings</a>";
        echo "<a href='/profile'>Profile</a>";
        echo "<a href='/logout'>Logout</a>";
    }else{
        echo "<a href='/login'>Login</a>";
        echo "<a href='/register'>Register</a>";
    }
    ?>
    </div>
    <?php
}
?>