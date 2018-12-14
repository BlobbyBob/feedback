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
