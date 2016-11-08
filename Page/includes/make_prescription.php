<?php
include_once 'functions.php';
include_once 'db_connect.php';
session_start();
if (!isset($_SESSION['user_id'])) redirect("../login.php?message=You need to be logged in to view the page!");
if (!RequireKey($mysqli, array("MakePrescription"))) redirect("../login.php?message=You don't have permission to access this page!");

if (!empty($_POST['product_list'])) {
  if (count($_POST['product_list']) == 0) redirect("../make_prescription.php?message=You need to select aleast one product!");

  if (!ctype_digit($_POST['CPR'])) redirect("../make_prescription?message=CPR needs to be a number!");
  $stmt = $mysqli->prepare("SELECT CPR, ID FROM User WHERE CPR = ?");
  $stmt->bind_param('i', $_POST['CPR']);
  if (!($stmt->execute())) redirect("../make_prescription.php?message=ERROR!");
  $stmt->bind_result($CPR, $User_ID);
  $stmt->fetch();
  $stmt->close();
  if ($CPR - $_POST['CPR'] == 0) {
    $stmt = $mysqli->prepare("INSERT INTO Prescription (User_ID, Name, Description, Date, ExpirationDate) VALUES (?,?,?,?,?)");
    $now  = date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d"), date("Y")));
    $e = date("Y-m-d", mktime(0, 0, 0, date("m")+1  , date("d"), date("Y")));
    $stmt->bind_param('issss', $User_ID, $_POST['name'], $_POST['description'], $now, $e);
    if($stmt->execute()) {
      if ($stmt->affected_rows == 1) {
        $prescription_id = $mysqli->insert_id;
        $stmt->close();
        $stmt = $mysqli->prepare("INSERT INTO Product_has_Prescription (Product_ProductNumber, Prescription_ID) VALUES (?,?)");
        foreach ($_POST['product_list'] as $product) {
          $stmt->bind_param('ii', $product, $prescription_id);
          if (!($stmt->execute())) redirect("../make_prescription.php?message=ERROR!");
        }
        $stmt->close();
        redirect("../make_prescription.php?message=Success!");
      }
      redirect("../make_prescription.php?message=ERROR!");
    }

    redirect("../make_prescription.php?message=ERROR Execute!");

  }
  redirect("../make_prescription.php?message=No user with that CPR!");

}
redirect("../make_prescription.php?message=Please fill in the fields");
?>
