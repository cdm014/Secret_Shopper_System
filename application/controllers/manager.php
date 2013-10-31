<?php
class Manager extends CI_Controller {
	var $cookie_name = 'mgr_login';
	var $password = '3741brun';
	var $mainlink;
	var $createlink;
	var $logoutlink;
	var $url;
	
	
	public function __construct() {
		parent::__construct();
		$this->load->helper(array('url','html'));
		$this->mainlink = anchor('manager/main','Return to Manager Menu','id="MainMenu"');
		$this->createlink = anchor("manager/create_shopper",'Create a new Shopper','id="createShopper"');
		$this->logoutlink = anchor('manager/logout/','Log Out of Secret Shopper Management','id="LogoutLink"');
		$this->url = array();
		$this->url['main'] = site_url('manager/main');
		$this->url['CreateShopper'] = site_url('manager/create_shopper');
		$this->url['logout'] = site_url('manager/logout');
		
	}
	public function index()
	{
		//either feed login form
		//or proceed directly to verifying manager login
		
		
		if($this->check())
		{
			redirect('/manager/main/','refresh');
		} else {
			$this->load->helper('form');
			$data = array();
			$data['cookie_name'] = $this->cookie_name;
			$this->load->view('manager/login',$data);
		}
		
	}
	private function check() {
		$this->load->helper('url');
		if ($this->input->post($this->cookie_name) == $this->password || $this->input->cookie($this->cookie_name) == $this->password){
			$cookie = array(
				'name' => $this->cookie_name,
				'value' => $this->password,
				'expire' => 3600
			);
			$this->input->set_cookie($cookie);
			return true;
		
		} else {
			
			return false;
		}
	
	}
	
	public function main()
	{
		
		/*
			present choice
				1. Edit Secret Shopper Data
				2. View results
						All Branches or just a particular Branch
						with or without view data attached
						specify date range
		*/
			$data = array();
			$data['ShoppersUrl'] = site_url('manager/display_shopper');
			$data['AllReviewsUrl'] = site_url('manager/all_reviews');
			$data['BranchScoresUrl'] = site_url('manager/branch_scores');
			$data['ShoppersLink'] = anchor('manager/display_shoppers','Shopper Data');
			$data['ReviewsLink'] = anchor('manager/all_reviews','List of Reviews Submitted');
			$data['BranchScoresLink'] = anchor('manager/branch_scores','See Branch scores for Yes or No questions');
			$data['IndividualBranch'] = anchor('manager/individual_scores','See scores for Yes or No questions for an individual branch');
			$data['ReferenceReviewsLink'] = anchor('manager/reference_reviews','List of Reference Reviews');
			$data['ReferenceScoresLink'] = anchor('manager/reference_scores','See scores for Yes or No questions for the Reference Department');
			
			$this->load->view('manager/main',$data);
		/*
			echo "<h1>Manager/main</h1>";
			echo "<p>This is a stub in controllers/manager.php function: main(). This code should be replaced with a real call to a view.</p>";
			$this->load->helper('url');
			echo "<p>".anchor('manager/display_shoppers','Shopper Data')."</p>";
			echo "<p>".anchor('manager/all_reviews','List of Reviews Submitted')."</p>";
			echo "<p>".anchor('manager/branch_scores','See Branch scores for Yes or No questions')."</p>";
		//*/
	}
	
	public function logout()
	{
		$cookie = array(
				'name' => $this->cookie_name,
				'value' => 'logged out',
				'expire' => 3600
			);
			$this->input->set_cookie($cookie);
			$this->load->helper('url');
			
			redirect('/manager/index/','refresh');
	}
	
	public function display_shoppers()
	{
		$this->load->model('shopper/shopper_model','shopper');
		$ids = $this->shopper->get_all_shopper_ids();
		$this->load->library('table');
		$table = array(
			array ( 'Secret Shopper Code', 'Name', 'e-Mail Address','phone number', 'branches they will visit')
		);
		$this->load->helper('url');
		foreach ($ids as $id)
		{
			$shopper =  $this->shopper->get_shopper_info($id);
			$sdata = array ( anchor('manager/edit_shopper/'.$shopper->id,$shopper->id), $shopper->name, mailto($shopper->email,$shopper->email), $shopper->phone, $shopper->branches);
			$table[] = $sdata;
		}
		
		$this->load->helper("url");
		$this->table->set_template(array('table_open' => '<table cellpadding="4" border="1" cellspacing ="0">'));
		$data = array();
		
		$data['table'] = $this->table->generate($table);
		
		$data['returnlink'] = $this->mainlink;
		$data['createlink'] = $this->createlink;
		$this->load->view('shopper/list',$data);
		/*
		echo "<pre>";
		echo print_r($data,true);
		echo "</pre>";
		//*/
		
	}
	

	
	public function create_shopper()
	{
		$this->load->helper('html');
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->view('shopper/create');
	}
	
