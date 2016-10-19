<<?php
  include_once "db_connect.php";
  include_once "functions.php";
  session_start();

  if (isset($_POST["ProductNumber"]) && isset($_SESSION["user_id"]) && RequireKey($mysqli, array("ManageProducts"))) {
    $product_number = $_POST["ProductNumber"];
    $stmt = $mysqli->prepare("DELETE FROM Product WHERE ProductNumber = ?");
    $stmt->bind_param("i", $product_number);
    if ($stmt->execute()) {
      if ($stmt->affected_rows > 0) {
        redirect("../ViewProducts.php?message=Delete success");
      }
    }
  }
  redirect("../RemoveProduct.php?message=Delete failed");
?>
