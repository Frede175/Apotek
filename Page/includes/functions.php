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

/**
 * Gets the security level of the user
 * @param $mysqli  Connection
 * @param int $user_id
 * @return int Security level
 */
function GetSecurityLevel($mysqli, $user_id) {
  $stmt = $mysqli->prepare("SELECT Roles.AccessLevel FROM User INNER JOIN Roles ON User.Roles_ID = Roles.ID WHERE User.ID = ?");
  $stmt->bind_param("i", $user_id);
  if ($stmt->execute()) {
    $stmt->bind_result($result);
    $stmt->fetch();
    $stmt->close();
    if ($result != null) {
      return $result["AccessLevel"];
    }
  }
  return null;
}

?>
