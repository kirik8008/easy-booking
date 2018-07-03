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
              <label for="time_booking">Номер телефона администратора</label>
              <input type="text" class="form-control" id="phone_admin" name="phone_admin" value="<?=$phone_admin?>">
              <small class="text-muted form-text">Обязательно, если будете использовать sms api. (Формат: 79001234567)</small>
            </div>
            <div class="form-group">
              <label for="time_booking">Почта администратора</label>
              <input type="email" class="form-control" id="email_admin" name="email_admin" value="<?=$email_admin?>">
              <small class="text-muted form-text">Обязательно, если будете использовать отправку email сообений.
                <? if($smtp_host!='' and $smtp_user!='' and $smtp_pass!='') { ?> <a data-toggle="modal" onClick="AjaxFormRequest('service_div', '_', '<?=base_url();?>administrator/send_message/email')" href="#service_dialog"> отправить тестовое сообщение. </a> <? } ?>
              </small>
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
          <div class="form-group">
            <label for="time_booking">Сервер SMTP</label>
            <input type="text" class="form-control" id="smtp_host" name="smtp_host" placeholder="Например smtp.yandex.ru" value="<?=$smtp_host?>">
            <small class="text-muted form-text">Указать сервер для подключения SMTP</small>
          </div>
          <div class="form-group">
            <label for="time_booking">Порт подключения SMTP</label>
            <input type="text" class="form-control" id="smtp_port" name="smtp_port" placeholder="465" value="<?=$smtp_port?>">
          </div>
          <div class="form-group">
            <label for="time_booking">Пользователь SMTP</label>
            <input type="text" class="form-control" id="smtp_user" name="smtp_user" value="<?=$smtp_user?>">
          </div>
          <div class="form-group">
            <label for="time_booking">Пароль подключения SMTP</label>
            <input type="password" class="form-control" id="smtp_pass" name="smtp_pass" value="<?=$smtp_pass?>">
          </div>
          <div class="form-group">
            <label for="time_booking">API sms (api_id)</label>
            <input type="text" class="form-control" id="sms_api" name="sms_api"  value="<?=$sms_api?>">
            <small class="text-muted form-text">На данный момент доступно только использование сервисов: <a href="https://pitka.sms.ru" target="_blank">sms.ru</a> (промокод: "pitka")
              <? if($sms_api!='' and $phone_admin!='') { ?> <a data-toggle="modal" onClick="AjaxFormRequest('service_div', '_', '<?=base_url();?>administrator/send_message/sms')" href="#service_dialog"> отправить тестовое сообщение. </a> <? } ?>
            </small>
          </div>


            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Сохранить</button>
          </form>
        </div>
      </div>

    </div>
  </div>
