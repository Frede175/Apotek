<?php
  include_once "db_connect.php";
  include_once "functions.php";

  session_start();
  if (isset($_SESSION['user_id'])) {
    //Get user sec level:
    if (RequireKey($mysqli, array("ManageProducts"))) {
      $product_number = $_POST["ProductNumber"];
      $name = $_POST["Name"];
      $description = $_POST["Description"];
      $stock = $_POST["stock"];
      $price = $_POST["Price"];
      $prescription = $_POST["Prescription"];
      if (ctype_digit($product_number) && ctype_digit($stock) && is_numeric($price)) {
        //Checking if a product already exist with that name:
        $stmt_check = $mysqli->prepare("SELECT ProductNumber FROM Product WHERE ProductNumber = ?");
        $stmt_check->bind_param("i", $product_number);
        if ($stmt_check->execute()) {
          if ($stmt_check->affected_rows <= 0) {
            $stmt_check->close();
            if (!isset($prescription)) $prescription = false;
            $stmt = $mysqli->prepare("INSERT INTO Product (ProductNumber, Name, Description, Price, Prescription) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("issdi", $product_number, $name, $description, $price, boolval($prescription));
            if ($stmt->execute()) {
              if ($stmt->affected_rows == 1) {
                $stmt_stock = $mysqli->prepare("INSERT INTO Stock (ProductNumber, Stock) VALUES (?, ?)");
                $stmt_stock->bind_param("ii", $product_number, $stock);
                if ($stmt_stock->execute()) {
                  if ($stmt_stock->affected_rows == 1) {
                    redirect("../shop.php?message=Add Product success and stock is up to date!");
                  }
                }
                redirect("../shop.php?message=Add Product success. Stock not up to date!");
              }
              redirect('../AddProduct.php?message=Error! insert');
            }
            redirect('../AddProduct.php?message=Error!');
          }
          redirect("../AddProduct.php?message=Product already exist! ");
        }
        redirect('../AddProduct.php?message=Error!');
      }
      redirect('../AddProduct.php?message=Wrong values type!');
    }
    redirect('../login.php?message=You dont have permission to add a product!');
  }
  redirect('../login.php?message=You need to login!');
?>
