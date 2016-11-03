<html>
  <head>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <title>FnJ Apotek</title>
  </head>

  <body>
    <?php include_once 'includes/header.php'; ?>

    <div class="main">
      <?php if (isset($_GET["message"])):?>
        <div class="message"> <!-- Needs to be styled -->
          <?php echo $_GET["message"]; ?>
        </div>
      <?php endif ?>

      <form method="post" action="includes/register.php">
        <input id="CPR" name="CPR" type="text" placeholder="CPR"><br>
        <input id="first_name" name="first_name" type="text" placeholder="First name"><br>
        <input id="last_name" name="last_name" type="text" placeholder="Last name"><br>
        <input id="zipcode" name="zipcode" type="text" placeholder="Zipcode"><br>
        <input id="address" name="address" type="text" placeholder="Address"><br>
        <input id="password" name="password" type="password" placeholder="Password"><br>
        <input id="password_confirm" name="password_confirm" type="password" placeholder="Password confirm"><br>
        <input type="submit" name="submit">
      </form>
      <a href="login.php" class="signupin">Already have an account? Sign in here!</a> <!-- FIX MARGIN -->
    </div>
  </body>
</html>