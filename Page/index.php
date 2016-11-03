<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <title>FnJ Apotek</title>
  </head>
  <body>
    <?php include_once 'includes/header.php'; ?>
    <div class="main">

      <?php if (isset($_GET["message"])):?>
        <div class="message"> 
          <?php echo $_GET["message"]; ?>
        </div>
      <?php endif ?>

      <p><?php include('text/test_text.txt'); ?></p>
    </div>
  </body>
</html>
