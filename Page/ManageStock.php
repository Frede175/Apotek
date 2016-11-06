<?php
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';
session_start();
if (!isset($_SESSION['user_id'])) redirect("login.php?message=You need to be logged in to view the page!");
if (!RequireKey($mysqli, array("ManageStock"))) redirect("login.php?message=You don't have permission to access this page!");
$stmt = $mysqli->prepare("SELECT Product.ProductNumber, Product.Name, Product.Description , Stock.Stock FROM Product INNER JOIN Stock ON Product.ProductNumber = Stock.ProductNumber");

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
            <th>In stock</th>
            <td></td>
          </tr>
        </thead>
        <tbody>
          <?php
            $count = 0;
            while ($row = $result->fetch_array(MYSQLI_NUM)) {
              $html =
              "<tr>" .
                "<td>" . $row[0] . "</td>" .
                "<td>" . $row[1] . "</td>" .
                "<td>" . $row[2] . "</td>" .
                "<td>" . $row[3] . "</td>" .
                "<td><form method='post'>" .
                  "<input type='hidden' name='ProductNumber' value=" . $row[0] . ">" .
                  "<input type='text' name='amount' placeholder='Amount' value='1'/>" .
                  "<input type='submit' formaction='includes/add_to_stock.php' value='Add amount to stock'/>";
                  if ($row[3] > 0) $html .= "<button formaction='includes/remove_from_stock.php'>Remove form stock</button>";
                $html .= "</form></td>" .
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
