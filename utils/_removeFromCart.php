<?php
session_start();
include '_dbconnect.php';

 if(isset($_POST["removeId"])){
        $id = $_POST["removeId"];
        $item = $_SESSION['cart'][$id];
        if(in_array($item, $_SESSION['cart'])){
            unset($_SESSION['cart'][$id]);
            header("Location: /autoEdge/shoppingCart.php?remove=True");
        exit();}
        
    }
header("Location: /autoEdge/shoppingCart.php?remove=False");
exit();

?>