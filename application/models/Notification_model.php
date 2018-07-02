<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notification_model extends CI_Model {

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
		if ($this->settings['notification_sms']=='1') $this->load->helper('sms.ru');
	}

// -----------------------------------------------------------------------------
//Тестовое sms сообщение

	public function sms_send_administrator_test()
	{
		if($this->settings['sms_api']!='' and $this->settings['phone_admin']!=''){
			$smsru = new SMSRU($this->settings['sms_api']); // Ваш уникальный программный ключ, который можно получить на главной странице
			$data = new stdClass();
			$data->to = $this->settings['phone_admin'];
			$data->text = 'Тестовое сообщение от "'.$this->settings['name_site'].'"'; // Текст сообщения
			$sms = $smsru->send_one($data); // Отправка сообщения и возврат данных в переменную
			if ($sms->status == "OK") { // Запрос выполнен успешно
    		echo "Сообщение отправлено успешно. <br>";
    		echo "ID сообщения: $sms->sms_id. <br>";
    		echo "Ваш новый баланс: $sms->balance";
			} else {
    		echo "Сообщение не отправлено. <br>";
    		echo "Код ошибки: $sms->status_code. <br>";
    		echo "Текст ошибки: $sms->status_text.";
			}
		}else echo 'Неверные настройки!';
	}

	// -----------------------------------------------------------------------------
	//Тестовое email сообщение

		public function email_send_administrator_test()
		{
			if($this->settings['smtp_host']!='' and $this->settings['smtp_user']!='' and $this->settings['smtp_pass']!=''){
				$this->load->library('email', $this->config);
				$this->email->from($this->settings['email_admin'], $this->settings['name_site']);
				$this->email->to($this->settings['email_admin']);
				$this->email->subject('Тест email');
				$this->email->message('Тестовая отправка email сообщения');
				$this->email->send();
				echo $this->email->print_debugger();
			}else echo 'Неверные настройки!';
		}

// -----------------------------------------------------------------------------
/*
Отправка номера бронирования пользователю указавшему свой номер телефона
получаем массив ('номер брони','дату и время','имя','телефон')
*/
	public function sms_send_user($array)
	{
		if($this->settings['sms_api']!='' and $this->settings['notification_sms']!='1'){
			$smsru = new SMSRU($this->settings['sms_api']);
			$data = new stdClass();
			$data->to = $array[3];
			$data->text = $array[2].', ваша бронь №'.$array[0].' на '.$array[1]; // Текст сообщения
			$sms = $smsru->send_one($data); // Отправка сообщения и возврат данных в переменную но данные пока что не используем)
		}
	}

}
