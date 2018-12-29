<?php

use Models\AnonymousElement;
use Models\Formelement;
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
        $this->load->helper(['url', 'form']);
    }

    public function login()
    {

        if ( ! $this->auth->isLoggedIn()) {

            $data = [
                'title' => 'Login',
                'style' => '<link rel="stylesheet" href="' . base_url('resources/css/style.css') . "\">\n"
                         . '<link rel="stylesheet" href="' . base_url('resources/css/login.css') . "\">\n",
                'script' => "<script src='" . base_url('resources/js/design.js') . "'></script>\n"
            ];

            $this->load->view('templates/header', $data);
            $this->load->view('backend/login', $data);
            $this->load->view('templates/footer', $data);

        } else {

            $this->output->set_status_header(302, 'Found');
            $this->output->set_header('Location: ' . base_url('index.php/verwaltung/'));

        }

    }

    public function main()
    {

        if ($this->check_login()) {

            $this->load->library('statistics', ['backend/bootadmin/stats_dashboard']);
            $this->load->model(['feedback', 'routes', 'forms']);

            $routes = $this->routes->count();
            $surveys = $this->feedback->count();
            $questions = 0;
            $answered = 0;

            $overview = $this->feedback->overview();
            foreach ($overview as $route) {
                $questions += $route->q_total;
                $answered += $route->q_answered;
            }

            $data = [];
            $feedback = $this->feedback->get();
            foreach ($feedback as $fb) {
                if ( ! isset($dates[strtotime($fb->date)/86400]))
                    $dates[strtotime($fb->date)/86400] = 0;
                $dates[strtotime($fb->date)/86400] += $fb->questions;
                $data[] = json_decode($fb->data);
            }

            $this->statistics->set($data);
            $this->statistics->set_form_elements($this->forms->get_form_elements($this->statistics->get_ids()));
            $this->statistics->run();
            $ratings = $this->statistics->get();

            $date_graph = [];
            foreach ($dates as $date => $count) {
                $date_graph[] = [ 'x' => $date * 86400, 'y' => $count ];
            }

            $recent = $this->feedback->recent_routes(8);

            $urls = $this->get_urls();

            $data = [
                'styles' => [
                    base_url('resources/css/datatables.min.css'),
                    base_url('resources/css/bootadmin.min.css'),
                    base_url('resources/css/chartist.min.css'),
                    base_url('resources/css/backend.css')
                ],
                'scripts' => [
                    base_url('resources/js/datatables.min.js'),
                    base_url('resources/js/bootadmin.min.js'),
                    base_url('resources/js/moment.min.js'),
                    base_url('resources/js/chartist.min.js'),
                    base_url('resources/js/chartist-plugin-axistitle.js'),
                    base_url('resources/js/backend.js')
                ],
                'topbar' => $this->load->view('backend/bootadmin/topbar', ['username' => $this->auth->getUser()->name, 'urls' => $urls], TRUE),
                'sidebar' => $this->load->view('backend/bootadmin/sidebar', ['active' => 'main', 'urls' => $urls], TRUE),
                'page' => $this->load->view('backend/bootadmin/main', [
                    'urls' => $urls,
                    'surveys' => $surveys,
                    'questions' => $questions,
                    'ratings' => $ratings,
                    'answered' => round(100 * $answered / $questions),
                    'surveys_avg' => round($surveys / $routes, 1),
                    'date_graph' => json_encode($date_graph),
                    'activity' => $recent
                ], TRUE)
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
                'topbar' => $this->load->view('backend/bootadmin/topbar', ['username' => $this->auth->getUser()->name, 'urls' => $urls], TRUE),
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
                'topbar' => $this->load->view('backend/bootadmin/topbar', ['username' => $this->auth->getUser()->name, 'urls' => $urls], TRUE),
                'sidebar' => $this->load->view('backend/bootadmin/sidebar', ['active' => 'routes/add', 'urls' => $urls], TRUE),
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

            if (count($this->routes->get_routes($id)) > 0) {
                // Show edit route form
                if ($this->input->post('edit_route') != null && count($this->routes->get_routes($this->input->post('id') ?? -1)) > 0) {

                    // Validate and save input
                    $this->load->library('form_validation');

                    $alert = '';

                    $this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissable" role="alert">', '<button type="button" class="close" data-dismiss="alert" aria-label="Schließen">
                    <span aria-hidden="true">&times;</span>
                    </button>
                    </div>');

                    // Set rules
                    $this->form_validation->set_rules('id', 'ID', 'integer|greater_than[0]|required');
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
                    $this->form_validation->set_message('greater_than', 'Dies ist keine gültige {field}.');
                    $this->form_validation->set_message('greater_than_equal_to', 'Dies ist kein gültiges {field}.');
                    $this->form_validation->set_message('less_than_equal_to', 'Dies ist kein gültiges {field}.');
                    $this->form_validation->set_message('roman', 'Dies ist kein gültiger {field}.');

                    // Validate syntax
                    if ($valid = $this->form_validation->run()) {

                        $route = new Route();
                        $route->id = $this->input->post('id');
                        $route->name = $this->input->post('name');
                        $route->image = $this->input->post('image');
                        $route->color = $this->colors->get_color($this->input->post('color'))->id;
                        $route->wall = $this->input->post('wall');
                        $route->grade = $this->input->post('grade');

                        // Validate logic
                        if (!$this->dbimage->is_image($route->image)) {
                            $valid = FALSE;
                            $alert .= $this->alert('Dieses Bild existiert nicht.', 'danger');
                        }
                        if ($route->color == NULL) {
                            $valid = FALSE;
                            $alert .= $this->alert('Diese Farbe existiert nicht.', 'danger');
                        }

                        if (!$this->input->post('setter-name')) {
                            if (!$this->setters->get_setter($this->input->post('setter-list'))) {
                                $valid = FALSE;
                                $alert .= $this->alert('Dieser Schrauber existiert nicht.', 'danger');
                            } else {
                                $route->setter = $this->input->post('setter-list');
                            }
                        } else {
                            if (!$this->setters->get_setter($this->input->post('setter-name'))) {

                                $setter = new Setter();
                                $setter->id = null;
                                $setter->name = $this->input->post('setter-name');

                                if (!$this->setters->add_setter($setter)) {
                                    $alert .= $this->alert('Dieser Schrauber konnte nicht hinzugefügt werden.', 'warning');
                                } else {
                                    $route->setter = $this->setters->get_setter($this->input->post('setter-name'))->id;
                                }
                            } else {
                                $route->setter = $this->setters->get_setter($this->input->post('setter-name'))->id;
                            }
                        }

                        if ($valid) {

                            $alert .= $this->routes->save($route) ? $this->alert('Die Änderungen wurden gespeichert.', 'success') : $this->alert('Es gab ein Problem beim Speichern der Änderungen.', 'warning');

                        }
                    }

                }

                // Show settings for route

                $route = $this->routes->get_routes($id)[0];
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
                    'topbar' => $this->load->view('backend/bootadmin/topbar', ['username' => $this->auth->getUser()->name, 'urls' => $urls], TRUE),
                    'sidebar' => $this->load->view('backend/bootadmin/sidebar', ['active' => 'routes/add', 'urls' => $urls], TRUE),
                    'page' => $this->load->view('backend/bootadmin/routes_edit', [
                        'urls' => $urls,
                        'form' => form_open(),
                        'alert' => $alert ?? '',
                        'colors' => $this->colors->get_colors(),
                        'setters' => $this->setters->get_setters(),
                        'images' => $image_urls,
                        'route' => $route,
                        'valid' => $valid ?? ''
                    ], TRUE)
                ];

                $this->load->view('backend/bootadmin', $data);

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
                    'topbar' => $this->load->view('backend/bootadmin/topbar', ['username' => $this->auth->getUser()->name, 'urls' => $urls], TRUE),
                    'sidebar' => $this->load->view('backend/bootadmin/sidebar', ['active' => 'routes/manage', 'urls' => $urls], TRUE),
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

    public function survey()
    {
        if ($this->check_login()) {

            $this->load->model(['colors', 'setters', 'dbimage', 'routes', 'forms']); // todo: do we need all of those?

            // Did something get submitted?
            if ($this->input->post('data') != NULL) {

                $data = json_decode($this->input->post('data'));

                if ($data == NULL) {
                    $alert = $this->alert('Die gesendeten Daten sind ungültig.', 'danger');
                } else {

                    $max_version = $this->forms->max_version();

                    $update = [];

                    $count = 0;

                    foreach ($data as $element) {
                        $elem = new AnonymousElement();
                        foreach ($element as $key => $value) {
                            $elem->$key = $value;
                        }

                        $elem->setData();

                        if ($elem->isDeleted()) {

                            $update[] = [
                                'id' => $elem->id,
                                'version' => -1
                            ];

                        } else {

                            $update[] = [
                                'id' => $elem->id,
                                'index' => $elem->index,
                                'data' => $elem->data,
                                'version' => $max_version
                            ];

                        }
                    }

                    $count += $this->forms->update($update);
                    switch ($count) {
                        case 0:
                            $c = 'Keine'; break;
                        case 1:
                            $c = 'Eine'; break;
                        default: $c = $count;
                    }
                    $alert = $this->alert($c . " Änderung" . ($count > 1 ? "en" : "") . " gespeichert.", 'success');

                }
            }

            $this->forms->remove_old_elements();
            $formelements = $this->forms->get_form();
            $formelements = array_map(function ($formelement){
                    /** @var Formelement $formelement */
                    return $this->load->view('formelements/settings', $formelement->get_settings(), TRUE);
                }, $formelements);

            $urls = $this->get_urls();

            $data = [
                'styles' => [
                    base_url('resources/css/bootadmin.min.css'),
                    base_url('resources/css/backend.css')
                ],
                'scripts' => [
                    base_url('resources/js/bootadmin.min.js'),
                    base_url('resources/js/backend.js'),
                    base_url('resources/js/html5sortable.min.js')
                ],
                'topbar' => $this->load->view('backend/bootadmin/topbar', ['username' => $this->auth->getUser()->name, 'urls' => $urls], TRUE),
                'sidebar' => $this->load->view('backend/bootadmin/sidebar', ['active' => 'survey', 'urls' => $urls], TRUE),
                'page' => $this->load->view('backend/bootadmin/survey', [
                    'urls' => $urls,
                    'hidden_form' => form_open('backend/survey', ['class' => 'hidden', 'id' => 'hidden_form']),
                    'alert' => isset($alert) ? $alert : '',
                    'formelements' => $formelements
                ], TRUE)
            ];

            $this->load->view('backend/bootadmin', $data);

        }
    }

    public function evaluation($route = null)
    {
        if ($this->check_login()) {

            $this->load->model(['feedback', 'forms']);
            $urls = $this->get_urls();

            if (is_null($route)) {

                $this->load->library('statistics');

                // Show overview
                $overview = $this->feedback->overview();

                if (count($overview) == 0)
                    $alert = $this->alert('Es wurde noch keine Umfrage ausgefüllt.', 'warning');

                $stats = [];
                $names = [];
                // todo: more efficient database request
                foreach ($overview as $route) {
                    $feedback = $this->feedback->get_feedback($route->id);
                    $this->statistics->set($feedback);
                    $this->statistics->set_form_elements($this->forms->get_form_elements($this->statistics->get_ids()));
                    $this->statistics->run();
                    $stats[] = $this->statistics->get();
                    $names[] = $route->name;
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
                    'topbar' => $this->load->view('backend/bootadmin/topbar', ['username' => $this->auth->getUser()->name, 'urls' => $urls], TRUE),
                    'sidebar' => $this->load->view('backend/bootadmin/sidebar', ['active' => 'evaluation', 'urls' => $urls], TRUE),
                    'page' => $this->load->view('backend/bootadmin/evaluation', [
                        'urls' => $urls,
                        'alert' => isset($alert) ? $alert : '',
                        'routes' => $overview,
                        'statistics' => $stats,
                        'names' => $names
                    ], TRUE)
                ];

                $this->load->view('backend/bootadmin', $data);

            } else {
                // Show route details

                $this->load->model('routes');
                $this->load->library('statistics', ['backend/bootadmin/evaluationsingle']);

                /** @var Route $rt */
                $rt = $this->routes->get_routes($route)[0];
                $feedback = $this->feedback->get($rt->id);

                // Calculate graphs
                $questions = $total = 0;
                $data = [];
                foreach ($feedback as $fb) {
                    if ( ! isset($dates[strtotime($fb->date)/86400]))
                        $dates[strtotime($fb->date)/86400] = 0;
                    $dates[strtotime($fb->date)/86400] += $fb->questions;
                    $questions += $fb->questions;
                    $total += $fb->total;
                    $data[] = json_decode($fb->data);
                }

                // Statistics
                $this->statistics->set($data);
                $this->statistics->set_form_elements($this->forms->get_form_elements($this->statistics->get_ids()));
                $this->statistics->run();
                $stats = $this->statistics->get();


                $date_graph = [];
                foreach ($dates as $date => $count) {
                    $date_graph[] = [ 'x' => $date * 86400, 'y' => $count ];
                }

                $data = [
                    'styles' => [
                        base_url('resources/css/datatables.min.css'),
                        base_url('resources/css/bootadmin.min.css'),
                        base_url('resources/css/chartist.min.css'),
                        base_url('resources/css/backend.css')
                    ],
                    'scripts' => [
                        base_url('resources/js/datatables.min.js'),
                        base_url('resources/js/bootadmin.min.js'),
                        base_url('resources/js/moment.min.js'),
                        base_url('resources/js/chartist.min.js'),
                        base_url('resources/js/chartist-plugin-axistitle.js'),
                        base_url('resources/js/backend.js')
                    ],
                    'topbar' => $this->load->view('backend/bootadmin/topbar', ['username' => $this->auth->getUser()->name, 'urls' => $urls], TRUE),
                    'sidebar' => $this->load->view('backend/bootadmin/sidebar', ['active' => 'evaluation', 'urls' => $urls], TRUE),
                    'page' => $this->load->view('backend/bootadmin/evaluationdetails', [
                        'urls' => $urls,
                        'alert' => isset($alert) ? $alert : '',
                        'name' => $rt->name,
                        'stats' => $stats,
                        'date_graph' => json_encode($date_graph, JSON_NUMERIC_CHECK),
                        'participation_graph' => json_encode([$total-$questions, $questions], JSON_NUMERIC_CHECK)
                    ], TRUE)
                ];

                $this->load->view('backend/bootadmin', $data);

            }
        }
    }

    /**
     * @param bool $return_only Default false. If true, the method won't redirect on to the login page
     * @return bool Is logged in?
     */
    private function check_login($return_only = false)
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

    /**
     * Is user logged in?
     *
     * @return bool Log in status
     */
    public static function isLogin() { // todo: put this in a helper
        return (new Backend())->check_login(true);
    }

    public function get_urls()
    {
        $base = base_url('index.php/verwaltung/');
        return [
            'login' => $base . 'login',
            'logout' => $base . 'logout',
            'main' => $base . 'dashboard',
            'survey' => $base . 'umfrage',
            'evaluation' => $base . 'evaluation',
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
