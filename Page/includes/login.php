<?php
  include_once 'db_connect.php';
  include_once 'functions.php';
  session_start();
  $cpr = $_POST["CPR"];
  if (ctype_digit($cpr)) {
    $stmt = $mysqli->prepare("SELECT ID, Password FROM user WHERE CPR = ?");
    $stmt->bind_param("i", $cpr);
    if ($stmt->execute()) {
      $stmt->bind_result($ID, $dbpassword);
      $stmt->fetch();
      if (isset($ID) && $ID != null) {
        $password = $_POST['password'];
        if (password_verify($password, $dbpassword)) {
            $_SESSION["user_id"] = $ID;
            redirect("../index.php");
        }
      }
      redirect("../login.php?message=Wrong CPR or password");
    }
    redirect("../login.php?message=Error ");

  }
  redirect("../login.php?message=CPR needs to be a number");



?>
