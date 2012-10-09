<?php defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends Admin_Controller
{

	public function __construct()
    {

        parent::__construct();

		// Load libraries
		$this->lang->load('documentation');
		$this->load->model('documentation_m');
		// $this->load->library('');

	}

	public function index()
	{

		// Build the page
		$this->template->title(lang('docs:title'))
					   ->build('admin/index', $this->data);
	}

}