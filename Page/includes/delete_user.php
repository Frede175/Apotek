<?php
  include_once 'functions.php';
  include_once 'db_connect.php';
  session_start();
  if (!isset($_SESSION['user_id'])) redirect("../login.php?message=You need to be logged in to view the page!");
  if (!RequireKey($mysqli, array("Admin"))) redirect("../login.php?message=You don't have permission to access this page!");

  if (isset($_POST["user_id"])) {
    $stmt = $mysqli->prepare("DELETE FROM User WHERE ID = ?");
    $stmt->bind_param('i', $_POST["user_id"]);

    if ($stmt->execute())
      if ($stmt->affected_rows == 1) redirect("../users.php?message=User has been deleted!");
    redirect("../users.php?message=Failed to delete user! " . $stmt->error);
  }
?>
