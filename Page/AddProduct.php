<<?php
  $message = $_GET["message"]; //Use this to get the message from the server about error and success.
?>
<!--
  Please add something like header, menu, and more stoff
-->


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
      <input id="Price" name="Price" type="checkbox" placeholder="Price">
      <input type="submit" name="submit">
    </form>
  </div>
</body>

</html>
