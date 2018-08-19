<?php

use Models\Route;

/**
 * Class Select
 * Display pages to select topics for the survey
 * @package Feedback
 * @subpackage Controller
 * @category Frontend
 * @author Ben Swierzy
 */
class Select extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
    }

    public function route()
    {

        $this->load->model('routes');

        $data['title'] = "Route auswählen";
        $data['style'] = '';
        $data['script'] = '';

        $data['style'] .= '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.css">';
        $data['style'] .= '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/10.2.0/css/bootstrap-slider.min.css" integrity="sha256-NGswHEy6gjXxyLL+vBBHigA1kGliPHt+7BBPBzntzAw=" crossorigin="anonymous" />';
        $data['style'] .= '<link rel="stylesheet" href="' . base_url('resources/css/style.css') . "\">\n";

        $data['script'] .= "<script src='" . base_url('resources/js/design.js') . "'></script>\n";
        $data['script'] .= "<script src=\"https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/10.2.0/bootstrap-slider.min.js\" integrity=\"sha256-tDcb6zRMjjdonaeNQujdwW5FQdABco7S2Z60J4cbH9s=\" crossorigin=\"anonymous\"></script>\n";
        $data['script'] .= "<script src='" . base_url('resources/js/select.js') . "'></script>\n";

        /** @var Route[] $routes */
        $routes = $this->routes->get_routes();
        $data['routes'] = [];
        foreach ($routes as $route) {
            $data['routes'][] = [
                'url' => base_url('index.php/survey/view/'.$route->id),
                'img' => base_url('index.php/image/get/'.$route->image),
                'color' => $route->color,
                'grade' => $route->grade,
                'rope' => $route->wall == 0 ? 'Vorstieg' : $route->wall,
                'name' => $route->name,
                'json' => json_encode(['color' => $route->color, 'grade' => self::get_numeric_grade($route->grade), 'rope' => (int) $route->wall])
            ];
        }

        $this->load->view('templates/header', $data);
        $this->load->view('pages/select', $data);
        $this->load->view('templates/footer', $data);
    }

    /**
     * Converts a roman UIAA grade to int
     * @param string $roman Grade as roman literal
     * @return int Grade
     */
    private static function get_numeric_grade($roman)
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