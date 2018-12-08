<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main_model extends CI_Model {

    public $table = "movies";
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
        $this->db->where('deleted_at', '');
        $this->db->limit($pageSize, $start);
        $this->db->order_by('id', 'DESC');

        $query = $this->db->get($this->table);
        $moviesData =  $query->result();
        return $moviesData;
    }

    public function get_total() 
    {
        return $this->db->count_all($this->table);
    }

    public function addMovies($moviesData = [])
    {
        if (empty($moviesData)) {
            return false;
        }
        $this->db->insert($this->table, $moviesData);
        return true;
    }

    public function updateMovies($moviesId, $moviesData = []) {
        $this->db->set($moviesData);
        $this->db->where('id', $moviesId);
        $this->db->update($this->table); // gives UPDATE `mytable` SET `field` = 'field+1' WHERE `id` = 2
        return true;
    }

}
