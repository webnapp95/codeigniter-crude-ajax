<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Movies extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
     * @see https://codeigniter.com/user_guide/general/urls.html
     */

        public function __construct()
        {
            parent::__construct();
            $this->load->helper('url');
            $this->load->model('Main_model');

            //load model
        }

    /**
     * Render movie list.
     *
     * @author Chigs Patel <info@webnappdev.in>
     * @date November 3 2018
     */
    public function index()
    {
		$this->load->view('movieList');
		$this->load->view('create');
		$this->load->view('edit');
	}

    /**
     * Get movie list.
     *
     * @return array
     * @author Chigs Patel <info@webnappdev.in>
     * @date November 3 2018
     */
    public function getList()
    {
    	$this->load->library('pagination');
        // init params
        $params = array();
        $limit_per_page = 1;
        //echo $_GET['page'];exit;
        //$page = ($this->uri->segment(3)) ? ($this->uri->segment(3)) : 1;
        $page = $_GET['page'] && $_GET['page'] >= 1 ? $_GET['page'] : 0;
        //echo $page;exit;
        $params = [
        	'page_size' => $limit_per_page,
        	'page'      => $page,
        	'offset'    => $page*$limit_per_page,
        ];

        $total_records = $this->Main_model->get_total();
    	$moviesData['moviesData'] = $this->Main_model->getMoviesList($params);


            $config['base_url'] = base_url();
            $config['total_rows'] = $total_records;
            $config['per_page'] = $limit_per_page;
            //$config["uri_segment"] = 3;
             
            // custom paging configuration
            $config['num_links'] = 2;
            $config['use_page_numbers'] = TRUE;
            $config['reuse_query_string'] = TRUE;
             
            $config['full_tag_open'] = '<div class="pagination">';
            $config['full_tag_close'] = '</div>';
             
            $config['first_link'] = 'First Page';
            $config['first_tag_open'] = '<span class="firstlink">';
            $config['first_tag_close'] = '</span>';
             
            $config['last_link'] = 'Last Page';
            $config['last_tag_open'] = '<span class="lastlink">';
            $config['last_tag_close'] = '</span>';
             
            $config['next_link'] = 'Next Page';
            $config['next_tag_open'] = '<span class="nextlink">';
            $config['next_tag_close'] = '</span>';
 
            $config['prev_link'] = 'Prev Page';
            $config['prev_tag_open'] = '<span class="prevlink">';
            $config['prev_tag_close'] = '</span>';
 
            $config['cur_tag_open'] = '<span class="curlink">';
            $config['cur_tag_close'] = '</span>';
 
            $config['num_tag_open'] = '<span class="numlink">';
            $config['num_tag_close'] = '</span>';

            $this->pagination->initialize($config);
            $moviesData['pagination'] = $this->pagination->create_links();
            $this->successResponse($moviesData);

            //echo json_encode($moviesData);
    }

    private function successResponse($data = [])
    {
        $response = [
            'code' => 0,
            'data' => $data,
            'msg'  => 'Success',
        ];
        $this->output->set_status_header(200)
                    ->set_content_type('application/json')
                    ->set_output(json_encode($response));
    }

    private function errorResponse($data = [])
    {
        
    }

}
