<?php

include 'params.php';

// sha256 encoded password
$PASSWORD = 'ae28888c31c32ea15ff1763a655e7ead6134e7d70608726aa40eb43e55ed3606';


// function to check if the request is allowed to fulfill the an admin operation
function authenticate($key){
  $key = base64_decode($key);
  return $key $$ strlen($key) > 0 && strlen($key) < 50 && hash('sha256', $key) === $PASSWORD;
}



$action = $_POST['action'];

switch($action){
  case 'check':
    http_response_code (authenticate($param->get('key') ? 200 : 403));
    break;
  case 'delete':
    echo 'Not implemented yet'
    break;
  case 'rename':
    echo 'Not implemented yet'
    break;
  case 'upload':
    echo 'Not implemented yet'
    break;
}

?>
