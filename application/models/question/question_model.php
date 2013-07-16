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
	}		