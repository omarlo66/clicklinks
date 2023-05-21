<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>
<body>
<script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="/assets/style.css">
<?php
require 'options.php';
if(isset($_GET['ref'])){
    require 'options.php';
    $ref = $_GET['ref'];
    $ref = get_user($ref);
    if($ref && $ref->id != 0){
        setcookie('ref', $ref->id , time() + (86400 * 30), "/");
    }
}
?>

    <h1>Register</h1>
    <div class="msg"></div>
    <div class="register_page">
    <div>
            <img src="/assets/register.png" alt="login">
    </div>
    <div class="register_form">
        
        <div class='input'>
            <i class="fa fa-user-circle" aria-hidden="true"></i>
            <input type="text" name="username" id="username" placeholder="Username">
        </div>
        <div style="height: 20px;"></div>
        <div class='input'>
            <i class="fa fa-envelope" aria-hidden="true"></i>
            <input type="email" name="email" id="email" placeholder="Email">
        </div>
        <div style="height: 20px;"></div>
        <div class='input'>
            <i class="fa fa-key" aria-hidden="true"></i>
            <input type="password" name="password" id="password" placeholder="Password">
        </div>
        <div style="height: 20px;"></div>
        <div class='input'>
            <i class="fa fa-key" aria-hidden="true"></i>
            <input type="password" name="password2" id="password2" placeholder="Confirm Password">
        </div>
        <div style="height: 20px;"></div>
        <div id='show_password'><i class="fa fa-eye" aria-hidden="true"></i></div>
        <div style="height: 20px;"></div>
        <button id="register">Register</button>
        <div style="height: 20px;"></div>
        <p>already have account <a href=" /login.php">Login</a></p>
    </div>
</div>
    <script>

        $('#password2').keyup(()=>{
        if($('#password').val() != $('#password2').val() ){
            $('#password2').css('border', '3px solid red');
        }
        else{
            $('#password2').css('border', '2px solid green');
        }});
        $('#show_password').click(()=>{
            if($('#password').attr('type') == 'text'){
                $('#password').attr('type', 'password');
                $('#password2').attr('type', 'password');
                $('#show_password').html('<i class="fa fa-eye" aria-hidden="true"></i>');
            }else{
                $('#password').attr('type', 'text');
                $('#password2').attr('type', 'text');
                $('#show_password').html('<i class="fa fa-eye-slash" aria-hidden="true"></i>');
            }
        });

        $('#register').click(()=>{
            let email = $('#email').val();
            if(email.includes('@') == false || email.includes('.') == false){
                $('.register_form').append('<p class="notification error">Email is not valid</p>');
                $('#email').css('border', '2px solid red');
                setInterval(()=>{$('.notification').remove()}, 5000);
                return;
            }
            if($('#password').val() != $('#password2').val() ){
                $('.register_form').append('<p class="notification error">Passwords do not match</p>');
                $('#password2').css('border', '2px solid red');
                setInterval(()=>{$('.notification').remove()}, 5000);
                return;
            }
            $.post('/apis/api-register.php',{username:$('#username').val(), email:$('#email').val(), password:$('#password').val()},
            (data)=>{
                if(data == 'success'){
                    $('.register_form').append('<p class="notification success"> You are registered now <a href="/login">now login</a></p>');
                }else{
                    $('.register_form').append('<p class="notification error">Something went wrong</p>');
                }
                    
                    setInterval(()=>{window.location.href='/login.php'}, 50000);
            }).fail(()=>{
                $('.register_form').append('<p class="notification error">Something went wrong</p>');
                setInterval(()=>{$('.notification').remove()}, 50000);
            });
        })
        $('input[type="text"]').keypress(function(e){
        if(e.key == "'" || e.key == '"'){//Enter key pressed
            $('.msg').html('<h3 class="notification error">You can\'t use this character</h3>');
            $('input[type="text"]').val('');
        }
        });
    </script>
    <?php include_once 'footer.php'?>
</body>
</html>