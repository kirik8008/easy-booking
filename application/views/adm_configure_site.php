<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

 <div class="py-5" id="global">
    <div class="container">
      <div class="row">
        <div class="col-md-6">
          <? echo form_open(); ?>
          	<input type="hidden" name="post_site" value="true">
            <div class="form-group">
              <label for="time_booking">Название сайта</label>
              <input type="text" class="form-control" id="name_site" name="name_site" placeholder="Название сайта" required="required" value="<?=$name_site?>">
              <small class="text-muted form-text">Название вашего календаря,страницы бронирования и т.п.</small>
            </div>
            <div class="form-group">
                  <label>Личный кабинет</label>
                  <div class="form-check">
                  	<input type="hidden" name="user_account" value="off">
                    <input class="form-check-input" type="checkbox" name="user_account" id="user_account" <?=$user_account?>>
                    <label class="form-check-label" for="user_account">Включить</label>
                  </div>
                  <small class="text-muted form-text">Кабинет для просмотра бронии пользователем. В нём можно: просмотреть,отменить бронь, а так же посмотреть архивные.</small>
            </div>
            <div class="form-group">
                  <label>API брнирования</label>
                  <div class="form-check">
                  	<input type="hidden" name="api_booking" value="off">
                    <input class="form-check-input" type="checkbox" name="api_booking" id="api_booking" <?=$api_booking?>>
                    <label class="form-check-label" for="api_booking">Включить</label>
                  </div>
                  <small class="text-muted form-text">Доступность функций бронирования со стороны.</small>
            </div>
            <div class="form-group">
                  <label for="exampleInputEmail1">Оповещение пользователя о бронировании</label>
                  <div class="form-check">
                  	<input type="hidden" name="notification_email" value="off">
                    <input type="hidden" name="notification_sms" value="off">
                    <input class="form-check-input" type="checkbox" name="notification_email" id="notification_email" <?=$notification_email?>>
                    <label class="form-check-label" for="notification_email">По E-mail</label><br>
                    <input class="form-check-input" type="checkbox" name="notification_sms" id="notification_sms" <?=$notification_sms?>>
                    <label class="form-check-label" for="notification_sms">По sms</label>
                  </div>
                  <small class="text-muted form-text">Оповещение будет работать, если ниже указаны корректные настройки e-mail или sms.</small>
            </div>
        </div>
        <div class="col-md-6">



            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Сохранить</button>
            <? if(!empty($time)) {?><a class="btn btn-primary" data-toggle="modal" href="#test" role="button" aria-expanded="false" aria-controls="collapseExample">Показать расписание</a>
            <? } ?>
          </form>
        </div>
      </div>

    </div>
  </div>
