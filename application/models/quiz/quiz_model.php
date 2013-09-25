<?php
	class Quiz_model extends CI_model {
		//results will be returned as an array of OBJECTS
		function __construct()
		{
			parent::__construct();
		}
		
		function list_quizzes()
		{
			$query = $this->db->get('quizzes');
			if ($query->num_rows() > 0)
			{
				$data = array();
				foreach ($query->result() as $answer)
				{
					$data[] = $answer;
				}
				return $data;
			} else {
				return FALSE;
			}
		}
		
		function get_questions($quiz_id)
		{
			$this->db->select('question_code');
			$this->db->where('quiz_id',$quiz_id);
			$this->db->order_by('order ASC');
			$query = $this->db->get('quiz_questions');
			if($query->num_rows() > 0)
			{
				$data = array();
				
				foreach ($query->result() as $row)
				{
					$data[] = $row;
				}
				return $data;
			} else {
				return false;
			}
			
		}
	
	}