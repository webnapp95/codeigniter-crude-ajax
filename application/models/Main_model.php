<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main_model extends CI_Model {

    const PAZE_SIZE = 10;
    const PAZE = 1;
    const IS_ACTIVE = '1';
    const IS_IN_ACTIVE = '0';
    const DESC = 'desc';
    const DEFAULT_COLUMN = 'id';

    /**
     * Get movies list by condition.
     *
     * @param  array $params
     * @return array
     * @author Chigs Patel <info@webnappdev.in>
     * @Date   3rd Nov 2018
     */
    public function getMoviesList($params = []) {
        $page     = isset($params['page']) ? $params['page'] : self::PAZE;
        $pageSize = isset($params['page_size']) ? $params['page_size'] : self::PAZE_SIZE;
        $start    = isset($params['offset']) ? $params['offset'] : 0;
        $this->db->limit($pageSize, $start);

        $query = $this->db->get('movies');
        $moviesData =  $query->result();
        return $moviesData;
    }

    public function get_total() 
    {
        return $this->db->count_all("movies");
    }

}
