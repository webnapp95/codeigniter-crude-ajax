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
        $limit_per_page = 10;
        //$page = ($this->uri->segment(3)) ? ($this->uri->segment(3)) : 1;
        $page = isset($_GET['page']) && $_GET['page']>=1 ? $_GET['page']-1 : 0;
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

        /**
     * Delete movie record by id.
     *
     * @param int    $id
     * @return json
     * @author Chigs Patel <info@webnappdev.in>
     * @Date 3rd Nov 2018
     */
    public function deleteMovies() {
        $id = $this->input->get('id');
        $data = ['is_active' => 1, 'deleted_at' => Date('Y-m-d H:i:s')];
        $this->db->where('id', $id);
        $isDeleted = $this->db->update('movies', $data);
        if ($isDeleted)
        return $this->successResponse([], 'Deleted Records Successfull');
        return $this->errorResponse('Something went wrong!');
    }

    public function createMovies()
    {
        $params = $this->input->post();
        if (empty($params)) {
            return $this->errorResponse('Params Error!');
        }
        $isAdd = $this->Main_model->addMovies($params);
        if ($isAdd)
        return $this->successResponse([], 'Add Records Successfull');
        return $this->errorResponse('Something went wrong!');

    }

    public function updateMovies()
    {
        $params = $this->input->post();
        if (!isset($params['id']) || empty($params['id'])) {
            return $this->errorResponse('Params Error!');
        }
        $isUpdate = $this->Main_model->updateMovies($params['id'], $params);
        if ($isUpdate)
        return $this->successResponse([], 'Add Records Successfull');
        return $this->errorResponse('Something went wrong!');
    }

    {
        $config['upload_path']          = 'C:\xampp\htdocs\codeigniter-crude-ajax\uploads';
        $config['allowed_types']        = 'gif|jpg|png';
        $config['max_size']             = 1000;
        //$config['max_width']            = 1024;
        //$config['max_height']           = 768;

        $this->load->library('upload', $config);

        if ( ! $this->upload->do_upload('image')) {
            $error = array('error' => $this->upload->display_errors());
            $this->errorResponse('Error', $error);
        }
        else
        {
            $data = array('upload_data' => $this->upload->data());
            $this->successResponse($data, 'Success');
        }
    }

    private function successResponse($data = [], $msg = 'Success')
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

    private function errorResponse($msg = 'Error', $data = [])
    {
        $response = [
            'code' => -1,
            'data' => $data,
            'msg'  => $msg,
        ];
        $this->output->set_status_header(200)
                    ->set_content_type('application/json')
                    ->set_output(json_encode($response));

    }

}
