<?php

/**
 * Class Pages
 * Controller for static content
 * @package Feedback
 * @subpackage Controller
 * @category Frontend
 * @author Ben Swierzy
 */
class Pages extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
    }

    /**
     * Display a static page, 404 if site not found
     * @param string $page The page name
     */
    public function view($page = 'start') {

        if ( !file_exists(APPPATH.'views/static/'.$page.'.php')) {

            show_404();

        }

        // todo: change coding style
        $data['title'] = ucfirst($page);
        $data['style'] = '';
        $data['script'] = '';

        // Specific styles
        $data['style'] .= '<link rel="stylesheet" href="' . base_url('resources/css/style.css') . "\">\n";
        if ($page == 'start')
            $data['style'] .= '<link rel="stylesheet" href="' . base_url('resources/css/start.css') . "\">\n";

        // Specific scripts
        $data['script'] = "<script src='" . base_url('resources/js/design.js') . "'></script>\n";

        // Specific data
        if ($page == 'start') {
            $data['url'] = base_url('index.php/select/route');
        }

        $this->load->view('templates/header', $data);
        $this->load->view('static/'.$page, $data);
        $this->load->view('templates/footer', $data);

    }

}