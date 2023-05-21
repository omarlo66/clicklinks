<div class="form">
    <div class="input">
        <p>Payment method</p>
        <select id="payment_method">
            <?php
            require_once '../../options.php';
            $payment_methods = payment_methods();
            foreach($payment_methods as $payment_method){?>
                <option value="<?php echo $payment_method?>"><?php echo $payment_method?></option>
            <?php }?>
        </select>
    </div>
    <div class="input">
        <p>Amount</p>
        <input type="number" id="amount" value="5">
    </div>
    <div class="input">
        <p>Transaction ID</p>
        <input type="text" id="transaction_id">
        <input type="file" id="transaction_id_file">
        <p>It should be a transaction id from the payment 3rd party or a screenshot including time, date, amount and mobile number</p>
    </div>
    <input type="hidden" id="user_id" value="<?php echo $_GET['user_id'];?>">
    <input type="hidden" id="auth">
    <button onclick="submit_deposit()">Deposit</button>
</div>

<script>
    $('#auth').val(randomString(20));
    data = {
        user_id: $('#user_id').val()
    }
    $.post('/user/payments/deposit.php?auth='+$('#auth').val(), data , function(data){
        $('.auth').val(data);
    });
    function submit_deposit(){
        var payment_method = $('#payment_method').val();
        var amount = $('#amount').val();
        var transaction_id = $('#transaction_id').val();
        var user_id = $('#user_id').val();
        
        $.ajax({
            url: '/user/payments/deposit.php',
            type: 'POST',
            data: {
                payment_method: payment_method,
                amount: amount,
                transaction_id: transaction_id,
                transaction_id_file: transaction_id_file,
                user_id: user_id,
                auth: $('#auth').val()
            },
            success: function(data){
                alert(data);
            }
        })
    }

</script>
<?php

if(isset($_POST['auth']) && $_POST['auth'] == $_SESSION['auth']){
    $payment_method = $_POST['payment_method'];
    $amount = $_POST['amount'];
    $transaction_id = $_POST['transaction_id'];
    $transaction_id_file = $_FILES['transaction_id_file'];
    $user_id = $_POST['user_id'];
    $user = get_user($user_id);
    $auth = get_user_meta($user->id,'payment_auth');
    if($auth != $_POST['auth']){
        echo 'Invalid auth';
        if(get_user_meta($user->id,'payment_fake') == $_POST['auth']){
            echo 'You are not logged in';
            user_rate($user->id, -1);
        }
        die();
    }
    insert_into_payments($user_id, $payment_method, $amount, $transaction_id,'deposit','pending');
    update_user_meta($user_id, 'pending_balance', $amount + get_user_credit($user_id));


    echo 'Deposit added successfully';
}

if(isset($_GET['auth']) && isset($_POST['user_id'])){
    $user_id = $_POST['user_id'];
    $user = get_user($user_id);
    if($user){
        $new_auth = rand(10000000000000000000, 99999999999999999999);
        echo $new_auth;
        update_user_meta($user_id , 'payment_auth', $new_auth);
        update_user_meta($user_id , 'payment_fake', $_GET['auth']);
    }
    else{
        $user_id = current_user();
        if($user_id == 0 and isset($_GET['auth'])){
            echo 'You are not logged in';
            die();
        }
    }
}

?>