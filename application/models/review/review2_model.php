<?php
	class Circulation_model extends CI_Model {
		var $reviews = "Distinct( concat_ws(' ', date, time, ss_id )) as reviews";
		
		function __construct()
		{
			parent::__construct();
		}
		
		public function get_reviews()
		{
			
			$this->db->select($this->reviews.', date, time, ss_id', false);
			$this->db->order_by('date','desc');
			$query = $this->db->get('circ_reviews');
			$retval = array();
			if ($query->num_rows() > 0) {
				foreach($query->result_array() as $row)
				{
					$retval[] = $row;
				}
			} else {
				return false;
			}
			return $retval;
		}
		
		public function get_review($ss_id, $date, $time)
		{
			$this->db->where('ss_id',$ss_id);
			$this->db->where('date',$date);
			$this->db->where('time',$time);
			$query = $this->db->get('circ_reviews');
			if($query->num_rows() > 0) {
				return $query->result_array();
			} else {
				return false;
			}
			
		}
		
		public function get_score($question)
		{
			$this->db->where('question',$question);
			$this->db->select_avg('answer','score');
			$query = $this->db->get('circ_reviews');
			if($query->num_rows() > 0) {
				return $query->row_array();
			} else {
				return false;
			}
		}
		
		public function get_review_answer($ss_id,$date,$time,$question)
		{
			$this->db->where('ss_id',$ss_id);
			$this->db->where('date',$date);
			$this->db->where('time',$time);
			$this->db->where('question',$question);
			$query = $this->db->get('circ_reviews');
			if($query->num_rows() 0)
			{
				return $query->result_array();
			} else {
				return false;
			}
		}
	}