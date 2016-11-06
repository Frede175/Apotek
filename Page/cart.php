<?php
session_start();
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
      <p>Cart</p>
      <?php if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0): ?>
        <table>
          <thead>
            <tr>
              <th>Pruduct number</th>
              <th>Name</th>
              <th>Description</th>
              <th>Price</th>
              <td></td>
            </tr>
          </thead>
          <tbody>
            <?php
              $stmt = $mysqli->prepare("SELECT Name, Description, Price FROM Product WHERE ProductNumber = ?");
              $total_price = 0;
              foreach ($_SESSION['cart'] as $product) {
                $stmt->bind_param('i', $product);
                if ($stmt->execute()) {
                  $stmt->bind_result($name, $description, $price);
                  $stmt->fetch();
                  $total_price += $price;
                  $html =
                  "<tr>" .
                    "<td>" . $product . "</td>" .
                    "<td>" . $name . "</td>" .
                    "<td>" . $description . "</td>" .
                    "<td>" . $price . "</td>" .
                    "<td><form method='post' action='includes/remove_from_cart.php'><input type='hidden' name='product' value='". $product . "'/><input type='submit' value='remove'/></form></td>" .
                  "</tr>";
                  echo $html;
                }
              }
              $stmt->close();
            ?>
          </tbody>
        </table>
        <p>Total price: <?php echo $total_price; ?></p>
        <form method="post" action="includes/buy_cart.php">
          <input type="submit" value="Buy cart"/>
        </form>
      <?php else: ?>
        <p>Nothing in cart!</p>
      <?php endif; ?>
    </div>
  </body>
</html>
