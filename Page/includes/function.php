<?php

function FindCityName($zipcode)
{
  $result = CallAPI("http://dawa.aws.dk/postnumre", array("nr" => $zipcode));
  $obj = json_decode($result);
  //Finding the name of the zipcode in the json returned by the api.
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



?>
