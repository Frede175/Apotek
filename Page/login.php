<!--
  Please add something like header, menu, and more stoff
-->
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

      <form method="post" action="includes/login.php">
        <input id="CPR" name="CPR" type="text" placeholder="CPR"><br>
        <input id="password" name="password" type="password" placeholder="Password"><br>
        <input type="submit" name="submit">
      </form>
      <a href="register.php" class="signupin">Dont have an account? Sign up here!</a> <!-- FIX MARGIN -->
    </div>
  </body>
</html>