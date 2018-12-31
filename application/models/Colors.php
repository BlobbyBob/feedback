<?php

class Colors extends CI_Model {

    public function __construct()
    {
        $this->load->database();
    }

    /**
     * Fetch all colors ordered by there german names
     * @return Models\Color[] All available colors
     */
    public function get_colors()
    {
        $this->db->order_by('german', 'ASC');
        return $this->db->get('color')->result('Models\Color');
    }

    /**
     * Get a color by ID
     * @param int $id ID of the color
     * @return Models\Color The color
     */
    public function get_color($id)
    {
        $this->db->where('id', $id);
        /** @var CI_DB_result $query */
        $query = $this->db->get('color');
        return $query->num_rows() == 0 ? null : $query->first_row('Models\Color');
    }

}