	public function insert_shopper()
	{
		$this->load->model('shopper/shopper_model','shopper');
		$action = $this->input->post('action');
		if ($action == 'create') {
			$this->shopper->create_shopper();
		} elseif ($action == 'update') {
			$this->shopper->update_shopper();
		}
		$this->load->helper('url');
		redirect('manager/display_shoppers','refresh');
	}
	
	public function edit_shopper($ss_id)
	{
		$this->load->model('shopper/shopper_model','shopper');
		$data = array();
		$data['shopper'] = $this->shopper->get_shopper_info($ss_id);
		$this->load->helper('html');
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->view('shopper/edit',$data);
		
	}
	
	
	public function all_reviews()
	{
		$this->load->model('review/review_model','review');
		$reviews = $this->review->get_all_reviews();
		$this->load->library('table');
		$this->load->helper(array('url','form','html'));
		//echo "<pre>".print_r($reviews,true)."</pre>";
		$this->table->set_heading("Branch","Date","Time","Shopper ID","link");
		foreach($reviews as $review) {
			$this->table->add_row($review['branch'],$review['date'],$review['time'],$review['ss_id'],anchor('manager/view_review/'.$review['branch']."/".$review['ss_id']."/".$review['date'].'/'.$review['time'],'See Review'));
		}
		$data = array();
		$data['table'] = $this->table->generate();
		$data['returnlink'] = $this->mainlink;
		$this->load->view('review/list',$data);
		/*
		echo "<h1>manager/all_reviews</h1>";
		echo "<pre>".print_r($data,true)."</pre>";
		//*/
	}
	
	public function reference_reviews()
	{
		$data = array();
		$this->load->model('review/reference_model','reference');
		$reviews = $this->reference->get_reviews();
		//$data['reviews'] = $reviews;
		if($reviews !== false)
		{
			$data['has_data'] = true;
			$this->load->library('table');
			$this->load->helper(array('url','form','html'));
			$this->table->set_heading("Date","Time","Shopper ID","Link");
			foreach ($reviews as $review)
			{
				$this->table->add_row($review['date'],$review['time'],$review['ss_id'],anchor('manager/view_ref_review/'.$review['ss_id']."/".$review['date']."/".$review['time'],'See Review'));
			}
			$data['table'] = $this->table->generate();		
			$data['returnlink']=$this->mainlink;
			$data['err_msg']='';
			
		} else {
			$data['has_data'] = false;
			$data['err_msg'] = "<p>No Reference Reviews Found</p>";
		}
		$this->load->view('review/list_reference',$data);
		
		/*
		echo "<h1>manager/reference_reviews</h1>";
		echo "<pre>".print_r($data,true)."</pre>";
		if($reviews === false) {
			echo "<p> No Reviews Found</p>";
		}
		//*/
	}
	
	
	
