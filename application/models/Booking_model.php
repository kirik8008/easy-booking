<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Booking_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('x99');
		$this->load->model("System_model");
	}

// -----------------------------------------------------------------------------
//простая функция для проверки данных

	public function check_text($in)
		{
			if(preg_match("/script|http|&lt;|&gt;|&lt;|&gt;|SELECT|UNION|UPDATE|DROP|exe|exec|INSERT|tmp/i",$in))
			$out=''; else $out=$in;
			return $out;
		}

// -----------------------------------------------------------------------------
//генерируем время бронирования

	function generate_add_form($config)
	{
		$x = 0;
		if($config['time_booking']>60) {$time_booking = $config['time_booking']-60; $time_booking = '01:'.$time_booking;} else $time_booking = '00:'.$config['time_booking'];
		while($x++<$config['count_booking'])
		{
			$time = $this->summa($config['time_work_start'],$time_booking);
			if($config['count_booking']!=1)
			$result[]=$config['time_work_start'].' - '.$time; else
			$result[]=$config['time_work_start'].' - '.$config['time_work_finish'];
			$config['time_work_start'] = $time;
		}
		return $result;
	}

// -----------------------------------------------------------------------------
//считаем время

	function summa($t1,$t2)
	{
		$enmin=0;
		$t1=explode(':',$t1);
		$t2=explode(':',$t2);
		$min = $t1[1]+$t2[1];
		if($min>=60) { $min=$min-60; $enmin++; }
		$hour = $t1[0]+$t2[0]+$enmin;
		if(strlen($min)==1) $min='0'.$min;
		return $hour.":".$min;
	}

	// -----------------------------------------------------------------------------
	//проверка что в этот день работает бронь

	function check_day($day,$config)
	{
		if($config['booking_disabled']=="1") $temp=true; else {
			if($config['booking_on']=="0")
			{
				if($config['booking_period']=="1")
				{
					$t1 = $this->System_model->number_of_day($config['booking_start'],$day.".".date("m.Y"));
					$t2 = $this->System_model->number_of_day($day.".".date("m.Y"),$config['booking_end']);
					if($t1>=0 OR $t2>=0) $temp=false; else $temp=true;
				}else {
					$t1 = $this->System_model->number_of_day($config['booking_start'],$day.".".date("m.Y"));
					if($t1>=0) $temp=false;
				}
			}else $temp=false;
		}
		if(!empty($temp)) $result="0"; else {
			$date = date("Y-m");
			if(strlen($day)<2) $day=$date.'-0'.$day; else $day = $date.'-'.$day;
			if($config['holiday']=="1"){
				$holiday_rus = $this->System_model->holiday_russia();
				$holiday = array_search($day,$holiday_rus);
			}
			if(empty($holiday)){
				$d = date('w',strtotime($day));
				switch ($d) {
					case 0: $result = $config['sunday']; break;
					case 1: $result = $config['monday']; break;
					case 2: $result = $config['tuesday']; break;
					case 3: $result = $config['wednesday']; break;
					case 4: $result = $config['thursday']; break;
					case 5: $result = $config['friday']; break;
					case 6: $result = $config['saturday']; break;
					default: $result = "0"; break;
				}
			} else $result = "0";
		}
		return $result;
	}

// -----------------------------------------------------------------------------
//генерация ссылок дней бронирования для календаря

	function generate_link_booking($config)
	{
		$this->load->library('calendar');
		$count = $this->calendar->get_total_days(date("m"),date("Y"));
		$this->db->where('status !=','0'); // запрашиваем все, кроме закрытых
		$booking = $this->db->get('BOOKING');
		$booking = $booking->result_array();
		$x=date("d");
		$result = array();
		while($x++<$count)
			{
				$res = array_keys(array_column($booking, 'DATE'), $x.'.'.date("m").'.'.date("Y"));
				if(count($res)<$config['count_booking']) $result[$x] = base_url().'calendar/reservation/'.coding($x.'/'.date("m").'/'.date("Y"));
				if($this->check_day($x,$config)!="1") unset($result[$x]);
			}
		return $result;
	}

