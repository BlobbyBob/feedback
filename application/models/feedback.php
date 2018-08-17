<?php

/**
 * Class Feedback
 * Database interface for Feedback
 * @package Feedback
 * @subpackage models
 * @category database
 * @author Ben Swierzy
 *
 */
class Feedback extends CI_Model
{

    public function __construct()
    {
        $this->load->database();
    }

    public function get_feedback()
    {
        
    }

    /**
     * Store Feedback
     * @param Models\Feedback $feedback Feedback to store
     * @return void
     */
    public function store($feedback)
    {
        $feedback = $this->encode_feedback($feedback);
        if (!$this->db->insert('feedback', $feedback)) {
            $this->db->where('route', $feedback->route);
            $this->db->where('author_id', $feedback->author_id);
            $this->db->update('feedback', ['data' => $feedback->data]);
        }
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
        $enc->data = json_encode($feedback->data);
        return $enc;
    }

}
