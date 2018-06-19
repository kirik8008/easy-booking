<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Calendar extends CI_Controller {

	public $data;

	public function __construct()
	{
		parent::__construct();
		$this->load->model('System_model');
		$this->data['settings'] = $this->System_model->settings;
		$this->load->model('Booking_model');
	}

	public function index()
	{
		$prefs = array(
        'start_day'    => 'monday',
        'show_next_prev'  => TRUE,
        'next_prev_url'   => '#'
		);
		$this->load->model('View_model');
		$prefs['template']=$this->View_model->temp();
		$this->load->library('calendar',$prefs);
		$data = $this->Booking_model->generate_link_booking($this->data['settings']);
		$data['calendar'] = $this->calendar->generate(false,false,$data);
		$this->load->view('top',$this->data); //загружаем топ
		
		$block_booking = $this->System_model->check_booking_on(); // проверка, доступно ли бронирование.
		if($block_booking) $this->load->view('block_dialog',$block_booking); //если бронь недосупна выводим причину...
		
		$this->load->view('Calendar_index',$data);
		$this->load->view('footer');
	}

	public function reservation($link)
	{
		if($this->System_model->check_url_reservation($link))
		{
		if(!empty($_POST['time'])) $result_add = $this->Booking_model->check_post_add_booking($_POST,$this->data['settings']);
		$data=$this->Booking_model->generate_free_time($link,$this->data['settings']);
		if(!empty($result_add))
			{
				if(!empty($result_add['error']))
					{
						$error = $this->System_model->message_view('ошибка','Бронирование отменено по причине:',$result_add['error'],true);
					}else
				{
					if($this->data['settings']['automatic_confirmation']==1) $a_c = ' Ваша бронь подтверждена!'; else $a_c='';
					$error = $this->System_model->message_view('удачно','Успешно!','Ваш номер бронирования: '.$result_add.$a_c,true);
					$this->data['error']=$error;
				}
			}
		$this->load->view('top',$this->data);
		$this->load->view('reservation',$data);
		$this->load->view('footer');
		} else redirect('/');

	}

}
