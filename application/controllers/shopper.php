<?php
class Shopper extends CI_Controller {
	public function index()
	{
		$this->load->model('shopper/shopper_model');
		//if not verified
		if ($this->input->cookie('ss_id') === false || $this->input->cookie('ss_id') == "logged out") {
			$this->load->helper('form');
			$this->load->view('shopper/login');
		} else {
			$this->load->helper('url');
			redirect('/shopper/login/','refresh');
		}
	}
	
	public function login()
	{
		$this->input->set_cookie(array('name' => 'id', 'value' => 'logged out', 'expire' => 1));
		$this->load->model('shopper/shopper_model','shopper');
		$verified = $this->shopper->verify_id($this->input->post('sscode'));
		$cverified = $this->shopper->verify_id($this->input->cookie('ss_id'));
		if ($verified || $cverified) 
		{
			if ($verified)
			{
				$cookie = array(
					'name' => 'ss_id',
					'value' => $this->input->post('sscode'),
					'expire' => 3600
				);
			} else {
				$cookie = array(
					'name' => 'ss_id',
					'value' => $this->input->cookie('ss_id'),
					'expire' => 3600
				);
			}
			$this->input->set_cookie($cookie);
			$this->load->helper('url');
			/*
				TODO: need to change next line to go to form selector after I add function for it
			*/
			redirect('/shopper/select_form/','refresh');
			echo "it worked 2";
		} else {
			$this->load->helper('url');
			$cookie = array(
				'name' => 'ss_id',
				'value' => 'logged out',
				'expire' => 3600
			);
			$this->input->set_cookie($cookie);
			redirect('/shopper/index/','refresh');
			
		}
	}
	
	public function logout() 
	{
		$this->load->helper('url');
			$cookie = array(
				'name' => 'ss_id',
				'value' => 'logged out',
				'expire' => 3600
			);
			$this->input->set_cookie($cookie);
			redirect('/shopper/index/','refresh');
	}
	
	public function select_form()
	{
		/*
			for now this function will simply list all possible quizzes and let them select which one they want to take
			later idea is to have it where certain users are authorized to only take certain quizzes
		*/
		$this->load->model('quiz/quiz_model','quiz');
		
		//for when quizzes are assigned to shoppers
		// $this->load->model('shopper/shopper_model','shopper');
		$quizzes = $this->quiz->list_quizzes();
		$this->load->helper('url');
		$quiz_array = array();
		foreach ($quizzes as $quiz)
		{
			$quiz_array[] = anchor('shopper/review_form/'.$quiz->id,$quiz->quiz_name);
		}
		$data = array();
		$data['quizzes'] = $quiz_array;
		$this->load->view('shopper/select_form',$data);
		/*
			//Stub display
			foreach ($data['quizzes'] as $quiz)
			{
				echo "<p>".$quiz."</p>";
			}
		
		//*/
	}
	
	public function review_form($quiz)
	{
		$this->load->model('shopper/shopper_model','shopper');
		$this->load->model('quiz/quiz_model','quiz');
		$this->load->model('question/question_model','question');
		$questions = $this->quiz->get_questions($quiz);
		$shopper = $this->shopper->get_shopper_info($this->input->cookie('ss_id'));
		$data['shopper'] = $shopper;
		$this->load->helper('form');
		$this->load->helper('url');
		
		$data['quiz'] = $quiz;
		$data['questions'] = array();
		foreach ($questions as $question)
		{
			$data['questions'][] = $this->question->get_question($question->question_code);
		}
		/*
			//Need to change this to load the generic form view that I can populate with questions
			//$this->load->view('shopper/review',$data);
			$this->load->view('review/view_form',$data);
		//*/
		//*
			//display stub
			echo "<p> You selected form #".$quiz."</p>";
			echo "<p> Hello ".$data['shopper']->name."</p>";
			foreach ($data['questions'] as $question)
			{
				echo "<p>".$this->question->get_form_field($question['code'])."</p>";
			}
			
		//*/
		
	}
	
	private function _login_form() 
	{
		$this->load->helper('form');
		$this->load->view('shopper/login');
	}
	
	public function check_ID($id) {
		$this->load->model('shopper/shopper_model','shopper');
		if ($this->shopper->verify_id($id))
		{
			echo "0";
		} else {
			echo "1";
		}
	
	}
}
?>