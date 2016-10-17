<!--
  Please add something like header, menu, and more stoff
-->
<html>
<head>
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <title>FnJ Apotek</title>
</head>

<body>

  <div class="main">
    <?php if (isset($_GET["message"])):?>
      <div class="message"> <!-- Needs to be styled -->
        <?php echo $_GET["message"]; ?>
      </div>
    <?php endif ?>

    <form method="post" action="includes/register.php">
      <input id="CPR" name="CPR" type="text" placeholder="CPR">
      <input id="first_name" name="first_name" type="text" placeholder="First name">
      <input id="last_name" name="last_name" type="text" placeholder="Last name">
      <input id="zipcode" name="zipcode" type="text" placeholder="zipcode">
      <input id="address" name="address" type="text" placeholder="Address">
      <input id="password" name="password" type="password" placeholder="Password">
      <input id="password_confirm" name="password_confirm" type="password" placeholder="Password confirm">
      <input type="submit" name="submit">
    </form>
  </div>
</body>

</html>
