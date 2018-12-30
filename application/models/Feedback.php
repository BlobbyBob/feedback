<?php

/**
 * Class Feedback
 * Database interface for Feedback
 * @package Feedback
 * @subpackage Models
 * @category Database
 * @author Ben Swierzy
 */
class Feedback extends CI_Model
{

    /**
     * Feedback constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Get all feedback information for a route
     *
     * @param int|null $route ID of the route to get the feedback on (optional)
     * @return array
     */
    public function get($route = null)
    {
        $this->db->select('*');
        $this->db->order_by('route', 'DESC');
        if ( ! is_null($route))
            $this->db->where('route', $route);
        return $this->db->get('feedback')->result();
    }

    /**
     * Get all feedback data for a route (or all routes)
     *
     * @param int|null $route ID of the route to get the feedback on (optional)
     * @return array
     */
    public function get_feedback($route = null)
    {
        $this->db->select('data');
        if ( ! is_null($route))
            $this->db->where('route', $route);
        $this->db->order_by('route', 'DESC');
        $data = [];
        foreach ($this->db->get('feedback')->result() as $row) {
            $data[] = json_decode($row->data);
        }
        return $data;
    }

    public function count()
    {
        return $this->db->count_all('feedback');
    }

    /**
     * @param int $limit
     * @return array
     */
    public function recent_routes($limit = -1)
    {
        $this->db->select('r.id as id, r.name as name, r.wall as wall, c.german as color, MAX(f.date) as date, SUM(f.questions) / SUM(f.total) as ratio, COUNT(*) as `count`', false);
        $this->db->from('feedback AS f');
        $this->db->join('routes AS r', 'f.route = r.id', 'left');
        $this->db->join('color AS c', 'r.color = c.id', 'left');
        if ($limit > 0)
            $this->db->limit($limit);
        $this->db->group_by('f.route');
        $this->db->order_by('date', 'DESC');
        $query = $this->db->get();
        $routes = [];
        foreach ($query->result() as $row) {
            $route = new stdClass();
            $route->id = $row->id;
            $route->name = empty($row->name) ? $row->color . $this->getRopeName($row->wall) : $row->name;
            $route->count = $row->count;
            $route->date = $row->date;
            $route->ratio = round($row->ratio*100, 1);
            $routes[] = $route;
        }
        return $routes;
    }

    public function overview()
    {

        $sql = "SELECT r.id as id, r.name as name, r.wall as wall, c.german as color, MAX(`date`) AS latest, COUNT(*) as `count`, SUM(questions) as answered, SUM(total) as total 
                FROM feedback f 
                LEFT JOIN routes r ON f.route = r.id 
                LEFT JOIN color c on r.color = c.id
                GROUP BY route";

        $query = $this->db->query($sql);

        $data = [];
        foreach ($query->result() as $row) {
            $route = new stdClass();
            $route->id = $row->id;
            $route->name = empty($row->name) ? $row->color . $this->getRopeName($row->wall) : $row->name;
            $route->latest = $row->latest;
            $route->count = $row->count;
            $route->q_answered = is_null($row->answered) ? 0 : $row->answered;
            $route->q_total = is_null($row->total) ? 0 : $row->total;

            $data[] = $route;
        }

        return $data;

    }

    /**
     * todo: move this function somewhere more fitting and universal
     */
    private function getRopeName($rope)
    {
        switch ($rope) {
            case 0: return ' im Vorstieg';
            case 4: return ' an Seil 4 (Eckseil)';
            case 9: return ' an Seil 9 (Eckseil)';
            default: return ' an Seil ' . $rope;
        }
    }

    /**
     * Store Feedback
     * @param Models\Feedback $feedback Feedback to store
     * @return void
     */
    public function store($feedback)
    {
        $feedback = $this->encode_feedback($feedback);
        $sql = $this->db->set($feedback)->get_compiled_insert('feedback') . ' ON DUPLICATE KEY UPDATE `data` = ' . $this->db->escape($feedback->data);
        $this->db->query($sql);
    }

    /**
     * Encodes the user input from the feedback for DB storage
     * @param Models\Feedback $feedback Feedback to encode
     * @return stdClass
     */
    protected function encode_feedback($feedback)
    {
        $enc = new stdClass();
        $enc->id = $feedback->id;
        $enc->route = $feedback->route;
        $enc->author_id = $feedback->author_id;
        if ($feedback->date)
            $enc->date = $feedback->date;
        $enc->questions = $feedback->questions;
        $enc->total = $feedback->total;
        $enc->data = json_encode($feedback->data);
        return $enc;
    }

}
