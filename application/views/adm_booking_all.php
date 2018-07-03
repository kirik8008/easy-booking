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
                <th>Функции</th>
              </tr>
            </thead>
            <tbody>
              <? if(!empty($expect)) {
                ?>
                    <tr class="table-primary"><TD COLSPAN=8><center>Ожидают подтверждения.</center></TD></tr>
                <?
                 foreach($expect as $i) { ?>
                <tr>
                  <td><?=$i['RESERVATION_NUMBER']?></td>
                  <td><?=$i['DATE']?> <?=$i['TIME']?></td>
                  <td><?=$i['SURNAME']?></td>
                  <td><?=$i['NAME']?></td>
                  <td><?=$i['MIDDLENAME']?></td>
                  <td><?=$i['PHONE']?></td>
                  <td><?=$i['EMAIL']?></td>
                  <td><a class="btn btn-success btn-sm" href='<?=base_url()?>administrator/confirmbooking/<?=$i['KEY']?>'><i class="fa fa-check-circle" aria-hidden="true"></i> Подтвердить</a></td>
                </tr>
              <? } }?>
            <? if(!empty($open)) {
              ?>
                  <tr class="table-primary"><TD COLSPAN=8><center>Открытые<i class="far fa-smile"></i></center></TD></tr>
              <?
              foreach($open as $i) {?>
              <tr>
                <td><?=$i['RESERVATION_NUMBER']?></td>
                <td><?=$i['DATE']?> <?=$i['TIME']?></td>
                <td><?=$i['SURNAME']?></td>
                <td><?=$i['NAME']?></td>
                <td><?=$i['MIDDLENAME']?></td>
                <td><?=$i['PHONE']?></td>
                <td><?=$i['EMAIL']?></td>
                <td><a class="btn btn-warning btn-sm" href='<?=base_url()?>administrator/cancelbooking/<?=$i['KEY']?>'><i class="fa fa-ban" aria-hidden="true"></i> Отменить</a></td>
              </tr>
            <? } } if(!empty($close)) {
                ?>
                    <tr class="table-primary"><TD COLSPAN=8><center>Завершенные<i class="far fa-smile"></i></center></TD></tr>
                <?
                foreach($close as $i){?>
                  <tr>
                    <td><?=$i['RESERVATION_NUMBER']?></td>
                    <td><?=$i['DATE']?> <?=$i['TIME']?></td>
                    <td><?=$i['SURNAME']?></td>
                    <td><?=$i['NAME']?></td>
                    <td><?=$i['MIDDLENAME']?></td>
                    <td><?=$i['PHONE']?></td>
                    <td><?=$i['EMAIL']?></td>
                    <td><a class="btn btn-danger btn-sm" href='#<?=$i['KEY']?>'><i class="fa fa-trash" aria-hidden="true"></i> Удалить</a></td>
                  </tr>
            <? } }?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
