<?php

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

        $data['mime'] = $image->mime;
        $data['data'] = $image->data;

        $this->load->view('misc/image', $data);

    }

}