<?php
  include_once 'functions.php';
  include_once 'db_connect.php';
  session_start();
  if (!isset($_SESSION['user_id'])) redirect("../login.php?message=You need to be logged in to view the page!");
  if (!RequireKey($mysqli, array("Admin"))) redirect("../login.php?message=You don't have permission to access this page!");

  if (isset($_POST["rolesSelect"]) && isset($_POST["user_id"])) {
    $stmt = $mysqli->prepare("UPDATE user SET Roles_ID = ? WHERE ID = ?");
    $stmt->bind_param('ii', $_POST["rolesSelect"], $_POST["user_id"]);

    if (!($stmt->execute())) redirect("../users.php?message=Failed to update users role!");

    if ($stmt->affected_rows == 1) {
      redirect("../users.php?message=User role was updated!");
    }
    redirect("../users.php?message=Failed to update users role!");
  }
?>
