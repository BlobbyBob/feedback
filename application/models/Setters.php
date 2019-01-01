<?php

use Models\Setter;

class Setters extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Get all setter
     * @return Setter[]
     */
    public function get_setters()
    {
        return $this->db->get('setter')->result('Models\Setter');
    }

    /**
     * Get the setter by ID or name
     * @param int|string $identifier ID or name of the setter
     * @return Setter The Setter
     */
    public function get_setter($identifier)
    {
        if ((int) $identifier != 0)
            $this->db->where('id', $identifier);
        else
            $this->db->where('name', $identifier);
        /** @var CI_DB_result $query */
        $query = $this->db->get('setter');
        return $query->num_rows() == 0 ? null : $query->first_row('Models\Setter');
    }

    /**
     * Save a setter to persistent memory
     * @param Setter $setter The Setter object
     * @return bool Was inserting successful
     */
    public function add_setter($setter)
    {
        if ($setter->id <= 0)
            return false;
        $this->db->insert('setter', $setter);
        return (bool) $this->db->affected_rows();
    }

}
