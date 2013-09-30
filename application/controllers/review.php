
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
	
	public function ref_submit()
	{
		/*
			//Stub for submit function for reference review
		//*/
		
		$data = array();
		$ss_id = $this->input->post('ss_id');
		$date = $this->input->post('date');
		$time = $this->input->post('time');
		
		$this->load->model('question/question_model','question');
		
		$questions = $this->question->get_quiz_question(2);
		
		foreach ($questions as $question)
		{
			if ($question['question_code'] != "date" && $question['question_code'] != "time"){
				$value = $this->input->post($question['question_code']);
				//*
				$data[] = array(
					'ss_id' => $ss_id,
					'date' => $date,
					'time' => $time,
					'quiz' => 2,
					'question' => $question['question_code'],
					'answer' => $value
				);
			}
			//*/
		}
		//*
		$this->db->insert_batch('ref_reviews',$data);
		//*/
		$this->load->helper('url');
		$this->load->view('shopper/thankyou');
	}
	
	
}