<?php
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=\"boincReport-".date('Y-m-d H:i:s').".csv\"");
$data=stripcslashes($_POST['csv_text']);
echo $data; 
?>