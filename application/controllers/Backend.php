<?php


/**
 * Class Backend
 * Controller for displaying the backend and managing backend input
 * @package Feedback
 * @subpackage Controller
 * @category Backend
 * @author Ben Swierzy
 */
class Backend extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
    }

}