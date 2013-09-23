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
			redirect('/shopper/review_form/','refresh');
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
	
	public function review_form()
	{
		/*
		 TODO: need to change this to figure out which form was selected and load the appropriate form.
		*/
	
		$this->load->model('shopper/shopper_model','shopper');
		$shopper = $this->shopper->get_shopper_info($this->input->cookie('ss_id'));
		$data['shopper'] = $shopper;
		$this->load->helper('form');
		$this->load->helper('url');
			
		$this->load->view('shopper/review',$data);
		
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