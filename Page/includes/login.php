<?php
  include_once 'db_connect.php';
  include_once 'function.php';
  session_start();
  $cpr = $_POST["CPR"];
  if (ctype_digit($cpr)) {
    $stmt = $mysqli->prepare("SELECT Password FROM User WHERE CPR = ?");
    $stmt->bind_param("i",  $cpr);
    if ($stmt->execute()) {
      $stmt->bind_result($result);
      $stmt->fetch();
      $stmt->close();
      if ($mysqli->affected_rows == 1) {
        $password = $_POST['password'];
        $hash = password_hash($password, PASSWORD_DEFAULT, ['cost' => 12]);
        if ($hash == $result['Password']) {
            echo "Logged in";
        }
      }
    }


  }


?>