// -----------------------------------------------------------------------------
//генерация свободного для бронирования времени страница reservation

	function generate_free_time($link,$config)
	{
		$this->load->model('System_model');
		$link = coding($link,true); //получаем ссылку
		$link = explode('/',$link); //работа с ссылкой
		$this->db->where('DATE',$link[0].'.'.$link[1].'.'.$link[2]); //ищем по дате в БД
		$booking = $this->db->get('BOOKING');
		$booking = $booking->result_array();
		$time = $this->generate_add_form($config); //генерируем форму
		$result=array();
		foreach($time as $key => $value)
			{
				$val = explode(' - ',$value);
				$res = array_keys(array_column($booking, 'TIME'), $val[0]);
				if(count($res)!=0) $result['time'][]=array('time'=>'<del>'.$val[0].'</del>','img'=>'-danger disabled', 'del'=>true); else
				$result['time'][]=array('time'=>$val[0],'img'=>'-success');
				//$link[0].' '.$this->System_model->month_name($link[1],true).' '.$link[2].'г. <b>'.
			}
		$result['date']=$link[0].' '.$this->System_model->month_name($link[1],true).' '.$link[2].'г.';
		if($config['automatic_confirmation']==1) $result['automatic_confirmation'] = '<b>Автоматическое подтверждение брони</b>'; else
		$result['automatic_confirmation'] = '<del>Автоматическое подтверждение брони</del>';
		return $result;
	}

// -----------------------------------------------------------------------------
//проверка пришедшего POST, для бронирования

	function check_post_add_booking($array,$config)
	{
		$text_error_booking=$this->System_model->check_booking_on();
		if (empty($text_error_booking)) {
		$result=array(); // инициализируем пустой массив
		do
		{
			$result['reservation_number'] = rand(100000,999999); // генеригуем номер бронирования
			$this->db->where('reservation_number',$result['reservation_number']); // ищем есть ли такой номер
			$this->db->from('BOOKING'); // в таблице
			$count = $this->db->count_all_results(); // выводим сколько нашлось результатов
		} while($count!=0); // если 0 совпадений то выходим из цикла и сохраняем текущий номер бронирования
		foreach($array as $key => $value) // перебираем пришедший POST
			{
				$check = $this->check_text($value); // проверяем каждую переменную
				if($check!='' or $key=='middlename_user') $result[$key]=$check; // после проверки собираем массив
				else $result['error']='Данные содержат запрещенные символы!'; //при найденной ошибке
			}
		$result['date'] = $this->uri->segment(3, 0); // получаем дату бронирования через URl
				if($result['date']!=0) //проверяем на ошибки
					{
						$result['date']=coding($result['date'],true);
						$result['date']=str_replace('/','.',$result['date']); //работа с датой
					}
		$temp_d=explode('.',$result['date']);
		$checkday = $this->check_day($temp_d[0],$config); // проверяем попадает ли выбранная дата в диапозон работы
		if ($checkday == "0") $result['error']="В выбранную вами дату, бронирование отключено!";
		$info_error = $this->check_array_booking($result); // проверяем все ли поля заполнены пользователем
		if(!empty($info_error))  //проверяе есть ли какие либо ошибки
			{
				if(!empty($result['error'])) $result['error'].=$info_error; else $result['error'] = $info_error; // выводим в массив ошибки
			}
		} else
			{
				$result['error'] = $text_error_booking['text']; // если бронирование отключено, то выводим сообщение о причине.
			}
		if(!empty($result['error'])) return $result; // если есть ошибки, то возвращаем их контроллеру для отображения
		else
			{
				$result = $this->add_booking($result,$config); // передаем массив для создания брони.
				return $result;
			}
	}

// -----------------------------------------------------------------------------
// проверяем заполнены ли обязательные строки из post

	function check_array_booking($i)
	{
		$this->db->where('TIME',$i['time']);
		$this->db->where('DATE',$i['date']);
		$this->db->from('BOOKING');
		$repetition = $this->db->count_all_results();
		if($repetition>0) $error[]='Выбранное вами время ('.$i['time'].' на '.$i['date'].') уже занято!';
		if(empty($i['date'])) {$error[]='Неверно выбрана дата.';}
		if(empty($i['time'])) {$error[]='Неверно выбрано время.';}
		if(empty($i['name_user'])) {$error[]='Не заполнено поле -> Имя.';}
		if(empty($i['surname_user'])) {$error[]='Не заполнено поле -> Фамилия.';}
		if(empty($i['phone_user'])) {$error[]='Не заполнено поле -> Телефон.';}
		if(empty($i['email_user'])) {$error[]='Не заполнено поле -> E-Mail.';}
		if(!empty($error))
			{
				$error_end='';
				foreach($error as $i)
				{
					$error_end.=$i.'<br>';
				}
				return $error_end;
			}
		else return false;
	}

