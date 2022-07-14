<?php
include_once 'simple_html_dom.php';
//include_once 'pricetable.php';

function curlLogin($url,$login,$pass)
  {
    $ch = curl_init();
    if(strtolower((substr($url,0,5))=='https')) { // если соединяемся с https
     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
     curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    }
    curl_setopt($ch, CURLOPT_URL, $url);
    // откуда пришли на эту страницу
    curl_setopt($ch, CURLOPT_REFERER, $url);
    // cURL будет выводить подробные сообщения о всех производимых действиях
    curl_setopt($ch, CURLOPT_VERBOSE, 0);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS,"key=login&mail=".$login."&pas=".$pass);
    //curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/101.0.4951.54 Safari/537.36"); Комменитурем, крон не может работать с другими UserAgent
    //curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (Windows; U; Windows NT 5.0; En; rv:1.8.0.2) Gecko/20070306 Firefox/1.0.0.4");
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 0);
    //curl_setopt($ch, CURLOPT_PROXY,"114.233.71.37:9000");
    //curl_setopt($ch, CURLOPT_PROXY,"91.238.98.62:8000");
    //curl_setopt($ch, CURLOPT_PROXYUSERPWD, "aEktnq:BSBB14");
    //сохранять полученные COOKIE в файл
    curl_setopt($ch, CURLOPT_COOKIEJAR, __DIR__ . '/cookie.txt');
    $result=curl_exec($ch);
 

 
    curl_close($ch);
 
    return $result;
  }

$url="https://tbankrot.ru/script/submit.php";
$login="89667842289@mail.ru";
$pass="89667842289@mail.ru";

curlLogin($url,$login,$pass); //проходим один раз сохраняем куки выходим */ 

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
//curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/101.0.4951.54 Safari/537.36");
//curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (Windows; U; Windows NT 5.0; En; rv:1.8.0.2) Gecko/20070306 Firefox/1.0.0.4");
curl_setopt($ch, CURLOPT_COOKIEFILE, __DIR__ . '/cookie.txt');
$response = curl_exec($ch);
curl_close($ch);

return $response;
}