	public function individual_scores() {
		if (func_num_args() > 0) {
			//we passed a branch
			$branch = func_get_arg(0);
			$fields = array('greeted','thanked','welcome','NameBadges','assistance','escort','selfcheck');
			$this->load->library('table');
			$this->table->set_template(array('table_open' => '<table cellpadding="4" border="1" cellspacing ="0"><col style="width:10em">'));
			$this->load->model('question/question_model','question');
			$branch_name = $this->question->translate_answer('branch',$branch);
			
			$this->load->model('review/review_model','review');
			$headings = array();
			$headings[] = 'Review';
			foreach ($fields as $field)
			{
				if($field == 'selfcheck') {
					$headings[] = "Mentioned Self-Checkout";
				} elseif ($field == 'escort'){
					$headings[] = "Were you escorted to the book you asked for?";
				}else {
					$headings[] = $this->question->translate_question_code($field);
				}
			}
			$this->table->set_heading($headings);
			
			$reviews = $this->review->get_branch_reviews($branch);
			foreach ($reviews as $review){
				$date = $review['date'];
				$time = $review['time'];
				$ss_id = $review['ss_id'];
				$row = array();
				$row[] = anchor('manager/view_review/'.$review['branch']."/".$review['ss_id']."/".$review['date'].'/'.$review['time'],$date." ".$time);
				
				foreach ($fields as $field) {
					$answer = $this->review->get_review_answer($branch,$ss_id,$date,$time,$field);
					$row[] = $answer[0]['answer'];
				}
				$this->table->add_row($row);
				
			}
			$final_row = array();
			$final_row[] = "Scores";
			foreach ($fields as $field) {
				$score = $this->review->get_branch_score($field,$branch);
				$final_row[] = ($score['score'] * 100)."%";
			}	
			$this->table->add_row($final_row);
			$data['table'] = $this->table->generate();
			$data['branch_name'] = $branch_name;
			$data['branch'] = $branch;
			$data['mainlink'] = $this->mainlink;
			$data['IndividualBranch'] = anchor('manager/individual_scores','Back to Branches Menu');
			$this->load->view('manager/individual_scores',$data);
			
		} else {
			//we didn't pass a branch
			
			$this->db->select('branch');
			$this->db->distinct();
			$bquery = $this->db->get('reviews');
			$branches = array();
			foreach ($bquery->result_array() as $row){
				$branches[] = $row['branch'];
			}
			$branchLinks = array();
			$this->load->library('table');
			foreach ($branches as $branch) {
				$this->load->model('question/question_model','question');
				$branch_name = $this->question->translate_answer('branch',$branch);
				$branchLinks[] = anchor('manager/individual_scores/'.$branch,$branch_name);
				$this->table->add_row(anchor('manager/individual_scores/'.$branch,$branch_name));
			}
			$data = array();
			$data['branchLinks'] = $branchLinks;
			$data['mainlink'] = $this->mainlink;
			$data['table'] = $this->table->generate();
			$this->load->view('manager/branch_list',$data);
			
			
			
		}
	
	}
	public function reference_scores()
	{
		$this->load->model('question/question_model','question');
		$this->load->model('review/reference_model','reference');
		$fields = $this->question->get_quiz_question(2);
		$data['fields'] = $fields;
		$questions = array();
		foreach ($fields as $field) {
			$questions[$field['question_code']] = $this->question->get_question($field['question_code']);
		}
		$data['questions'] = $questions;
		$score_fields = array();
		
		$score_fields_labels = array();
		$score_fields_labels[] = 'Review';
		foreach ($questions as $question) 
		{
			if ($question['type'] == 'yes_no')
			{
				$score_fields[] = $question['code'];
				$score_fields_labels[] = $question['text'];
			}
		}
		$data['score_fields'] = $score_fields;
		$data['score_fields_labels'] = $score_fields_labels;
		$this->load->library('table');
		$this->table->set_template(array('table_open' => '<table cellpadding="4" border="1" cellspacing ="0"><col style="width:10em">'));
		$this->table->set_heading($score_fields_labels);
		$reviews = $this->reference->get_reviews();
		if($reviews !== false)
		{
			$data['err_msg'] = false;
			$data['reviews'] = $reviews;
			foreach ($reviews as $review)
			{
				$date = $review['date'];
				$time = $review['time'];
				$ss_id = $review['ss_id'];
				$row = array();
				$row[] = anchor('/manager/view_ref_review/'.$ss_id."/".$date."/".$time,$date." ".$time); 
				foreach($score_fields as $field)
				{
					$answer = $this->reference->get_review_answer($ss_id,$date,$time,$field); 
					$row[] = $answer[0]['answer'];
				}
				$this->table->add_row($row);
			}
			//final row
			$final_row = array();
			$final_row[] = "Score";
			foreach($score_fields as $field)
			{
				$score = $this->reference->get_score($field);
				$final_row[] = ($score['score']* 100)."%"; 
				
			}
			$this->table->add_row($final_row); 
			$data['table'] = $this->table->generate();
		} else {
			$data['err_msg'] = "<p>No Reviews Found</p>";
		}
		$data['mainlink'] = $this->mainlink;
		$this->load->view('manager/reference_scores',$data);
		/*
		echo "<h1>manager/reference_scores</h1>";
		echo "<pre>".print_r($data,true)."</pre>";
		/*
		if($reviews === false) {
			echo "<p> No Reviews Found</p>";
		}
		//*/
		
	}
	
