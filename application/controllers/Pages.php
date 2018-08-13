<?php

/**
 * Class Pages
 * Controller for static content
 */
class Pages extends CI_Controller
{

    public function view($page = 'start') {

        if ( !file_exists(APPPATH.'views/pages/'.$page.'.php')) {

            show_404();

        }

        $data['title'] = ucfirst($page);

        $this->load->view('templates/header', $data);
        $this->load->view('pages/'.$page, $data);
        $this->load->view('templates/footer', $data);

    }

}