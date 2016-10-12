<?php
  include_once 'db_connect';
  include_once 'function.php';
  session_start();
  $cpr; $passowrd; $password_confirm; $zipcode; $first_name; $last_name; $address;

  if (ctype_digit($cpr)) {
      $stmt = $mysqli->prepare("SELECT FirstName FROM User WHERE CPR = ?");
      $stmt->bind("i", $cpr);
      if ($stmt->execute()) {
        $stmt->bind_result($result);
        $stmt->fetch();
        $stmt->close();
        if ($mysqli->affected_rows == 0) {
          // Zipcode check if vaild and finding city name
          //Checking database first
          $stmt_zipcode = $mysqli->prepare("SELECT * FROM Zipcode WHERE Zipcode = ?");
          $stmt_zipcode->bind("i", $zipcode);
          $cityName = null;
          if ($stmt_zipcode->execute()) {
            $stmt_zipcode->bind_result($result_zipcode);
            $stmt_zipcode->fetch();
            $stmt_zipcode->close();
            if ($mysqli->affected_rows == 1) {
              $cityName = $result["Name"];
            }
          }
          //If not using api to look it up.
          if (cityName == null) {
            $cityName = FindCityName($zipcode)
            if ($cityName == null){
              return;//TODO add error and return to register page.
            }

            

          }



          $stmt_register = $mysqli->pepare("INSERT INTO User () VALUES ")
        }
        else {

        }
      }
  }
?>
