<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Администратора панель</title>
	<link rel="stylesheet" href="<?=base_url(); ?>sag/css/bootstrap.min.css">
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" ></script>
	<link href="<?=base_url(); ?>sag/css/fontawesome-all.css" rel="stylesheet">
	<script src="<?=base_url(); ?>sag/js/bootstrap.min.js"></script>  
	
</head>
<body>
    <div class="container">
      <div class="row">
        <div class="col-md-12" >
        Забронированное время на <?=$date?>
          <table class="table table-sm">
            <thead>
              <tr>
                <th>#</th>
                <th>Бронь на дату</th>
                <th>Фамилия</th>
                <th>Имя</th>
                <th>Отчество</th>
                <th>Телефон</th>
                <th>Примечание</th>
              </tr>
            </thead>
            <tbody>
            <? if(!empty($today)) { foreach($today as $i) {?>
              <tr>
                <td><?=$i['RESERVATION_NUMBER']?></td>
                <td><?=$i['DATE']?> <?=$i['TIME']?></td>
                <td><?=$i['SURNAME']?></td>
                <td><?=$i['NAME']?></td>
                <td><?=$i['MIDDLENAME']?></td>
                <td><?=$i['PHONE']?></td>
                <td></td>
              </tr>
              <? } }else {?>
              <tr class="table-primary"><TD COLSPAN=7><center>Пустенько... <i class="far fa-smile"></i> Ничего не найдено.</center></TD></tr>
              <? } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
