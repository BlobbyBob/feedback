<?php

// Not so CI conform
include_once "Backend.php";

/**
 * Class Ajax
 * Controller for fetching code snippets via ajax
 *
 * @package Feedback
 * @subpackage Controller
 * @category Backend
 * @author Ben Swierzy
 */
class Ajax extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get the HTML Representation of form elements dynamically
     *
     * @param string $type Either 'html' or 'settings'
     */
    public function formelements($element, $type = 'html')
    {

        $this->load->model('forms');

        if ( ! in_array($type, ['html', 'settings']) || ! in_array($element, ['checkbox', 'numeric', 'pagebreak', 'radio', 'rating', 'select', 'text', 'textarea'])) {

            show_404();

        }

        if ($type == 'html') {
            show_error("Msg");
        }

        if ($type == 'settings') {

            if ($this->auth->pageAccess(__CLASS__, __FUNCTION__)) {

                $formelement = $this->forms->add_formelement($element);
                $this->load->view('formelements/settings', $formelement->get_settings());

            }

        }

    }

}