<?php
include_once 'includes/functions.php';
include_once 'includes/db_connect.php';
session_start();
if (!isset($_SESSION['user_id'])) redirect("login.php?message=You need to be logged in to view the page!");
if (!RequireKey($mysqli, array("MakePrescription"))) redirect("login.php?message=You don't have permission to access this page!");

$stmt = $mysqli->prepare("SELECT Product.ProductNumber, Product.Name, Product.Description, Product.Price FROM Product");
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();
?>
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

      <form method="post" action="includes/make_prescription.php">
        <input type="text" name="name" placeholder="Name"/>
        <input tyoe="text" name="description" placeholder="Description"/>
        <input type="text" name="CPR" placeholder="CPR" />

        <table>
          <thead>
            <tr>
              <th>
                Product Number
              </th>
              <th>
                Name
              </th>
              <th>
                Description
              </th>
              <th>
                Price
              </th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <?php
              while($row = $result->fetch_array(MYSQLI_NUM)) {
                $html =
                "<tr>" .
                "<td>" . $row[0] . "</td>" .
                "<td>" . $row[1] . "</td>" .
                "<td>" . $row[2] . "</td>" .
                "<td>" . $row[3] . "</td>" .
                "<td><input type='checkbox' name='product_list[]' value='" . $row[0] . "' ></td>" .
                "</tr>";
                echo $html;
              }
            ?>
          </tbody>
        </table>

        <input type="submit" value="Make prescription" />
      </form>

    </div>
  </body>
</html>
