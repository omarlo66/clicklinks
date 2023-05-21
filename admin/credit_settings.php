<div class="admin_form">
    <h2>Sell points Fees</h2>
    <div class="input">
        <p>How much fees to sell points to currency</p>
        <?php
            require_once '../options.php';
            $points_to_currency_fees = get_options('points_to_currency_fees');
            $vodafone_cash = get_options('vodafone_cash');
            $vodafone_cash_instruction = get_options('vodafone_cash_instruction');
            $paypal = get_options('paypal');
            $paypal_instruction = get_options('paypal_instruction');
            $payeer = get_options('payeer');
            $payeer_instruction = get_options('payeer_instruction');
            
            if(!$points_to_currency_fees){
                $points_to_currency_fees = 0;
            }
        ?>
        <input type="number" id='points_to_currency_fees' value="<?php echo $points_to_currency_fees?>">
    </div>
    <h2>Payment methods</h2>
    <p>Vodafone cash</p>
    <div class="input">
        <input type="text" id='vodafone_cash' value="<?php echo $vodafone_cash?>">
    </div>
    <p>Vodafone cash instruction</p>
    <div class="input">
        <input type="text" id='vodafone_cash_instruction' value="<?php echo $vodafone_cash_instruction?>">
    </div>
    <p>Paypal</p>
    <div class="input">
        <input type="text" id='paypal' value="<?php echo $paypal?>">
    </div>
    <p>Paypal instruction</p>
    <div class="input">
        <input type="text" id='paypal_instruction' value="<?php echo $paypal_instruction?>">
    </div>
    <p>Payeer</p>
    <div class="input">
        <input type="text" id='payeer' value="<?php echo $payeer?>">
    </div>
    <p>Payeer instruction</p>
    <div class="input">
        <input type="text" id='payeer_instruction' value="<?php echo $payeer_instruction?>">
    </div>
    <button id="update_settings">Save</button>
</div>
    <div>
        <button onclick="market()">
            Market pending points
        </button>
        <button onclick="load_deposits()">
            Deposits
        </button>
        <button onclick="withdraw()">
            Withdraws
        </button>
    </div>
<script>
    $('#update_settings').click(()=>{
        $.post('admin/api/payment_settings.php',{
            points_to_currency_fees: $('#points_to_currency_fees').val(),
            vodafone_cash: $('#vodafone_cash').val(),
            vodafone_cash_instruction: $('#vodafone_cash_instruction').val(),
            paypal: $('#paypal').val(),
            paypal_instruction: $('#paypal_instruction').val(),
            payeer: $('#payeer').val(),
            payeer_instruction: $('#payeer_instruction').val(),
        },(data)=>{
            console.log(data,$('#points_to_currency_fees').val());
            if(data == 'Updated Successfully'){
                $('.admin_form').append('<h3 class="notification success"><p> Updated Succefully </p></h3>');
            }else{
                $('.admin_form').append('<h3 class="notification error"><p> Error: Something hapened </p></h3>');
            }
            setInterval(function(){
                $('.notification').remove();
            }, 4000);
        });
    });
    function load_deposits(){
        $('.admin_form').load('admin/api/payments/deposit.php?page=1&status=pending');
    }
    function withdraw(){
        $('.admin_form').load('admin/api/payments/withdraw.php?page=1&status=pending');
    }
    function market(){
        $('.admin_form').load('admin/api/payments/market.php?page=1&status=pending');
    }

</script>