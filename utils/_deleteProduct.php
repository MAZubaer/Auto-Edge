<?php
    include '_dbconnect.php';
    $id = $_POST['id'];
    $sql = "DELETE FROM `products` WHERE `product_id` = $id";
    $result = mysqli_query($conn, $sql);
    $script = $_POST["script"];
    $params = $_POST["params"];

    if($result){
        header("Location: /autoEdge/manageProduct.php?delete=true");
    }
    else{
        header("Location: /autoEdge/manageProduct.php?delete=false");
    }
?>