// -----------------------------------------------------------------------------
//бронирование занесение в БД

	function add_booking($i,$config)
	{
		if(empty($i['middlename_user'])) $i['middlename_user']=''; // если нет отчества то создаем пустую переменную
		if($config['automatic_confirmation']==1) $automatic_confirmation = '1'; else $automatic_confirmation = '2'; // проверяем автоматическое подтверждение бронирования
		$array = array(
			'reservation_number' => $i['reservation_number'],
			'date' => $i['date'],
			'time' => $i['time'],
			'status' => $automatic_confirmation,
			'name' => $this->encryption->encrypt($i['name_user']),
			'surname' => $this->encryption->encrypt($i['surname_user']),
			'middlename' => $this->encryption->encrypt($i['middlename_user']),
			'phone'=> $this->encryption->encrypt($i['phone_user']),
			'email' => $this->encryption->encrypt($i['email_user']),
			'note' => ''
		);
		$result = $this->db->insert('BOOKING',$array); //занесение в базу
		return $i['reservation_number'];  // возврат номера бронирования
	}

// -----------------------------------------------------------------------------
//отображение брони на сегодня,завтра,послезавтра

	function view_booking()
	{
		$this->db->order_by("TIME", "DESC");
		$all = $this->db->get_where('BOOKING',array('status !='=>'0'));
		$all = $all->result_array();
		$result['today'] = $this->search_array($all); //сегодня
		$result['tomorrow'] = $this->search_array($all,1); // завтра
		$result['after_tomorrow'] = $this->search_array($all,2); //послезавтра
		return $result;
	}

// -----------------------------------------------------------------------------
//функция возвращает брони на (0-сегодня,1-завтра,2-послезавтра) испольуется view_booking

	function search_array($array,$data=0)
	{
		$d = strtotime("+".$data." day");
		$r_today = array_keys(array_column($array, 'DATE'), date("d.m.Y",$d));
		$mass = array();
		foreach($r_today as $value)
			{
				$mass[]=$this->decode_text($array[$value]);
			}
		return $mass;
	}

// -----------------------------------------------------------------------------
//вывод всех забронированных

		function all_view_booking()
		{
			$result=array('open'=>array(),'close'=>array(),'expect'=>array());
			$booking = $this->db->get('BOOKING');
			$booking = $booking->result_array(); //вытаскиваем всё
			foreach ($booking as $v) {
				$time_array=$this->decode_text($v); // декод
				if($this->System_model->number_of_day(data("d.m.Y"),$time_array['DATE'])>0) { //проверяем актуальные брони
					if($time_array['STATUS']==1) //если бронь подтверждена заносим в массив open
						$result['open'][]=$time_array; else {
							$result['expect'][]=$time_array; //в противном случае в массив expect
						}
				} else {
					$resuls['close']=$time_array; // если дата брони уже прошла.
				}
			}
			return $result;
		}

// -----------------------------------------------------------------------------
//функция расшифровки

	function decode_text($i)
	{
			$result=array(
				'RESERVATION_NUMBER'=>$i['RESERVATION_NUMBER'],
				'DATE' => $i['DATE'],
				'TIME'=>$i['TIME'],
				'NAME'=>$this->encryption->decrypt($i['NAME']),
				'SURNAME'=>$this->encryption->decrypt($i['SURNAME']),
				'MIDDLENAME'=>$this->encryption->decrypt($i['MIDDLENAME']),
				'PHONE'=>$this->encryption->decrypt($i['PHONE']),
				'EMAIL'=>$this->encryption->decrypt($i['EMAIL']),
				'STATUS'=>$i['STATUS']);

		return $result;
	}

// -----------------------------------------------------------------------------
//поиск номера бронирования

	function search_booking($array)
	{
		$array=$this->check_text($array);
		//SELECT * FROM dиevice_all WHERE inv LIKE '%".$array['search']."%' UNION
		$query = $this->db->query("SELECT * FROM BOOKING WHERE RESERVATION_NUMBER LIKE '%".$array."%'");
		$query=$query->result_array();
		$d=array();
		foreach($query as $i)
		{
			$d[] = $this->decode_text($i);
		}
		return $d;
	}

// -----------------------------------------------------------------------------

}
