<?php

/**
 * Class Pages
 * Controller for static content
 */
class Pages extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
    }

    public function view($page = 'start') {

        if ( !file_exists(APPPATH.'views/pages/'.$page.'.php')) {

            show_404();

        }

        $data['title'] = ucfirst($page);

        // Specific styles
        $data['style'] = "<link rel=\"stylesheet\" href=\"" . base_url('resources/css/style.css') . "\">\n";
        if ($page == 'start')
            $data['style'] .= "<link rel=\"stylesheet\" href=\"" . base_url('resources/css/start.css') . "\">\n";
        if ($page == 'select')
            $data['style'] .= "<link rel=\"stylesheet\" href=\"https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.css\">\n";

        // Specific scripts
        $data['script'] = "<script src='" . base_url('resources/js/design.js') . "'></script>";

        $this->load->view('templates/header', $data);
        $this->load->view('pages/'.$page, $data);
        $this->load->view('templates/footer', $data);

    }

}