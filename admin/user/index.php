<?php

include_once '../../options.php';


if(current_user() && current_user()['role'] != 'admin' && current_user()['role'] == 'user'){
    $user_id = current_user()['id'];
    include_once '../options.php';
    user_rate($user_id,-1);
    header('location:../index.php');
    exit();
}
if(current_user() && current_user()['role'] == 'admin'){

    if(isset($_GET['id'])){
        $user_id = $_GET['id'];
        $user = get_user($user_id);
        echo "<h1>".$user->name."</h1>";
        echo "<h2>Balance of points: ".user_points($user_id)."</h2>";
        echo "<h2>Balance of currency: ".get_user_credit($user_id)."</h2>";
        echo "<h2>Rate: ".get_user_meta($user_id,'rate')."</h2>";
        echo "<h2>Role: ".$user['role']."</h2>";
        echo "<h2>last login: ".get_user_meta($user_id,'last_login')."</h2>";
        echo "<h2>last ip: ".get_user_meta($user_id,'last_ip')."</h2>";
        ?>
        <button onclick="send_email()">Send email to <?php echo $user->name?></button>
        <script>
            function send_email(){
                $('.body').append('<input type="text" name="subject" placeholder="Subject"><br>');
                $('.body').append('<textarea name="message" placeholder="Message"></textarea><br>');
                $('.body').append('<input type="hidden" name="user_id" value="<?php echo $user_id?>">');
                $('.body').append('<button onclick="send()">send</button>');
            }
            function send(){
                let subject = $('input[name="subject"]').val();
                let message = $('textarea[name="message"]').val();
                let user_id = $('input[name="user_id"]').val();
                $.post('',{send_email:true,subject:subject,message:message,user_id:user_id},function(data){
                    alert(data);
                })
            }
        </script>
        <?php
    }
    if(isset($_POST['send_email'])){
        $user_id = $_POST['user_id'];
        $subject = $_POST['subject'];
        $message = $_POST['message'];
        $user_id = $_POST['user_id'];
        $headers = 'From: '.get_options('admin_email'). "\r\n" .
        'Reply-To: '.get_options('admin_email'). "\r\n" .
        'X-Mailer: PHP/' . phpversion();
        $status = mail(get_user_meta($user_id,'email'),$subject,$message,$headers);
        if($status){
            echo "<script>alert('Email sent successfully')</script>";
        }else{
            echo "<script>alert('Email sent failed')</script>";
        }
    }
}
