<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class View extends CI_Controller {

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
		$this->load->view("top",$this->data);

		$this->load->view('footer');

	}

	public function search()
	{
		if(!empty($_POST))
		{
			if($_POST['nomber_booking']!='' AND $_POST['nomber_phone']!='')
			{
				$this->load->model('View_model');
				$this->View_model->search_booking($_POST['nomber_booking'],$_POST['nomber_phone']);
			} else echo 'Укажите номер брони и номер телефона, указанный при бронировании!';
		} else echo '-';
	}

}
