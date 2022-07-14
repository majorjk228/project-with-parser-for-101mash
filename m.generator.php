<?php
include 'parser/db.php';
//include 'ajax.php';
// https://ruseller.com/lessons.php?rub=37&id=1705 manual


// получаем токен
// if (isset($_GET["token"]) && preg_match('/^[0-9A-F]{40}$/i', $_GET["token"])) {
  if (isset($_GET["token"])) {
  $token = $_GET["token"];
  //echo $token;
}
else {
  echo ("Токен не валиден.");
}

// // проверяем токен
//$sql = ("SELECT * FROM gen_links WHERE token = '$token'");
$sql =("
SELECT lots.*, gen.token
FROM gen_links gen
LEFT JOIN lots_all lots on lots.id_lot = gen.id_lot
WHERE token = '$token' 
");

if($conn->query($sql)){   
  //echo "Найдено";
  $row_cnt = $conn->query($sql)->num_rows;
  if ($row_cnt != NULL){
    foreach($conn->query($sql) as $row){  //Выводим Инфу на страницу
      $row["id_lot"] . "</br>";
      $row["name_lot"] . "</br>";
    }
  } else echo "По данному токену ничего не найдено";
  } else{
  echo "Ошибка: " . $conn->error;
  }




// if ($row) {
//   extract($row);
// }
// else {
//   throw new Exception("токен не валиден.");
// }

// // активируем пользовательский аккаунт
// // ...

// // удаляем токен из базы
// $query = $db->prepare(
//   "DELETE FROM pending_users WHERE username = ? AND token = ? AND tstamp = ?",
// );
// $query->execute(
//   array(
//       $username,
//       $token,
//       $tstamp
//   )
// );

?>


<!DOCTYPE html>
<html>

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel='stylesheet' href='style.css' />
    <script
      src="https://code.jquery.com/jquery-3.6.0.min.js"
      integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
      crossorigin="anonymous"></script>
      <title>Подборка лотов</title>
      <style>
         .like
        {
          width: 150px; 
          position: absolute; 
          /* right: 175px; */
          float: right;

        }
        .pricer
        {
          /* right: 175px; */
          /* float: right; */
          /* position: absolute;  */
          text-align: right;
          display: grid;
        }
        /*.dislike
        {
          width: 150px; 
          position: absolute;
        } */
        .damn{
          width: 150px;
          float: right;
        }
    </style> 
      </head>

<body>


<input class="form-control" type="text" placeholder="Поиск по таблице" id="search-text" onkeyup="tableSearch()"> 


<legend class="token">Ваш токен: <?php echo $token; ?></legend>

<div class="container">
<table class="table table-bordered table-dark" align="center" id="info-table"> 
  <thead>
  <tr>
    <!-- <tr align="center" style="vertical-align: middle"> -->
      <th scope="col">#</th>
      <th scope="col">ID Лота</th>
      <th scope="col">Изображение</th>
      <th scope="col">Текст</th>
      <th scope="col">Цена лота</th>
      <th scope="col">Прием заявок</th>
      <th scope="col">Регион</th>
      <!-- <th scope="col">Стрелка</th> -->
      <!-- <th scope="col">Календарь</th> -->
      <!-- <th scope="col">Наименование</th>
      <th scope="col">Заголовок</th>
      <th scope="col">Дата календаря цены</th>
      <th scope="col">Цена календаря</th> 
      <th scope="col">Минмальная цена</th>
      <th scope="col">Проведение торгов</th>
      <th scope="col">Кто проводит торги</th>
      <th scope="col">Кто проводит торги</th>   
      <th scope="col">Телефон</th>
      <th scope="col">Email</th>
      <th scope="col">Ссылка на лот</th> -->
    </tr>
  </thead>
  <tbody>
    <?php if ($row_cnt != NULL) :?>
    <?php  foreach($conn->query($sql) as $row)   :?>
      <!-- <tr class="result"> -->
      <tr align="justify">
      <?php 
            $var = ($row['price_lot'] == 1) ? '<img src="/uparrow.png" width="15" height="15">' : '<img src="/downarrow.png" width="15" height="15">'; 
            echo '<td><button type="button" value="'. $row['id_lot'] . '" data-lot="'. $row['id_lot'] . '" class="btn btn-success damn like">Нравится</button><button type="button" value="'. $row['id_lot'] . '" data-lot="'. $row['id_lot'] . '"" class="btn btn-danger damn dislike">Не нравится</button></td>' . '<td data-label="ID Лота"><input type="button" id="submit" class="btn btn-info title" name="title" value="' . $row['id_lot']  . '" data-lot="'. $row['id_lot'] . '"></td>' . '<td data-label="Изображение"> <p class="aligncenter"><img src="' . $row['img_lot'] . '"width="350"></p></td>'. '<td data-label="Текст" class="text">' . $row['text_lot'] . '</td>'
            . '<td class="pricer" data-label="Цена лота">' . $row['price_lot'] . ' ' . $var . '<input type="button" id="submit" class="btn btn-info title" name="title" value="' . $row['id_lot']  . '" data-lot="'. $row['id_lot'] . '"></td>'
            . '<td data-label="Прием заявок">' . $row['dopinfo_lot'] . '  ' . $row['dopinfo2_lot'] . '</td>' . '<td data-label="Регион" class="region">' . $row['region_lot'] . '</td>';
        ?>  
        </tr>
        <?php endforeach;?> 
        <?php endif;?> 
    </tbody>
    </table>
    </div>

    <!-- <div>
      <button type="button" class="btn btn-primary active" data-bs-toggle="button" autocomplete="off"  id="aligncenter" onClick='location.href="/index.php"' aria-pressed="true">Вернутся назад</button>
    </div> -->


    <!-- <input type="text"  name="title" class="title" value="4606018"> -->

    <!-- <button class="otpravka">Отправить</button> -->

    <!-- <button class="btn btn-info otpravka">Отправить</button>  -->

      <script>
                $(document).ready(function(){
                  $('input.title').on('click', function(){
                    //console.log('heelo world');
                    var titleVal = $('input.title').val();
                    //var content = $('input.title').val();
                    
                    //console.log(title);

                    $.ajax({
                      method: "POST",
                      url: "ajax.php",
                      //data: { title: titleVal }
                      data: {title: $(this).data('lot')}
                    })
                      .done(function( msg ) {
                        alert( "Календарь: \n" + msg );
                      });
                  })  
                  
                  
                  $('button.like').on('click', function(){
                    //console.log('heelo world');
                    var liker = $('legend.token').text();
                    //var content = $('input.title').val();
                    //var token = $('input.title').val();
                    
                    //console.log(liker);

                    $.ajax({
                      method: "POST",
                      url: "ajax.php",
                       //data: { like: liker, token: liker}
                      data: { like: $(this).data('lot'), token: liker}
                    })
                      .done(function( msg ) {
                        alert(msg);
                      });
                  }) 

                  $('button.dislike').on('click', function(){
                    //console.log('heelo world');
                    //var disliker = $('legend.token').text();
                    var liker = $('legend.token').text();
                    //var content = $('input.title').val();
                    
                   //console.log(liker);

                    $.ajax({
                      method: "POST",
                      url: "ajax.php",
                       data: { dislike: $(this).data('lot'), token: liker }
                      //data: { like: $(this).data('lot')}
                    })
                      .done(function( msg ) {
                        alert(msg);
                      });
                  }) 


                });

      </script>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

 <script src="./main.js"></script> 

</body>


</html>