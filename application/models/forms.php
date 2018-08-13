<?php

use Models\FormElement;

class Form extends CI_Model
{

    public function __construct()
    {
        $this->load->database();
    }

    /**
     * @return FormElement[]
     */
    public function get_form()
    {

    }

}
