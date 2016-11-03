<?php
    include_once 'includes/functions.php';
    include_once 'includes/db_connect.php';
    session_start();
    if (!isset($_SESSION['user_id'])) redirect("login.php?message=You need to be logged in to view the page!");
    if (!RequireKey($mysqli, array("Admin"))) redirect("login.php?message=You don't have permission to access this page!");

    //Select from database!
    $stmt = $mysqli->prepare("SELECT User.FirstName, User.LastName, Roles.Roles_ID, Roles.Name FROM User INNER JOIN Roles ON User.Roles_ID = Roles.ID");
    if (!$stmt->execute()) redirect("index?message=Error loading users!");
    
  ?>

<html>
<head>
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <title>FnJ Apotek</title>
</head>

  <!--nav menu TODO -->

  <body>

  </body>

</html>
