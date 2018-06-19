<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class System_model extends CI_Model {

	public $settings; // массив с настройками
	public $config_file = "./sag/config/settings.dat"; // файл конфигурации

	public function __construct()
	{
		parent::__construct();
		$this->load_settings();	 //заггрузка настроек
		$this->load->helper('x99');
	}

// -----------------------------------------------------------------------------
/*функция подсчета дней между датами.
data1 - начало, data2 - конец
если выводит отрицательное число, значит в data1 указана дата позже даты data2 
*/

	function number_of_day($data1,$data2)
	{
		$difference = intval(strtotime($data2) - strtotime($data1));
 		return $difference / (3600 * 24);
	}

// -----------------------------------------------------------------------------
//проверка функцианирования бронирования. Вывод сообщений

	function check_booking_on()
	{
		$result=array();
		$config = $this->settings;
		if($config['booking_on']=="0")
			{
				$result['text']='Бронирование отключено администратором.';
				if($config['booking_available']=='1') // если бронирование включено с....
				 	{
						if($this->number_of_day($config['booking_start'],date("d.m.Y"))>=0) //если  этот день настал то брониование доступно.
						unset($result['text']); else
						$result['text']='Бронирование будет открыто с '.$config['booking_start'];
					}
				if($config['booking_period']=='1') //если бронирование в период...
					{
						$d=$this->number_of_day($config['booking_start'],$config['booking_end']); // период работы брони
						$l=$this->number_of_day($config['booking_start'],date("d.m.Y")); //сколько прошло дней или сколько осталось до открытия
						if(($l<0) OR ($l>=$d)) //проверяем заходит ли сегодняшняя дата в период бронирование если нет то выводим сообщение...
						$result['text']='Бронирование будет доступно в период с '.$config['booking_start'].' до '.$config['booking_end'];
						else unset($result['text']);
					}
			} else unset($result['text']);

		return $result;
	}

// -----------------------------------------------------------------------------
//проверка правильность ссылки на странице calendar/reservation

	function check_url_reservation($url)
	{
		$url = coding($url,true);
		$url = explode('/',$url);
		if(count($url)==3) return true; else false;
	}

// -----------------------------------------------------------------------------
// загрузка настроек

	function load_settings()
	{
		if(file_exists($this->config_file))
		{ // если существует файл-конфигурации то читаем его в переменную
			$config = file_get_contents($this->config_file);
			$this->settings = unserialize($config);
		}else
		{//если нет то загружаем конфигурации из БД
			$config = $this->db->get('CONFIG');
			$config=$config->result_array();
			if (count($config)==0)
				{//если в БД пусто то записываем стандартные конфигурации
					$array = $this->default_array();
					foreach($array as $key => $value)
						{
							$this->db->insert('CONFIG',array('KEY_CONFIG'=>$key, 'VALUE'=>$value));
						}
				} else
				{// если есть в БД что то, то фильтруем полученные значения
					$array=$this->parse_the_array($config);
				}
			file_put_contents($this->config_file,serialize($array)); //пишем строку в файл
			$this->settings = $array;
		}
	}

// -----------------------------------------------------------------------------
// фильтруем массив с настройками.

	function parse_the_array($array)
	{
		$result=array();
		foreach ($array as $i)
			{
				$result[$i['KEY_CONFIG']] = $i['VALUE'];
			}
		return $result;
	}

// -----------------------------------------------------------------------------
//default массив с настройками

	function default_array()
	{
		$array=array(
			'name_site' => 'Календарь', // название страницы(сайта)
			'booking_on' => '1', // бронь ключена
			'booking_disabled' => '0',
			'booking_available' => '0',
			'booking_period' => '0',
			'booking_start' => '24.04.2018',
			'booking_end' => '',
			'monday' => '1',
			'tuesday' => '1',
			'wednesday' => '1',
			'thursday' => '1',
			'friday' => '1',
			'saturday' => '0',
			'sunday' => '0',
			'holiday' => '0', //выключение брони в праздники.
			'automatic_confirmation' => '1', //автоматическое подтверждение брони.
			'time_work_start' => '09:00', //время первой брони.
			'time_work_finish' => '18:00', //время последней брони.
			'time_booking' => '30', //время одного бронирования(минуты)
			'count_booking' => '18' //количество возможных бронирований
		);
		return $array;
	}

// -----------------------------------------------------------------------------
//сборка для сохранения настроек по включению и отключению брони

	function check_booking_on_config($array)
	{
		$b = $array['booking_status'];
		$a="0";
		switch($b)
			{
				//если бронирование отключено
				case "0": {	$array['booking_on']=$a;
										$array['booking_disabled']='1';
										$array['booking_available']=$a;
										$array['booking_period']=$a;
										$array['booking_start']=''; // очищаем строку начала бронирования
										$array['booking_end']=''; break;} //очищаем строку закрытия бронировани
				//если бронирование включено
				case "1": {	$array['booking_on']='1';
										$array['booking_disabled']=$a;
										$array['booking_available']=$a;
										$array['booking_period']=$a;
										$array['booking_start']=''; // очищаем строку начала бронирования
										$array['booking_end']=''; break;} //очищаем строку закрытия бронировани
				//если бронирование включено с определенной даты
				case "2": {	$array['booking_on']=$a;
										$array['booking_disabled']=$a;
										$array['booking_available']='1';
										$array['booking_period']=$a;
										$array['booking_end']=''; break;} //очищаем строку закрытия бронировани
				//если бронирование включено в определенный период
				case "3": {	$array['booking_on']=$a;
										$array['booking_disabled']=$a;
										$array['booking_available']=$a;
										$array['booking_period']='1'; break;}
			}
		unset($array['booking_status']);
		return $array;
	}

// -----------------------------------------------------------------------------
//редактирование(сохранение) настроек в БД и

	function save_config($array)
	{
		$array=$this->check_post_array($array);
		if(!empty($array['error']))
		$result = $this->message_view('ошибка','Возникла ошибка при сохранении.',$array['error']); else
		{
			$array=$this->check_booking_on_config($array);
			foreach($array as $key => $value)
				{
					if($value=='on') $value = '1';
					if($value=='off') $value = '0';
					$this->db->where('KEY_CONFIG',$key);
					$this->db->update('CONFIG',array('VALUE'=>$value));
				}
			if($array['holiday']=='on') $this->download_calendar_holiday();
			if($array['holiday']=='off') {
				if(file_exists("./sag/config/calendar.xml")) unlink('./sag/config/calendar.xml');
			}
			$this->recreate(); //пересоздаем файл конфигурации
			$result = $this->message_view('удачно','Сохранено.','');
		}
		return $result;
	}

	// -----------------------------------------------------------------------------
	//загрузка xml файла(календаря) с праздниками РФ на текущий год.

	function download_calendar_holiday()
	{
		$ReadFile = fopen ('http://xmlcalendar.ru/data/ru/'.date("Y").'/calendar.xml', "rb");
    		if ($ReadFile) {
        		$WriteFile = fopen ('./sag/config/calendar.xml', "wb");
        		if ($WriteFile){
            		while(!feof($ReadFile)) {
                		fwrite($WriteFile, fread($ReadFile, 4096 ));
            		}
            		fclose($WriteFile);
        			}
        		fclose($ReadFile);
					}
	}

//------------------------------------------------------------------------------
/*получаем массив с праздничными и сокращенными днями.
в случае если нужны только праздники, нужно закомментировать одну строку:
if( $day->attributes()->t == 2 ) $arHolidays[] = $d;
*/

	function holiday_russia()
	{
		$calendar = simplexml_load_file(base_url()."sag/config/calendar.xml");
		$calendar = $calendar->days->day;
		//все праздники за текущий год
		foreach( $calendar as $day ){
    	$d = (array)$day->attributes()->d;
    	$d = $d[0];
			$d = date("Y").'-'.substr($d, 0, 2).'-'.substr($d, 3, 2);
    	if( $day->attributes()->t == 1 ) $arHolidays[] = $d;// праздники
			if( $day->attributes()->t == 2 ) $arHolidays[] = $d;//сокращенные дни
		}
		return $arHolidays;
	}

// -----------------------------------------------------------------------------
//пересоздать файл с конфигурацией

	function recreate()
	{
		$config = $this->db->get('CONFIG'); //получаем конфигурацию из БД
		$config=$config->result_array();
		$array=$this->parse_the_array($config); // фильтруем :D
		file_put_contents($this->config_file,serialize($array)); // записываем новые настройки!
		$this->settings = $array; // обновляем переменную
	}

// -----------------------------------------------------------------------------
//подготовка конфигураций для редактирования.

	function training_array($array)
	{
		$result=array();
		//показываем или блокируем input в форме с датами открытия и закрытия бронирования.
		if($array['booking_available']=='1') {$result['input_booking_start']=''; $result['input_booking_end']='disabled';}
		else {
			$result['input_booking_start']='disabled'; $result['input_booking_end']='disabled';
		}
		if($array['booking_period']=='1') {$result['input_booking_start']=''; $result['input_booking_end']='';}

		foreach($array as $key => $value)
			{
				switch($value)
					{
						case '0': {$result[$key]=''; break;}
						case '1': {$result[$key]='checked'; break;}
						default: {$result[$key]=$value;}
					}
			}
		return $result;
	}

// -----------------------------------------------------------------------------
//функция проверки

	function check_post_array($array)
	{
		if(!empty($array['post_booking'])) //проверяем настройки бронирования
			{
				$start=explode(':',$array['time_work_start']);
				$end = explode(':',$array['time_work_finish']);
				if($start[0]>=$end[0]) $array['error']='Неправильно указано Время работы бронирования !';
				if(empty($array['time_booking'])) $array['time_booking']=0;
				$min = (60*($end[0]-$start[0]))-$array['time_booking'];
				if($min<0) $array['error']='Указанное время бронирования не совпадает с Временем работы бронирования!';
			//Проверяем если выбран период включения бронирования.
				if($array['booking_status']=='3')
				{
					if($this->number_of_day($array['booking_start'],$array['booking_end'])<0) $array['error']='Указан неверный период включения бронирования. Дата окончания не может быть раньше даты начал бронирования!';
				}
			//Проверяем если выбран период включения бронирования.
				if(empty($array['error']))
					{
						$start_time = explode(':',$array['time_work_start']);
						$finish_time = explode(':',$array['time_work_finish']);
						$start_time = $start_time[0]*60+$start_time[1];
						$finish_time = $finish_time[0]*60+$finish_time[1];
						if($array['time_booking']!='0') $array['count_booking'] = (int)(($finish_time - $start_time)/$array['time_booking']); else $array['count_booking']=1;
					}
			}
		return $array;
	}

// -----------------------------------------------------------------------------
//уведомление

	/*
		message_view('ошибка','проблемка тут','описание ошибки',true);
		если передавать 4-й параметр то сообщение выведется, если нет то функция вернет сообщение.
	*/
	function message_view($status,$title='Информация',$text,$view=false)
	{
		switch($status)
		{
			case "удачно": $status='success'; break;
			case "предупреждение": $status='warning'; break;
			case "ошибка": $status='danger'; break;
			case "информация": $status='info'; break;
			default: $status='primary';
		}
		$message='
		<div class="alert alert-'.$status.' alert-dismissible fade show" role="alert">
  		<strong>'.$title.'</strong> '.$text.'
  		<button type="button" class="close" data-dismiss="alert" aria-label="Закрыть">
    	<span aria-hidden="true">&times;</span>
  		</button>
		</div>
		';
		if(!empty($view)) echo $message; else return $message;
	}

// -----------------------------------------------------------------------------
//название месяца.

	public function month_name($month,$int=false)
	{
		switch($month)
		{
			case 1: {$result[1]='Январь'; $result[2]='января'; break;}
			case 2: {$result[1]='Февраль'; $result[2]='февраля'; break;}
			case 3: {$result[1]='Март'; $result[2]='марта'; break;}
			case 4: {$result[1]='Апрель'; $result[2]='апреля'; break;}
			case 5: {$result[1]='Май'; $result[2]='мая'; break;}
			case 6: {$result[1]='Июнь'; $result[2]='июня'; break;}
			case 7: {$result[1]='Июль'; $result[2]='июля'; break;}
			case 8: {$result[1]='Август'; $result[2]='августа'; break;}
			case 9: {$result[1]='Сентябрь'; $result[2]='сентября'; break;}
			case 10: {$result[1]='Октябрь'; $result[2]='октября'; break;}
			case 11: {$result[1]='Ноябрь'; $result[2]='ноября'; break;}
			case 12: {$result[1]='Декабрь'; $result[2]='декабря'; break;}
			default: {$result[1]='error'; $result[2]='error';}
		}
	if(!empty($int)) return $result[2]; else return $result[1];
	}

// -----------------------------------------------------------------------------
//простая функция для проверки данных

	public function check_text($in)
		{
			if(preg_match("/script|http|&lt;|&gt;|&lt;|&gt;|SELECT|UNION|UPDATE|DROP|exe|exec|INSERT|tmp/i",$in))
			$out=''; else $out=$in;
			return $out;
		}

}
