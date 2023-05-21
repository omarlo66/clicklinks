<?php
include_once '../header.php';
include_once '../options.php';
if(current_user() && current_user()['id'] == 0 || ! current_user()){
    echo "<script>location.href = '/login.php'</script>";
    return;
}

$user_name = current_user()['name'];
$user_id = current_user()['id'];

?>
<div class="wallet_options">
    <div onclick="location.href = '/user/transactions.php?points=1'">
    Points Transactions
    <?php echo user_points($user_id); ?>
    </div>
    <div onclick="location.href = '/user/transactions.php?credit=1'">
    Credit Transactions
    <?php echo get_user_credit($user_id); ?>
    </div>
</div>
<?php
if(isset($_GET['points'])){
    
    $per_page = 10;
    $page = 1;
    if(isset($_GET['per_page'])){
        $per_page = $_GET['per_page'];
    }
    if(isset($_GET['page'])){
        $page = $_GET['page'];
    }
    $points_transactions = get_user_transactions($user_id, $per_page, $page);
    $pages = get_user_points_transactions_pages($user_id, $per_page);
?>

<div class="points_transactions">
    <h2>Points Transactions</h2>
    <?php
    for( $i = $pages; $i > 0; $i--){
        echo "<a href='/user/transactions.php?points=1&per_page=$per_page&page=$i'>$i</a>";
    }
    ?>
    <table>
        <tr>
            <th>Transaction ID</th>
            <th>Points</th>
            <th>Reason</th>
            <th>Date</th>
        </tr>
        <?php
        if(! $points_transactions){
            echo "<tr><td colspan='4'>No Transactions</td></tr>";
        }
        foreach($points_transactions as $transaction){
            echo "<tr>";
            $color = $transaction['amount'] < 0 ? '#B22222' : '#32CD32';
            echo "<td>".$transaction['id']."</td>";
            echo "<td style='background: $color; color: white;'>".$transaction['amount']."</td>";
            echo "<td>".$transaction['title']."</td>";
            echo "<td>".$transaction['date']."</td>";
            echo "</tr>";
        }

        ?>
    </table>
    <div>
        <select name="per_page">
            <option value="10">10</option>
            <option value="20">20</option>
            <option value="50">50</option>
        </select>
        <button class="btn btn-primary" onclick="location.href = '/user/transactions.php?points=1&per_page='+this.previousElementSibling.value">Go</button>
    </div>

</div>

<?php
}
if(isset($_GET['credit'])){
    ?>
    <div class="credit">
    <?php
        $per_page = 10;
        $page = 1;
        if(isset($_GET['per_page'])){
            $per_page = $_GET['per_page'];
        }
        if(isset($_GET['page'])){
            $page = $_GET['page'];
        }
        $Credit_Trasnsactions = get_user_transactions_credit($user_id, $per_page, $page);
        $pages = get_user_credit_transactions_pages($user_id,$per_page);
    ?>

    <div class="points_transactions">
    <h2>Credit Transactions ( $ )</h2>
    <?php
    for( $i = $pages; $i > 0; $i--){
        echo "<a href='/user/transactions.php?credit=1&per_page=$per_page&page=$i'>$i</a>";
    }
    ?>
    <table>
        <tr>
            <th>Transaction ID</th>
            <th>Points</th>
            <th>Reason</th>
            <th>Date</th>
        </tr>
        <?php
        if(! $Credit_Trasnsactions){
            echo "<tr><td colspan='4'>No Transactions</td></tr>";
        }
            
        
        foreach($Credit_Trasnsactions as $transaction){
            echo "<tr>";
            $color = $transaction['amount'] < 0 ? '#B22222' : '#32CD32';
            echo "<td>".$transaction['id']."</td>";
            echo "<td style='background: $color; color: white;'>".$transaction['amount']."</td>";
            echo "<td>".$transaction['title']."</td>";
            echo "<td>".$transaction['date']."</td>";
            echo "</tr>";
        }

        ?>
    </table>
    <div>
        <select name="per_page">
            <option value="10">10</option>
            <option value="20">20</option>
            <option value="50">50</option>
        </select>
        <button class="btn btn-primary" onclick="location.href = '/user/transactions.php?credit=1&per_page='+this.previousElementSibling.value">Go</button>
    </div>

</div>
<?php
}
