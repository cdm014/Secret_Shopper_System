<?php
	class Question_model extends CI_Model {
	
		function __construct()
		{
			parent::__construct();
		}
		
		
		
		function get_answers($qcode)
		{
			$this->db->where('code',$qcode);
			$query = $this->db->get('q_answers');
			if ($query->num_rows() > 0) 
			{
				$data = array();
				foreach ($query->result_array() as $answer) 
				{
					$data[] = $answer;
				}
				return $data;
			} else {
				return false;
			}
		}
		
		function get_question($qcode) {
			$this->db->where('code',$qcode);
			$query = $this->db->get('questions');
			if($query->num_rows() > 0) {
				return $query->row_array();
			} else {
				return false;
			}
		}
		
		function translate_question_code($qcode) {
			$qarray = $this->get_question($qcode);
			if ($qarray){
				return $qarray['text'];
			} else {
				return false;
			}
		}
		
		function get_answer($qcode, $sval)
		{
			$this->db->where('code',$qcode);
			$this->db->where('sval',$sval);
			$query = $this->db->get('q_answers');
			if ($query->num_rows() > 0)
			{
				return $query->row_array();
			} else {
				return false;
			}
		}
		function translate_answer_sval($qcode, $sval)
		{
			$ansArray = $this->get_answer($qcode,$sval);
			if($ansArray){
				return $ansArray['dval'];
			} else {
				return $sval;
			}
		}
		function translate_answer($qcode, $answer) {
			$qarray = $this->get_question($qcode);
			switch ($qarray['type'])
			{
				case "yes_no":
					if ($answer == 1) {
						return "Yes";
					} else {
						return "No";
					}
					break;
				case "text":
					return $answer;
					break;
				case "radio buttion":
				case "dropdown":
				case "checkbox":
					return $this->translate_answer_sval($qcode,$answer);
					
			}
		}
		
		function get_form_field($qcode)
		{
			$this->load->library('form_validation');
			$this->load->helper('form');
			$this->load->helper('url');
			$qarray = $this->get_question($qcode);
			$retval = "";
			switch($qarray['type'])
			{
				case "text":
					$retval = $qarray['text']."<br />".form_input($qarray['code'],set_value($qarray['code']));
					break;
				case "dropdown":
					$ddarray = array();
					$aarray = $this->get_answers($qarray['code']);
					foreach ($aarray as $answer)
					{
						$ddarray[$answer['sval']] = $answer['dval'];
					}
					$retval = $qarray['text']."<br />".form_dropdown($qarray['code'],$ddarray);
					break;
				case "yes_no":
					$no_btn = array(
						'name' => $qarray['code'],
						'id' => "Not".$qarray['code'],
						'value' => 0,
						'checked' => set_radio($qarray['code'],0)
					);
					$yes_btn = array(
						'name' => $qarray['code'],
						'id' => $qarray['code'],
						'value'=>1,
						'checked'=>set_radio($qarray['code'],1)
					);
					$retval = $qarray['text']."<br />".form_radio($no_btn).form_label("No","Not".$qarray['code']).form_radio($yes_btn).form_label("Yes",$qarray['code']);
					break;
				case "textarea":
					$retval = $qarray['text']."<br />".form_textarea($qarray['code'],set_value($qarray['code']));
					break;
				case "fieldset":
					$retval = form_fieldset($qarray['text']);
					break;
				case "fieldset_close":
					$retval = form_fieldset_close();
					break;
			}
			$retval = "<p>".$retval."</p>";
			return $retval;
		}
		
		function get_quiz_question($quiz)
		{
			$this->db->where('quiz_id',$quiz);
			$this->db->order_by('order asc');
			$query = $this->db->get('quiz_questions');
			if ($query->num_rows < 1) {
				return false;
			} else {
				$retval = array();
				foreach ($query->result_array() as $row)
				{
					$retval[] = $row;
				}
				return $retval;
			}
		}
	}		