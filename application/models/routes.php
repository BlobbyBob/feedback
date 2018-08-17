<?php

class Routes extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }

    /**
     * Get all the saved routes
     * @param int|null $id The ID of the route, NULL will fetch all
     * @return Models\Route[]
     */
    public function get_routes($id = NULL)
    {
        if (!is_null($id))
            $this->db->where('id', $id);
        $this->db->order_by('id', 'RANDOM');

        /** @var CI_DB_result $query */
        $query = $this->db->get('routes');

        return $query->result('Models\Route');
    }
}
