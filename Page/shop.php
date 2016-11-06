<?php
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';
session_start();

$stmt = $mysqli->prepare("SELECT Product.ProductNumber, Product.Name, Product.Description, Product.Price, Product.Prescription, Stock.Stock FROM Product INNER JOIN Stock ON Product.ProductNumber = Stock.ProductNumber");

if (!($stmt->execute())) redirect("index.php?message=Failed to load shop!");
$result = $stmt->get_result();

?>


<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <title>FnJ Apotek</title>
  </head>
  <body>
    <?php include_once 'includes/header.php'; ?>
    <div class="main">
      <?php if (isset($_GET["message"])):?>
        <div class="message"> <!-- Needs to be styled -->
          <?php echo $_GET["message"]; ?>
        </div>
      <?php endif ?>
      <p>Shop</p>
      <table>
        <thead>
          <tr>
            <th>Pruduct number</th>
            <th>Name</th>
            <th>Description</th>
            <th>Price</th>
            <th>In stock</th>
            <td></td>
          </tr>
        </thead>
        <tbody>
          <?php
            $count = 0;
            while ($row = $result->fetch_array(MYSQLI_NUM)) {
              if (!$row[4]) continue;
              $html =
              "<tr>" .
                "<td>" . $row[0] . "</td>" .
                "<td>" . $row[1] . "</td>" .
                "<td>" . $row[2] . "</td>" .
                "<td>" . $row[3] . "</td>" .
                "<td>" . $row[5] . "</td>" .
                "<td><form method='post' action='includes/add_to_cart.php'>" .
                  "<input type='hidden' name='ProductNumber' value=" . $row[0] . ">" .
                  "<input type='submit' value='Add to cart'>" .
                "</form></td>" .
              "</tr>";
              echo $html;
              $count += 1;
            }

            if ($count == 0) {
              echo "<p>No products available</p>";
            }
          ?>
        </tbody>
      </table>
    </div>
  </body>
</html>
