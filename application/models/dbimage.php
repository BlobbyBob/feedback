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

    /**
     * Check if an image with the ID exists
     * @param int $id ID of the image
     * @return bool
     */
    public function is_image($id = -1)
    {

        $this->db->select('id');
        $this->db->where('id', $id);
        /** @var CI_DB_result $query */
        $query = $this->db->get('images');

        return (bool) $query->num_rows();

    }

    /**
     * Get all valid ids of images
     * @return int[] An array with valid ids
     */
    public function get_ids()
    {

        $this->db->select('id');
        /** @var CI_DB_result $query */
        $query = $this->db->get('images');

        $ids = [];
        foreach ($query->result('object') as $row)
            $ids[] = $row->id;
        return $ids;

    }

    /**
     * Save image file in database
     * @param \Models\Image $image The image to save
     * @return void
     */
    public function save_image($image)
    {

        $this->db->insert('images', [
            'id' => $image->id,
            'data' => $image->data,
            'mime' => $image->mime
        ]);

    }

    /**
     * Delete image from database
     * @param int $id ID of the image
     * @return bool Whether this image was deleted or not
     */
    public function delete_image($id)
    {

        $this->db->delete('images', ['id' => $id]);
        return (bool) $this->db->affected_rows();

    }

}
