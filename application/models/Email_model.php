<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Email_model extends CI_Model {

	public $config; // массив с настройками email
	public $settings; // массив с настроками бронирования

	public function __construct()
	{
		parent::__construct();
		$this->load->model('System_model');
		$this->settings = $this->System_model->settings;
		$this->config = array(
			'useragent' => 'Easy-Booking',
			'mailpath' => '/usr/sbin/sendmail',
			'smtp_host' => $this->settings['smtp_host'],
			'smtp_user' => $this->settings['smtp_user'],
			'smtp_pass' => $this->settings['smtp_pass'],
			'smtp_port' => $this->settings['smtp_port'],
			'mailtype' => $this->settings['mailtype'],
			'wordwrap' => true, // перенос слов.
			'wrapchars' => 76, // количество символов для переноса слова.
			'validate' => false //проверка адрес электронной почты
		);
	}

}
