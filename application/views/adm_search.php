<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

    <div class="container">
      <div class="row">
        <div class="col-md-12" >
          <table class="table">
            <thead>
              <tr>
                <th>#</th>
                <th>Бронь на дату</th>
                <th>Фамилия</th>
                <th>Имя</th>
                <th>Отчество</th>
                <th>Телефон</th>
                <th>E-Mail</th>
              </tr>
            </thead>
            <tbody>
            <? if(!empty($search)) { foreach($search as $i) {?>
              <tr>
                <td><?=$i['RESERVATION_NUMBER']?></td>
                <td><?=$i['DATE']?> <?=$i['TIME']?></td>
                <td><?=$i['SURNAME']?></td>
                <td><?=$i['NAME']?></td>
                <td><?=$i['MIDDLENAME']?></td>
                <td><?=$i['PHONE']?></td>
                <td><?=$i['EMAIL']?></td>
              </tr>
              <? } }else {?>
              <tr class="table-primary"><TD COLSPAN=7><center>Пустенько... <i class="far fa-smile"></i> Ничего не найдено.</center></TD></tr>
              <? } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
