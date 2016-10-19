<!--
  Please add something like header, menu, and more stoff
-->
<?php
  include_once 'includes/functions.php';
  include_once 'includes/db_connect.php';
  session_start();
  if (!isset($_SESSION['user_id'])) redirect("login.php?message=You need to be logged in to view the page!");
  if (!RequireKey($mysqli, array("ManageProducts"))) redirect("login.php?message=You don't have permission to access this page!");
?>

<html>
<head>
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <title>FnJ Apotek</title>
</head>

<body>

  <div class="main">
    <?php if (isset($_GET["message"])):?>
      <div class="message"> <!-- Needs to be styled -->
        <?php echo $_GET["message"]; ?>
      </div>
    <?php endif ?>


    <form method="post" action="includes/addProduct.php">
      <input id="ProductNumber" name="ProductNumber" type="text" placeholder="Product Number">
      <input id="Name" name="Name" type="text" placeholder="Name">
      <input id="Description" name="Description" type="text" placeholder="Description">
      <input id="stock" name="stock" type="text" placeholder="Stock">
      <input id="Price" name="Price" type="text" placeholder="Price">
      Prescription: <input id="Prescription" name="Prescription" type="checkbox" placeholder="Prescription">
      <input type="submit" name="submit">
    </form>
  </div>
</body>

</html>
