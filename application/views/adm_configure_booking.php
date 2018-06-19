<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<link rel="stylesheet" href="<?=base_url(); ?>sag/css/tcal.css">
<script src="<?=base_url(); ?>sag/js/tcal.js"></script>

<script type="text/javascript">
function Show_time(a) {
        start=document.getElementById("date_start");
        end=document.getElementById("date_end");
        switch(a)
        {
        	case 2: {start.disabled = false; end.disabled = true; break;}
        	case 3: {start.disabled = false; end.disabled = false; break;}
        	default: {start.disabled = true; end.disabled = true;}
        	//default: {obj.style.display="none"; objtwoo.style.display="none";}
        }
}
</script>

<? if(!empty($time)) {?>
<div class="modal" id="test">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Расписание брони.</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
					<table class="table table-hover table-sm" >
						<thead>
    					<tr>
      					<th scope="col">#</th>
      					<th scope="col">Время брони</th>
    					</tr>
  						</thead>
        			<? foreach($time as $key => $value) { ?>
        				<tr><td><?=$key+1?></td><td><?=$value?></td></tr>
        			<? } ?>
        			</table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
        </div>
      </div>
    </div>
</div>
<? } ?>
 <div class="py-5" id="global">
    <div class="container">
      <div class="row">
        <div class="col-md-6">
          <? echo form_open(); ?>
          	<input type="hidden" name="post_booking" value="true">
            <div class="form-group">
              <label for="exampleInputEmail1">Бронирование</label>
              <div class="form-check">
              	<div class="custom-control custom-radio">
                <input type="radio" id="customRadio1" value="1" onClick="Show_time(1);" name="booking_status" class="custom-control-input" <?=$booking_on;?>>
                <label class="custom-control-label" for="customRadio1">Включено</label>
              </div>
              <div class="custom-control custom-radio">
                <input type="radio" id="customRadio2" value="2" onClick="Show_time(2);" name="booking_status" class="custom-control-input" <?=$booking_available;?>>
                <label class="custom-control-label" for="customRadio2">Доступно с</label>
              </div>
              <div class="custom-control custom-radio">
                <input type="radio" id="customRadio3" value="3" onClick="Show_time(3);" name="booking_status" class="custom-control-input" <?=$booking_period;?>>
                <label class="custom-control-label" for="customRadio3">В период с...до...</label>
              </div>
              <div class="custom-control custom-radio">
                <input type="radio" id="customRadio4" value="0" onClick="Show_time(0);" name="booking_status" class="custom-control-input" <?=$booking_disabled;?>>
                <label class="custom-control-label" for="customRadio4">Отключить</label>
              </div>
              <div class="custom-control" id="date_start_end">
              	<input type="text" id="date_start" name="booking_start" class="tcal" value="<?=$booking_start;?>" <?=$input_booking_start;?>/> -
                <input type="text" id="date_end" name="booking_end" class="tcal" value="<?=$booking_end;?>" <?=$input_booking_end;?> />
              </div>
              <small class="text-muted form-text">Укажите даты начала открытия бронирования либо период, в случае если выбрали один из этих пунктов!</small>
              </div>
            </div>
            <div class="form-group">
              <label for="date">Дни доступные для бронирования</label>
              <div class="form-check">
              	<input type="hidden" name="monday" value="off">
                <input class="form-check-input" type="checkbox" name="monday" id="monday" <?=$monday?> >Понедельник
                <br>
                <input type="hidden" name="tuesday" value="off">
                <input class="form-check-input" type="checkbox" name="tuesday" id="tuesday" <?=$tuesday?>>Вторник
                <br>
                <input type="hidden" name="wednesday" value="off">
                <input class="form-check-input" type="checkbox" name="wednesday" id="wednesday" <?=$wednesday?>>Среда
                <br>
                <input type="hidden" name="thursday" value="off">
                <input class="form-check-input" type="checkbox" name="thursday" id="thursday" <?=$thursday?>>Четверг
                <br>
                <input type="hidden" name="friday" value="off">
                <input class="form-check-input" type="checkbox" name="friday" id="friday" <?=$friday?>>Пятница
                <br>
                <input type="hidden" name="saturday" value="off">
                <input class="form-check-input" type="checkbox" name="saturday" id="saturday" <?=$saturday;?>>Суббота
                <br>
                <input type="hidden" name="sunday" value="off">
                <input class="form-check-input" type="checkbox" name="sunday" id="sunday" <?=$sunday;?>>Воскресенье </div>
              <small class="text-muted form-text">В какие дни будет доступно бронирование.</small>
            </div>

        </div>
        <div class="col-md-6">
        <div class="form-group">
              <label for="exampleInputEmail1">Праздничные дни РФ</label>
              <div class="form-check">
              	<input type="hidden" name="holiday" value="off">
                <input class="form-check-input" type="checkbox" name="holiday" id="holiday" <?=$holiday;?>>
                <label class="form-check-label" for="holiday">Включить</label>
              </div>
              <small class="text-muted form-text">В эти дни бронирование будет отключено!</small>
            </div>
            <div class="form-group">
              <label for="exampleInputEmail1">Автоматическое подтверждение брони</label>
              <div class="form-check">
              	<input type="hidden" name="automatic_confirmation" value="off">
                <input class="form-check-input" type="checkbox" name="automatic_confirmation" id="automatic_confirmation" <?=$automatic_confirmation?>>
                <label class="form-check-label" for="automatic_confirmation">Включить</label>
              </div>
              <small class="text-muted form-text">Если отключено, то подтверждать бронь нужно в разделе Бронь</small>
            </div>
            <div class="form-group">
              <label for="time_work">Время работы бронирования</label>
              <br> c
              <input type="text" id="time_work_start" name="time_work_start" placeholder="00:00" value="<?=$time_work_start?>" required="required"> до
              <input type="text" id="time_work_finish" name="time_work_finish" placeholder="23:59" value="<?=$time_work_finish?>" required="required">
              <small class="text-muted form-text">Указать промежуток времени в который можно будет сделать бронь</small>
            </div>
            <div class="form-group">
              <label for="time_booking">Время бронирования</label>
              <input type="text" class="form-control" id="time_booking" name="time_booking" placeholder="Указывается в минутах" value="<? if(empty($time_booking) OR $time_booking==0) echo '0'; else echo $time_booking; ?>">
              <small class="text-muted form-text">Указывается длительность одного бронирования. Если указать 0 то бранирование будет растянуто на все время работы бронирования!</small>
            </div>
            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Сохранить</button>
            <? if(!empty($time)) {?><a class="btn btn-primary" data-toggle="modal" href="#test" role="button" aria-expanded="false" aria-controls="collapseExample">Показать расписание</a>
            <? } ?>
          </form>
        </div>
      </div>

    </div>
  </div>
