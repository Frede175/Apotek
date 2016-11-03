<?php
    include_once 'includes/functions.php';
    include_once 'includes/db_connect.php';
    session_start();
    if (!isset($_SESSION['user_id'])) redirect("login.php?message=You need to be logged in to view the page!");
    if (!RequireKey($mysqli, array("Admin"))) redirect("login.php?message=You don't have permission to access this page!");

    //Select roles from database!
    $stmt = $mysqli->prepare("SELECT ID, Name FROM Roles");
    $stmt->execute();
    $result = $stmt->get_result();
    $roles = array();
    while ($row = $result->fetch_array(MYSQLI_NUM)) {
      $roles[] = array($row[0], $row[1]);
    }
    $stmt->close();


    //Select users from database!
    $stmt = $mysqli->prepare("SELECT User.FirstName, User.LastName, Roles.Name, Roles.ID FROM User INNER JOIN Roles ON User.Roles_ID = Roles.ID");

    $stmt->execute();
    //if (false) redirect("index?message=Error loading users!");
    $result = $stmt->get_result();
  ?>

<html>
<head>
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <title>FnJ Apotek</title>
</head>

  <!--nav menu TODO -->

  <body>
    <?php include_once 'includes/header.php'; ?>
    <div class="main">

      <?php if (isset($_GET["message"])):?>
        <div class="message"> <!-- Needs to be styled -->
          <?php echo $_GET["message"]; ?>
        </div>
      <?php endif ?>

      <h2>Users</h2>

      <table>
        <thead>
          <tr>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Has role</th>
            <th>Set role</th>
          </tr>
        </thead>
        <tbody>
          <?php
            //Getting the data from the server.
            while ($row = $result->fetch_array(MYSQLI_NUM)) {
              $html = "<tr>";
              $html .= "<td>" . $row[0] . "</td>";
              $html .= "<td>" . $row[1] . "</td>";
              $html .= "<td>" . $row[2] . "</td>";

              //Making a option to change the role for the user and delete the user!
              $html .=
              "<td>" .
                "<form method='post' action='includes/update_role.php'>" .
                  "<select name='rolesSelect'>";
                  foreach ($roles as $role) {
                    $html .= "<option value='". $role[0] ."'> " . $role[1] . "</option>";
                  }
                  $html .= '</select>' .
                  "<input type='hidden' name='user_id' value='" . $row[3] . "'/>" .
                  "<input type='submit' value='Change user role'/>" .
                "</form>" .
                "<form method='post' action='includes/delete_user.php'>" .
                  "<input type='hidden' name='user_id' value='" . $row[3] . "'/>" .
                  "<input type='submit' value='Delete user'/>" .
                "</form>" .
              "</tr>";
              echo $html;
            }
          ?>
        </tbody>
      </table>
    </diV>


  </body>

</html>
