<?php
  include_once 'db_connect';
  include_once 'functions.php';
  session_start();
  $cpr = $_POST["cpr"];
  $passowrd = $_POST["passowrd"];
  $password_confirm = $_POST["password_confirm"];
  $zipcode = $_POST["zipcode"];
  $first_name = $_POST["first_name"];
  $last_name = $_POST["last_name"];
  $address = $_POST["address"];

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
          //If the system does not know the zipcode, look it up with API.
          if (cityName == null) {
            $cityName = FindCityName($zipcode);
            if ($cityName == null){
              return;//TODO: add error and return to register page.
            }
            //Adding the city name and zipcode to the database.
            $stmt_city = $mysqli->prepare("INSERT INTO Zipcode (Zipcode, Name) VALUES (?, ?)");
            $stmt_city->bind_param("is", $zipcode, $cityName);

            if ($stmt_city->execute()) {
              if ($stmt_city->affected_rows != 1) { //ERROR in insert
                $stmt_city->close();
                return; //TODO: add error and return to register page.
              }
              $stmt_city->close();
            }

          }

          //Hashing password:
          $hash = password_hash($password, PASSWORD_DEFAULT, ['cost' => 12]);

          $stmt_register = $mysqli->pepare("INSERT INTO User (FirstName, LaastName, CPR, Password, Address, Zipcode, Roles_ID) VALUES (?,?,?,?,?,?,?)");
          //Making user have the role of user. Admin will need to change this if the user needs more access via. a page on the website.
          $stmt_register->bind_param("ssissii", $first_name, $last_name, $cpr, $hash, $address, $zipcode, 0);

          if ($stmt_register->execute()) {
            if ($stmt_register->affected_rows == 1) {
              //Registered and logged in
              $_SESSION["user_id"] = $mysqli->insert_id;
              $stmt_register->close();
              $mysqli->close();
              header("Location: ../index.php");
            }
          }

          $stmt_register->close();
        } else {

        }
      }
  }
?>
