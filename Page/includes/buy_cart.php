<?php
include_once 'functions.php';
include_once 'db_connect.php';
session_start();
if (isset($_SESSION['cart'])) {
  $stmt = $mysqli->prepare("UPDATE Stock SET Stock = Stock - 1 WHERE ProductNumber = ?");
  foreach ($_SESSION['cart'] as $product) {
    $stmt->bind_param('i', $product);
    $stmt->execute();
    if (!($stmt->affected_rows == 1)) redirect("../cart.php?message=Error");
  }
  $stmt->close();
  unset($_SESSION['cart']);
  redirect("../shop.php?message=You have bought the cart!");
}
redirect("../cart.php?message=Error");
?>
