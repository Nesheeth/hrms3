<?php 

$zip = new ZipArchive;
$res = $zip->open('hrms.zip');
if ($res === TRUE) {
  $zip->extractTo(getcwd());
  $zip->close();
  echo 'Done!';
} else {
  echo 'Not done!';
}