	public function view_review($branch,$ss_id,$date,$time){
		$this->load->model('review/review_model','review');
		$this->load->library('table');
		$this->table->set_heading('Question','Response');
		$this->load->model('question/question_model','question');
		$branch_name = $this->question->translate_answer('branch',$branch);
		$data['branch'] = $branch_name;
		$data['date'] = $date;
		$data['returnlink'] = $this->mainlink;
		$this->load->model('shopper/shopper_model','shopper');
		$shopper = $this->shopper->get_shopper_info($ss_id);
		$data['shopper'] = $shopper;
		
		$review = $this->review->get_review($branch,$ss_id,$date,$time);
		foreach ($review as $question) 
		{
			
			$DoNotDisplay = "greet_count,LibraryCardExperience,employee_activity,selfcheck";
			if($question['question'] == 'card'||stripos($DoNotDisplay,$question['question']) === false &&($question['question'] != 'employee_appearance_examples' ||$question['answer'] != '')) {
				
				$qcode = $question['question'];
				$answer = $question['answer'];
				$this->table->add_row($this->question->translate_question_code($question['question']), $this->question->translate_answer($qcode,$answer));
				$field = '';
				if($question['question'] == 'greeted') {
					$field = 'greet_count';
				} elseif ($question['question'] == 'card' && $question['answer'] == 1) {
					$field = "LibraryCardExperience";
				} elseif ($question['question'] == 'employee_count') {
					$field = "employee_activity";					
				}

				if ($field != '') {
					$answer2 = $this->review->get_review_answer($branch,$ss_id,$date,$time,$field);
					$ranswer2 = $answer2[0]['answer'];
					//echo "answer2: <pre>".print_r($answer2,true)." </pre>";
					if($answer2 !== false) {
						$this->table->add_row($this->question->translate_question_code($field),$this->question->translate_answer($field,$ranswer2));
					} else {
						$this->table->add_row($this->question->translate_question_code($field),"ERROR DATA NOT FOUND");
					}		
				}
			}
		}
		$table = $this->table->generate();
		$data['table'] = $table;
		$this->load->view('review/view',$data);
		/*
		//echo "<pre>".print_r($review,true)."</pre>";
		echo "<h1>manager/view_review</h1>";
		echo "<p>This is a stub in controllers/manager.php function: view_review(). This code should be replaced with a real call to a view.</p>";
		echo "<p>$this->mainlink</p>";
		echo $table;
		//*/
	}
	
	public function branch_scores()
	{
	/*
			greeted
			thanked
			welcome
			NameBadges
			assistance
			escort
			selfcheck
		*/
		
		$fields = array('greeted','thanked','welcome','NameBadges','assistance','escort','selfcheck');
		$this->db->select('branch');
		$this->db->distinct();
		$bquery = $this->db->get('reviews');
		$branches = array();
		foreach ($bquery->result_array() as $row){
			$branches[] = $row['branch'];
		}
		$this->load->library('table');
		$this->table->set_template(array('table_open' => '<table cellpadding="4" border="1" cellspacing ="0">'));
		$this->load->model('question/question_model','question');
		$this->load->model('review/review_model','review');
		$headings = array();
		$headings[] = 'Branch';
		foreach ($fields as $field)
		{
			$headings[] = $this->question->translate_question_code($field);
		}
		$this->table->set_heading($headings);
		//echo "<pre>".print_r($branches,true)."</pre>";
		//*
		foreach($branches as $branch)
		{
			
			
			$rowArray = array();
			$branch_name = $this->question->translate_answer('branch',$branch);
			$rowArray[] = anchor('manager/individual_scores/'.$branch,$branch_name);
			
			foreach ($fields as $field)
			{
				
				$score = $this->review->get_branch_score($field,$branch);
				$rowArray[] = ($score['score'] * 100)."%";
			}
			$this->table->add_row($rowArray);
			
		}
		$data['table'] = $this->table->generate();
		$data['returnlink'] = $this->mainlink;
		$data['ReviewsLink'] = anchor("manager/all_reviews","List of Secret Shopper Reviews",'id="ReviewsLink"');
		$data['IndividualBranch'] = anchor('manager/individual_scores','See scores for Yes or No questions for an individual branch');
		$data['instructions'] = "<p>Click the Branch name to see the individual review scores for that branch.</p>";
		$this->load->view('manager/branch_scores',$data);
		//*/
		/*
		echo "<h1>manager/branch_scores</h1>";
		echo "<p>This is a stub for controller manager.php function branch_scores(). This should be replaced with a real view call</p>";
		echo "<p>".$this->mainlink."</p>";
		echo "<p>Scores range from 0 to 1 and are computed as Yes_answes/(Yes_answers + No_answers + Blank_answers)</p>";
		echo $data['table'];
		//*/
	}
	
	
	
}