<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?> 
<script type="text/javascript">
function time_check(time_booking) {
document.getElementById('time').value=time_booking;
var div1 = document.getElementById("view_time_div");
div1.classList.add("alert");
div1.classList.add("alert-dark");
div1.innerHTML = "Бронь на <?=$date?> " + time_booking;
return false;
}

</script>

<div class="py-5" >
    <div class="container">
      <div class="row">
        <div class="col-md-6">
          <div class="card">
            <div class="card-header">Доступное время для бронирования <?=$date?></div>
            <div class="card-body">
            <div class="btn-group-toggle" data-toggle="buttons">
            	<? foreach($time as $key => $value) { ?>
  				<label class="btn btn<?=$value['img']?> ">
    				<input type="radio" name="<?=$value['time']?>" value="<?=$value['time']?>" <? if(empty($value['del'])) {?>onChange="time_check('<?=$value['time']?>');" <? } ?> id="<?=$value['time']?>" autocomplete="off"> <?=$value['time']?>
  				</label>
  				<? } ?>
			</div>
            </div>
            <div class="card-footer text-muted">
    			<?=$automatic_confirmation;?>
  			</div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="card">
            <div class="card-header"> Данные для бронирования </div>
            <div class="card-body">
              <? echo form_open(); ?>
              <div class="form-group">
                  	<div class="" id="view_time_div" role="alert">
					</div>
					<input type="hidden" id="time" name="time" value="">
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Фамилия</label>
                  <input type="text" class="form-control" name="surname_user" placeholder="Иванов" required="required">
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Имя</label>
                  <input type="text" class="form-control" name="name_user" placeholder="Иван" required="required">
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Отчество</label>
                  <input type="text" class="form-control" name="middlename_user" placeholder="Иванович">
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Номер телефона</label>
                  <input type="text" class="form-control" name="phone_user" placeholder="+7-900-123-45-67" required="required">
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">E-Mail</label>
                  <input type="email" class="form-control" name="email_user" placeholder="box@mail.com" required="required">
                </div>
                <p>При нажатии на кнопку Забронировать, вы соглашаетесь с <a href="#">политикой конфиденциальности</a>.</p>
                <button type="submit" class="btn btn-primary">Забронировать
                </button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
