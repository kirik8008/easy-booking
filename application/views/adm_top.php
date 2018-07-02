<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Администратора панель</title>
	<link rel="stylesheet" href="<?=base_url(); ?>sag/css/bootstrap.min.css">
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" ></script>
	<link href="<?=base_url(); ?>sag/css/font-awesome.css" rel="stylesheet">
	<script src="<?=base_url(); ?>sag/js/bootstrap.min.js"></script>
<script src="<?=base_url(); ?>sag/js/jquery-2.1.3.min.js"></script>
	<script type="text/javascript">
            function AjaxFormRequest(result_id,form_id,url) {
                jQuery.ajax({
                    url:     url, //Адрес подгружаемой страницы
                    type:     "POST", //Тип запроса
                    dataType: "html", //Тип данных
                    data: jQuery("#"+form_id).serialize(),
                    success: function(response) { //Если все нормально
                    document.getElementById(result_id).innerHTML = response;
                },
                error: function(response) { //Если ошибка
                document.getElementById(result_id).innerHTML = "Ошибка при отправке формы";
                }
             });
        }
   </script>

</head>
<body>

	<div class="modal" id="service_dialog">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Панель администратора</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
					</div>
					<div class="modal-body" id="service_div">

					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
					</div>
				</div>
			</div>
	</div>

<nav class="navbar navbar-expand-md bg-secondary navbar-dark">
    <div class="container">
      <a class="navbar-brand" href="#">Администратора панель</a>
      <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item">
            <a class="nav-link" href="#"><i class="fa fa-info"></i> Информация</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="http://example.com" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-bookmark"></i> Бронь</a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
              <a class="dropdown-item" href="<?=base_url()?>administrator/booking_add"><i class="fa fa-clock-o"></i> Ожидают подтверждения</a>
              <a class="dropdown-item" href="<?=base_url()?>administrator/reservation"><i class="fa fa-book"></i> Ближайшие</a>
              <a class="dropdown-item" href="#"><i class="fa fa-calendar"></i> Все брони</a>
              <a class="dropdown-item" href="<?=base_url()?>administrator/print_booking"><i class="fa fa-print"></i> На печать</a>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#"><i class="fa fa-history"></i> История</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="http://example.com" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cogs"></i> Настройки&nbsp;</a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
              <a class="dropdown-item" href="<?=base_url();?>administrator/configure/site"><i class="fa fa-sitemap"></i> Сайт</a>
              <a class="dropdown-item" href="<?=base_url();?>administrator/configure/booking"><i class="fa fa-bookmark"></i> Бронирование</a>
            </div>
          </li>
        </ul>

        <form class="form-inline m-0" id="cm-search" action="" onkeyup="AjaxFormRequest('global', 'cm-search', '<?=base_url();?>administrator/search_booking')">
          <input class="form-control mr-1" name="search" type="search" placeholder="Поиск брони">
        </form>

      </div>
    </div>
  </nav>

<? if(!empty($result)) echo $result;?>
