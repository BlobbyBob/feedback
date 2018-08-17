<?php

/**
 * Class Dbimage
 * Database interface for fetching images
 * @package Feedback
 * @subpackage Models
 * @category Database
 * @author Ben Swierzy
 */
class Dbimage extends CI_Model
{

    /**
     * Image constructor.
     */
    public function __construct()
    {
        $this->load->database();
    }

    /**
     * Fetch an image by ID
     * @param int $id ID of the image
     * @return \Models\Image|null The image if it was found, null otherwise
     */
    public function get_image($id = -1)
    {

        $this->db->where('id', $id);
        /** @var CI_DB_result $query */
        $query = $this->db->get('images');
        if ($query->num_rows() == 0)
            return null;

        return $query->first_row('Models\Image');

    }

}
