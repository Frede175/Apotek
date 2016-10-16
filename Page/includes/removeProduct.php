<<?php
  include_once "db_connect.php";
  include_once "functions.php";
  session_start();

  if (isset($_POST["ProductNumber"]) && isset($_SESSION["user_id"]) && GetSecurityLevel($_SESSION["user_id"]) >= 1) {
    $product_number = $_POST["ProductNumber"];
    $stmt = $mysqli->prepare("DELETE FROM Product WHERE ProductNumber = ?");
    $stmt->bind_param("i", $product_number);
    if ($stmt->execute()) {
      if ($stmt->affected_rows > 0) {
        header("Location: ../ViewProducts.php?message=Delete success");
      }
    }
  }
  header("Location: ../RemoveProduct.php?message=Delete failed");
?>
