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
        $this->load->helper('url');
    }

    public function login()
    {
        $data = [
            'style' => [
                base_url('resources/css/backend.css'),
                base_url('resources/css/login.css')
            ],
            'script' => [
                base_url('resources/js/login.js')
            ]
        ];

        $this->load->view('backend/header', $data);
        $this->load->view('backend/login', $data);
        $this->load->view('backend/footer', $data);

    }

}