<?php 

include 'parser/db.php';

$result = $conn->query("SELECT * FROM `lots_all`"); //выборка всех лотов

$lots = [];


    $kalendar = $conn->query("SELECT DISTINCT b.id_lot \n" //выборко только лотов где есть календарь

    . "FROM `lots_all` a\n"

    . "left join pricetable2 b on b.id_lot = a.id_lot;");

    $pricer = [];
          global $page;
          $page = isset($_GET['page']) ? $_GET['page'] : 0; //Пагинация
          $count = 20;

          foreach($result as $row){
            $lots[] = $row;
          }
          foreach($kalendar as $row){ //перебор где есть календарь
            $pricer[] = $row;
          }

           $page_count = floor(count($lots) / $count); //Пагинация

          if (isset($_POST['submit'])) { //кнопка с календарем

          $price = $conn->query("SELECT * FROM `pricetable2` WHERE id_lot =" . $_POST['submit'] . "");

          $row_cnt = $price->num_rows; // сколько строк вернул(проверка есть ли календарь)
           
          }
          
          /*if (isset($_POST['submitDB'])) { //кнопка с календарем

            $search = explode(" ", $_POST['search']); //Делаем раздельный поиск по каждому слову

            $count = count($search); //Считаем количсество слов

            
            $array = []; //Кладем в массив данные с поиска

            $i = 0;
            
            foreach($search as $key){
              if ($count != NULL ){
             
              $i++;
              
              if($i < $count) $array[] = "CONCAT (`id_lot`, `text_lot`) LIKE '%" . $key . "%' OR "; else $array[] = "CONCAT (`id_lot`, `text_lot`) LIKE '%" . $key . "%'";
              }
            }
          
            //$sql = "SELECT * FROM `lots_all` WHERE " .implode("", $array);
            //echo $sql;
            $res = $conn->query("SELECT * FROM `lots_all` WHERE " .implode("", $array) );

            $row_cnt = $res->num_rows; // сколько строк вернул(проверка есть ли календарь)
            //$res = $conn->query("SELECT * FROM `lots_all` WHERE `id_lot` LIKE '%$search%' or `name_lot` LIKE '%$search%'");
              if ($row_cnt != NULL){
                foreach($res as $row){   
                  echo $row["id_lot"] . "</br>";
                  echo $row["name_lot"] . "</br>";
                  echo $row["header_lot"];
                  echo $row["datetime"] . "</br>";
                  echo $row["price"];
                  echo $row["text_lot"] . "</br>" ;
                  echo $row["price_lot"] . "</br>";
                  echo trim($row["pricemin_lot"]);
                  echo trim($row["region_lot"] . "</br>");
                  echo $row["dates_lot"] . "</br>";
                  echo $row["torgi_lot"] . "</br>";
                  echo $row["dopinfo_lot"] . "</br>";
                  echo $row["dopinfo2_lot"] . "</br>"; 

                  }
              }
            }*/
        $conn->close();
        

