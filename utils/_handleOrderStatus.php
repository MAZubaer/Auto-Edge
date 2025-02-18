<?php
    include '_dbconnect.php';
    $orderId = $_POST['orderId'];
    $status = $_POST['status'];

    if($status == 'Not Delivered'){
        $sql = "UPDATE `orders` SET `order_status` = 'on the way' WHERE `orders`.`order_id` = $orderId";
        $result = mysqli_query($conn, $sql);
        if($result){
            header("Location: /autoEdge/manageOrder.php");
        }else{
            header("Location: /autoEdge/manageOrder.php?error=true");
        }
    }else if($status == 'on the way'){
        $sql = "UPDATE `orders` SET `order_status` = 'Complete' WHERE `orders`.`order_id` = $orderId";
        $result = mysqli_query($conn, $sql);
        if($result){
            header("Location: /autoEdge/manageOrder.php");
        }else{
            header("Location: /autoEdge/manageOrder.php?error=true");
        }
    }else{
        header("Location: /autoEdge/manageOrder.php?error=true");
    }
?>