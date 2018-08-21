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
        $this->load->driver('cache', ['key_prefix' => 'image-']);
    }

    public function get($id = -1)
    {

        if ( ! $image = $this->cache->get($id)) {

            $this->load->model('dbimage');
            $image = $this->dbimage->get_image($id);

            if ($image == NULL) {

                show_404();

            }

            // Cache for 1 week
            $this->cache->save($id, $image, 86400 * 7);

        }

        $this->output
            ->set_content_type($image->mime)
            ->set_output($image->data);

    }

}