<?php


/**
 * Class Backend
 * Controller for displaying the backend and managing backend input
 * @package Feedback
 * @subpackage Controller
 * @category Backend
 * @author Ben Swierzy
 */
class Backend extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper(['url', 'form']);
    }

    public function login()
    {

        if ( ! $this->session->userdata('login') === TRUE) {

            $data = [
                'styles' => [
                    base_url('resources/css/backend.css'),
                    base_url('resources/css/login.css')
                ],
                'scripts' => [
                    base_url('resources/js/login.js')
                ]
            ];

            $this->load->view('backend/login', $data);

        } else {

            $this->output->set_status_header(302, 'Found');
            $this->output->set_header('Location: ' . base_url('index.php/verwaltung/main'));

        }

    }

    public function main()
    {

        if ($this->check_login()) {

            $urls = $this->get_urls();

            $data = [
                'styles' => [
                    base_url('resources/css/datatables.min.css'),
                    base_url('resources/css/bootadmin.min.css')
                ],
                'scripts' => [
                    base_url('resources/js/datatables.min.js'),
                    base_url('resources/js/bootadmin.min.js')
                ],
                'topbar' => $this->load->view('backend/bootadmin/topbar', ['logout' => base_url('index.php/verwaltung/logout'), 'urls' => $urls], TRUE),
                'sidebar' => $this->load->view('backend/bootadmin/sidebar', ['active' => 'main', 'urls' => $urls], TRUE),
                'page' => $this->load->view('backend/bootadmin/main', ['urls' => $urls], TRUE)
            ];

            $this->load->view('backend/bootadmin', $data);

        }

    }

    public function images($page = '', $id = -1)
    {

        if ($this->check_login()) {

            $this->load->model('dbimage');

            $alert = '';
            $urls = $this->get_urls();

            if ($this->input->post('upload') != NULL) {
                // Upload image
                if ( ! in_array(mime_content_type($_FILES['image']['tmp_name']), ['image/jpg', 'image/jpeg', 'image/gif', 'image/png'])) {

                    // Wrong mime type
                    $alert = $this->load->view('backend/bootadmin/alert', [
                        'type' => 'danger',
                        'msg' => 'Dies ist kein gültiges Bild. Akzeptierte Formate sind JPG, GIF und PNG.'
                    ], TRUE);

                } elseif ($_FILES['image']['size'] > 2000000) {

                    // File too large
                    $alert = $this->load->view('backend/bootadmin/alert', [
                        'type' => 'danger',
                        'msg' => 'Die Datei überschreitet die maximale Uploadgröße von 2MB.'
                    ], TRUE);

                } else {

                    list($width, $height) = getimagesize($_FILES['image']['tmp_name']);

                    if ($width == 0 || $height == 0) {

                        // Broken image
                        $alert = $this->load->view('backend/bootadmin/alert', [
                            'type' => 'danger',
                            'msg' => 'Es gab ein Problem beim Verarbeiten der Grafik.'
                        ], TRUE);

                    } elseif ($width >= $height) {

                        // Landscape format
                        $alert = $this->load->view('backend/bootadmin/alert', [
                            'type' => 'warning',
                            'msg' => 'Das Bild muss im Hochformat vorliegen.'
                        ], TRUE);

                    } else {

                        // Save image to db
                        $image = new \Models\Image();
                        $image->id = NULL;
                        $image->data = file_get_contents($_FILES['image']['tmp_name']);
                        $image->mime = mime_content_type($_FILES['image']['tmp_name']);

                        $this->dbimage->save_image($image);

                        $alert = $this->alert('Bild erfolgreich hochgeladen', 'success');

                    }
                }

            }

            // Delete images
            if (in_array($page, ['delete', 'delete_confirm']) && ! $this->dbimage->is_image($id)) {

                $alert .= $this->alert('Dieses Bild existiert nicht.', 'warning');

            } elseif ($page == 'delete') {

                // todo move css to views
                $alert .= $this->alert('Möchtest du das Bild wirklich löschen? <strong>Diese Aktion kann nicht rückgängig gemacht werden!</strong>&nbsp;&nbsp; <a href="'.$urls['images_delete_confirm'].$id.'" class="btn btn-danger btn-sm">Unwiderruflich Löschen</a>', 'danger');

            } elseif ($page == 'delete_confirm') {

                if ($this->dbimage->delete_image($id))
                    $alert .= $this->alert('Das Bild wurde gelöscht.', 'success');
                else
                    $alert .= $this->alert('Das Bild wird ist noch mindestens einer Route zugeordnet und kann nicht gelöscht werden.', 'warning');

            }

            // Get thumbnail grid
            $image_urls = [];
            foreach ($this->dbimage->get_ids() as $id) {
                $image_urls[] = [
                    'src' => base_url('index.php/image/get/'.$id),
                    'delete' => $urls['images_delete'] . $id,
                ];
            }

            $data = [
                'styles' => [
                    base_url('resources/css/datatables.min.css'),
                    base_url('resources/css/bootadmin.min.css'),
                    base_url('resources/css/backend.css')
                ],
                'scripts' => [
                    base_url('resources/js/datatables.min.js'),
                    base_url('resources/js/bootadmin.min.js')
                ],
                'topbar' => $this->load->view('backend/bootadmin/topbar', ['logout' => base_url('index.php/verwaltung/logout'), 'urls' => $urls], TRUE),
                'sidebar' => $this->load->view('backend/bootadmin/sidebar', ['active' => 'images', 'urls' => $urls], TRUE),
                'page' => $this->load->view('backend/bootadmin/images', [
                    'urls' => $urls,
                    'form' => form_open_multipart('backend/images'),
                    'alert' => $alert,
                    'images' => $image_urls
                ], TRUE)
            ];

            $this->load->view('backend/bootadmin', $data);

        }

    }

    /**
     * Print an alert box
     * @param string $msg The message in the alert box
     * @param string $type The (bootstrap css) type of the alert box
     * @return mixed alert box markup
     */
    private function alert($msg, $type = 'default') {
        return $this->load->view('backend/bootadmin/alert', [
            'type' => $type,
            'msg' => $msg
        ], TRUE);
    }

    public function routes_add()
    {

    }

    public function routes_manage($id = -1)
    {

    }

    private function check_login()
    {

        // todo change it in production
        return true;

//        if ( ! $this->session->userdata('login' ) === TRUE) {
//
//            $this->output->set_status_header(302, 'Found');
//            $this->output->set_header('Location: ' . base_url('index.php/verwaltung/login'));
//
//            return false;
//
//        }
//
//        return true;

    }

    public function get_urls()
    {
        $base = base_url('index.php/verwaltung/');
        return [
            'login' => $base . 'login',
            'logout' => $base . 'logout',
            'main' => $base . 'dashboard',
            'survey' => $base . '',
            'results' => $base . '',
            'routes/add' => $base . 'routen/hinzufuegen',
            'routes/manage' => $base . 'routen/verwalten',
            'images' => $base . 'bilder',
            'images_delete' => $base . 'bilder/loesche/',
            'images_delete_confirm' => $base . 'bilder/geloescht/',
        ];
    }

}
