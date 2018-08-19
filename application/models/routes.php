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
        $this->db->select('routes.id AS id, routes.name AS name, routes.grade AS grade,
                           color.name AS color, setter.name AS setter, routes.wall AS wall, routes.image AS image', FALSE);
        $this->db->join('color', 'routes.color = color.id', 'left');
        $this->db->join('setter', 'routes.setter = setter.id', 'left outer');
        if (!is_null($id))
            $this->db->where('routes.id', $id);
        $this->db->order_by('id', 'RANDOM');

        /** @var CI_DB_result $query */
        $query = $this->db->get('routes');

        return $query->result('Models\Route');
    }
}
