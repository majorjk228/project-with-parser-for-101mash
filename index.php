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
        $conn->close();
        

?>
<!DOCTYPE html>
<html>

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  
    <style>
      .aligncenter {
         text-align: center; 
         vertical-align: middle;   
      }
      .white {
        vertical-align: middle;
        background-color: #f0f4c3;
      }
      .podborka {
        max-width: 230px;
      }
       /* td.text {
       /* max-width: 500px; */
       /* white-space: nowrap; /* Запрещаем перенос строк */
       /* overflow: hidden; /* Обрезаем все, что не помещается в область */
       /* padding: 5px; /* Поля вокруг текста */
       /* text-overflow: ellipsis; /* Добавляем многоточие */
      /* }*/
      .content_block{
        max-width: 500px; 
        white-space: nowrap; /*Запрещаем перенос строк*/
        overflow: hidden; /*Обрезаем все, что не помещается в область*/
        padding: 5px; /*Поля вокруг текста*/
        text-overflow: ellipsis; /*Добавляем многоточие*/
        /* transition: all 5s; */
      }
       .active{
        max-width: 100%;
        white-space: normal;
        overflow: visible;
      }  

      

      </style>
</head>

<body>
  <form method="post" action="result.php">
    <input type="text" class="form-control" placeholder="Введите номер лота или описание лота" name="search" required>
    <input type="submit" name="submitDB"  class="btn btn-primary" value="Поиск">
  </form>  

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
      <th scope="col">Ссылка на лот</th> <p class="aligncenter"><img src="' . $lots[$i]['img_lot'] . '"width="350"></p> -->
    </tr>
  </thead>
  <tbody>
  <?php for($i = $page*$count; $i <= ($page+1)*$count; $i++) :?>
      <tr align="justify">
            <?php if($lots[$i]['id_lot'] != NULL):?>      <!--//если лот найден - выводим, ниже вывод всей таблицы -->  
            <?php 
            $var = ($lots[$i]['price_lot'] == 1) ? '<img src="/uparrow.png" width="15" height="15">' : '<img src="/downarrow.png" width="15" height="15">'; 
            echo 
            '<td><input type="button" id="submit" class="btn btn-info title" name="title" value="' . $lots[$i]['id_lot']  . '" data-lot="'. $lots[$i]['id_lot'] . '"></td>' . 
            '<td>       
            <div id="carouselExampleInterval-'.$i.'" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
              <div class="carousel-item active" data-bs-interval="99999999999999">
                <img src="' . $lots[$i]['img_lot'] . '" class="d-block w-350" width="350" alt="...">
              </div>
              <div class="carousel-item" data-bs-interval="99999999999999">
                <img src="' . $lots[$i+10]['img_lot'] . '" class="d-block w-350" width="350" alt="...">
              </div>
              <div class="carousel-item">
                <img src="' . $lots[$i+20]['img_lot'] . '" class="d-block w-350" width="350"  alt="...">
              </div>
            </div>
            <button class="carousel-control-prev" type="button" name="'.$i.'" data-bs-target="#carouselExampleInterval-'.$i.'" data-bs-slide="prev">
              <span class="carousel-control-prev-icon aria-hidden="true"></span>
              <span class="visually-hidden">Предыдущий</span>
            </button>
            <button class="carousel-control-next" type="button" name="'.$i.'" data-bs-target="#carouselExampleInterval-'.$i.'" data-bs-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Следующий</span>
            </button>
          </div>
            </td>'.
            '<td class="text"><div class="content_block  block-'.$i.'">' . $lots[$i]['text_lot'] . '</div>
            <br><input type="button" id="submit" class="btn btn-info content_toggle block-'.$i.'" name="'.$i.'" value="Показать текст"></td>' .
            '<td style="text-align: center;" width="130" >' . $lots[$i]['price_lot'] . ' ' . $var . '</td>' .
            '<td>' . $lots[$i]['dopinfo_lot'] . '  ' .$lots[$i]['dopinfo2_lot'] . '</td>' . 
            '<td class="region">' .$lots[$i]['region_lot'] . '</td>';?>  
          <?php endif;?>
          <?php endfor;?> 
    </tr> 
  </tbody>
</table>

  <div class ="page_list" align="center">
          <?php for($p = 0; $p <= $page_count; $p++) :?> 
          <a href="?page=<?php echo $p; ?>"><button class ="page_button"><?php echo $p + 1 ?></button></a>
          <?php endfor;?>
  </div>  
  <script
      src="https://code.jquery.com/jquery-3.6.0.min.js"
      integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
      crossorigin="anonymous">
  </script>
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

                 $(document).ready(function(){
                    $('.content_toggle').click(function(){ //для отслеживание показа текста
                      var idRow = $(this).attr("name");
                      if ($('.block-' + idRow).hasClass("active")) {
                        
                        $('.block-' + idRow).removeClass("active");
                        $('.block-' + idRow).val("Показать текст"); 

                        //console.log(idRow);
                      }else {
                        
                        $('.block-' + idRow).addClass("active");
                        $('.block-' + idRow).val("Скрыть текст");
                      }
                      
                            
                      return false;
                    });
                    $('.carousel-control-prev').click(function(){ // Предыдущий слайд
                      var idPrev = $(this).attr("name");
                      //$('.prev-' + idPrev).click(); 
                      $('.prev-' + idPrev).attr('data-bs-target', '#carouselExampleInterval-' + idPrev);
                      
                      console.log(idPrev);
                    });
                });

              
                 /*$(document).ready(function() {
                  $('.show_text').on('click',function() {
                      if($(this).prev().is(':visible')) {
                              $(this).text('Показать скрытое');
                          $(this).prev().hide('slow');
                      } else {
                              $(this).text('Скрыть показанное');
                          $(this).prev().show('slow');
                      }
                  });
              });*/

      </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="./main.js"></script> 
    
        
</body>

</html>
