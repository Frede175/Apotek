<?php
include_once 'functions.php';
include_once 'db_connect.php';
session_start();
if (!isset($_SESSION['user_id'])) redirect("../login.php?message=You need to be logged in to view the page!");

if (isset($_POST['ID'])) {
  $stmt = $mysqli->prepare("SELECT product.ProductNumber, stock.Stock FROM product INNER JOIN product_has_prescription ON product.ProductNumber = product_has_prescription.Product_ProductNumber INNER JOIN stock ON product.ProductNumber = stock.ProductNumber INNER JOIN prescription ON product_has_prescription.Prescription_idPrescription = prescription.idPrescription WHERE product_has_prescription.Prescription_idPrescription = ? AND prescription.User_ID = ?");
  $stmt->bind_param('ii', $_POST['ID'], $_SESSION['user_id']);
  $stmt->execute();
  $result = $stmt->get_result();
  $stmt->close();
  $stmt = $mysqli->prepare("UPDATE stock SET stock = stock - 1 WHERE ProductNumber = ?");
  while ($row = $result->fetch_array(MYSQLI_NUM)) {
    if ($row[1] > 0) {
      $stmt->bind_param('i', $row[0]);
      $stmt->execute();
    }
  }
  $stmt->close();
  redirect("../view_prescriptions.php?message=You have bought your prescription");
}
redirect("../view_prescriptions.php?message=Error");

?>
