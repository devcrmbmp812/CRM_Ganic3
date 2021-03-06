<?php
defined('BASEPATH') OR exit('No direct script access allowed');
	class Supplier_master extends CI_Controller {

		public $view_path;
		public $data;
		public $table;
		public $logged_id;
		public function __construct()
		{
			parent::__construct();
			
			$this->table="customer_master";
			$this->logged_id = $this->session->user_id;
			$this->view_path = 'common/ajax/supplier_master/';
		}
		public function add()
		{
			is_ajax();
			$this->data['currency_options']=$this->custom->createDropdownSelect("currency_master",array('currency_id','currency_name','currency_description'),"Currency",array(" ( "," ) "));
			$this->data['country_options']=$this->custom->createDropdownSelect("country_master",array('country_id','country_name'),"Country",array(' '));
			$this->load->view($this->view_path.'add',$this->data);
		}
		public function edit()
		{
			$this->fetchData();
			$this->data['mode'] = "edit";
			$this->load->view($this->view_path.'edit',$this->data);
		}
		public function view()
		{
			$this->fetchData();
			$this->data['mode'] = "view";
			$this->load->view($this->view_path.'edit',$this->data);
		}

		public function save()
		{
			$post=$post=$this->input->post();
			if($post)
			{
				if($post['currency_id']==""){
					$post['currency_id'] = $this->custom->getSingleValue("currency_master","currency_id",array('currency_name' => "SGD"));
				}
				if($post['country_id']==""){
					$post['country_id'] = $this->custom->getSingleValue("country_master","country_id",array('country_name' => "SINGAPORE"));
				}
				$id = $this->custom->insertRow($this->table,$post);
				$where = array('customer_id'=>$id);
				$this->custom->updateRow($this->table,array('flag' => 'S'), $where);
				if($id != "error"){	
					
					set_flash_message('message','success',"Supplier Inserted Successfully");
				}		
				else
				{
					set_flash_message('message','danger',"Something Went Wrong !!");
				}
				redirect('master_files/supplier_master');
			}
			else
			{
				show_404();
			}
		}
		public function update()
		{
			$post=$this->input->post();
			if($post)
			{
				if($post['currency_id']==""){
					$post['currency_id'] = $this->custom->getSingleValue("currency_master","currency_id",array('currency_name' => "SGD"));
				}
				if($post['country_id']==""){
					$post['country_id'] = $this->custom->getSingleValue("country_master","country_id",array('country_name' => "SINGAPORE"));
				}
				$id = $post['id'];
				unset($post['id']);
				$where = array('customer_id'=>$id);
				$result = $this->custom->updateRow($this->table,$post,$where);
				if($result){
					
					set_flash_message('message','success',"Supplier Updated Successfully");
				}
				else{
					set_flash_message('message','danger',"Something Went Wrong !!");
				}
				redirect('master_files/customer_master');
			}
			else
			{
				show_404();
			}
		}
		public function delete()
		{
			is_ajax();
			$id=$this->input->post('rowID');
			$where = array('customer_id' => $id);
			$result = $this->custom->deleteRow($this->table,$where);
			echo $result;
		}
		function fetchData(){
			is_ajax();
			$id=$this->input->post('rowID');

			$row = $this->custom->getSingleRow($this->table,array('customer_id' => $id));
			if($row)
			{
				$this->data['customer'] = $row;
				$this->data['currency_options']=$this->custom->createDropdownSelect("currency_master",array('currency_id','currency_name','currency_description'),"Currency",array(" ( "," ) "),array(),array($row->currency_id));
				$this->data['country_options']=$this->custom->createDropdownSelect("country_master",array('country_id','country_name'),"Country",array(' '),'',array($row->country_id));
			}	
		}

	}

?>