<?php
header('Content-Type: application/json');

$all_content = '{"name": "", "path": "", "type": "dir", "children": ' . json_encode(listFolders('.')) . '}';

print_r($all_content);

function ignore($dir){
  $ignore_list = array('folder.php','.htaccess','.htpasswd','static','index.html');
  foreach($ignore_list as $start){
    if(strpos($start, $dir) === 0) return true;
  }
  return false;
}

function listFolders($dir)
{
    $dh = scandir($dir);
    $return = array();

    foreach ($dh as $folder) {
        if ($folder != '.' && $folder != '..' && !ignore($folder) && $folder != null && $dir != null) {
            if (is_dir($dir . '/' . $folder)) {
                $return[] = array(
                    'name' => $folder,
                    'path' => ltrim($dir, '.') . '/' . $folder,
                    'type' => 'dir',
                    'children' => listFolders($dir . '/' . $folder)
                );
            }elseif(is_file($dir . '/' . $folder)){
                $return[] = array(
                    'name' => $folder,
                    'path' => ltrim($dir, '.') . '/' . $folder,
                    'type' => 'file',
                );
            }
        }
    }
    return $return;
}
?>
