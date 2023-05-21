<!DOCTYPE html>
<html lang="en">
<head>
    <?php include_once 'options.php';?>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Withdraw | <?php echo get_options('title');?></title>
</head>
<body>
    <?php include_once 'header.php';?>

    <h1>Withdraw you earnings</h1>
    <div class="form">
        <p>Amount:</p>
        <div class="input">
            <input type="number" id="amount">
        </div>
        <p>Payment Method:</p>
        <div class="input">
            <select id="payment_method">
                <option value="vodafone_cash">Vodafone Cash</option>
                <option value="paypal">Paypal</option>
                <option value="payeer">Payeer</option>
            </select>
        </div>
        <p>Account details:</p>
        <div class="input">
            <input type="text" id="account">
        </div>
        <input type="hidden" id="credit">
        <p class="hint">you can enter a phone number or email or id that we can send money to by using the payment method you choose.</p>
        <button onclick="withdraw()">Withdraw</button>
    </div>
    <script>
        function withdraw(){
            var amount = $('#amount').val();
            var payment_method = $('#payment_method').val();
            var account = $('#account').val();
            $.ajax({
                url: '/apis/withdraw.php',
                type: 'POST',
                data: {
                    amount: amount,
                    payment_method: payment_method,
                    account: account
                },
                success: function(data){
                    if(data == 'success'){
                        $('.form').html('<div class="notification success">Your request has been sent successfully, we will send you the money as soon as possible.</div>');
                    }else{
                        alert(data);
                    }
                }
            });
        }
        $('#amount').change(()=>{
            var amount = $('#amount').val();
            var credit = $('#credit').val();
            if(amount > credit){
                $('#amount').val(credit);
            }
        });
    </script>
    <?php
    include_once 'footer.php';
    ?>
</body>
</html>