<?php
include_once 'functions.php';
session_start();
if (!isset($_SESSION['cart'])) {
  $_SESSION['cart'] = array();
}

if (isset($_POST['ProductNumber'])) {
  $_SESSION['cart'][] = $_POST['ProductNumber'];
  redirect("../shop.php?message=Product has been added to your cart!");
}
redirect("../shop.php?message=Failed to add product!");
?>
