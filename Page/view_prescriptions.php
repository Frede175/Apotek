<?php
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';
session_start();
if (!isset($_SESSION['user_id'])) redirect("login.php?message=You need to be logged in to view the page!");
if (isset($_POST['ID'])) {
  $stmt = $mysqli->prepare("SELECT Name, Description, Date, ExpirationDate FROM Prescription WHERE User_id = ? AND ID = ?");
  $stmt->bind_param('ii', $_SESSION['user_id'], $_POST['ID']);
  $stmt->execute();
  $stmt->bind_result($name, $description, $date, $expirationDate);
  $stmt->fetch();
  $stmt->close();

  $stmt = $mysqli->prepare("SELECT product.ProductNumber, product.Name, product.Description, product.Price, stock.Stock FROM product inner join product_has_prescription on product.ProductNumber = product_has_prescription.Product_ProductNumber INNER JOIN stock on stock.ProductNumber = product.ProductNumber WHERE product_has_prescription.Prescription_idPrescription = ?");
  $stmt->bind_param('i', $_POST['ID']);
  $stmt->execute();
  $result = $stmt->get_result();
}
else {
  $stmt = $mysqli->prepare("SELECT ID, Name, Description, Date, ExpirationDate FROM Prescription WHERE User_id = ?");
  $stmt->bind_param('i', $_SESSION['user_id']);
  $stmt->execute();
  $result = $stmt->get_result();
}

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
      <?php if (isset($_POST['ID'])): ?>
        <p><?php echo $name; ?></p>
        <p><?php echo $description; ?></p>
        <p>Date created: <?php echo $date; ?></p>
        <p>Expiration date: <?php echo $expirationDate; ?></p>
        <table>
          <thead>
            <tr>
              <th>ProductNumber</th>
              <th>Name</th>
              <th>Description</th>
              <th>Price</th>
            </tr>
          </thead>
          <tbody>
            <?php
              $total_price = 0;
              while ($row = $result->fetch_array(MYSQLI_NUM)) {
                if ($row[4] <= 0) $HTMLClass = "red"; else $HTMLClass = "green";
                $html =
                "<tr class=". $HTMLClass . ">" .
                  "<td>" . $row[0] . "</td>" .
                  "<td>" . $row[1] . "</td>" .
                  "<td>" . $row[2] . "</td>" .
                  "<td>" . $row[3] . "</td>" .
                "</tr>";
                echo $html;
                if ($row[4] > 0) $total_price += $row[3];
              }
            ?>
          </tbody>
        </table>

        <p>If you choose to buy the discription with any products marked with red, you agrees to that you will not get them!</p>
        <p>Total price: <?php echo $total_price; ?></p>
        <form method="post" action="includes/buy_prescription.php">
          <input type="hidden" name='ID' value="<?php echo $_POST['ID']; ?>"/>
          <input type="submit" value="Buy"/>
        </form>

      <?php else: ?>
        <p>Prescriptions</p>
        <table>
          <thead>
            <tr>
              <th>Name</th>
              <th>Description</th>
              <th>Date</th>
              <th>Expiration date</th>
              <td></td>
            </tr>
          </thead>
          <tbody>
            <?php
              $count = 0;
              while ($row = $result->fetch_array(MYSQLI_NUM)) {
                $html =
                "<tr>" .
                  "<td>" . $row[1] . "</td>" .
                  "<td>" . $row[2] . "</td>" .
                  "<td>" . $row[3] . "</td>" .
                  "<td>" . $row[4] . "</td>" .
                  "<td><form method='post' action='view_prescriptions.php'>" .
                    "<input type='hidden' name='ID' value=" . $row[0] . ">" .
                    "<input type='submit' value='Buy'>" .
                  "</form></td>" .
                "</tr>";
                echo $html;
                $count += 1;
              }

              if ($count == 0) {
                echo "<p>You don't have any prescriptions</p>";
              }
            ?>
          </tbody>
        </table>
      <?php endif; ?>
    </div>
  </body>
</html>
