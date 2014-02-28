<?php
	class Review_model extends CI_Model {
		var $reviews = "Distinct( concat_ws(' ', date, time, branch,  ss_id )) as reviews";
		function __construct()
		{
			parent::__construct();
		}
		
		public function get_all_reviews()
		{
			$this->db->select($this->reviews.', date, time, branch, ss_id');
			$this->db->order_by('branch','asc');
			$query = $this->db->get('reviews');
			$retval = array();
			if ($query->num_rows() > 0) {
				foreach ($query->result_array() as $row)
				{
					$retval[] = $row;
				}
				return $retval;
			} else {
				return false;
			}		
		}
		
		public function get_branch_reviews($branch)
		{
			$this->db->select($this->reviews.', date, time, branch, ss_id',false);
			$this->db->where('branch',$branch);
			$this->db->order_by("date","ASC");
			$query = $this->db->get('reviews');
			if ($query->num_rows() > 0) {
				foreach ($query->result_array() as $row)
				{
					$retval[] = $row;
				}
				return $retval;
			} else {
				return false;
			}
		}
		public function get_review($branch,$ss_id,$date,$time)
		{
			$this->db->where('branch',$branch);
			$this->db->where('ss_id',$ss_id);
			$this->db->where('date',$date);
			$this->db->where('time',$time);
			$query = $this->db->get('reviews');
			if ($query->num_rows() > 0) {
				return $query->result_array();
				
			} else {
				
				return false;
			}
		}
		
		public function get_review_answer($branch,$ss_id,$date,$time,$question){
			$this->db->where('branch',$branch);
			$this->db->where('ss_id',$ss_id);
			$this->db->where('date',$date);
			$this->db->where('time',$time);
			$this->db->where('question',$question);
			$query = $this->db->get('reviews');
			if ($query->num_rows() > 0) {
				return $query->result_array();
			} else {
				return false;
			}
		
		}
		
		
		public function get_all_question($question) {
			$this->db->where('question',$question);
			$query = $this->db->get('reviews');
			if ($query->num_rows() > 0) {
				$retval = array();
				foreach ($query->result_array() as $row)
				{
					$retval[] = $row;
				}
				return $retval;
			} else {
				return false;
			}
		
		}
		
		public function get_branch_question($question, $branch) {
			$this->db->where('question',$question);
			$this->db->where('branch',$branch);
			$query = $this->db->get('reviews');
			if ($query->num_rows() > 0) {
				$retval = array();
				foreach ($query->result_array() as $row)
				{
					$retval[] = $row;
				}
				return $retval;
			} else {
				return false;
			}
		}
		
		public function get_branch_score($question, $branch) {
			$this->db->where('question',$question);
			$this->db->where('branch',$branch);
			$this->db->select_avg('answer','score');
			$query = $this->db->get('reviews');
			if ($query->num_rows() > 0) 
			{
				return $query->row_array();
			} else {
				return false;
			}
		}
			
	
	
	}