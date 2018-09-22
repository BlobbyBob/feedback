<?php

use Models\Route;
use Models\Setter;


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
            if (in_array($page, ['delete', 'delete_confirm']) && !$this->dbimage->is_image($id)) {

                $alert .= $this->alert('Dieses Bild existiert nicht.', 'warning');

            } elseif ($page == 'delete') {

                // todo move css to views
                $alert .= $this->alert('Möchtest du das Bild wirklich löschen? <strong>Diese Aktion kann nicht rückgängig gemacht werden!</strong>&nbsp;&nbsp; <a href="' . $urls['images_delete_confirm'] . $id . '" class="btn btn-danger btn-sm">Unwiderruflich Löschen</a>', 'danger');

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
                    'src' => base_url('index.php/image/get/' . $id),
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
    private function alert($msg, $type = 'default')
    {
        return $this->load->view('backend/bootadmin/alert', [
            'type' => $type,
            'msg' => $msg
        ], TRUE);
    }

    public function routes_add()
    {
        if ($this->check_login()) {

            $this->load->model(['colors', 'setters', 'dbimage', 'routes']);
            $reset = false;

            if ($this->input->post('add_route') != NULL) {

                $this->load->library('form_validation');

                $alert = '';

                $this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissable" role="alert">', '<button type="button" class="close" data-dismiss="alert" aria-label="Schließen">
                    <span aria-hidden="true">&times;</span>
                    </button>
                    </div>');

                // Set rules
                $this->form_validation->set_rules('name', 'Name', 'trim|max_length[127]');
                $this->form_validation->set_rules('grade', 'Grad', [['roman', function ($value) {
                    return preg_match('~^[IVX]+[\+\-]?$~', $value) && self::get_numeric_grade($value) != 0;
                }]]); // Todo put get_numeric_grade into helper
                $this->form_validation->set_rules('color', 'Farbe', 'integer|required');
                $this->form_validation->set_rules('setter-list', 'Schrauberauswahl', 'integer|required');
                $this->form_validation->set_rules('setter-name', 'Schrauber', 'trim|max_length[127]');
                $this->form_validation->set_rules('wall', 'Seil', 'integer|greater_than_equal_to[0]|less_than_equal_to[12]|required');
                $this->form_validation->set_rules('image', 'Bild', 'max_length[127]|required');

                $this->form_validation->set_message('required', 'Das Feld <strong>{field}</strong> muss ausgefüllt werden.');
                $this->form_validation->set_message('max_length', 'Die maximale Länge für <strong>{field}</strong> beträgt <i>{param}</i> Zeichen.');
                $this->form_validation->set_message('integer', 'Die Eingabe für <strong>{field}</strong> ist ungültig.');
                $this->form_validation->set_message('greater_than_equal_to', 'Dies ist kein gültiges Seil.');
                $this->form_validation->set_message('less_than_equal_to', 'Dies ist kein gültiges Seil.');
                $this->form_validation->set_message('roman', 'Dies ist kein gültiger Grad.');

                // Validate syntax
                if ($valid = $this->form_validation->run()) {

                    $route = new Route();
                    $route->id = NULL;
                    $route->name = $this->input->post('name');
                    $route->image = $this->input->post('image');
                    $route->color = $this->colors->get_color($this->input->post('color'))->id;
                    $route->wall = $this->input->post('wall');
                    $route->grade = $this->input->post('grade');

                    // Validate logic
                    if ( ! $this->dbimage->is_image($route->image)) {
                        $valid = FALSE;
                        $alert .= $this->alert('Dieses Bild existiert nicht.', 'danger');
                    }
                    if ($route->color == NULL) {
                        $valid = FALSE;
                        $alert .= $this->alert('Diese Farbe existiert nicht.', 'danger');
                    }

                    if ( ! $this->input->post('setter-name')) {
                        if ( ! $this->setters->get_setter($this->input->post('setter-list'))) {
                            $valid = FALSE;
                            $alert .= $this->alert('Dieser Schrauber existiert nicht.', 'danger');
                        } else {
                            $route->setter = $this->input->post('setter-list');
                        }
                    } else {
                        if ( ! $this->setters->get_setter($this->input->post('setter-name'))) {

                            $setter = new Setter();
                            $setter->id = null;
                            $setter->name = $this->input->post('setter-name');

                            if ( ! $this->setters->add_setter($setter)) {
                                $alert .= $this->alert('Dieser Schrauber konnte nicht hinzugefügt werden.', 'warning');
                            } else {
                                $route->setter = $this->setters->get_setter($this->input->post('setter-name'))->id;
                            }
                        } else {
                            $route->setter = $this->setters->get_setter($this->input->post('setter-name'))->id;
                        }
                    }

                    if ($valid) {

                        if ($this->routes->add_route($route)) {
                            $reset = true;
                            $alert = $this->alert('Die Route wurde gespeichert.', 'success');
                        } else
                            $alert = $this->alert('Es gab ein Problem beim Speichern der Route.', 'warning');

                    }

                }
            }

            $urls = $this->get_urls();

            $image_urls = [];
            foreach ($this->dbimage->get_ids() as $id) {
                $image_urls[] = [
                    'src' => base_url('index.php/image/get/' . $id),
                    'id' => $id
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
                    base_url('resources/js/bootadmin.min.js'),
                    base_url('resources/js/backend.js')
                ],
                'topbar' => $this->load->view('backend/bootadmin/topbar', ['logout' => base_url('index.php/verwaltung/logout'), 'urls' => $urls], TRUE),
                'sidebar' => $this->load->view('backend/bootadmin/sidebar', ['active' => 'images', 'urls' => $urls], TRUE),
                'page' => $this->load->view('backend/bootadmin/routes_add', [
                    'urls' => $urls,
                    'form' => form_open('backend/routes_add'),
                    'alert' => isset($alert) ? $alert : '',
                    'colors' => $this->colors->get_colors(),
                    'setters' => $this->setters->get_setters(),
                    'images' => $image_urls,
                    'valid' => isset($valid) ? $valid : '',
                    'reset' => $reset
                ], TRUE)
            ];

            $this->load->view('backend/bootadmin', $data);

        }
    }

    public function routes_manage($id = -1)
    {

        if ($this->check_login()) {

            $this->load->model(['colors', 'setters', 'dbimage', 'routes']);
            $urls = $this->get_urls();

            if ($route = $this->routes->get_routes($id)) {
                // Show edit route form
            } else {
                // Show overview
                $routes = $this->routes->get_routes(NULL, false, true);

                $data = [
                    'styles' => [
                        base_url('resources/css/datatables.min.css'),
                        base_url('resources/css/bootadmin.min.css'),
                        base_url('resources/css/backend.css')
                    ],
                    'scripts' => [
                        base_url('resources/js/datatables.min.js'),
                        base_url('resources/js/bootadmin.min.js'),
                        base_url('resources/js/backend.js')
                    ],
                    'topbar' => $this->load->view('backend/bootadmin/topbar', ['logout' => base_url('index.php/verwaltung/logout'), 'urls' => $urls], TRUE),
                    'sidebar' => $this->load->view('backend/bootadmin/sidebar', ['active' => 'images', 'urls' => $urls], TRUE),
                    'page' => $this->load->view('backend/bootadmin/routes_manage', [
                        'urls' => $urls,
                        'form' => form_open('backend/routes_manage'),
                        'alert' => isset($alert) ? $alert : '',
                        'routes' => $routes
                    ], TRUE)
                ];

                $this->load->view('backend/bootadmin', $data);
            }

        }

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

    public static function get_numeric_grade($roman)
    {
        $roman = substr(strtoupper($roman), 0, strspn(strtoupper($roman), 'IVX'));
        switch ($roman) {
            case 'I': return 1;
            case 'II': return 2;
            case 'III': return 3;
            case 'IV': return 4;
            case 'V': return 5;
            case 'VI': return 6;
            case 'VII': return 7;
            case 'VIII': return 8;
            case 'IX': return 9;
            case 'X': return 10;
            case 'XI': return 11;
            case 'XII': return 12;
            default: return 0;
        }
    }

}
