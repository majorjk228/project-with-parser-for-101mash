<?php
include 'parser/db.php';
//include 'ajax.php';

$arr = [];
if (isset($_POST['submitDB'])) { //кнопка с календарем

    //echo $_POST['search'];

    $search = explode(" ", $_POST['search']); //Делаем раздельный поиск по каждому слову

    $count = count($search); //Считаем количсество слов

    
    $array = []; //Кладем в массив данные с поиска

    $i = 0;
    
    foreach($search as $key){
      if ($count != NULL ){
     
      $i++;
      
      //if($i < $count) $array[] = "CONCAT (`id_lot`, `text_lot`) LIKE '%" . $key . "%' OR "; else $array[] = "CONCAT (`id_lot`, `text_lot`) LIKE '%" . $key . "%'";
      if($i < $count) $array[] = "CONCAT (`id_lot`, `text_lot`) LIKE '%" . $key . "%' AND "; else $array[] = "CONCAT (`id_lot`, `text_lot`) LIKE '%" . $key . "%'";
      }
    }
  
    $sql = "SELECT * FROM `lots_all` WHERE " .implode("", $array);
    //echo $sql;

    //$res = $conn->query("SELECT * FROM `lots_all` WHERE " .implode("", $array) );

    $res = $conn->query("SELECT * FROM `lots_all` WHERE " .implode("", $array) );


    $row_cnt = $res->num_rows; // сколько строк вернул(проверка есть ли календарь)
    //$res = $conn->query("SELECT * FROM `lots_all` WHERE `id_lot` LIKE '%$search%' or `name_lot` LIKE '%$search%'");
      if ($row_cnt != NULL){
        foreach($res as $row){   
          $row["id_lot"] . "</br>";
          $row["name_lot"] . "</br>";
          $row["header_lot"];
          $row["datetime"] . "</br>";
          $row["price"];
          $row["text_lot"] . "</br>" ;
          $row["price_lot"] . "</br>";
          trim($row["pricemin_lot"]);
          trim($row["region_lot"] . "</br>");
          $row["dates_lot"] . "</br>";
          $row["torgi_lot"] . "</br>";
          $row["dopinfo_lot"] . "</br>";
          $row["dopinfo2_lot"] . "</br>";
          }
      }
      $price = $conn->query("SELECT * FROM `pricetable2` WHERE id_lot =" . $row["id_lot"] . "");
      $row_cnt2 = $price->num_rows;
      foreach($price as $rows){   
        //$id = $rows["datetime"];
        //$link = $rows["price"];
        //echo $id . " — " . $link . "₽ </br>";             
    }
    }
    //print_R($arr);


?>

