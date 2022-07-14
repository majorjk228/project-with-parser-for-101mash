<?php
include_once 'simple_html_dom.php';
//set_time_limit(100);

function curlGetArcticles($url)
{
$ch = curl_init();
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//curl_setopt($ch, CURLOPT_PROXY,"91.238.98.62:8000");
//curl_setopt($ch, CURLOPT_PROXYUSERPWD, "aEktnq:BSBB14");
curl_setopt($ch, CURLOPT_PROXY,"188.120.226.59:3128");
//curl_setopt($ch, CURLOPT_PROXY,"91.224.62.194:8080");
curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_HTTP);
curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/101.0.4951.54 Safari/537.36");
//curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (Windows; U; Windows NT 5.0; En; rv:1.8.0.2) Gecko/20070306 Firefox/1.0.0.4");
//curl_setopt($ch, CURLOPT_COOKIEFILE, __DIR__ . '/cookie.txt');
$response = curl_exec($ch);
curl_close($ch);

return $response;
}

//$posts = [];
//$conn = mysqli_connect("localhost", "root", "", "parset");
$conn = mysqli_connect("localhost", "parser", "tVvrZX8LfFMQHjh6", "parser");
//$sql = "SELECT `articles` FROM `test_articles` WHERE id = 12";//  id BETWEEN 23 AND 30"; 468 - 511
////$sql = "SELECT `articles` FROM `articles` WHERE `parsed` = \'-\' LIMIT 1"; UPDATE `articles` SET `parsed` = '-' WHERE `articles`.`id` = 1;
//$sql = "SELECT `articles` FROM `articles` WHERE `parsed` = '-' LIMIT 1";
$sql = "SELECT `articles` FROM `articles` WHERE id BETWEEN 300 AND 350";//WHERE `del` = '-' LIMIT 1"; //WHERE id = 2";//BETWEEN 1 AND 10";7521
if($result = $conn->query($sql)){
    foreach($result as $row){   
        $link = $row["articles"];
        echo $link . "</br>";
        //sleep(50);
        //usleep(900000); 
        $page = curlGetArcticles($link);
        ////$page = curlGetArcticles('https://tbankrot.ru/item?id=4607637');   
        $html = str_get_html($page); 
        //echo $html;
        //die();
        $id = $link;
        //$close = trim($html->find('.info_head', 0)->find('span.num', 0)->find('span.status.red', 0)); //загловок
        if (!empty($html)) {
            //sleep(120);
             $elements = [  
                //$id = $link,
                'ID_Lot' => $id = mb_strcut($id, 28, 7),
                 $close = trim($html->find('.info_head', 0)->find('span.num', 0)->find('span.closed', 0)), //загловок
                'tetst' => $damn = ($close  == null) ? 'Лот в работе' : 'Устаревший лот'
             ];
             usleep(30000); 
            //  sleep(30);
            // echo $damn; //В работе или устарвеший
           // echo $id; //айди лота
             print_r($elements);
            // usleep(600000);
            $conn = mysqli_connect("localhost", "parser", "tVvrZX8LfFMQHjh6", "parser");
             if($damn == 'Устаревший лот'){
              $sql = "DELETE FROM  `articles` WHERE `articles` = '$link'";
              //$sql = "DELETE FROM  `test_lot` WHERE `id_lot` = '$id'";
                 if($conn->query($sql)){   
                 echo "Старый лот удален";
                 $log = date('Y-m-d H:i:s') . ' Старый лот удален: ' . $link;
                file_put_contents(__DIR__ . '/log_del.txt', $log . PHP_EOL, FILE_APPEND);
                 } else{
                 echo "Ошибка: " . $conn->error;
                 }                
            }
            $conn->query("DELETE FROM  `lots_all` WHERE `id_lot` = '$id'"); //Удаление основного лота.
            $conn->query("DELETE FROM  `pricetable2` WHERE `id_lot` = '$id'"); //Удаление календаря цен.
            $conn->close();
            //$conn->query("UPDATE `articles` SET `del` = '-' WHERE `del` = '+' ORDER BY del DESC LIMIT 1");
           // $conn->query("UPDATE `articles` SET `del` = '+' WHERE `articles` = '$link'");
           
        }
        else echo 'Страница не открылась';
    } 
    $log = date('Y-m-d H:i:s') . ' Удаление остановилось на лоте: ' . $link;
    file_put_contents(__DIR__ . '/log_del.txt', $log . PHP_EOL, FILE_APPEND);
}
    