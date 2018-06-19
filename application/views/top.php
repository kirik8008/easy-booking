<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title><?=$settings['name_site'];?></title>
	<link rel="stylesheet" href="<?=base_url(); ?>sag/css/bootstrap.min.css">
	<link href="<?=base_url(); ?>sag/css/font-awesome.css" rel="stylesheet">
	<script src="<?=base_url(); ?>sag/js/jquery-2.1.3.min.js"></script>
	<script src="<?=base_url(); ?>sag/js/bootstrap.js"></script>
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
                document.getElementById(result_id).innerHTML = "Ошибка при отправке формы" + result_id + " !!! " + form_id + " !!! " + url;
                }
             });
        }
   </script>
</head>
<body>

	<div class="modal" id="search_dialog">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Поиск брони</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
					</div>
					<div class="modal-body" id="search_booking">

					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
					</div>
				</div>
			</div>
	</div>
		<nav class="navbar navbar-expand-md navbar-dark bg-secondary">
			 <a class="navbar-brand" href="<?=base_url()?>"><?=$settings['name_site'];?></a>
			 <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
				 <span class="navbar-toggler-icon"></span>
			 </button>
			 <div class="collapse navbar-collapse" id="navbarCollapse">
				 <ul class="navbar-nav mr-auto">
					 <li class="nav-item active">
						 <a class="nav-link" href="<?=base_url()?>">Главная <span class="sr-only">(current)</span></a>
					 </li>
					 <li class="nav-item">
						 <a class="nav-link" href="<?=base_url()?>view">Кабинет</a>
					 </li>
					 <li class="nav-item">
						 <a class="nav-link disabled" href="#">Disabled</a>
					 </li>
				 </ul>
				 <form class="form-inline m-0" id="cm-search" action="" onkeyup="AjaxFormRequest('search_booking', 'cm-search', '<?=base_url();?>view/search')">
					 <input class="form-control mr-sm-2" name="nomber_booking" type="text" placeholder="Номер брони" aria-label="">
					 <input class="form-control mr-sm-2" name="nomber_phone" type="text" placeholder="Номер телефона" aria-label="Search">
					 <a class="btn btn-outline-light my-2 my-sm-0" data-toggle="modal" href="#search_dialog" type="submit">Найти</a>
				 </form>
			 </div>
		 </nav>

<? if(!empty($error)) echo $error;?>
