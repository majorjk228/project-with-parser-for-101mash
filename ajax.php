<?php
include 'parser/db.php';


if (isset($_POST['ourForm_inp'])) { //кнопка с календарем


$price = $conn->query("SELECT * FROM `pricetable2` WHERE id_lot =" . $_POST['ourForm_inp'] . "");

$row_cnt2 = $price->num_rows; // сколько строк вернул(проверка есть ли календарь)
if ($row_cnt2 != NULL){ //формирование календаря с цен, его вывод
  foreach($price as $rows){   
    
    $id = $rows["datetime"];
    $link = $rows["price"];    

    echo $id . " — " . $link . "₽ </br>";  

   /*$viv1 = '<tr class="result2">   
    <td>' .  $id . " — " . $link . '₽ </br><td>
    </tr>
    ';*/

    }
}   
}



if (isset($_POST['title'])) { //кнопка с календарем
  

  $price = $conn->query("SELECT * FROM `pricetable2` WHERE id_lot =" . $_POST['title'] . "");


  $row_cnt2 = $price->num_rows; // сколько строк вернул(проверка есть ли календарь)
  if ($row_cnt2 != NULL){ //формирование календаря с цен, его вывод
    foreach($price as $rows){   
      
      $id = $rows["datetime"];
      $link = $rows["price"];    
  
      echo $id . " — " . $link . "₽ \n";  
  
     /*$viv1 = '<tr class="result2">   
      <td>' .  $id . " — " . $link . '₽ </br><td>
      </tr>
      ';*/
      //unset($_POST['title']);
      //header("Location: ".$_SERVER['REQUEST_URI']);
      }
  }  
  else {
    
    echo "Календарь для этого лота отсутсвует"; 
    //unset($_POST['title']);
    //header("Location: ".$_SERVER['REQUEST_URI']);
    }
  }


    // $reqid = $_REQUEST['idcat'];
    // $result = mysql_query("SELECT * FROM goodies WHERE manufacturer='$reqid'");
    // // выводим товары полученные по запросу
    // while ($row=mysql_fetch_array($result))
    // {
    // print $row['title']."<br>";
    // }

    $token = sha1(uniqid($username, true));
    if (isset($_POST['link'])) { //генерация ссылки $url = "https://101mash.ru/result.php?token=$token";

  
      //echo 'Кнопка работает';

      $token = sha1(uniqid($username, true));
      //$token = uniqid(md5(rand()), true);
      //echo $_POST['link'];
      //print_r ($_POST['link']);
      //echo $sql = "INSERT INTO `gen_links` (`id_lot`, `token`) VALUES ('" . $_POST['link'] . "', '$token')";
      foreach ($_POST['link'] as $element)
      {
        //echo $element;
        $query = $conn->query(
          "INSERT INTO `gen_links` (`id_lot`, `token`) VALUES ('$element', '$token')"
        );
      }
      // $query = $conn->query(
      //  // "INSERT INTO `gen_links` (`id_lot`, `token`) VALUES ('4638009', '$token')"
      //  //"INSERT INTO `gen_links` (`id_lot`, `token`) VALUES ('4638010', 'acfef79c40d2b8de8aad11bee546e83a5eba2068')"
      // // "INSERT INTO `gen_links` (`id_lot`, `token`) VALUES (" . $_POST['title'] . ", '$token')"
      // //"INSERT INTO `gen_links` (`id_lot`, `token`) VALUES ('" . $_POST['link'] . "', '$token')"
      //  );
      //  $query2 = $conn->execute(
      //       array(
      //           // $username,
      //           // $token,
      //           $id_lot,
      //           $token
      //           //$_SERVER["REQUEST_TIME"]
      //       )
      //  );
       $url = "https://101mash.ru/m.generator.php?token=$token";
       echo $url;

    
    }


    if (isset($_POST['like'])) {

      $lot = $_POST['like'];

      $token = $_POST['token'];

      $token = substr($token, 19);

      //echo $token;

     //echo $sql = "UPDATE `gen_links` SET like_lot = '1' WHERE token = '$token'";

      $query = $conn->query(
        "UPDATE `gen_links` SET like_lot = '1' WHERE token = '$token' and id_lot = '$lot' ",
      );
      $query = $conn->query(
        "UPDATE `gen_links` SET dislike_lot = '0' WHERE token = '$token' and id_lot = '$lot' "
      );

      echo 'Лот ' . $lot .  ' лайкнут!';

    }

    if (isset($_POST['dislike'])) {

    // echo 'кнпока нажата';

      $lot = $_POST['dislike'];

      $token = $_POST['token'];

      $token = substr($token, 19);

      //echo $token;

     //echo $sql = "UPDATE `gen_links` SET like_lot = '1' WHERE token = '$token'";

     $query = $conn->query(
       "UPDATE `gen_links` SET dislike_lot = '1' WHERE token = '$token' and id_lot = '$lot' "
     );
     $query = $conn->query(
       "UPDATE `gen_links` SET like_lot = '0' WHERE token = '$token' and id_lot = '$lot' "
    );

      echo 'Лот ' . $lot .  ' Дизлайкнут!';

    }



?>



