<?php
include_once 'functions.php';
include_once 'db_connect.php';
session_start();
if (!isset($_SESSION['user_id'])) redirect("../login.php?message=You need to be logged in to view the page!");
if (!RequireKey($mysqli, array("ManageStock"))) redirect("../login.php?message=You don't have permission to access this page!");

if (isset($_POST['amount']) && isset($_POST['ProductNumber'])) {
  if (!(ctype_digit($_POST['amount']))) redirect("../ManageStock.php?message=Amount needs to be a number!");

  $stmt = $mysqli->prepare("SELECT Stock FROM Stock WHERE ProductNumber = ?");
  $stmt->bind_param('i', $_POST['ProductNumber']);
  $stmt->execute();
  $stmt->bind_result($stock);
  $stmt->fetch();
  $stmt->close();
  if ($stock > 0) {
    $remove = $_POST['amount'];
    $remove = $stock - $remove;
    if ($remove < 0) $remove = 0;
    $stmt = $mysqli->prepare("UPDATE Stock SET Stock = ? WHERE ProductNumber = ?");
    $stmt->bind_param('ii', $remove, $_POST['ProductNumber']);
    $stmt->execute();
    if ($stmt->affected_rows == 1) redirect("../ManageStock.php?message=Stock updated");
    $stmt->close();
  }

}
redirect("../ManageStock.php?message=Failed to update stock");
?>
