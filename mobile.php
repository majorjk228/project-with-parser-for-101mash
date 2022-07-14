<?php 

include 'parser/db.php';

$result = $conn->query("SELECT * FROM `lots_all`"); //выборка всех лотов

$lots = [];


    $kalendar = $conn->query("SELECT DISTINCT b.id_lot \n" //выборко только лотов где есть календарь

    . "FROM `lots_all` a\n"

    . "left join pricetable2 b on b.id_lot = a.id_lot;");

    $pricer = [];
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
        $conn->close();
?>
<!DOCTYPE html>
<html>

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel='stylesheet' href='style.css' />
    <style>
      #zatemnenie {
        background: rgba(102, 102, 102, 0.5);
        width: 400px;
        height: 550px;  
        position: absolute;
        top: 0;
        left: 0; 
        display: none;  
      }
       #okno {
        width: 400px;
        height: 550px;  
        text-align: center;
        padding: 15px;
        border: 3px solid #0000cc;
        border-radius: 10px;
        color: #e31021; 
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        margin: auto;
        background: #fff;
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
      }
      </style> 
</head>

<body>


<input class="form-control" type="text" placeholder="Поиск по таблице" id="search-text" onkeyup="tableSearch()"> <!--//Форма с поиском по таблице -->

<!-- Кнопка-триггер модального окна тест модального онка
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
  Запустите демо модального окна
</button>

<!-- Модальное окно -->
<!-- <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Заголовок модального окна</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
      </div>
    </div>
  </div>
</div> -->

<div class="container">
<table class="table table-bordered table-dark" id="info-table"> 
  <thead>
    <!-- <tr style="vertical-align: middle"> -->
    <tr>
      <!-- <th scope="col">#</th> -->
      <th scope="col">ID Лота</th>
      <th scope="col">Календарь</th>
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
      <th scope="col">Кто проводит торги 2</th>
      <th scope="col">Изображение</th>
      <th scope="col">Стрелка</th>
      <th scope="col">Телефон</th>
      <th scope="col">Email</th>
    </tr>
  </thead>
  <tbody>
   <?php for($i = $page*$count; $i <= ($page+1)*$count; $i++) :?> <!--//вывод по 20 элементов БД -->
      <tr align="justify">
            <?php if($lots[$i]['id_lot'] != NULL):?>      <!--//если лот найден - выводим, ниже вывод всей таблицы -->     
            <?php echo '<td data-label="ID Лота">' . $lots[$i]['id_lot'] . '</td>' . '<td data-label="Календарь"><form action="#zatemnenie" method="POST" target="_self"><input type="submit" class="btn btn-info" name="submit" value="' . $lots[$i]['id_lot']  . '"/></form></td>' . '<td data-label="Наименование">' . $lots[$i]['name_lot'] . '</td>' . '<td data-label="Заголовок">' .$lots[$i]['header_lot'] . '</td>' . '<td data-label="Текст" class="text">' .$lots[$i]['text_lot'] . '</td>'
            . '<td data-label="Цена лота">' .$lots[$i]['price_lot'] . '</td>' . '<td data-label="Минмальная цена">' .$lots[$i]['pricemin_lot'] . '</td>' . '<td data-label="Регион" class="region">' .$lots[$i]['region_lot'] . '</td>' . '<td data-label="Прием заявок">' .$lots[$i]['dates_lot'] . '</td>' . '<td data-label="Проведение торгов">' .$lots[$i]['torgi_lot'] . '</td>'
            . '<td data-label="Кто проводит торги">' .$lots[$i]['dopinfo_lot'] . '</td>'. '<td data-label="Кто проводит торги 2">' .$lots[$i]['dopinfo2_lot'] . '</td>'. '<td data-label="Изображение"> <p class="aligncenter"><img src="' . $lots[$i]['img_lot'] . '"width="350"></p></td>'. '<td data-label="Стрелка" style="text-align: center;">' . $lots[$i]['arrow_lot'] . '</td>' . '<td data-label="Телефон">' . $lots[$i]['phone_lot'] . '</td>' . '<td data-label="Email">' . $lots[$i]['email_lot'] . '</td>';?>  
      </tr> 
    <?php endif;?>
    <?php endfor;?> 
    <div id="zatemnenie">
      <div id="okno">
      <?php
      if ($row_cnt != NULL){ //формирование календаря с цен, его вывод
              foreach($price as $row){   
                $id = $row["datetime"];
                $link = $row["price"];
                echo $id . " — " . $link . "₽ </br>";     
            }
            echo '<a href="#" class="close">Закрыть окно</a>';
            //echo '<button type="button" class="btn btn-secondary close" data-bs-dismiss="modal">Закрыть</button>';
          }
          else 
          {
            echo 'Таблица с ценами у данного лота отсутсвует </br>';
            echo '<a href="#" id="clickclose" class="close">Закрыть окно</a>';
            echo '<script type="text/javascript">document.getElementById(\'clickclose\').click();</script>'; // автоматическое закрытие календаря, если его нет
          }?>
        <!-- <a href="#" class="close">Закрыть окно</a> -->
      </div>
    </div>
     
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
</div>

  <div class ="page_list" align="center">
          <?php for($p = 0; $p <= $page_count; $p++) :?> 
          <a href="?page=<?php echo $p; ?>"><button class ="page_button"><?php echo $p + 1 ?></button></a>
          <?php endfor;?>
  </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="./main.js"></script> <!--подключение поиска  -->
        
</body>

</html>