?>
<!DOCTYPE html>
<html>

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <script
      src="https://code.jquery.com/jquery-3.6.0.min.js"
      integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
      crossorigin="anonymous">
    </script>
    <style>
      #zatemnenie {
        display: none; /* Скрыто по умолчанию */
          position: fixed; /*Оставаться на месте */
          z-index: 1; /* Сидеть на вершине */
          left: 0;
          top: 0;
          width: 100%; /* Полная ширина */
          height: 100%; /* Полная высота */
          overflow: auto; /* Включите прокрутку, если это необходимо */
          background-color: rgb(0,0,0); /* Цвет запасной вариант */
          background-color: rgba(0,0,0,0.4); /* Черный с непрозрачностью */
      }
      #okno {
        background-color: #fefefe;
        margin: 15% auto; /* 15% сверху и по центру */
        padding: 20px;
        border: 1px solid #888;
        width: 20%; /* Может быть больше или меньше, в зависимости от размера экрана */
        text-align: center; 
        vertical-align: middle;
      }
      #zatemnenie:target {display: block;}
      .close {
        display: inline-block;
        border: 1px solid #0000cc;
        color: #0000cc;
        padding: 0 12px;
        margin: 10px;
        text-decoration: none;
        background: #f2f2f2;
        font-size: 14pt;
        cursor:pointer;
        text-align: center; 
        vertical-align: middle;   
      } 
      .close:hover {background: #e6e6ff; }
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
      .podborka {
        max-width: 230px;
      }
      </style>
</head>

<body>


<!-- <input class="form-control" type="text" placeholder="Поиск по таблице" id="search-text" onkeyup="tableSearch()"> //Форма с поиском по таблице -->

  <form method="post" action="result.php">
    <input type="text" class="form-control" placeholder="Введите номер лота или описание лота" name="search" required>
    <input type="submit" name="submitDB"  class="btn btn-primary" value="Поиск">
  </form>  


  <!-- <div>
      <button type="button" class="btn btn-primary active" data-bs-toggle="button" autocomplete="off"  id="aligncenter" onClick="" aria-pressed="true">Скопировать ссылку</button>
  </div> -->

  <!-- <fieldset class="podborka">
    <legend>Подборка</legend>

    <label>Лот 123<input type="text" required></label>
    <label>Лот 456<input type="email" required></label> -->
    <!-- <label class="name"></label> -->
    <!-- <label>Лот 456</label>
    <br>
    <label>Лот 456</label>
    <label>Лот 456</label> 
  </fieldset> -->
  <!-- <form method="post" action="generator.php">
    <input type="hidden" class="gen" name="search" value="" required> 
    <input type="submit" name="submitLOT"  class="btn btn-primary" value="Сгенерировать">
  </form>  -->

  <!-- <button type="button" class="btn btn-primary active" data-bs-toggle="button" autocomplete="off" name="submitLOT" id="aligncenter"  aria-pressed="true">Сгенерировать</button> -->


<table class="table table-bordered table-dark" align="center" id="info-table"> 
  <thead>
    <tr align="center" style="vertical-align: middle">
      <!-- <th scope="col">#</th> -->
      <th scope="col">ID Лота</th>
      <th scope="col">Изображение</th>
      <th scope="col">Текст</th>
      <th scope="col">Цена лота</th>
      <th scope="col">Прием заявок</th>
      <th scope="col">Регион</th>
      <!-- <th scope="col">Стрелка</th> -->
      <!-- <th scope="col">Календарь</th> -->
      <th scope="col">Наименование</th>
      <th scope="col">Заголовок</th>
      <!-- <th scope="col">Дата календаря цены</th>
      <th scope="col">Цена календаря</th>  -->
      <th scope="col">Минмальная цена</th>
      <th scope="col">Проведение заявок</th>
      <th scope="col">Проведение торгов</th>
      <th scope="col">Кто проводит торги</th> 
      <th scope="col">Телефон</th>
      <th scope="col">Email</th>
      <th scope="col">Ссылка на лот</th>
    </tr>
  </thead>
  <tbody>
  <?php for($i = $page*$count; $i <= ($page+1)*$count; $i++) :?>
      <tr align="justify">
            <?php if($lots[$i]['id_lot'] != NULL):?>      <!--//если лот найден - выводим, ниже вывод всей таблицы -->     
            <?php 
            $var = ($lots[$i]['price_lot'] == 1) ? '<img src="/uparrow.png" width="15" height="15">' : '<img src="/downarrow.png" width="15" height="15">'; 
            echo '<td><input type="button" id="submit" class="btn btn-info title" name="title" value="' . $lots[$i]['id_lot']  . '" data-lot="'. $lots[$i]['id_lot'] . '"></td>' . '<td> <p class="aligncenter"><img src="' . $lots[$i]['img_lot'] . '"width="350"></p></td>'. '<td class="text">' .$lots[$i]['text_lot'] . '</td>'
            . '<td style="text-align: center;" width="180" >' . $lots[$i]['price_lot'] . ' ' . $var . '</td>'
            . '<td>' .$lots[$i]['dopinfo2_lot'] . '</td>' . '<td class="region">' .$lots[$i]['region_lot'] . '</td>' . '<td>' . $lots[$i]['name_lot'] . '<td>' .$lots[$i]['header_lot'] 
            . '<td>' .$lots[$i]['pricemin_lot'] . '</td>' . '<td>' .$lots[$i]['dates_lot'] . '</td>' 
            . '<td>' .$lots[$i]['torgi_lot'] . '</td>' . '<td>' . $lots[$i]['dopinfo_lot'] . '  ' .$lots[$i]['dopinfo2_lot'] . '</td>' . '<td>' . $lots[$i]['phone_lot'] . '</td>' . '<td>' . $lots[$i]['email_lot'] . '</td>' . '<td>' . $lots[$i]['link_lot'] . '</td>';?>  
          <?php endif;?>
          <?php endfor;?> 
    </tr> 

     <!-- <form action="#zatemnenie" method="POST" target="_self"><input type="submit" class="btn btn-info" name="submit" value="'  </form>--> 
     <!-- '<td><input type="submit" class="btn btn-info title" name="title" value="' . $lots[$i]['id_lot']  . '"></td>' -->
        <!-- <a href="#zatemnenie">Вызвать всплывающее окно</a> -->
     <!-- <tr>
      <th scope="row">2</th>
      <td>@TwBootstrap</td>
      <td>@TwBootstrap</td>
      <td>@TwBootstrap</td>
    </tr> -->
    <!-- <tr>
      <th scope="row">3</th>
      <td>Jacob</td>
      <td>Thornton</td>
      <td>@fat</td>
    </tr>
    <tr>
      <th scope="row">4</th>
      <td colspan="2">Larry the Bird</td>
      <td>@twitter</td>
    </tr> -->
  </tbody>
</table>

  <div class ="page_list" align="center">
          <?php for($p = 0; $p <= $page_count; $p++) :?> 
          <a href="?page=<?php echo $p; ?>"><button class ="page_button"><?php echo $p + 1 ?></button></a>
          <?php endfor;?>
  </div>
  <script>
                 $(document).ready(function(){
                  $('input.title').on('click', function(){
                    //console.log('heelo world');
                    var titleVal = $('input.title').val();
                    //var titleVal = $('input.title').val();
                    //var content = $('input.title').val();
                    
                    //console.log(titleVal);

                    $.ajax({
                      method: "POST",
                      url: "ajax.php",
                      //data: { title: titleVal }
                      data: {title: $(this).data('lot')}, //.attr('data-poezd')
                    })
                      .done(function( msg ) {
                        alert( "Календарь: \n" + msg );
                      });
                  });  
                 });

                // // $('#submit').click(function(){
                // //   $.ajax({ 
                // //         type: 'post',
                // //         url: 'ajax.php',
                // //         data: ('#form_1').serialize(),
                // //         success: function(response) {
                // //             $('#tablica1').html(response);
                // //         }
                // //   });
                // // });

                // // if ($('#checkbox').is(':checked')){
                // //       alert('Включен');
                // //     } else {
                // //       alert('Выключен');
                // //     }

               
                   
                //    $(document).ready(function(){
  
                //     var arr = [];
                //     $('input[type=checkbox]').on('change', function(){
                //       if ($(this).is(':checked')) { 
                //         arr.push($(this).attr('value'));
                //         //arr.push($(this).attr('value'));
                //       } else {
                //         let idx = arr.indexOf($(this).attr('value'));
                //         arr.splice(idx, 1);
                //       }
                      
                //       console.log(arr.join(', '));
                //       //console.log(arr); //масив
                //      // $('.name').text('Лот: ' + arr.join(', Лот: ') );
                      
                //       $('.gen').val(arr.join(' '))

                //       localStorage.setItem('appended', JSON.stringify(arr));
                // //       // $.ajax({
                // //       //   url: 'ajax.php',
                // //       //   type: 'post',
                // //       //   // передаем в data массив со значениями checkbox и значение select
                // //       //   data: {
                // //       //     ch: cBox,
                // //       //     sel: selectedValue
                // //       //   }
                // //       // }).done(function(msg) {
                // //       //   $('#result').html(msg);
                // //       // });
                    
                //   });
                // });

                
                // $(document).ready(function() { //локал сторейдж
                //     const items = localStorage.getItem('appended'); // получили по ключу свой элемент
                //     var elements = JSON.parse(items) || []; // распарсили полученный элемент
                //     // пройдем по элементам и добавим их к body
                //     for (var index = 0; index < elements.length; index++) {
                //       console.log(elements[index])
                //       //$('body').append(elements[index]); // дабавили к body наш элемент
                //       //$('.kek').val(elements[index]);
                //       $('.name').text('Лоты: ' + elements);
                //     }
                // });

                
                  

      </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="./main.js"></script> 
    
        
</body>

</html>
