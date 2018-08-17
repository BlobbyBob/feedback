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

        if ( !file_exists(APPPATH.'views/pages/'.$page.'.php')) {

            show_404();

        }

        $data['title'] = ucfirst($page);
        $data['style'] = '';
        $data['script'] = '';

        // Specific styles
        if ($page == 'select') {
            $data['style'] .= "<link rel=\"stylesheet\" href=\"https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.css\">\n";
            $data['style'] .= "<link rel=\"stylesheet\" href=\"https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/10.2.0/css/bootstrap-slider.min.css\" integrity=\"sha256-NGswHEy6gjXxyLL+vBBHigA1kGliPHt+7BBPBzntzAw=\" crossorigin=\"anonymous\" />\n";
        }
        $data['style'] .= "<link rel=\"stylesheet\" href=\"" . base_url('resources/css/style.css') . "\">\n";
        if ($page == 'start')
            $data['style'] .= "<link rel=\"stylesheet\" href=\"" . base_url('resources/css/start.css') . "\">\n";

        // Specific scripts
        $data['script'] = "<script src='" . base_url('resources/js/design.js') . "'></script>\n";
        if ($page == 'select') {
            $data['script'] .= "<script src=\"https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/10.2.0/bootstrap-slider.min.js\" integrity=\"sha256-tDcb6zRMjjdonaeNQujdwW5FQdABco7S2Z60J4cbH9s=\" crossorigin=\"anonymous\"></script>\n";
            $data['script'] .= "<script src='" . base_url('resources/js/select.js') . "'></script>\n";
        }

        $this->load->view('templates/header', $data);
        $this->load->view('pages/'.$page, $data);
        $this->load->view('templates/footer', $data);

    }

}