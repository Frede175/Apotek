<?php
  include_once 'db_connect.php';
  include_once 'functions.php';
  session_start();
  $cpr = $_POST["CPR"];
  if (is_digits($cpr)) {
    $stmt = $mysqli->prepare("SELECT ID, Password FROM User WHERE CPR = ?");
    $stmt->bind_param("i", $cpr);
    if ($stmt->execute()) {
      $stmt->bind_result($result);
      $stmt->fetch();
      $stmt->close();
      if ($mysqli->affected_rows == 1) {
        $password = $_POST['password'];
        $hash = password_hash($password, PASSWORD_DEFAULT, ['cost' => 12]);
        if ($hash == $result['Password']) {
            $_SESSION["user_id"] = $result["ID"];
            header("Location: ../index.php");
        }
      }
      header("Location: ../login.php?message=Wrong CPR or password");
      return;
    }
    else {
      header("Location: ../login.php?message=Error");
    }
  }
  else {
    header("Location: ../login.php?message=CPR needs to be a number");
  }


?>
