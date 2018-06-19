<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class View_model extends CI_Model {

	public function temp()
	{
		$prefs =
       		'{table_open}<table class="table" >{/table_open}

        {heading_row_start}<tr>{/heading_row_start}

        {heading_previous_cell}<th><a href="{previous_url}">&lt;&lt;</a></th>{/heading_previous_cell}
        {heading_title_cell}<th colspan="{colspan}"><center>{heading}</center></th>{/heading_title_cell}
        {heading_next_cell}<th><a href="{next_url}">&gt;&gt;</a></th>{/heading_next_cell}

        {heading_row_end}</tr>{/heading_row_end}

        {week_row_start}<tr>{/week_row_start}
        {week_day_cell}<td>{week_day}</td>{/week_day_cell}
        {week_row_end}</tr>{/week_row_end}

        {cal_row_start}<tr>{/cal_row_start}
        {cal_cell_start}<td>{/cal_cell_start}
        {cal_cell_start_today}<td>{/cal_cell_start_today}
        {cal_cell_start_other}<td class="other-month">{/cal_cell_start_other}

        {cal_cell_content}<a href="{content}" class="btn btn-success btn-lg">{day}</a>{/cal_cell_content}
        {cal_cell_content_today}<div class="highlight"><a href="{content}" class="btn btn-success btn-lg" >{day}</a></div>{/cal_cell_content_today}

        {cal_cell_no_content}<a href="#" class="btn btn-secondary btn-lg disabled">{day}</a>{/cal_cell_no_content}
        {cal_cell_no_content_today}<div class="highlight"><a href="#" class="btn btn-secondary btn-lg disabled">{day}</a></div>{/cal_cell_no_content_today}

        {cal_cell_blank}&nbsp;{/cal_cell_blank}

        {cal_cell_other}{day}{/cal_cel_other}

        {cal_cell_end}</td>{/cal_cell_end}
        {cal_cell_end_today}</td>{/cal_cell_end_today}
        {cal_cell_end_other}</td>{/cal_cell_end_other}
        {cal_row_end}</tr>{/cal_row_end}

        {table_close}</table>{/table_close}';

		return $prefs;
	}

	public function search_booking($booking,$phone)
	{
		$this->load->model("Booking_model");
		$booking=$this->Booking_model->check_text($booking);
		$phone=$this->Booking_model->check_text($phone);
		$this->db->where('RESERVATION_NUMBER',$booking);
		$query = $this->db->get('BOOKING');
		$query=$query->result_array();
		if(count($query)>0)
			{
				$result = $this->Booking_model->decode_text($query[0]);
				if($result['PHONE']==$phone)
				echo 'Бронь №'.$result['RESERVATION_NUMBER'].' на '.$result['DATE'].' время: '.$result['TIME'];
				else echo 'Возможно введеный вами номер телефона, не соответствует введеному номеру при бронировании! ';
			}else echo 'Не найдено.';
	}
}
