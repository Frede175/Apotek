<?php
  include_once 'functions.php';
  session_start();
  if (isset($_POST['product'])) {
    unset($_SESSION['cart'][array_search($_POST['product'], $_SESSION['cart'])]);
    redirect('../cart.php');
  }
  redirect('../cart.php?message=Failed');

?>
