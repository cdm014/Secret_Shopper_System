<?php
class Review extends CI_Controller {
	
	public function index()
	{
	}

	public function submit()
	{
		
		/*
			'employee_count','greeted','greet_count','employee_activity','employee_appearance','employee_appearance_examples','NameBadges','thanked','welcome','assistance','escort','card','LibraryCardExperience','selfcheck'
		*/
		
		$fields = array('employee_count','greeted','greet_count','employee_activity','employee_appearance','employee_appearance_examples','NameBadges','thanked','welcome','assistance','escort','card','LibraryCardExperience','selfcheck');
		$data = array();
		$ss_id = $this->input->post('ss_id');
		$date = $this->input->post('date');
		$time = $this->input->post('time');
		$branch = $this->input->post('branch');
		foreach ($fields as $field) {
			$value = $this->input->post($field);
			//*
			$data[] = array(
				'ss_id' => $ss_id,
				'date' => $date,
				'time' => $time,
				'branch' => $branch,
				'question' => $field,
				'answer' => $value
			);
			//*/
		}
		$this->db->insert_batch('reviews',$data);
		$this->load->helper('url');
		$this->load->view('shopper/thankyou');
	}
	
	public function refSubmit()
	{
		/*
			//Stub for submit function for reference review
		//*/
	}
	
	
}