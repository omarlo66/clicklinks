
<?php require_once 'options.php';?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="  /assets/style.css">
<script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
<script src="/assets/script/main.js"></script>
<header class="header">
    <div class="logo"> 
        <a href="/">
            <?php set_option('logo','/assets/logo.jpeg');?>
            <img src="<?php echo get_options('logo');?>" alt="<?php echo get_options('title'); ?>">
        </a>
    </div>
    <div class="user_menu">
        <?php
        include_once 'options.php';
        include_once 'menu.php';
        ?>
    </div>
    <div class="nav_menu_btn">
        <i class="fa fa-bars" aria-hidden="true"></i>
    </div>
</header>
<div class="sidebar"></div>
<script>
    $('.nav_menu_btn').click(()=>{
        let nav_bar = $('.sidebar');
        if($('.sidebar').hasClass('active')){
            $('.sidebar').removeClass('active');
            $('.sidebar').html('<i class="fa fa-bars" aria-hidden="true"></i>');
            $('.sidebar').html('');
            $('.sidebar').removeClass('active');
        }else{
            nav_bar.addClass('active');
            $('.sidebar').html('<i class="fa fa-times" aria-hidden="true"></i>');
            $('.sidebar').addClass('active');
            $('.sidebar').append('<div class="sub_menu">'+$('.user_menu').html()+'</div>');
        }
    });
</script>
<div class="user_menu"></div>
<div class="msg"></div>

<div id="body" class="body">

