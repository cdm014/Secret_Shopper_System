<?php
	class Shopper_model extends CI_Model {
		var $id = '';
		var $name = '';
		var $email = '';
		var $phone = '';
		
		function __construct()
		{
			parent::__construct();
		}
		
		function verify_id($id)
		{
			$this->db->select('id');
			$this->db->where('id',$id);
			$query = $this->db->get('shoppers');
			if ($query->num_rows() > 0 )
			{
				return true;
			} else {
				return false;
			}
		}
		
		function get_shopper_info($id)
		{
			$query = $this->db->get_where('shoppers',array('id' => $id));
			if ($query->num_rows() == 0) 
			{
				return false;
			} else {
				if ($query->num_rows() == 1) 
				{
					return $query->row();
				}
			}
			
		}
		
		function get_all_shopper_ids()
		{
			$this->db->select('id');
			$query = $this->db->get('shoppers');
			$retval = array();
			if ($query->num_rows() == 0) 
			{
				return false;
			} else {
				foreach ($query->result() as $row)
				{
					$retval[] = $row->id;
				}
				return $retval;
			}
		}
		
		function create_shopper() {
			$data = array(
				'id' => $this->input->post('ss_id'),
				'name' => $this->input->post('name'),
				'phone'=> $this->input->post('phone'),
				'email' => $this->input->post('eMail'),
				'branches' => $this->input->post('branches')
			);
			$this->db->insert('shoppers',$data);
		
		}
		
		function update_shopper() {
			$data = array(
				'name' => $this->input->post('name'),
				'phone'=> $this->input->post('phone'),
				'email' => $this->input->post('eMail'),
				'branches' => $this->input->post('branches')
			);
			$this->db->where('id',$this->input->post('ss_id'));
			$this->db->update('shoppers',$data);
		
		}
	}