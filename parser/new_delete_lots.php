<?php
include_once 'db.php';

$sql = "SELECT * FROM `lots_all` WHERE date_to < NOW()";
if($conn->query($sql)){   
    echo $row_cnt = $conn->query($sql)->num_rows;
 } else echo "Ошибка: " . $conn->error;
?>