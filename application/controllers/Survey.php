<?php

use Models\Formelement;

/**
 * Class Survey
 * Controller for displaying the survey
 */
class Survey extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('routes');
        $this->load->helper('url');
    }

    /**
     * @param int $id ID of the route the survey is about
     */
    public function view($id = -1)
    {

        $this->load->helper('form');
        $this->load->model('forms');

        if (count($this->routes->get_routes($id)) == 0) {

            show_404('Diese Route existiert nicht.', true);

        }

        $formelements = Formelement::set_pages($this->forms->get_form());
        $pages = [];
        $total_value = 0;
        $page_value = [];
        $max = 1;
        foreach ($formelements as $formelement) {
            $total_value += $this->get_formelement_value($formelement);

            if (!isset($page_value[$formelement->page]))
                $page_value[$formelement->page] = 0;
            $page_value[$formelement->page] += $this->get_formelement_value($formelement);

            if (!isset($pages[$formelement->page]))
                $pages[$formelement->page] = '';


            $pages[$formelement->page] .= $this->load->view('formelements/html', $formelement->get_data(), true);

            $max = max($max, $formelement->page);

        }

        $progress = [];
        $progress[1] = 0;
        if ($total_value != 0) {
            foreach ($page_value as $page => $value) {
                $progress[$page + 1] = ceil(100 * $value / $total_value);
            }
        }

        // todo: change coding style
        // Data for header and footer
        $data['title'] = "Umfrage";
        $data['style'] = '<link rel="stylesheet" href="' . base_url('resources/css/style.css') . '">\n';
        $data['script'] = "<script src='" . base_url('resources/js/design.js') . "'></script>\n";
        $data['script'] .= "<script src='" . base_url('resources/js/survey.js') . "'></script>\n";

        // Data for survey
        $survey['pages'] = $pages;
        $survey['form'] = form_open('survey/finished/' . $id);
        $survey['img_src'] = "https://www.klettern.de/sixcms/media.php/6/KL-Einste-Wand-IMG_2139.jpg";
        $survey['progress'] = $progress;
        $survey['max_page'] = $max + 1;

        $this->load->view('templates/header', $data);
        $this->load->view('pages/survey', $survey);
        $this->load->view('templates/footer', $data);

    }

    /**
     * Process the submitted survey
     * @param int $id Id of the route
     */
    public function finished($id = -1)
    {

        $this->load->model('feedback');

        if (count($this->routes->get_routes($id)) == 0) {

            show_404('Diese Route existiert nicht.', true);

        }

        $feedback = new \Models\Feedback();
        $feedback->id = NULL;
        $feedback->route = $id;
        $feedback->author_id = md5($this->input->ip_address().date('d-m-Y'));
        $feedback->data = new stdClass();
        $feedback->date = NULL;
        $feedback->questions = 0;
        $feedback->total = 0;

        foreach ($this->input->post() as $key => $post) {
            if (strpos($key, 'field-') === 0 && strspn($key, '0123456789', 6) == strlen($key) - 6) {

                $key = substr($key, 6);
                $feedback->total++;

                if ( ! empty($post)) {
                    $feedback->data->$key = $post;
                    $feedback->questions++;
                }

            }
        }

        $this->feedback->store($feedback);

        $data['style'] = '';
        $data['script'] = '';

        $data['style'] .= '<link rel="stylesheet" href="' . base_url('resources/css/style.css') . "\">\n";
        $data['script'] = "<script src='" . base_url('resources/js/design.js') . "'></script>\n";

        $data['select'] = base_url('index.php/select/route');
        // $data['random'] = '#';

        $this->load->view('templates/header', $data);
        $this->load->view('pages/finished', $data);
        $this->load->view('templates/footer', $data);

    }

    /**
     * Get the value of the progressbar of a formelement
     * @param Formelement $element
     * @return int The value
     */
    private function get_formelement_value($element)
    {
        if ($element->is_checkbox() || $element->is_radio() || $element->is_rating() || $element->is_numeric())
            return 1;
        if ($element->is_select())
            return 2;
        if ($element->is_text())
            return 3;
        if ($element->is_textarea())
            return 4;
        return 0;
    }

}