<?php
include_once 'simple_html_dom.php';
//include_once 'parser.php';
echo 'Телефон активировался';
function curlGetPhone($url)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
   // curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (Windows; U; Windows NT 5.0; En; rv:1.8.0.2) Gecko/20070306 Firefox/1.0.0.4");
   // curl_setopt($ch, CURLOPT_PROXY,"91.238.98.62:8000");
   // curl_setopt($ch, CURLOPT_PROXYUSERPWD, "aEktnq:BSBB14");
    $response = curl_exec($ch);
    curl_close($ch);
    
    return $response;
}


$conn = mysqli_connect("localhost", "101mash_ru", "fastuser", "101mash_ru");
$sql = "SELECT inn_lot FROM `lots_all`  WHERE id = (SELECT MAX(id) FROM lots_all);";
//$sql = "SELECT inn_lot FROM `lots_all` WHERE id = 55";//BETWEEN 46 AND 51";
if($result = $conn->query($sql)){
    foreach($result as $row){   
        $userinn = $row["inn_lot"];
        //echo $userinn . "</br>";
        $page = curlGetPhone('https://xn----etbpba5admdlad.xn--p1ai/search?sort=&search=&trades-section=&trades-type=&begin-price-from=&begin-price-to=&current-price-from=&current-price-to=&current-price-period-from=&current-price-period-to=&min-price-from=&min-price-to=&percent-reduction-from=&percent-reduction-to=&currency=&bid_begin=&begin_bid_from=&begin_bid_to=&bid_end=&end_bid_from=&end_bid_to=&bid-period-begin=&bid-period-begin-from=&bid-period-begin-to=&bid-period-end=&bid-period-end-from=&bid-period-end-to=&price-offer-begin=&price-offer-begin-from=&price-offer-begin-to=&price-offer-end=&price-offer-end-from=&price-offer-end-to=&period-end=&period_end_from=&period_end_to=&debtor_type=&debtor_name=&debtor_inn=&group_org=&organizer_name=&arbitr_inn=' . $userinn .  '&trade_number=&words-exception='); 
        $html = str_get_html($page); 
        $resulted = $html->find('.lot-card__center', 0);
        if ($resulted != null){ 
        $resulted = $html->find('.lot-top', 0)->find('a.lot-description__link', 0)->attr['href'];;
        $page = curlGetPhone($resulted);
        $html = str_get_html($page);     
        $tel = trim($html->find('.collapsible-body', 2)->find('p',-1)->find('span.param-label', 0)->plaintext);
        echo $tel;    
        if (($tel == 'Телефон:') or ($tel == 'Телефон контактного лица:')) {
            $phone = [               
                $tel = trim($html->find('.collapsible-body', 2)->find('p',-1)->find('span.js-share-search', 0)->plaintext),
                    'inn' => $userinn,    
                    //$test = ($userinn != $tel) ? $tel : 'Телефон отсутствует', потестит 202 айди
                    'phone' => $tel,        
                    ];
                    print_r($phone);
        } else {
                $phone = [               
                $tel = trim($html->find('.collapsible-body', 3)->find('p',-1)->find('span.js-share-search', 0)->plaintext),
                    'inn' => $userinn,    
                    //$test = ($userinn != $tel) ? $tel : 'Телефон отсутствует',
                    'phone' => $tel,        
                    ];
                    print_r($phone);
                } 
            }   
            else {
                echo 'Телефон не найден';
                $log = date('Y-m-d H:i:s') . ' Телефон не найден у лота с ИНН: ' . $userinn;
                file_put_contents(__DIR__ . '/log_link.txt', $log . PHP_EOL, FILE_APPEND);
            } 
        $sql = "UPDATE lots_all SET `phone_lot` = '{$phone['phone']}' WHERE `inn_lot` = '{$phone['inn']}'";  //{$phone['phone']}8 (977) 811-46-46
            if($conn->query($sql)){   
                echo "Данные успешно добавлены";
                } else{
                echo "Ошибка: " . $conn->error;
                }
    }
}
else {
    echo 'Не удалось выполнить запрос к бд';
}
$result->free(); 
$conn->close();

      