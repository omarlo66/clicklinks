<?php

include_once '../../../options.php';
if(current_user() && current_user()['role'] != 'admin'){
    header('location:../../index.php');
    exit();
}
if(isset($_GET['page']) && isset($_GET['status'])){
    global $sql;
    $page = $_GET['page'];
    $status = $_GET['status'];
    $payments = $sql->query("SELECT * FROM payments WHERE status = '$status' and type='deposit' ORDER BY id DESC LIMIT 10");
    $payments = $payments->fetch_all(MYSQLI_ASSOC);

    echo "<table class='table table-striped table-bordered table-hover'>";
    echo "<tr>";
    echo "<th>user</th>";
    echo "<th>payment method</th>";
    echo "<th>amount</th>";
    echo "<th>transaction id</th>";
    echo "<th>transaction id file</th>";
    echo "<th>date</th>";
    echo "<th>actions</th>";
    echo "</tr>";
    foreach($payments as $payment){
        $user = get_user($payment['user_id']);
        echo "<tr>";
        echo "<td>".$user->name."</td>";
        echo "<td>".$payment['method']."</td>";
        echo "<td>".$payment['amount']."</td>";
        echo "<td>".explode(',',$payment['tansaction_id'])[0]."</td>";
        echo "<td><a href='uploads/?open=".explode(',',$payment['tansaction_id'])[1]."'>view</a></td>";
        echo "<td>".$payment['date']."</td>";
        echo "<td><a href='/admin/api/deposit.php?approve=".$payment['id']."'>approve</a> | <a href='/admin/api/deposit.php?status=rejected&id=".$payment['id']."'>reject</a></td>";
        echo "</tr>";
    }
    echo "</table>";

}

?>