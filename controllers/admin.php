<?php defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends Admin_Controller
{

	public $directory = '';
	public $data_file = '';

	public function __construct()
    {

        parent::__construct();

		// Load libraries
		$this->lang->load('documentation');
		$this->load->model('documentation_m');
		$this->load->library('form_validation');

		// Get current directory information and data
		$this->directory = $this->documentation_m->get_directory();
		$this->data_file = $this->directory.'_data';
		$this->_data     = @json_decode(file_get_contents($this->data_file), true);

		// Check data is set
		if( ! $this->_data && $this->uri->segment(3) != 'language' )
		{
			// Redirect etc etc.
		}

		// Add metadata
		$this->template->append_css('module::admin.css')
					   ->append_js('module::jquery.ui.nestedSortable.js')
					   ->append_js('module::admin.js');

		// Set the validation rules
		$this->validation_rules = array(
									array('field' => 'title', 'label' => 'Title', 'rules' => 'trim|max_length[255]|required'),
									array('field' => 'slug', 'label' => 'Slug', 'rules' => 'trim|max_length[255]|required'),
									array('field' => 'parent', 'label' => 'Parent', 'rules' => 'trim|numeric'),
									array('field' => 'keywords', 'label' => 'Keywords', 'rules' => 'trim'),
									array('field' => 'description', 'label' => 'Description', 'rules' => 'trim')
								  );

	}

	public function index()
	{

		// Variables
		$this->data->controller =& $this;
		$this->data->docs       =  $this->documentation_m->generate_doc_tree($this->_data);

		// Build the page
		$this->template->title(lang('docs:title'))
					   ->build('admin/index', $this->data);
	}

	public function create()
	{

		// Check for post data
		if( substr($this->input->post('btnAction'), 0, 4) == 'save' )
		{

			// Variables
			$this->data->input = $_POST;

			// Set validation rules
			$this->form_validation->set_rules($this->validation_rules);

			// Run validation
			if( $this->form_validation->run() )
			{

				// Add to data file
				$input  = $this->input->post();
				unset($input['btnAction']);
				$data[] = array_merge(array('id' => ( count($this->_data) + 1 )), $input);
				file_put_contents($this->data_file, json_encode($this->_data));

				// Create file
				$file   = $this->directory.$input['slug'].'.md';
				$handle = fopen($file, 'w');
				fclose($handle);
				chmod($file, 0777);

				// Redirect
				$this->session->set_flashdata('success', 'New documentation created successfully');
				redirect('admin/documentation');

			}

		}

		// Build the page
		$this->template->title(lang('docs:title').' '.lang('docs:section:create'))
					   ->build('admin/create', $this->data);

	}

	public function edit($id)
	{



	}

	public function delete($id)
	{



	}

	public function order()
	{

		// Variables
		$order		= $this->input->post('order');
		$data		= $this->input->post('data');
		$root_docs	= isset($data['root_docs']) ? $data['root_docs'] : array();

		// Check order is valid
		if( is_array($order) )
		{

			// Unset all category relationships
			foreach( $this->_data AS &$doc )
			{
				$doc['parent'] = 0;
			}

						foreach( $order as $i => $cat )
			{

		}

	}

	public function preview($id)
	{



	}

}