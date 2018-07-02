<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Administrator extends CI_Controller {

	public $data;

	public function __construct()
	{
		parent::__construct();
		$this->load->model('System_model');
		$this->data['settings'] = $this->System_model->settings;
		$this->load->model('Booking_model');
	}
	// -----------------------------------------------------------------------------
	public function index()
	{
		$this->load->view('adm_top');

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


		$this->load->view('footer');
	}
// -----------------------------------------------------------------------------
//страница конфигураций бронирования
	public function configure($page)
	{
		$result[] = '';
		if(!empty($_POST['post_booking']) or !empty($_POST['post_site']))
			{
				$result['result'] = $this->System_model->save_config($_POST);
				$this->data['settings'] = $this->System_model->settings;
			}
		$this->load->view('adm_top',$result);
		$data_settings = $this->System_model->training_array($this->data['settings']);
		$data_settings['time']=$this->Booking_model->generate_add_form($this->data['settings']);
		switch($page)
		{
			case "site": {$this->load->view('adm_configure_site',$data_settings); $this->load->model('Notification_model'); break;}
			case "booking": {$this->load->view('adm_configure_booking',$data_settings); break;}
			default: echo 'test';
		}
		$this->load->view('footer');
	}
// -----------------------------------------------------------------------------
//подтверждения бронирования
	public function booking_add()
	{
		$this->data['time']=$this->Booking_model->generate_add_form($this->data['settings']);
		$this->load->view('adm_top');
		$this->load->view('adm_booking_add',$this->data);
		$this->load->view('footer');
	}
// -----------------------------------------------------------------------------
//вывод всех
	public function booking_all()
	{

	}
// -----------------------------------------------------------------------------
//отображение брони на ближайшие три дня
	public function reservation()
	{
		$data = $this->Booking_model->view_booking();
		$this->load->view('adm_top');
		$this->load->view('adm_reservation',$data);
		$this->load->view('footer');
	}
// -----------------------------------------------------------------------------
//поиск бронирования
	public function search_booking()
	{
		if(!empty($_POST))
		{
			if($_POST['search']!='')
			{
				$data['search'] = $this->Booking_model->search_booking($_POST['search']);
				$this->load->view('adm_search',$data);
			}else echo 'Ждемся...';
		}
	}
// -----------------------------------------------------------------------------
//вывод для печати
	public function print_booking()
	{
		$data = $this->Booking_model->view_booking();
		$data['date']=date("d").' '.$this->System_model->month_name(date("m"),true).' '.date("Y");
		$this->load->view('adm_print',$data);
	}
// -----------------------------------------------------------------------------
//отправка тестового SMS сообщения сообщений
		public function send_message($id=false)
		{
			$this->load->model('Notification_model');
			switch ($id) {
				case 'sms': {$this->Notification_model->sms_send_administrator_test(); break;}
				case 'email': {$this->Notification_model->email_send_administrator_test(); break;}
				default: {break;}
			}
		}
}
