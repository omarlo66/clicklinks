
<?php
include_once '../../../options.php';
if(current_user() && current_user()['role'] != 'admin' || !current_user()){
    header('location:../../../index.php');
    exit();
}
$status = 'pending';
$per_page = 10;
$page = 1;
if(isset($_GET['status'])){
    $status = $_GET['status'];
}
if(isset($_GET['per_page'])){
    $per_page = $_GET['per_page'];
}
if(isset($_GET['page'])){
    $page = $_GET['page'];
}
$type = 'withdraw';
$withdraws = get_payments('type',$type, $per_page, $page);

$pending = array();
$approved = array();
$rejected = array();

foreach($withdraws as $withdraw){
    if($withdraw['status'] == 'pending'){
        array_push($pending,$withdraw);
    }
    if($withdraw['status'] == 'approved'){
        array_push($approved,$withdraw);
    }
    if($withdraw['status'] == 'rejected'){
        array_push($rejected,$withdraw);
    }
}

?>

<div class="admin_menu">
    <div id="pending">Pending</div>
    <div id="approved">Approved</div>
    <div id="rejected">Rejected</div>
</div>

<div>
    <table>
        <tr>
        <th>User</th>
        <th>Amount</th>
        <th>Method</th>
        <th>Transaction ID</th>
        <th>Date</th>
        <th>action</th>
        </tr>
        <?php
        foreach($pending as $withdraw){
            $user = get_user($withdraw['user_id']);
            echo "<tr>";
            echo "<td>".$user->name."</td>";
            echo "<td>".$withdraw['amount']."</td>";
            echo "<td>".$withdraw['method']."</td>";
            echo "<td>".$withdraw['tansaction_id']."</td>";
            echo "<td>".$withdraw['date']."</td>";
            echo "<td><a href='/admin/api/withdraw.php?approve=".$withdraw['id']."'>approve</a> | <a href='/admin/api/withdraw.php?reject=".$withdraw['id']."'>reject</a></td>";
            echo "</tr>";
        }
        ?>
    </table>