//$posts = [];
//$conn = mysqli_connect("localhost", "root", "", "parset");
$conn = mysqli_connect("localhost", "101mash_ru", "fastuser", "101mash_ru");
//$sql = "SELECT `articles` FROM `articles` WHERE id = 1238";//  id BETWEEN 23 AND 30"; 468 - 511
//$sql = "SELECT `articles` FROM `articles` WHERE `parsed` = \'-\' LIMIT 1"; UPDATE `articles` SET `parsed` = '-' WHERE `articles`.`id` = 1;
$sql = "SELECT `articles` FROM `articles` WHERE `parsed` = '-' LIMIT 1";
if($result = $conn->query($sql)){
    foreach($result as $row){   
        $link = $row["articles"];
        echo $link . "<br>";
        $page = curlGetArcticles($link);
        //$page = curlGetArcticles('https://tbankrot.ru/item?id=4607637');   
        $html = str_get_html($page); 
        //echo $html;
        $err = $html->find('h1', 0)->plaintext;
        //echo $err;
        if ($err != 'Ошибка 404. Страницы не существует.' or !empty($html)) {
        // if (!empty($html)) {
        //   if ($err != 'Ошибка 404. Страницы не существует.') {
        $url = 'https://tbankrot.ru'; 
         $elements = [        
       
       
       'ID_Lot' => $id = $link,
       'ID_Lot' => $id = mb_strcut($id, 28, 7),
   
       $header = $html->find('.lot_head', 0)->find('h1', 0)->plaintext,
       //'header' =>  trim($header = $html->find('.lot_head', 0)->find('h1', 0)->plaintext), //загловок
        //$damns = preg_replace('Т', 's', $header), 
       'header' => str_replace('\'', '', $header),
       'header2' => trim($header2 = $html->find('.info_head', 0)->find('b', 0)->plaintext), //загловок
   
       //'body' => trim($body = $html->find('.lot_text', 0)->plaintext), //Текст лота start_price
        $body = trim($body = $html->find('.lot_text', 0)->plaintext), //Текст лота start_price
       'body' => str_replace('\'', '', $body),
   
       'price' => trim($price = $html->find('.start_price', 0)->plaintext),// Прайс макс
   
        $priceminman = trim($priceminman = $html->find('.cur_price', 0)),  //прайс мин 
       //'pricemin' => ($priceminman != null) ? trim($priceminman = $html->find('.cur_price', 0)->find('p', 3)->plaintext) : null,
       'pricemin' => ($priceminman != null) ? trim($priceminman = $html->find('.cur_price', 0)->find('p.green.semibold', 0)->plaintext) : null,
   
       'region' => trim($region = $html->find('.row', 4)->plaintext),
   
       $dates = trim($html->find('.dates', 0)->find('td', 0)->plaintext),
       
       //'dates1' => $dates1 = mb_strcut($dates, 29, 10), //1 дата
        //$date = "2013-06-17 19:00:00";
        //$d1 = strtotime($dates1), // переводит из строки в дату
        //$dateparse = date("Y-m-d", $d1), // переводит в новый формат

        $dates2 = mb_strcut($dates, 92, -7), //Разпарсиваем строку

        //$myDateTime = DateTime::createFromFormat('d/m/Y H:i', '17/11/2020 18:00'), //формат 17/11/2020 18:00
        $myDateTime = DateTime::createFromFormat('d/m/Y', $dates2), //формат 17/11/2020

       'dates2' =>  $newDateString = $myDateTime->format('Y-m-d'),
       
       'dates' => trim($dates = $html->find('.dates', 0)->find('td', 0)->plaintext), //Проведение заявок
   
       'torgi' => trim($torgi = $html->find('.dates', 0)->find('td', 1)->plaintext), //Проведение торгов
   
       'dopinfo' =>  trim($dopinfo = $html->find('#dop_info_4', 0)->find('td', 0)->plaintext), //Проведение торгов
   
       'dopinfo2' =>  trim($dopinfo2 = $html->find('#dop_info_4', 0)->find('td', 1)->plaintext), //Проведение торгов
     
       $img = $html->find('.lot_photo', 0)->attr['style'], //Фото
       $img = substr($img, 23, -2), //распарсиваем строку с изображением вырезаем ток ссылку
       'img' => ($img != null) ? $img : '/nullimg.jpg',
   
   
       $arrow = trim($arrow = $html->find('span.arrow', 0)->find('img', 0)->attr['src']),
       'arrow' => ($arrow == '/img/a_up.png') ? 1 : 0,    
   
   
       'phone' => 'Телефон отсутствует',
   
       $email = trim($email = $html->find('#org_request', 0)->find('li', 1)->find('input[name=email]', 0)->attr['value']),//емаил
       'email' => ($email != null) ? $email : 'Email отсутствует',//емаил
   
       $inn = $html->find('.trade_block', 1)->find('.body', 0)->find('.row', 0)->plaintext,
       'inn' => ($inn != null) ? $html->find('.trade_block', 1)->find('.row', 0)->find('div', 1)->plaintext : 'ИНН отсутствует' , 

       $close = trim($html->find('.info_head', 0)->find('span.num', 0)->find('span.closed', 0)), //загловок
       'tetst' => $damn = ($close  == null) ? 'Лот в работе' : 'Устаревший лот',

       'link_lot' => $link,

        ];
   
        //$elements = array_unique($elements);
      print_r ($elements);
      if($damn != 'Устаревший лот'){  
      include_once 'pricetable.php';
      $conn = mysqli_connect("localhost", "101mash_ru", "fastuser", "101mash_ru");
    
      $sql = ("INSERT INTO `lots_all` (`id`, `id_lot`, `name_lot`, `header_lot`, `text_lot`, `price_lot`, `pricemin_lot`, `region_lot`, `date_to`, `dates_lot`, `torgi_lot`, `dopinfo_lot`, `dopinfo2_lot`, `img_lot`, `arrow_lot`, `phone_lot`, `email_lot`, `inn_lot`, `link_lot`, `dateparsing`) 
      VALUES (NULL, '{$elements['ID_Lot']}', '{$elements['header']}', '{$elements['header2']}', '{$elements['body']}', '{$elements['price']}', '{$elements['pricemin']}', '{$elements['region']}', '{$elements['dates2']}', '{$elements['dates']}', '{$elements['torgi']}', '{$elements['dopinfo']}', '{$elements['dopinfo2']}', '{$elements['img']}', '{$elements['arrow']}', '{$elements['phone']}', '{$elements['email']}', '{$elements['inn']}', '{$elements['link_lot']}', CURRENT_TIMESTAMP)");
     // $sql = ("INSERT INTO `lots_all` ( `id_lot`, `name_lot`) VALUES ('524', '{$elements['header']}')");
      if($conn->query($sql)){   
      echo "Данные успешно добавлены";
      } else{
      echo "Ошибка: " . $conn->error;
      }
      $conn->close();

      $conn = mysqli_connect("localhost", "101mash_ru", "fastuser", "101mash_ru");
   
      //$sql = "UPDATE `articles` SET `parsed` = '+' WHERE `articles` = '$link'";
      $sql = "DELETE FROM `articles`  WHERE `articles` = '$link'";
      if($conn->query($sql)){   
      echo "Основные Данные успешно спаршены, лот убран из БД";
      } else{
      echo "Ошибка: " . $conn->error;
      }
      $conn->close();
      $log = date('Y-m-d H:i:s') . ' Лот забран: ' . $link;
        file_put_contents(__DIR__ . '/log_link.txt', $log . PHP_EOL, FILE_APPEND);
        include_once 'phone.php';
    } else
          { 
            echo 'Лот устарел';
            $conn->query("DELETE FROM  `pricetable2` WHERE `id_lot` = '$id'"); //Удаление календаря цен.
            $conn->query("DELETE FROM  `articles` WHERE `articles` = '$link'"); //Удаление ссылки
          }
    }
       else 
       { echo 'Страница не открывается'; 
        $log = date('Y-m-d H:i:s') . ' Лот не забран(Страница не открывается или устарел): ' . $link;
        file_put_contents(__DIR__ . '/log_errors_lot.txt', $log . PHP_EOL, FILE_APPEND);
        $conn = mysqli_connect("localhost", "101mash_ru", "fastuser", "101mash_ru");
        $sql = "UPDATE `articles` SET `parsed` = '0' WHERE `articles` = '$link'";
        if($conn->query($sql)){   
        echo "Лот не забран ошибка, в бд поставлен 0";
        } else{
        echo "Ошибка: " . $conn->error;
        }
        $conn->close();
      }
        
      //$conn = mysqli_connect("localhost", "root", "", "parset");*/
  
    }
       error_reporting(E_ALL);
       ini_set('error_log', __DIR__ . '/php-errors.log');
       error_log('Запись в лог', 0);
 
       //set_time_limit(200);
    }
  //}
  // include_once 'phone.php';