<!DOCTYPE html>
<html>

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <script
      src="https://code.jquery.com/jquery-3.6.0.min.js"
      integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
      crossorigin="anonymous"></script>
    <style>
      .close:hover {background: #e6e6ff;}
      .aligncenter {
         text-align: center; 
         vertical-align: middle;
      }
      .form-control{
        width: 120%;
      }
      .white {
        vertical-align: middle;
        background-color: #f0f4c3;
      }
      button {
            margin: 0 auto;
            display: block;
        }
         div {
            text-align: center;
        } 
        .btn-info
        {
          width: 150px; /* Полная ширина */
        }
    </style>    
</head>

<body>

  <div>
   <!-- <form method="post" action="generator.php"> -->
    <!-- <input type="text" class="form-control" placeholder="Введите номер лота или описание лота" name="search" required>
    <input type="submit" name="submitDB"  class="btn btn-primary" value="Поиск">  -->
      <!-- <button type="button" class="btn btn-primary active link" data-bs-toggle="button" autocomplete="off" name="link" id="aligncenter" onClick="" aria-pressed="true">Cгенерировать ссылку</button> -->
      <input type="submit" name="link"  class="btn btn-primary link" value="Cгенерировать ссылку"> 
      <label class="url"></label>
       <!-- </form>   -->
  </div> 
  

  <fieldset class="podborka">
    <legend>Подборка</legend>
    <label class="name"></label>
    <input type="hidden" class="gen" name="search" value="" required> 
  </fieldset>
<!-- <input class="form-control" type="text" placeholder="Поиск по таблице" id="search-text" onkeyup="tableSearch()"> -->

<table class="table table-bordered table-dark" align="center" id="info-table"> 
  <thead>
    <tr align="center" style="vertical-align: middle">
      <!-- <th scope="col">#</th> -->
      <th scope="col">Календарь</th>
      <th scope="col">#</th>
      <th scope="col">ID Лота</th>
      <th scope="col">Наименование</th>
      <th scope="col">Заголовок</th>
      <!-- <th scope="col">Дата календаря цены</th>
      <th scope="col">Цена календаря</th> -->
      <th scope="col">Текст</th>
      <th scope="col">Цена лота</th>
      <th scope="col">Минмальная цена</th>
      <th scope="col">Регион</th>
      <th scope="col">Прием заявок</th>
      <th scope="col">Проведение торгов</th>
      <th scope="col">Кто проводит торги</th>
      <th scope="col">Кто проводит торги2</th>
      <th scope="col">Изображение</th>
      <th scope="col">Стрелка</th>
      <th scope="col">Телефон</th>
      <th scope="col">Email</th>
      <th scope="col">Ссылка на лот</th>
    </tr>
  </thead>
  <tbody>
    <?php if ($row_cnt != NULL) :?>
    <?php  foreach($res as $row)   :?>
      <tr class="result">
      <td width="200"> 
        <?php 
        if ($row_cnt2 != NULL){
        foreach($price as $rows){   
        $id = $rows["datetime"];
        $link = $rows["price"];
        echo $id . "</br>" . $link . "</br></br>";             
        }      
        } else echo 'Календарь отсутствует';
        ?>
        </td>
          <?php  echo '<td><input type="checkbox" name="option1" value="' . $row['id_lot'] . '"></td>' . '<td><input type="submit" class="btn btn-info title" name="title" value="' . $row["id_lot"]  . '"/></td>' .  '<td>' . $row["name_lot"] . '</td>'  . '<td>' . $row["header_lot"] . '</td>' . '<td>' . $row["text_lot"] . '</td>' . '<td>' . $row["price_lot"] . '</td>'
          . '<td>' . $row["pricemin_lot"] . '</td>'  . '<td>' . $row["region_lot"] . '</td>' . '<td>' . $row["dates_lot"] . '</td>' . '<td>' . $row["torgi_lot"] . '</td>' . '<td>' . $row["dopinfo_lot"] . '</td>' . '<td>' . $row["dopinfo2_lot"] . '</td>'
          . '<td> <p class="aligncenter"><img src="' . $row["img_lot"] . '"width="350"></p></td>' . '<td>' . $row["arrow_lot"] . '</td>' . '<td>' . $row["phone_lot"] . '</td>' . '<td>' . $row["email_lot"] . '</td>' . '<td>' . $row["link_lot"] . '</td>'; ?>
      </tr>
     <?php endforeach; ?>
    <?php endif; ?>
  
    </tbody>
    </table>


    <div>
      <button type="button" class="btn btn-primary active" data-bs-toggle="button" autocomplete="off"  id="aligncenter" onClick='location.href="/index.php"' aria-pressed="true">Вернутся назад</button>
    </div>


    <!-- <input type="text"  name="title" class="title" value="4606018"> -->

    <!-- <button class="otpravka">Отправить</button> -->

    <!-- <button class="btn btn-info otpravka">Отправить</button>  -->

      <script>
        var arr = [];
                $(document).ready(function(){
                  $('input.title').on('click', function(){
                    //console.log('heelo world');
                    var titleVal = $('input.title').val();
                    //var content = $('input.title').val();
                    
                    //console.log(title);

                    $.ajax({
                      method: "POST",
                      url: "ajax.php",
                      data: { title: titleVal }
                    })
                      .done(function( msg ) {
                        alert( "Календарь: \n" + msg );
                      });
                  })    
                });

                   $(document).ready(function(){
  
                    //var arr = [];
                    $('input[type=checkbox]').on('change', function(){
                      if ($(this).is(':checked')) { 
                        arr.push($(this).attr('value'));
                        //arr.push($(this).attr('value'));
                      } else {
                        let idx = arr.indexOf($(this).attr('value'));
                        arr.splice(idx, 1);
                      }
                      
                      console.log(arr.join(', '));
                      //console.log(arr); //масив
                      $('.name').text('Лот: ' + arr.join(', Лот: ') );
                      
                      $('.gen').val(arr.join(' '))

                     // localStorage.setItem('appended', JSON.stringify(arr));
                        
                  });
                });

                
                // $(document).ready(function() { //локал сторейдж
                //     const items = localStorage.getItem('appended'); // получили по ключу свой элемент
                //     var elements = JSON.parse(items) || []; // распарсили полученный элемент
                //     // пройдем по элементам и добавим их к body
                //     for (var index = 0; index < elements.length; index++) {
                //       console.log(elements[index])
                //       //$('body').append(elements[index]); // дабавили к body наш элемент
                //       //$('.kek').val(elements[index]);
                //      // $('.name').text('Лоты: ' + elements);
                //     }
                // });


                $(document).ready(function(){
                  // $('button.link').on('click', function(){
                    $('input.link').on('click', function(){
                    //console.log('heelo world');
                    //var linkVal = $('input.gen').val();
                    var linkVal = arr;
                    //var linkVal = linkVal.toArray();
                    // for (var index = 0; index < linkVal.length; index++) {
                    //   console.log(linkVal[index])
                    // }
                   // var linkVal = 523;
                    //var content = $('input.title').val();
                    
                    //console.log(title);

                    console.log(arr);

                    $.ajax({
                      method: "POST",
                      url: "ajax.php",
                      data: { link: linkVal }
                    })
                      .done(function( msg ) {
                        //alert( "Отработано: \n" + msg );
                        $('.url').text(msg)
                      });
                  })    
                });
      </script>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

<!-- <script src="./main.js"></script> -->

</body>


</html>