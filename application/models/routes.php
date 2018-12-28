<?php

use Models\Route;

class Routes extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }

    /**
     * Get all the saved routes
     * @param int|null $id The ID of the route, NULL will fetch all
     * @param bool $random Whether the order should be random. Default: true
     * @return Models\Route[]
     */
    public function get_routes($id = NULL, $random = TRUE, $german = FALSE)
    {
        $this->db->select('routes.id AS id, routes.name AS name, routes.grade AS grade,
                           color.' . ($german ? 'german' : 'name') . ' AS color, setter.name AS setter, routes.wall AS wall, routes.image AS image', FALSE);
        $this->db->join('color', 'routes.color = color.id', 'left');
        $this->db->join('setter', 'routes.setter = setter.id', 'left outer');
        if (!is_null($id))
            $this->db->where('routes.id', $id);
        if ($random)
            $this->db->order_by('id', 'RANDOM');

        /** @var CI_DB_result $query */
        $query = $this->db->get('routes');

        return $query->result('Models\Route');
    }

    public function count()
    {
        return $this->db->count_all('routes');
    }

    /**
     * Save a route to persistent memory (If it already exists this action will fail)
     * @param Route $route The Route object
     * @return bool Was saving successful
     */
    public function add_route($route)
    {
        $this->db->insert('routes', $route);
        return (bool) $this->db->affected_rows();
    }

    /**
     * Save a route to persistent memory (It may already exist there and will be overwritten in this case)
     * @param Route $route The route subject (needs resolved setter and color names)
     * @return bool Was saving successful
     */
    public function save($route)
    {
        $this->db->replace('routes', $route);
        return (bool) $this->db->affected_rows();
    }
}
