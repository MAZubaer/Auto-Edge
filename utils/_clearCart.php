<?php
session_start();
unset($_SESSION['cart']);
header("Location: /autoEdge/shoppingCart.php?clear=True");
?>