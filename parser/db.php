<?php
$conn = mysqli_connect("localhost", "101mash_ru", "fastuser", "101mash_ru");
if($conn->connect_error){
    die("Ошибка: " . $conn->connect_error);
}
 //else echo "Подключение успешно установлено";
 //$conn->query("SELECT * FROM `lots_all`");


 /*$sql = "SELECT * FROM `lots_all` WHERE ID = 1";
 if($conn->query($sql)){   
 echo "Основные Данные успешно спаршены, + в бд поставлен";
 } else{
 echo "Ошибка: " . $conn->error;
 }
 $conn->close();*/

 //$conn->close();

