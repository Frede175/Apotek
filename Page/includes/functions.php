<?php

function FindCityName($zipcode)
{
  $result = CallAPI("http://dawa.aws.dk/postnumre", array("nr" => $zipcode));
  $obj = json_decode($result);
  //Finding the name of the zipcode in the json returned by the api.
  if ($obj == null) return null;
  return $obj[0]->navn;
}



function CallAPI($url, $data = false)
{
  $curl = curl_init();
  if ($data) {
    $url = sprintf("%s?%s", $url, http_build_query($data));
  }

  curl_setopt($curl, CURLOPT_URL, $url);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

  $result = curl_exec($curl);
  curl_close($curl);
  return $result;
}

function GetFullName($mysqli, $userID) {
  $stmt = $mysqli->prepare("SELECT FirstName, LastName FROM User WHERE ID = ?");
  $stmt->bind_param('i', $userID);
  if (!($stmt->execute())) return "Error";
  $stmt->bind_result($FirstName, $LastName);
  $stmt->fetch();
  $stmt->close();
  return $FirstName . " " . $LastName;
}

/**
 * Get the differnet key the that user have
 * @param [type] $mysqli Connection
 * @param int $userID The user id
 * @return Array of keys that the user have.
 */
function GetUserKeys($mysqli, $userID) {
  $stmt = $mysqli->prepare(
  "SELECT
  	seckeys.Key
  FROM seckeys
	  INNER JOIN roles_has_seckeys ON roles_has_seckeys.SecKeys_Key = seckeys.Key
	  INNER JOIN roles ON roles.ID = roles_has_seckeys.Roles_ID
	  INNER JOIN user ON user.Roles_ID = roles.ID
  WHERE
	  user.ID = ?"
  );
  $stmt->bind_param('i', $userID);
  if (!($stmt->execute())) return array();
  $stmt->bind_result($key);
  $keys = array();
  while ($stmt->fetch()) {
    $keys[] = $key;
  }
  $stmt->close();
  return $keys;
}

/**
 * Specify the key to access the page.
 * @param [type] $mysqli Connection
 * @param array $keys An array of allowed keys
 * @return bool If the user has access to the page.
 */
function RequireKey($mysqli, $keys) {
  $userKeys = GetUserKeys($mysqli, $_SESSION['user_id']);
  foreach ($keys as $key) {
    foreach ($userKeys as $UserKey) {
      if ($key == $UserKey) return true;
    }
  }
  return false;
}

function HasRole($mysqli, $role) {
  $stmt = $mysqli->prepare("SELECT roles.Name FROM Roles INNER JOIN User ON User.Roles_ID = Roles.ID WHERE user.ID = ?");
  $stmt->bind_param("i", $_SESSION['user_id']);
  $stmt->execute();
  $stmt->bind_result($name);
  $stmt->fetch();
  $stmt->close();
  if ($role == $name) return true;
  return false;
}

function redirect($url)
{
   header('Location: ' . $url);
   die();
}

?>
