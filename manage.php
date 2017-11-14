<?php

// function to check if the request is allowed to fulfill the an admin operation
function authenticate($token, $is_encoded=true){
  return $token && hash('sha256', $token) === 'ae28888c31c32ea15ff1763a655e7ead6134e7d70608726aa40eb43e55ed3606';
}

// renames a file or directory, the path should already contain the name, return false when failed, true otherwise
function change_name($path, $to){
  $name_len = strrpos($path, basename($path));
  $path_len = strlen($path);
  if($path_len === 0 || $name_len === false) return false;
  $new_path = substr($path, -$name_len) . $to;
  return rename($path, $new_path);
}

// remove a file or directory
function remove($path){
  if($is_dir($path)){
    return rmdir($path);
  }else{
    return unlink($path);
  }
}

$action = urldecode($_POST['action']);
$key = base64_decode(urldecode($_POST['key']));
$path = urldecode($_POST['path']);

switch($action){
  case 'check':
    if(authenticate($key)){
      http_response_code(204);
    }else{
      http_response_code(403);
      echo $key . ' is not accepted';
    }
    break;
  case 'delete':
    echo 'Not implemented yet';
    break;
  case 'rename':
    if(authenticate($key)){
      change_name($path, $_POST['name']) ? http_response_code(204) : http_response_code(400);
    }else{
      http_response_code(403);
    }
    break;
  case 'upload':
    echo 'Not implemented yet';
    break;
  case 'create':
    echo 'Not implemented yet';
    break;
}

?>
