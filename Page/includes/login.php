<?php
  include_once 'db_connect.php';
  session_start();
  echo 'Hello';
  $cpr = $_POST["CPR"];
  echo $cpr;
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
