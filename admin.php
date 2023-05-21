<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once 'options.php';?>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
</head>
<body>
    <script src='/assets/script/textarea.js'></script>
    <div class="admin_page">
    <?php
    require_once 'header.php';
    if(current_user()['role'] != 'admin'){
        header('Location: login.php');
    }
    ?>
    <h1>Admin panel</h1>
    
    <div class="admin_menu">
        <div id="web_settings">website settings</div>
        <div id="users_admin">users</div>
        <div id="links_admin">links</div>
        <div id="pages_admin">pages</div>
        <div id="ads">ads</div>
        <div id='payments'>Payments</div>
    </div>

    <div id="form">

    </div>
    

    <script>
        <?php
        if(isset($_GET['page'])){
            $page = $_GET['page'];
            echo "$('#form').addClass('form');";
            echo "$('.form').load('admin_$page.php');";
            if(in_array($page, ['deposits', 'withdarws', 'market'])){
                echo "$('#admin_form').load('admin/api/payments/$page.php?page=1&status=pending');";
            }
        }
        ?>
        $('#web_settings').click(function(){
            $('#form').addClass('form');
            $('.form').load('admin_settings.php');
        });
        $('#users_admin').click(function(){
            $('#form').addClass('form');
            $('.form').load('admin_users.php');
        });
        $('#links_admin').click(function(){
            $('#form').addClass('form');
            $('.form').load('admin_links.php');
        });
        $('#pages_admin').click(function(){
            $('#form').addClass('form');
            $('.form').load('admin_pages.php');
        });
        $('#ads').click(function(){
            $('#form').addClass('form');
            $('.form').load('ads_widget.php');
        });
        $('#payments').click(function(){
            $('#form').addClass('form');
            $('.form').load('credit_settings.php');
        });
    </script>
<?php
if(isset($_GET['delete_user'])){
    $id = $_GET['delete_user'];
    $sql->query("DELETE FROM users WHERE id = $id");
    header('location: admin.php');
}

include_once 'footer.php';
?>
</div>
</body>
</html>