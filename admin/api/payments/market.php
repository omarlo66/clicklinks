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
if(isset($_GET['approve'])){
    $id = $_GET['approve'];
    $item = get_market_item($id);
    if(! $item){
        echo 'Item not found';
        exit();
    }
    $status = update_market_item($id,$item->title,$item->user_id,$item->amount,$item->price,'approved');
    if($status){
        echo 'Approved';
    }else{
        echo 'Something went wrong';
    }
}
if(isset($_GET['reject'])){
    $id = $_GET['reject'];
    $item = get_market_item($id);
    $status = update_market_item($id,$item['title'],$item['user_id'],$item['amount'],$item['price'],'rejected');
    if($status){
        echo 'rejected';
    }else{
        echo 'Something went wrong';
    }
}
$market_items_pending = get_market_items('status', $status, $per_page, $page);
?>

<div class="admin_menu">
    <div id="pending">Pending</div>
    <div id="approved">Approved</div>
    <div id="Sold">Sold</div>
</div>
<div>
    <table>
        <tr>
        <th>User</th>
        <th>Amount</th>
        <th>Price</th>
        <th>Date</th>
        <th>action</th>
        </tr>
        <?php
        if(! $market_items_pending){
            echo '<tr><td colspan="4">No items</td></tr>';
        }
        foreach($market_items_pending as $item){
            $user = get_user($item['user_id']);
            echo '<tr>';
            $username = $user->name;
            echo '<td><a href="/admin/user/?id='.$user->id.'" target="__blank">'.$username.'</a></td>';
            echo '<td>'.$item['amount'].'</td>';
            echo '<td>'.$item['price'].'</td>';
            echo '<td>'.$item['date'].'</td>';
            echo '<td><button onclick="approve('.$item['id'].')">approve</button><button onclick="reject('.$item['id'].')">reject</button></td>';
            echo '</tr>';
        }
        ?>
    </table>
    <script>
        $('#pending').click(function(){
            $('.form').load('/admin/api/payments/market.php?status=pending');
        });
        $('#approved').click(function(){
            $('.form').load('/admin/api/payments/market.php?status=approved');
        });
        $('#Sold').click(function(){
            $('.form').load('/admin/api/payments/market.php?status=sold');
        });
        function approve(id){
            $.get('admin/api/payments/market.php?approve='+id, (data)=>{
                alert(data);
            });
        }
        function reject(id){
            $.get('admin/api/payments/market.php?reject='+id, (data)=>{
                alert(data);
            });
        }
    </script>
</div>