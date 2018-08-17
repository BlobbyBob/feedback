<?php

class Routes extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }

    /**
     * Get all the saved routes
     * @return Models\Route[]
     */
    public function get_routes()
    {
        $this->db->order_by('id', 'RANDOM');

        /** @var CI_DB_result $query */
        $query = $this->db->get('routes');

        return $query->result('Models\Route');
    }
}
