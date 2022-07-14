<?php
include_once 'simple_html_dom.php';


function curlGetPrice($url, $id)
{

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_URL, $url);
    //curl_setopt($ch, CURLOPT_REFERER, $referer);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "key=get_price_down&id=" . $id); 
    //curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (Windows; U; Windows NT 5.0; En; rv:1.8.0.2) Gecko/20070306 Firefox/1.0.0.4");
    $response = curl_exec($ch);
    curl_close($ch);

    return $response;
}

    //$conn = mysqli_connect("localhost", "root", "", "parset");
    $conn = mysqli_connect("localhost", "101mash_ru", "fastuser", "101mash_ru");
    $sql = "SELECT `articles` FROM `articles` WHERE `parsed` = '-' LIMIT 1";
    //$sql = "SELECT DISTINCT `id_lot` FROM `lots_all` WHERE id_lot = 4606018";//BETWEEN 1 AND 72"; 
    if($result = $conn->query($sql)){
        foreach($result as $row){   
            $link = $row["articles"];
            $id = mb_strcut($link, 28, 7);
            //$id = '4606018';
            $ajax = curlGetPrice('https://tbankrot.ru/script/ajax.php', $id);  
            usleep(180000);
            $priceTable = str_get_html($ajax);
  
    if (!empty($priceTable)) { //Проверка на активную табличку цен
        $log = date('Y-m-d H:i:s') . ' Табличка с ценами спаршена id lota: ' . $id;
        file_put_contents(__DIR__ . '/log_link.txt', $log . PHP_EOL, FILE_APPEND);
   $elementprice = [
        'ID_Lot' => $id,
        'dateprice №1' => trim($tableprice = $priceTable->find('td.date', 0)->plaintext),
        'tableprice №1' => $tableprice = trim($tableprice = $priceTable->find('td.price', 0)->plaintext),//таблица с ценами 

        'dateprice №2' => trim($tableprice = $priceTable->find('td.date', 1)->plaintext),
        'tableprice №2' => trim($tableprice = $priceTable->find('td.price', 1)->plaintext),//таблица с ценами 

        'dateprice №3' => trim($tableprice = $priceTable->find('td.date', 2)->plaintext),
        'tableprice №3' => trim($tableprice = $priceTable->find('td.price', 2)->plaintext),//таблица с ценами 

        'dateprice №4' => trim($tableprice = $priceTable->find('td.date', 3)->plaintext),
        'tableprice №4' => trim($tableprice = $priceTable->find('td.price', 3)->plaintext),//таблица с ценами 

        'dateprice №5' => trim($tableprice = $priceTable->find('td.date', 0)->plaintext),
        'tableprice №5' => trim($tableprice = $priceTable->find('td.price', 4)->plaintext),//таблица с ценами 

        'dateprice №6' => trim($tableprice = $priceTable->find('td.date', 5)->plaintext),
        'tableprice №6' => trim($tableprice = $priceTable->find('td.price', 5)->plaintext),//таблица с ценами 

        'dateprice №7' => trim($tableprice = $priceTable->find('td.date', 6)->plaintext),
        'tableprice №7' => trim($tableprice = $priceTable->find('td.price', 6)->plaintext),//таблица с ценами 

        'dateprice №8' => trim($tableprice = $priceTable->find('td.date', 7)->plaintext),
        'tableprice №8' => trim($tableprice = $priceTable->find('td.price', 7)->plaintext),//таблица с ценами 

        'dateprice №9' => trim($tableprice = $priceTable->find('td.date', 8)->plaintext),
        'tableprice №9' => trim($tableprice = $priceTable->find('td.price', 8)->plaintext),//таблица с ценами 

        'dateprice №10' => trim($tableprice = $priceTable->find('td.date', 9)->plaintext),
        'tableprice №10' => trim($tableprice = $priceTable->find('td.price', 9)->plaintext),//таблица с ценами 

        'dateprice №11' => trim($tableprice = $priceTable->find('td.date', 10)->plaintext),
        'tableprice №11' => trim($tableprice = $priceTable->find('td.price', 10)->plaintext),//таблица с ценами 

        'dateprice №12' => trim($tableprice = $priceTable->find('td.date', 11)->plaintext),
        'tableprice №12' => trim($tableprice = $priceTable->find('td.price', 11)->plaintext),//таблица с ценами 

        'dateprice №13' => trim($tableprice = $priceTable->find('td.date', 12)->plaintext),
        'tableprice №13' => trim($tableprice = $priceTable->find('td.price', 12)->plaintext),//таблица с ценами 

        'dateprice №14' => trim($tableprice = $priceTable->find('td.date', 13)->plaintext),
        'tableprice №14' => trim($tableprice = $priceTable->find('td.price', 13)->plaintext),//таблица с ценами 

        'dateprice №15' => trim($tableprice = $priceTable->find('td.date', 14)->plaintext),

        'dateprice №16' => trim($tableprice = $priceTable->find('td.date', 15)->plaintext),
        'tableprice №16' => trim($tableprice = $priceTable->find('td.price', 15)->plaintext),//таблица с ценами 

        'dateprice №17' => trim($tableprice = $priceTable->find('td.date', 16)->plaintext),
        'tableprice №17' => trim($tableprice = $priceTable->find('td.price', 16)->plaintext),//таблица с ценами 

        'dateprice №18' => trim($tableprice = $priceTable->find('td.date', 17)->plaintext),
        'tableprice №18' => trim($tableprice = $priceTable->find('td.price', 17)->plaintext),//таблица с ценами 

        'dateprice №19' => trim($tableprice = $priceTable->find('td.date', 18)->plaintext),
        'tableprice №19' => trim($tableprice = $priceTable->find('td.price', 18)->plaintext),//таблица с ценами 

        'dateprice №20' => trim($tableprice = $priceTable->find('td.date', 19)->plaintext),
        'tableprice №20' => trim($tableprice = $priceTable->find('td.price', 19)->plaintext),//таблица с ценами 

    ];

    
    $elementprice = array_unique($elementprice);
    usleep(180000);   
    //$conn = mysqli_connect("localhost", "root", "", "parset");
    $conn = mysqli_connect("localhost", "101mash_ru", "fastuser", "101mash_ru");
    $sql = ("INSERT IGNORE INTO `pricetable2` (`id`, `id_lot`, `datetime`, `price`) VALUES (NULL, '{$elementprice['ID_Lot']}', '{$elementprice['dateprice №1']}', '{$elementprice['tableprice №1']}'), 
    (NULL, '{$elementprice['ID_Lot']}', '{$elementprice['dateprice №2']}', '{$elementprice['tableprice №2']}'), 
    (NULL, '{$elementprice['ID_Lot']}', '{$elementprice['dateprice №3']}', '{$elementprice['tableprice №3']}'),
    (NULL, '{$elementprice['ID_Lot']}', '{$elementprice['dateprice №4']}', '{$elementprice['tableprice №4']}'), 
    (NULL, '{$elementprice['ID_Lot']}', '{$elementprice['dateprice №5']}', '{$elementprice['tableprice №5']}'),
    (NULL, '{$elementprice['ID_Lot']}', '{$elementprice['dateprice №6']}', '{$elementprice['tableprice №6']}'),
    (NULL, '{$elementprice['ID_Lot']}', '{$elementprice['dateprice №7']}', '{$elementprice['tableprice №7']}'), 
    (NULL, '{$elementprice['ID_Lot']}', '{$elementprice['dateprice №8']}', '{$elementprice['tableprice №8']}'),
    (NULL, '{$elementprice['ID_Lot']}', '{$elementprice['dateprice №9']}', '{$elementprice['tableprice №9']}'),
    (NULL, '{$elementprice['ID_Lot']}', '{$elementprice['dateprice №10']}', '{$elementprice['tableprice №10']}'),
    (NULL, '{$elementprice['ID_Lot']}', '{$elementprice['dateprice №11']}', '{$elementprice['tableprice №11']}'),
    (NULL, '{$elementprice['ID_Lot']}', '{$elementprice['dateprice №12']}', '{$elementprice['tableprice №12']}'),
    (NULL, '{$elementprice['ID_Lot']}', '{$elementprice['dateprice №13']}', '{$elementprice['tableprice №13']}'),
    (NULL, '{$elementprice['ID_Lot']}', '{$elementprice['dateprice №14']}', '{$elementprice['tableprice №14']}'),
    (NULL, '{$elementprice['ID_Lot']}', '{$elementprice['dateprice №15']}', '{$elementprice['tableprice №15']}'),
    (NULL, '{$elementprice['ID_Lot']}', '{$elementprice['dateprice №16']}', '{$elementprice['tableprice №16']}'),
    (NULL, '{$elementprice['ID_Lot']}', '{$elementprice['dateprice №17']}', '{$elementprice['tableprice №17']}'),
    (NULL, '{$elementprice['ID_Lot']}', '{$elementprice['dateprice №18']}', '{$elementprice['tableprice №18']}'),
    (NULL, '{$elementprice['ID_Lot']}', '{$elementprice['dateprice №19']}', '{$elementprice['tableprice №19']}'),
    (NULL, '{$elementprice['ID_Lot']}', '{$elementprice['dateprice №20']}', '{$elementprice['tableprice №20']}')");

        if($conn->query($sql)){   
        echo "Данные успешно добавлены";
        } else{
        echo "Ошибка: " . $conn->error;
        }
        $conn->close();
        
    }
    else {
        echo 'Табличка с ценами отсутствует';
        $log = date('Y-m-d H:i:s') . ' Табличка с ценами отсутствует на Лоте: ' . $id;
        file_put_contents(__DIR__ . '/log_link.txt', $log . PHP_EOL, FILE_APPEND);
    }//Конец проверки на empt
    sleep(30);
    //$conn = mysqli_connect("localhost", "root", "", "parset");
    $conn = mysqli_connect("localhost", "101mash_ru", "fastuser", "101mash_ru");
    $sql = ("DELETE FROM `pricetable2` WHERE `datetime` = \"\" or `price` = \"\""); //удаляем пустые записи
    if($conn->query($sql)){   
        echo "Лишние столбцы успешно удалены";
        } else{
        echo "Ошибка: " . $conn->error;
        }
        $conn->close();

    print_r ($elementprice);       
    } 
}
