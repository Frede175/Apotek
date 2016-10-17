<?php
  include_once 'db_connect.php';
  include_once 'functions.php';
  session_start();
  $cpr = $_POST["CPR"];
  $password = $_POST["password"];
  $password_confirm = $_POST["password_confirm"];
  $zipcode = $_POST["zipcode"];
  $first_name = $_POST["first_name"];
  $last_name = $_POST["last_name"];
  $address = $_POST["address"];

  if (ctype_digit($cpr)) {
      $stmt = $mysqli->prepare("SELECT FirstName FROM User WHERE CPR = ?");
      $stmt->bind_param("i", $cpr);
      if ($stmt->execute()) {
        $stmt->bind_result($result);
        $stmt->fetch();
        $stmt->close();
        if ($result == null) {
          // Zipcode check if vaild and finding city name
          //Checking database first
          $stmt_zipcode = $mysqli->prepare("SELECT * FROM Zipcode WHERE Zipcode = ?");
          $stmt_zipcode->bind_param("i", $zipcode);
          $cityName = null;
          if ($stmt_zipcode->execute()) {
            $result_zipcode = $stmt_zipcode->get_result();
            $result_zipcode->fetch_assoc();
            $stmt_zipcode->close();
            if ($mysqli->affected_rows == 1) {
              $cityName = $result["Name"];
            }
          }
          //If the system does not know the zipcode, look it up with API.
          if ($cityName == null) {
            $cityName = FindCityName($zipcode);
            if ($cityName == null){
              redirect("../register.php?message=Can't find city!");
            }
            //Adding the city name and zipcode to the database.
            $stmt_city = $mysqli->prepare("INSERT INTO Zipcode (Zipcode, Name) VALUES (?, ?)");
            $stmt_city->bind_param("is", $zipcode, $cityName);

            if ($stmt_city->execute()) {
              if ($stmt_city->affected_rows != 1) { //ERROR in insert
                $stmt_city->close();
                redirect("../register.php?message=Error!");
              }
            }

          }

          //Hashing password:
          $hash = password_hash($password, PASSWORD_DEFAULT, ['cost' => 12]);

          $stmt_register = $mysqli->prepare("INSERT INTO User (FirstName, LastName, CPR, Password, Address, Zipcode_Zipcode, Roles_ID) VALUES (?,?,?,?,?,?,?)");
          //Making user have the role of user. Admin will need to change this if the user needs more access via. a page on the website.
          $roleID = 0;
          $stmt_register->bind_param("ssissii", $first_name, $last_name, $cpr, $hash, $address, $zipcode, $roleID);

          if ($stmt_register->execute()) {
            if ($stmt_register->affected_rows == 1) {
              //Registered and logged in
              $_SESSION["user_id"] = $mysqli->insert_id;
              $stmt_register->close();
              $mysqli->close();
              redirect("../index.php");
            }
          }
          redirect("../register.php?message=Error!");
        }
        redirect("../register.php?message=User is already registered!");
      }
      redirect("../register.php?message=Error!");
  }
  redirect("../register.php?message=CPR needs to be a number!");
?>
