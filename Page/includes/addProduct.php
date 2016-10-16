<<?php
  include_once "db_connect.php";
  include_once "functions.php";

  session_start();
  if (isset($_SESSION['user_id'])) {
    //Get user sec level:
    $AccessLevel = GetSecurityLevel($mysqli, $_SESSION['user_id']);
    if ($AccessLevel >= 1) {
      $product_number = $_POST["ProductNumber"];
      $name = $_POST["Name"];
      $description = $_POST["Description"];
      $stock = $_POST["stock"];
      $price = $_POST["Price"];
      $prescription = $_POST["Prescription"];
      if (ctype_digit($product_number) && is_bool($prescription) && ctype_digit($stock) && is_numeric($price)) {
        //Checking if a product already exist with that name:
        $stmt_check = $mysqli->prepare("SELECT ProductNumber FROM Product WHERE ProductNumber = ?");
        $stmt_check->bind_param("i", $product_number);
        if ($stmt_check->execute()) {
          if ($stmt_check->affected_rows == 0) {
            $stmt_check->close();

            $stmt = $mysqli->prepare("INSERT INTO Product (ProductNumber, Name, Description, Price, Prescription) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("issidi", $product_number, $name, $description, $price, boolval($prescription));
            if ($stmt->execute()) {
              if ($stmt->affected_rows == 1) {
                $stmt_stock = $mysqli->prepare("INSERT INTO Stock (ProductNumber, Stock) VALUES (?, ?)");
                $stmt_stock->bind_param("ii", $product_number, $stock);
                if ($stmt->execute()) {
                  if ($stmt->affected_rows == 1) {
                    header("Location: ../ViewProducts.php?message=Add Product success and stock is up to date!");
                  }
                }
                header("Location: ../ViewProducts.php?message=Add Product success. Stock not up to date!");
              }
              header('Location: ../AddProduct.php?message=Error!');
            }
            header('Location: ../AddProduct.php?message=Error!');
          }
          header("Location: ../AddProduct.php?message=Product already exist!");
        }
        header('Location: ../AddProduct.php?message=Error!');
      }
      header('Location: ../AddProduct.php?message=Wrong values type!');
    }
    header('Location: ../login.php?message=You dont have permission to add a product!');
  }
  header('Location: ../login.php?message=You need to login!');
?>
