<?php
include_once 'includes/functions.php';
include_once 'includes/db_connect.php';
session_start();
if (!isset($_SESSION['user_id'])) redirect("login.php?message=You need to be logged in to view the page!");
if (!RequireKey($mysqli, array("MakePrescription"))) redirect("login.php?message=You don't have permission to access this page!");
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

      

    </div>
  </body>
</html>
