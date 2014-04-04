
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
		$this->load->helper(array('form','url'));
		$this->load->library('form_validation');
		$this->form_validation->set_rules('employee_activity','What were the employees doing?','required');
		$this->form_validation->set_rules('employee_appearance_examples','Examples of employee dress','required');
		$this->form_validation->set_rules('date','Date','callback_date_check');
		if($this->form_validation->run() == false)
		{
			$data = array();
			$this->load->model('shopper/shopper_model','shopper');
			$shopper = $this->shopper->get_shopper_info($this->input->post('ss_id'));
			$data['shopper'] = $shopper;
			$this->load->view("shopper/review",$data);
		} else {
			
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
	}
	public function date_check($date) {
		if (preg_match('/\d{4}-\d{2}-\d{2}/',$date)) {
			return true;
		} else {
			$this->form_validation->set_message('date_check','<script>alert(\'The %s field is not formatted correctly. Please use your browsers back button to provide an answer then resubmit the form.\');</script><p>You did not format %1$s correctly.</p>');
			return false;
		}
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
		
		
		
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="error">','<p><strong>Use the back button to go back and correct the problems then resubmit the form</strong></p></div>');
		$this->form_validation->set_message('required','<script>alert(\'An answer to %s is required. Please use your browsers back button to provide an answer then resubmit the form.\');</script><p>You did not answer %1$s.</p>');
		$this->form_validation->set_rules('employee_activity','What were the employees doing?','required');
		$this->form_validation->set_rules('employee_appearance_examples','Examples of employee dress','required');
		$this->form_validation->set_rules('date','Date','callback_date_check');
		if($this->form_validation->run() == false)
		{
			/*
			$this->load->model('question/question_model','question');
			$this->load->model('shopper/shopper_model','shopper');
			$this->load->helper('form');
			$this->load->helper('url');
			$shopper = $this->shopper->get_shopper_info($this->input->post('ss_id'));
			$quiz_questions = $this->question->get_quiz_question(2);
			$data = array();
			$data['shopper'] = $shopper;
			foreach ($quiz_questions as $question)
			{
				$data[$question['question_code']] = $this->question->get_form_field($question['question_code']);
			}
			
			$this->load->view('shopper/reference_review',$data);
			*/
			echo validation_errors();
		} else {
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
	public function circ_submit()
	{
		/*
			//Stub for submit function for reference review
		//*/
		
		$data = array();
		$ss_id = $this->input->post('ss_id');
		$date = $this->input->post('date');
		$time = $this->input->post('time');
		
		$this->load->model('question/question_model','question');
		
		$questions = $this->question->get_quiz_question(3);
		
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="error">','<p><strong>Use the back button to go back and correct the problems then resubmit the form</strong></p></div>');
		$this->form_validation->set_message('required','<script>alert(\'An answer to %s is required. Please use your browsers back button to provide an answer then resubmit the form.\');</script><p>You did not answer %1$s.</p>');
		$this->form_validation->set_rules('employee_activity','What were the employees doing?','required');
		$this->form_validation->set_rules('employee_appearance_examples','Examples of employee dress','required');
		$this->form_validation->set_rules('date','Date','callback_date_check');
		if($this->form_validation->run() == false)
		{
			
			/*
			$data = array();
			$quiz_questions = array();
			$this->load->model('question/question_model','question');
			$this->load->model('shopper/shopper_model','shopper');
			$this->load->helper('form');
			$this->load->helper('url');
			$shopper = $this->shopper->get_shopper_info($this->input->post('ss_id'));
			$data['shopper'] = $shopper;
			$quiz_questions = $this->question->get_quiz_question(3);
			foreach ($quiz_questions as $question)
			{
				$data[$question['question_code']] = $this->question->get_form_field($question['question_code']);
			}
			$this->load->view('shopper/circulation_review',$data);
			*/
			echo validation_errors();
			
		} else {
		
			foreach ($questions as $question)
			{
				if ($question['question_code'] != "date" && $question['question_code'] != "time"){
					$value = $this->input->post($question['question_code']);
					//*
					$data[] = array(
						'ss_id' => $ss_id,
						'date' => $date,
						'time' => $time,
						'quiz' => 3,
						'question' => $question['question_code'],
						'answer' => $value
					);
				}
				//*/
			}
			//*
			$this->db->insert_batch('circ_reviews',$data);
			//*/
			$this->load->helper('url');
			$this->load->view('shopper/thankyou');
		}
	
	}
	
	
}