<?php 
include_once 'simple_html_dom.php';

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
    //curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (Windows; U; Windows NT 5.0; En; rv:1.8.0.2) Gecko/20070306 Firefox/1.0.0.4");
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 0);
    //curl_setopt($ch, CURLOPT_PROXY,"114.233.71.37:9000");
    //curl_setopt($ch, CURLOPT_PROXY,"91.238.98.62:8000");
    //curl_setopt($ch, CURLOPT_PROXYUSERPWD, "aEktnq:BSBB14");
    //сохранять полученные COOKIE в файл
    curl_setopt($ch, CURLOPT_COOKIEJAR, __DIR__ . '/cookiearticlesnew.txt');
    $result=curl_exec($ch);
 

 
    curl_close($ch);
 
    return $result;
}

$url="https://tbankrot.ru/script/submit.php";
$login="89667842289@mail.ru";
$pass="89667842289@mail.ru";

echo curlLogin($url,$login,$pass); //проходим один раз сохраняем куки выходим */ 

function curlGetPage($url)
    {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    //curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (Windows; U; Windows NT 5.0; En; rv:1.8.0.2) Gecko/20070306 Firefox/1.0.0.4");
    curl_setopt($ch, CURLOPT_COOKIEFILE, __DIR__ . '/cookiearticlesnew.txt');
    $response = curl_exec($ch);
    curl_close($ch);

    return $response;
    }


$page = curlGetPage('https://tbankrot.ru/?page=1&swp=any_word&debtor_cat=0&parent_cat=1&sub_cat=2%2C14%2C15%2C16%2C17%2C18&sort=created&sort_order=desc&show_period=all&place[]=109&place[]=119&place[]=120&place[]=121&place[]=122&place[]=123&place[]=124&place[]=125&place[]=126&place[]=127&place[]=128&place[]=129&place[]=131&place[]=132&place[]=133&place[]=135&place[]=136&place[]=137&place[]=138&place[]=139&place[]=140&place[]=141&place[]=142&place[]=145&place[]=146&place[]=149&place[]=151&place[]=152&place[]=153&place[]=154&place[]=157&place[]=158&place[]=159&place[]=160&place[]=161&place[]=162&place[]=165&place[]=166&place[]=168&place[]=170&place[]=179&place[]=180&place[]=181&place[]=182&place[]=183&place[]=184&place[]=185&place[]=186');
$html = str_get_html($page);
echo $html;
$pagenavi = $html->find('.paginator_row', 0);
$pageCount = ($pagenavi->find('li', 4)->plaintext);

for ($i = 1; $i <= 6; $i++) {
    
    $page = curlGetPage('https://tbankrot.ru/?page='. $i . '&swp=any_word&debtor_cat=0&parent_cat=1&sub_cat=2%2C14%2C15%2C16%2C17%2C18&sort=created&sort_order=desc&show_period=all&place[]=109&place[]=119&place[]=120&place[]=121&place[]=122&place[]=123&place[]=124&place[]=125&place[]=126&place[]=127&place[]=128&place[]=129&place[]=131&place[]=132&place[]=133&place[]=135&place[]=136&place[]=137&place[]=138&place[]=139&place[]=140&place[]=141&place[]=142&place[]=145&place[]=146&place[]=149&place[]=151&place[]=152&place[]=153&place[]=154&place[]=157&place[]=158&place[]=159&place[]=160&place[]=161&place[]=162&place[]=165&place[]=166&place[]=168&place[]=170&place[]=179&place[]=180&place[]=181&place[]=182&place[]=183&place[]=184&place[]=185&place[]=186');
    $html = str_get_html($page);
    
    sleep(5); 
$urls = 'https://tbankrot.ru';   
foreach ($html->find('.info_head') as $element){
      $link = $element->find('a', 1);
        $posts = [
        'link' => $urls . $id = trim($link->attr['href'])
        ]; 
        usleep(300000); 
        //print_r ($posts);


    //$conn = mysqli_connect("localhost", "root", "", "parset");
    $conn = mysqli_connect("localhost", "101mash_ru", "fastuser", "101mash_ru");
   
    $sql = ("SELECT articles from articles WHERE articles  = '{$posts['link']}'");
    $result = $conn->query($sql);
    if($result = $conn->query($sql)){   
    $row_cnt = $result->num_rows;
        if ($row_cnt >= 1) {
            echo "Ссылка уже присутствует в базе" . $posts['link'] . "\n";
        } else {
            echo "Новая запись в бд " . $posts['link'] . "\n";
            //$conn->query("INSERT IGNORE INTO `articles` (`id`, `articles`, `parsed`) VALUES (NULL, '{$posts['link']}'), '-';");
            $conn->query("INSERT IGNORE INTO `articles` (`id`, `articles`) VALUES (NULL, '{$posts['link']}');");
            $log = date('Y-m-d H:i:s') . '| Новая ссылка добавлена в бд: ' . $posts['link'];
            file_put_contents(__DIR__ . '/log_overday.txt', $log . PHP_EOL, FILE_APPEND);
            continue;
        }
        
    } else{
    echo "Ошибка: " . $conn->error;
    }
    $conn->close();
} 
    usleep(300000); 
    set_time_limit(200);
    if ($i > 5)
    {
        echo 'Закончился парсинг на стр: ' . $i;
        $log = date('Y-m-d H:i:s') . ' Ежедневный сбор прошел ' . $i . ' страниц';
        file_put_contents(__DIR__ . '/log_overday.txt', $log . PHP_EOL, FILE_APPEND);
        die();
    }
}
die();