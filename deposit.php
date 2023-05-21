<!DOCTYPE html>
<html lang="en">
<head>
    <?php include_once 'options.php';?>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deposit | <?php echo get_options('title');?></title>
</head>
<body>
    <?php include_once 'header.php';
    $vodafone_cash = get_options('vodafone_cash');
    $vc_inst = get_options('vodafone_cash_instruction');
    $paypal = get_options('paypal');
    $paypal_inst = get_options('paypal_instruction');
    $payeer = get_options('payeer');
    $payeer_inst = get_options('payeer_instruction');

    ?>
    <div>
        
        <div class="form">
        <select id="payment_method" class="payment_method">
            <option value="vodafone_cash">Vodafone Cash</option>
            <option value="paypal">Paypal</option>
            <option value="payeer" selected>Payeer</option>
        </select>
        <div id="payment_method_container" class="payment_method">
            <p id="account"></p>
            <p id="instruction"></p>
        </div>
            <p>Amount:</p>
            <div class="input">
                <input type="number" id="amount">
            </div>
            <p>Transaction Detaails:</p>
            <div class="input">
                <input type="text" id="transaction_id" placeholder="Transaction ID">
            </div>
            <p>Attach a proof screenshot for payment:</p>
            <div class="input">
                <input type="file" id="transaction_file">
            </div>
            <button onclick="deposit()">Deposit</button>
            <p class="hint">No fees applied in deposit.</p>
    </div>
    <script>
        $('#payment_method').change(function(){
            var method = $(this).val();
            if($('#payment_method').val() == 'vodafone_cash'){
                $('#account').html('<?php echo $vodafone_cash?>');
                $('#instruction').html('<?php echo $vc_inst?>');
            }else if($('#payment_method').val() == 'paypal'){
                $('#account').html('<?php echo $paypal?>');
                $('#instruction').html('<?php echo $paypal_inst?>');
            }else if($('#payment_method').val() == 'payeer'){
                $('#account').html('<?php echo $payeer?>');
                $('#instruction').html('<?php echo $payeer_inst?>');
            }
        });
        function deposit(){
            var payment_method = $('#payment_method').val();
            var amount = $('#amount').val();
            var transaction_id = $('#transaction_id').val();
            var transaction_file = $('#transaction_file')[0].files[0];
            console.log(transaction_file);
            if(payment_method == 'vodafone_cash'){
                if(amount == '' || transaction_id == '' || transaction_file == ''){
                    alert('Please fill all fields');
                    return;
                }
            }else{
                if(amount == '' || transaction_id == ''){
                    alert('Please fill all fields');
                    return;
                }
            }
            var data = new FormData();
            data.append('payment_method',payment_method);
            data.append('amount',amount);
            data.append('transaction_id',transaction_id);
            data.append('transaction_file',transaction_file);
            $.ajax({
                url: '/apis/deposit.php',
                type: 'POST',
                data: data,
                processData: false,
                contentType: false,
                success: function(data){
                    if(data == 'success'){
                        $('.form').html('');
                        $('.form').append('<h2 class="notification success">Your deposit request has been sent</h2>');
                        console.log(data);
                        /*setTimeout(function(){
                            window.location.href = '/user/';
                        },3000);*/
                    }else{
                        alert(data);
                    }
                }
            });
        }
    </script>
        <?php

include_once 'footer.php';

?>
</body>
</html>