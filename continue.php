<title>Redirecting...</title>
<?php
function forward($location)
{
  $http = "http:/";
  $destiny = "";
  $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
  $host = "http://$_SERVER[HTTP_HOST]";
  $urlParts = explode('/', str_ireplace(array('http://', 'https://'), '', $location));
  $filtered_array = array_filter($urlParts);
  $formatted_array =  json_encode($filtered_array);
  $perfect_array =  json_decode($formatted_array, true);
  if (is_array($perfect_array)) {
    foreach ($perfect_array as $value) {
      $destiny .= "/" . $value;
      // return $destiny;
    }
    // echo $http.$destiny;
    header("location:$http$destiny");
  }
}
$redirect = true;
$rdr = false;
if (isset($_GET["continue"])) {
  $continue = $_GET["continue"];
  $rdr = true;
  if ($continue) {
    forward($continue);
    unset($continue);
  } else {
    forward(".");
  }
} else {
  echo "Redirection failed, Page locked!";
}
return true;
exit;
?>