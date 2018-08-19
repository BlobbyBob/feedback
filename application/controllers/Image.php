<?php

/**
 * Class Image
 * Controller for displaying images
 * @package Feedback
 * @subpackage Controller
 * @category Frontend
 * @author Ben Swierzy
 */
class Image extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function get($id = -1)
    {

        $this->load->model('dbimage');
        $image = $this->dbimage->get_image($id);

        if ($image == NULL) {

            show_404();

        }

        $this->output
            ->set_content_type($image->mime)
            ->set_output($image->data);

    }

}