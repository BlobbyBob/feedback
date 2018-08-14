<?php

use Models\Formelement;

class Form extends CI_Model
{

    public function __construct()
    {
        $this->load->database();
    }

    /**
     * @return Formelement[]
     */
    public function get_form()
    {

    }

}
