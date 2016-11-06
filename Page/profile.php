<?php
  include_once 'includes/functions.php';
  include_once 'includes/db_connect.php';
  session_start();
  if (!isset($_SESSION['user_id'])) redirect("login.php?message=You need to be logged in to view the page!");

  $stmt = $mysqli->prepare("SELECT User.FirstName, User.LastName, User.CPR, User.Address, Zipcode.Zipcode, Zipcode.Name FROM User inner join zipcode on User.Zipcode_Zipcode = Zipcode.Zipcode WHERE ID = ?");
  $stmt->bind_param("i", $_SESSION['user_id']);

  if (!($stmt->execute())) redirect("index.php?message=Failed to load page!");
  $stmt->bind_result($FirstName, $LastName, $CPR, $Address, $Zipcode, $Zipcode_name);
  $stmt->fetch();
  $stmt->close();
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
      <h1>Profile</h1>

      <p>First name: <?php echo $FirstName; ?></p>
      <p>Last name: <?php echo $LastName; ?></p>
      <p>CPR: <?php echo $CPR; ?></p>
      <p>Address: <?php echo $Address; ?></p>
      <p>Zipcode: <?php echo $Zipcode; ?></p>
      <p>City: <?php echo $Zipcode_name; ?></p>
    </div>
  </body>
</html>
